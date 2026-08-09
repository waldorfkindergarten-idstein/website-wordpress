<?php
/**
 * One-time front-page content and media migration.
 *
 * @package WaldorfPfirsichbluete
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const WALDORF_PB_CONTENT_MIGRATION_VERSION = 1;
const WALDORF_PB_CONTENT_MIGRATION_OPTION  = 'waldorf_pb_content_migration_version';
const WALDORF_PB_CONTENT_MIGRATION_LOCK    = 'waldorf_pb_content_migration_lock';
const WALDORF_PB_CONTENT_MIGRATION_ERROR   = 'waldorf_pb_content_migration_error';
const WALDORF_PB_SOURCE_META_KEY           = '_waldorf_pb_source_filename';

/**
 * Return section pattern slugs in canonical front-page order.
 *
 * @return string[]
 */
function waldorf_pb_front_page_pattern_slugs(): array {
	return array(
		'hero',
		'season',
		'values',
		'haus',
		'gruppen',
		'rhythmus',
		'jahreslauf',
		'verpflegung',
		'team',
		'stimmen',
		'anmeldung',
		'aktuelles',
		'downloads',
		'cta',
		'kontakt',
	);
}

/**
 * Return the ten theme photos that become editor-owned media attachments.
 *
 * @return string[]
 */
function waldorf_pb_migration_photo_filenames(): array {
	return array(
		'photo-hero.jpg',
		'photo-garten.jpg',
		'photo-gruppenraum.jpg',
		'photo-waldtag.jpg',
		'photo-morgenkreis.jpg',
		'photo-holz.jpg',
		'photo-krippe.jpg',
		'photo-malecke.jpg',
		'photo-rhythmus.jpg',
		'photo-essen.jpg',
	);
}

/**
 * Return the five legacy downloads that become media attachments.
 *
 * @return string[]
 */
function waldorf_pb_migration_pdf_filenames(): array {
	return array(
		'anmeldung-familiengruppe.pdf',
		'beitragsordnung-2022.pdf',
		'vereinssatzung.pdf',
		'anmeldung-wiegenstube.pdf',
		'anmeldung-kindergarten-u3.pdf',
	);
}

/**
 * Map only defaults whose labels identify a real source document unambiguously.
 *
 * @return array<string, string>
 */
function waldorf_pb_migration_download_links(): array {
	return array(
		'Anmeldebogen'        => 'anmeldung-familiengruppe.pdf',
		'Gebührenordnung'     => 'beitragsordnung-2022.pdf',
		'Satzung des Vereins' => 'vereinssatzung.pdf',
	);
}

/**
 * Classify current content without treating arbitrary editor content as seedable.
 *
 * @param string $content Current front-page post content.
 * @return string One of empty, legacy, new or unknown.
 */
function waldorf_pb_classify_front_page_content( string $content ): string {
	if ( '' === trim( $content ) ) {
		return 'empty';
	}

	if ( false !== strpos( $content, 'wp:waldorf/' ) ) {
		return 'new';
	}

	$has_legacy_news   = false !== strpos( $content, 'wp:waldorf-idstein/news-panel' );
	$has_legacy_rhythm = false !== strpos( $content, 'wp:waldorf-idstein/tagesrhythmus' );
	$has_legacy_hero   = false !== strpos( $content, 'wp-block-group hero' );

	if ( $has_legacy_news && $has_legacy_rhythm && $has_legacy_hero ) {
		return 'legacy';
	}

	return 'unknown';
}

/**
 * Load a local pattern body without relying on pattern-registry timing.
 *
 * @param string $slug Allowlisted local pattern slug.
 * @return string|WP_Error
 */
function waldorf_pb_load_migration_pattern( string $slug ) {
	if ( ! in_array( $slug, waldorf_pb_front_page_pattern_slugs(), true ) ) {
		return new WP_Error( 'invalid_pattern', 'Unbekanntes Startseiten-Pattern: ' . $slug );
	}

	$file = get_template_directory() . '/patterns/' . $slug . '.php';
	if ( ! is_file( $file ) ) {
		return new WP_Error( 'missing_pattern', 'Pattern-Datei fehlt: ' . $file );
	}

	ob_start();
	include $file;
	$content = ob_get_clean();

	if ( false === $content || '' === trim( $content ) ) {
		return new WP_Error( 'empty_pattern', 'Pattern enthält keine Blöcke: ' . $slug );
	}

	return trim( $content );
}

/**
 * Build concrete canonical blocks, never persisted core/pattern references.
 *
 * @return string|WP_Error
 */
function waldorf_pb_build_canonical_front_page_content() {
	$sections = array();

	foreach ( waldorf_pb_front_page_pattern_slugs() as $slug ) {
		$section = waldorf_pb_load_migration_pattern( $slug );
		if ( is_wp_error( $section ) ) {
			return $section;
		}

		$sections[] = $section;
	}

	$sections[] = '<!-- wp:waldorf/dekoration {"variant":"back-to-top","lock":{"move":true,"remove":true},"metadata":{"name":"Zurück nach oben"}} /-->';
	$content    = implode( "\n\n", $sections );

	if ( false !== strpos( $content, 'wp:pattern' ) ) {
		return new WP_Error( 'pattern_reference', 'Die kanonische Startseite enthält unerwartet eine Pattern-Referenz.' );
	}

	return $content;
}

/**
 * Find one attachment by its stable source filename.
 *
 * @param string $filename Portable source filename.
 * @return int|WP_Error Zero if no attachment exists.
 */
function waldorf_pb_find_source_attachment( string $filename ) {
	$ids = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => array( 'inherit', 'private', 'trash', 'draft', 'pending', 'future' ),
			'posts_per_page' => 2,
			'fields'         => 'ids',
			'meta_key'       => WALDORF_PB_SOURCE_META_KEY,
			'meta_value'     => $filename,
			'no_found_rows'  => true,
		)
	);

	if ( count( $ids ) > 1 ) {
		return new WP_Error( 'duplicate_attachment_marker', 'Mehrere Medien tragen die Quellmarkierung ' . $filename . '.' );
	}

	if ( empty( $ids ) ) {
		return 0;
	}

	$attachment_id = (int) $ids[0];
	$file          = get_attached_file( $attachment_id );
	if ( 'trash' === get_post_status( $attachment_id ) || ! is_string( $file ) || ! is_file( $file ) ) {
		return new WP_Error( 'unavailable_attachment', 'Das markierte Medium ' . $filename . ' ist gelöscht oder seine Datei fehlt.' );
	}

	return $attachment_id;
}

/**
 * Import one source through the WordPress media pipeline.
 *
 * @param string $source_path Absolute source path.
 * @param string $filename    Stable portable filename.
 * @return int|WP_Error Attachment ID.
 */
function waldorf_pb_import_source_attachment( string $source_path, string $filename ) {
	$existing = waldorf_pb_find_source_attachment( $filename );
	if ( is_wp_error( $existing ) || $existing > 0 ) {
		return $existing;
	}

	if ( ! is_file( $source_path ) || ! is_readable( $source_path ) ) {
		return new WP_Error( 'missing_source', 'Quelldatei fehlt oder ist nicht lesbar: ' . $source_path );
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$temp_file = wp_tempnam( $filename );
	if ( ! is_string( $temp_file ) || ! copy( $source_path, $temp_file ) ) {
		return new WP_Error( 'source_copy_failed', 'Temporäre Kopie fehlgeschlagen: ' . $filename );
	}

	$file_array = array(
		'name'     => $filename,
		'tmp_name' => $temp_file,
	);
	$title      = pathinfo( $filename, PATHINFO_FILENAME );
	$attachment = media_handle_sideload( $file_array, 0, $title );

	if ( is_wp_error( $attachment ) ) {
		if ( is_file( $temp_file ) ) {
			unlink( $temp_file );
		}
		return $attachment;
	}

	$attachment_id   = (int) $attachment;
	$attachment_file = get_attached_file( $attachment_id );
	$source_hash     = hash_file( 'sha256', $source_path );
	$uploaded_hash   = is_string( $attachment_file ) && is_file( $attachment_file ) ? hash_file( 'sha256', $attachment_file ) : false;

	if ( false === $source_hash || $source_hash !== $uploaded_hash ) {
		wp_delete_attachment( $attachment_id, true );
		return new WP_Error( 'attachment_hash_mismatch', 'Die Mediendatei ist keine exakte Kopie von ' . $filename . '.' );
	}

	if ( false === add_post_meta( $attachment_id, WALDORF_PB_SOURCE_META_KEY, $filename, true ) ) {
		wp_delete_attachment( $attachment_id, true );
		return new WP_Error( 'attachment_marker_failed', 'Quellmarkierung konnte nicht gespeichert werden: ' . $filename );
	}

	return $attachment_id;
}

/**
 * Import all migration sources and return attachment data keyed by filename.
 *
 * @return array<string, array{id:int,url:string}>|WP_Error
 */
function waldorf_pb_import_migration_media() {
	$sources   = array();
	$image_dir = get_template_directory() . '/assets/images/';

	foreach ( waldorf_pb_migration_photo_filenames() as $filename ) {
		$sources[ $filename ] = $image_dir . $filename;
	}

	foreach ( waldorf_pb_migration_pdf_filenames() as $filename ) {
		$sources[ $filename ] = ABSPATH . 'downloads/' . $filename;
	}

	$attachments = array();
	foreach ( $sources as $filename => $source_path ) {
		$attachment_id = waldorf_pb_import_source_attachment( $source_path, $filename );
		if ( is_wp_error( $attachment_id ) ) {
			return $attachment_id;
		}

		$url = wp_get_attachment_url( $attachment_id );
		if ( false === $url ) {
			return new WP_Error( 'attachment_url_missing', 'Für das Medium fehlt eine URL: ' . $filename );
		}

		$attachments[ $filename ] = array(
			'id'  => $attachment_id,
			'url' => $url,
		);
	}

	return $attachments;
}

/**
 * Fill only empty, portable asset attributes in a parsed block tree.
 *
 * Existing IDs and non-placeholder download URLs are editor-owned and remain
 * untouched. This is the central no-overwrite/idempotence guard.
 *
 * @param array[]                               $blocks      Parsed blocks.
 * @param array<string, array{id:int,url:string}> $attachments Imported attachment data.
 * @param bool                                  $changed     Set when attributes change.
 * @return array[]
 */
function waldorf_pb_hydrate_front_page_assets( array $blocks, array $attachments, bool &$changed ): array {
	$download_links = waldorf_pb_migration_download_links();

	foreach ( $blocks as &$block ) {
		$name  = isset( $block['blockName'] ) ? (string) $block['blockName'] : '';
		$attrs = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();

		if ( in_array( $name, array( 'waldorf/photo', 'waldorf/gruppen-karte' ), true ) ) {
			$fallback = isset( $attrs['fallback'] ) ? wp_basename( (string) $attrs['fallback'] ) : '';
			if ( 0 === absint( $attrs['id'] ?? 0 ) && isset( $attachments[ $fallback ] ) ) {
				$attrs['id']    = $attachments[ $fallback ]['id'];
				$block['attrs'] = $attrs;
				$changed        = true;
			}
		}

		if ( 'waldorf/download' === $name ) {
			$title       = isset( $attrs['title'] ) ? wp_strip_all_tags( (string) $attrs['title'] ) : '';
			$current_url = isset( $attrs['fileUrl'] ) ? trim( (string) $attrs['fileUrl'] ) : '#';
			$filename    = $download_links[ $title ] ?? '';

			if ( 0 === absint( $attrs['id'] ?? 0 ) && in_array( $current_url, array( '', '#' ), true ) && isset( $attachments[ $filename ] ) ) {
				$attrs['id']      = $attachments[ $filename ]['id'];
				$attrs['fileUrl'] = $attachments[ $filename ]['url'];
				$block['attrs']   = $attrs;
				$changed          = true;
			}
		}

		if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
			$block['innerBlocks'] = waldorf_pb_hydrate_front_page_assets( $block['innerBlocks'], $attachments, $changed );
		}
	}
	unset( $block );

	return $blocks;
}

/**
 * Store an actionable failure for administrators without marking completion.
 *
 * @param WP_Error $error   Migration error.
 * @param int      $page_id Front-page ID, if resolved.
 */
function waldorf_pb_store_migration_error( WP_Error $error, int $page_id = 0 ): void {
	update_option(
		WALDORF_PB_CONTENT_MIGRATION_ERROR,
		array(
			'time'    => time(),
			'code'    => $error->get_error_code(),
			'message' => $error->get_error_message(),
			'page_id' => $page_id,
		),
		false
	);
}

/**
 * Execute migration after blocks are registered and before template rendering.
 *
 * @return true|WP_Error
 */
function waldorf_pb_run_content_migration() {
	if ( 'page' !== get_option( 'show_on_front' ) ) {
		return new WP_Error( 'front_page_not_static', 'Unter Einstellungen > Lesen ist keine statische Startseite aktiviert.' );
	}

	$page_id = absint( get_option( 'page_on_front', 0 ) );
	if ( 0 === $page_id ) {
		return new WP_Error( 'front_page_missing', 'Unter Einstellungen > Lesen ist keine statische Startseite ausgewählt.' );
	}

	$page = get_post( $page_id );
	if ( ! $page instanceof WP_Post || 'page' !== $page->post_type ) {
		return new WP_Error( 'front_page_invalid', 'Die konfigurierte Startseite ist keine gültige Seite.' );
	}

	$current_content = (string) $page->post_content;
	$content_type    = waldorf_pb_classify_front_page_content( $current_content );
	if ( 'unknown' === $content_type ) {
		return new WP_Error(
			'front_page_unrecognized',
			'Die Startseite enthält nicht erkannte oder redaktionell erstellte Inhalte. Sie wurde nicht überschrieben; bitte Inhalt und Migration manuell prüfen.'
		);
	}

	$attachments = waldorf_pb_import_migration_media();
	if ( is_wp_error( $attachments ) ) {
		return $attachments;
	}

	if ( 'new' === $content_type ) {
		$seed_content = $current_content;
	} else {
		$seed_content = waldorf_pb_build_canonical_front_page_content();
		if ( is_wp_error( $seed_content ) ) {
			return $seed_content;
		}
	}

	$blocks  = parse_blocks( $seed_content );
	$changed = false;
	$blocks  = waldorf_pb_hydrate_front_page_assets( $blocks, $attachments, $changed );
	$content = serialize_blocks( $blocks );

	if ( 'new' === $content_type && ! $changed ) {
		// Preserve byte-for-byte editor content when there are no links to add.
		$content = $current_content;
	}

	if ( wp_revisions_enabled( $page ) ) {
		$revision = wp_save_post_revision( $page_id );
		if ( is_wp_error( $revision ) ) {
			return $revision;
		}
	} elseif ( 'legacy' === $content_type ) {
		return new WP_Error( 'revisions_disabled', 'Für die Startseite sind Revisionen deaktiviert; Legacy-Inhalte wurden nicht ersetzt.' );
	}

	$result = wp_update_post(
		array(
			'ID'           => $page_id,
			'post_content' => $content,
		),
		true
	);
	if ( is_wp_error( $result ) || 0 === $result ) {
		return is_wp_error( $result ) ? $result : new WP_Error( 'page_update_failed', 'Die Startseite konnte nicht aktualisiert werden.' );
	}

	$version_saved = update_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, WALDORF_PB_CONTENT_MIGRATION_VERSION, false );
	if ( ! $version_saved && WALDORF_PB_CONTENT_MIGRATION_VERSION !== (int) get_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, 0 ) ) {
		return new WP_Error( 'version_update_failed', 'Die Migrationsversion konnte nach dem Speichern der Startseite nicht gesetzt werden.' );
	}

	delete_option( WALDORF_PB_CONTENT_MIGRATION_ERROR );

	return true;
}

/**
 * Acquire a short-lived atomic option lock and run the migration once.
 */
function waldorf_pb_maybe_migrate_content(): void {
	if ( (int) get_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, 0 ) >= WALDORF_PB_CONTENT_MIGRATION_VERSION ) {
		return;
	}

	$current_lock = (string) get_option( WALDORF_PB_CONTENT_MIGRATION_LOCK, '' );
	$lock_time    = (int) strtok( $current_lock, ':' );
	if ( $lock_time > 0 && $lock_time < time() - 10 * MINUTE_IN_SECONDS ) {
		delete_option( WALDORF_PB_CONTENT_MIGRATION_LOCK );
	}

	$lock_token = time() . ':' . wp_generate_uuid4();
	if ( ! add_option( WALDORF_PB_CONTENT_MIGRATION_LOCK, $lock_token, '', 'no' ) ) {
		return;
	}

	$page_id = absint( get_option( 'page_on_front', 0 ) );
	try {
		$result = waldorf_pb_run_content_migration();
		if ( is_wp_error( $result ) ) {
			waldorf_pb_store_migration_error( $result, $page_id );
		}
	} catch ( Throwable $error ) {
		waldorf_pb_store_migration_error( new WP_Error( 'unexpected_error', $error->getMessage() ), $page_id );
	} finally {
		if ( $lock_token === get_option( WALDORF_PB_CONTENT_MIGRATION_LOCK ) ) {
			delete_option( WALDORF_PB_CONTENT_MIGRATION_LOCK );
		}
	}
}
add_action( 'init', 'waldorf_pb_maybe_migrate_content', 100 );

/**
 * Surface persistent migration failures to administrators.
 */
function waldorf_pb_content_migration_admin_notice(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$error = get_option( WALDORF_PB_CONTENT_MIGRATION_ERROR, array() );
	if ( ! is_array( $error ) || empty( $error['message'] ) ) {
		return;
	}

	$page_id = isset( $error['page_id'] ) ? absint( $error['page_id'] ) : 0;
	$edit_url = $page_id > 0 ? get_edit_post_link( $page_id, 'raw' ) : '';
	?>
	<div class="notice notice-error">
		<p><strong><?php esc_html_e( 'Startseiten-Migration angehalten:', 'waldorf-pfirsichbluete' ); ?></strong> <?php echo esc_html( (string) $error['message'] ); ?></p>
		<p>
			<?php esc_html_e( 'Es wurden keine nicht erkannten Seiteninhalte überschrieben. Ursache beheben; die Migration versucht es beim nächsten Aufruf erneut.', 'waldorf-pfirsichbluete' ); ?>
			<?php if ( is_string( $edit_url ) && '' !== $edit_url ) : ?>
				<a href="<?php echo esc_url( $edit_url ); ?>"><?php esc_html_e( 'Startseite prüfen', 'waldorf-pfirsichbluete' ); ?></a>
			<?php endif; ?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'waldorf_pb_content_migration_admin_notice' );
