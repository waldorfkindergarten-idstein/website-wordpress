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

const WALDORF_PB_CONTENT_MIGRATION_VERSION = 2;
const WALDORF_PB_CONTENT_MIGRATION_OPTION  = 'waldorf_pb_content_migration_version';
const WALDORF_PB_CONTENT_MIGRATION_LOCK    = 'waldorf_pb_content_migration_lock';
const WALDORF_PB_CONTENT_MIGRATION_ERROR   = 'waldorf_pb_content_migration_error';
const WALDORF_PB_CONTENT_MIGRATION_BACKUP  = 'waldorf_pb_content_migration_backup';
const WALDORF_PB_SOURCE_META_KEY           = '_waldorf_pb_source_filename';
const WALDORF_PB_SOURCE_HASH_META_KEY      = '_waldorf_pb_source_sha256';
const WALDORF_PB_MIGRATION_RETRY_SECONDS   = 5 * MINUTE_IN_SECONDS;
const WALDORF_PB_MIGRATION_LOCK_SECONDS    = 10 * MINUTE_IN_SECONDS;

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
 * Normalize legacy content exactly as used to produce the allowlisted hashes.
 */
function waldorf_pb_normalize_legacy_content( string $content ): string {
	$normalized = preg_replace( '/\s+/', ' ', $content );

	return trim( is_string( $normalized ) ? $normalized : $content );
}

/**
 * Return exact hashes of replaceable legacy content.
 *
 * Production may add a separately verified variant through the filter. Broad
 * signatures are deliberately not accepted.
 *
 * @return string[]
 */
function waldorf_pb_legacy_content_hashes(): array {
	$hashes = apply_filters(
		'waldorf_pb_legacy_content_hashes',
		array( '024fa4d26f210e3f6a87b53fbe1118e5d7f328e9ffab5473c99b5f4103791252' )
	);

	if ( ! is_array( $hashes ) ) {
		return array();
	}

	$hashes = array_map(
		static function ( $hash ): string {
			return is_string( $hash ) ? strtolower( $hash ) : '';
		},
		$hashes
	);

	return array_values(
		array_unique(
			array_filter(
				$hashes,
				static function ( string $hash ): bool {
					return 1 === preg_match( '/^[a-f0-9]{64}$/', $hash );
				}
			)
		)
	);
}

/**
 * Return the exact top-level schema expected for a complete migrated page.
 *
 * Section order and editorial attributes may change after migration, but every
 * protected canonical section and the back-to-top block must still exist.
 *
 * @return string[]
 */
function waldorf_pb_complete_front_page_schema(): array {
	$schema = array(
		'decoration:back-to-top',
		'decoration:hero-separator',
		'section:aktuelles',
		'section:anmeldung',
		'section:cta',
		'section:downloads',
		'section:gruppen',
		'section:haus',
		'section:hero',
		'section:jahreslauf',
		'section:kontakt',
		'section:rhythmus',
		'section:season',
		'section:stimmen',
		'section:team',
		'section:values',
		'section:verpflegung',
	);
	sort( $schema );

	return $schema;
}

/**
 * Resolve a block's anchor id, falling back to its outermost HTML tag's id.
 *
 * The `anchor` block support is HTML-sourced ( `attribute: 'id', selector: '*'` ),
 * so the block editor writes it only as `id="..."` on the block's wrapper
 * element and never back into the comment-JSON `attrs`. `parse_blocks()` only
 * sees the comment JSON, so a saved block's anchor must be read from its
 * markup instead. Only the block's own outermost opening tag is inspected so
 * an id belonging to nested content is never mistaken for the block's anchor.
 *
 * @param array<string, mixed> $block Parsed block array from parse_blocks().
 * @return string The anchor id, or an empty string when the block has none.
 */
function waldorf_pb_front_page_block_anchor( array $block ): string {
	$attrs = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
	if ( isset( $attrs['anchor'] ) && is_string( $attrs['anchor'] ) && '' !== $attrs['anchor'] ) {
		return $attrs['anchor'];
	}

	$inner_html = isset( $block['innerHTML'] ) ? (string) $block['innerHTML'] : '';
	if ( '' === trim( $inner_html ) ) {
		return '';
	}

	$tags = new WP_HTML_Tag_Processor( $inner_html );
	if ( ! $tags->next_tag() ) {
		return '';
	}

	$id = $tags->get_attribute( 'id' );

	return is_string( $id ) ? $id : '';
}

/**
 * Derive stable top-level schema tokens from concrete page blocks.
 *
 * @return string[]
 */
function waldorf_pb_front_page_schema_from_content( string $content ): array {
	$schema       = array();
	$anchor_names = array( 'aktuelles', 'anmeldung', 'downloads', 'gruppen', 'haus', 'jahreslauf', 'kontakt', 'rhythmus', 'team', 'verpflegung' );
	$named_roots  = array(
		'Jahreszeitentisch'  => 'season',
		'Werte und Leitbild' => 'values',
		'Elternstimmen'      => 'stimmen',
		'Kennenlern-Aufruf'  => 'cta',
	);

	foreach ( parse_blocks( $content ) as $block ) {
		$name = isset( $block['blockName'] ) ? (string) $block['blockName'] : '';
		if ( '' === $name && '' === trim( (string) ( $block['innerHTML'] ?? '' ) ) ) {
			continue;
		}

		$attrs = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
		if ( 'waldorf/dekoration' === $name && 'back-to-top' === ( $attrs['variant'] ?? '' ) ) {
			$schema[] = 'decoration:back-to-top';
			continue;
		}
		if ( 'core/separator' === $name && false !== strpos( (string) ( $attrs['className'] ?? '' ), 'is-style-hand-drawn' ) ) {
			$schema[] = 'decoration:hero-separator';
			continue;
		}

		if ( 'core/group' !== $name ) {
			$schema[] = 'unknown:' . $name;
			continue;
		}

		$anchor = waldorf_pb_front_page_block_anchor( $block );
		if ( in_array( $anchor, $anchor_names, true ) ) {
			$schema[] = 'section:' . $anchor;
			continue;
		}

		$class_name = isset( $attrs['className'] ) ? (string) $attrs['className'] : '';
		if ( in_array( 'pb-hero', preg_split( '/\s+/', $class_name ) ?: array(), true ) ) {
			$schema[] = 'section:hero';
			continue;
		}

		$editor_name = isset( $attrs['metadata']['name'] ) ? (string) $attrs['metadata']['name'] : '';
		if ( isset( $named_roots[ $editor_name ] ) ) {
			$schema[] = 'section:' . $named_roots[ $editor_name ];
			continue;
		}

		$schema[] = 'unknown:core/group';
	}

	sort( $schema );

	return $schema;
}

/**
 * Classify current content without treating arbitrary editor content as seedable.
 *
 * @return string One of empty, legacy, new or unknown.
 */
function waldorf_pb_classify_front_page_content( string $content ): string {
	if ( '' === trim( $content ) ) {
		return 'empty';
	}

	if ( waldorf_pb_complete_front_page_schema() === waldorf_pb_front_page_schema_from_content( $content ) ) {
		return 'new';
	}

	$legacy_hash = hash( 'sha256', waldorf_pb_normalize_legacy_content( $content ) );
	if ( in_array( $legacy_hash, waldorf_pb_legacy_content_hashes(), true ) ) {
		return 'legacy';
	}

	return 'unknown';
}

/**
 * Load a local pattern body without relying on pattern-registry timing.
 *
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
 * Whether the migration has completed successfully.
 */
function waldorf_pb_content_migration_is_complete(): bool {
	return (int) get_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, 0 ) >= WALDORF_PB_CONTENT_MIGRATION_VERSION;
}

/**
 * Whether this request needs the safe front-page fallback.
 */
function waldorf_pb_should_render_front_page_fallback(): bool {
	return ! is_admin()
		&& ! waldorf_pb_content_migration_is_complete()
		&& did_action( 'wp' ) > 0
		&& is_front_page();
}

/**
 * While incomplete, prevent a DB template override from bypassing the fallback.
 *
 * @param WP_Block_Template|null $template      Resolved template.
 * @param string                 $id            Template ID.
 * @param string                 $template_type Template post type.
 * @return WP_Block_Template|null
 */
function waldorf_pb_use_file_front_page_template_until_migrated( $template, string $id, string $template_type ) {
	$front_page_id = get_stylesheet() . '//front-page';
	if ( ! waldorf_pb_should_render_front_page_fallback() || 'wp_template' !== $template_type || $front_page_id !== $id ) {
		return $template;
	}

	$file_template = get_block_file_template( $front_page_id, 'wp_template' );

	return $file_template instanceof WP_Block_Template ? $file_template : $template;
}
add_filter( 'pre_get_block_template', 'waldorf_pb_use_file_front_page_template_until_migrated', 10, 3 );

/**
 * Replace a custom front-page template in plural template resolution.
 *
 * @param WP_Block_Template[] $templates     Resolved templates.
 * @param array               $query         Template query.
 * @param string              $template_type Template post type.
 * @return WP_Block_Template[]
 */
function waldorf_pb_use_file_front_page_template_in_list_until_migrated( array $templates, array $query, string $template_type ): array {
	if ( ! waldorf_pb_should_render_front_page_fallback() || 'wp_template' !== $template_type ) {
		return $templates;
	}

	$front_page_id = get_stylesheet() . '//front-page';
	$file_template = get_block_file_template( $front_page_id, 'wp_template' );
	if ( ! $file_template instanceof WP_Block_Template ) {
		return $templates;
	}

	foreach ( $templates as $index => $template ) {
		if ( $template instanceof WP_Block_Template && $front_page_id === $template->id && 'custom' === $template->source ) {
			$templates[ $index ] = $file_template;
		}
	}

	return $templates;
}
add_filter( 'get_block_templates', 'waldorf_pb_use_file_front_page_template_in_list_until_migrated', 20, 3 );

/**
 * Preserve the exact wrapper emitted by core/post-content while replacing it.
 *
 * @param string $block_content Existing rendered wrapper, possibly empty.
 * @param string $inner_content Canonical rendered blocks.
 * @param array  $block         Parsed post-content block.
 */
function waldorf_pb_replace_post_content_inner( string $block_content, string $inner_content, array $block ): string {
	$opening_end   = strpos( $block_content, '>' );
	$closing_start = strrpos( $block_content, '</' );
	if ( false !== $opening_end && false !== $closing_start && $closing_start > $opening_end ) {
		return substr( $block_content, 0, $opening_end + 1 ) . $inner_content . substr( $block_content, $closing_start );
	}

	$tag_name = 'div';
	if ( ! empty( $block['attrs']['tagName'] ) && tag_escape( $block['attrs']['tagName'] ) === $block['attrs']['tagName'] ) {
		$tag_name = $block['attrs']['tagName'];
	}

	return sprintf(
		'<%1$s class="entry-content wp-block-post-content is-layout-flow wp-block-post-content-is-layout-flow">%2$s</%1$s>',
		$tag_name,
		$inner_content
	);
}

/**
 * Replace only the actual front page's post-content output with canonical blocks.
 *
 * @param string   $block_content Rendered post-content block.
 * @param array    $block         Parsed post-content block.
 * @param WP_Block $instance      Block instance carrying post context.
 */
function waldorf_pb_render_front_page_fallback( string $block_content, array $block, $instance ): string {
	static $rendering = false;

	$post_id       = isset( $instance->context['postId'] ) ? absint( $instance->context['postId'] ) : 0;
	$front_page_id = absint( get_option( 'page_on_front', 0 ) );
	$is_static     = 'page' === get_option( 'show_on_front' );
	if ( $rendering || ! waldorf_pb_should_render_front_page_fallback() || ( $is_static && ( 0 === $front_page_id || $post_id !== $front_page_id ) ) ) {
		return $block_content;
	}

	$canonical = waldorf_pb_build_canonical_front_page_content();
	if ( is_wp_error( $canonical ) ) {
		return $block_content;
	}

	$rendering = true;
	try {
		$content = do_blocks( $canonical );
	} finally {
		$rendering = false;
	}

	return waldorf_pb_replace_post_content_inner( $block_content, $content, $block );
}
add_filter( 'render_block_core/post-content', 'waldorf_pb_render_front_page_fallback', 20, 3 );

/**
 * Return all waldorf block names referenced in a parsed tree.
 *
 * @param array[] $blocks Parsed blocks.
 * @return string[]
 */
function waldorf_pb_collect_waldorf_block_names( array $blocks ): array {
	$names = array();
	foreach ( $blocks as $block ) {
		$name = isset( $block['blockName'] ) ? (string) $block['blockName'] : '';
		if ( 0 === strpos( $name, 'waldorf/' ) ) {
			$names[] = $name;
		}

		if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
			$names = array_merge( $names, waldorf_pb_collect_waldorf_block_names( $block['innerBlocks'] ) );
		}
	}

	$names = array_values( array_unique( $names ) );
	sort( $names );

	return $names;
}

/**
 * Find referenced blocks that are unavailable at migration time.
 *
 * The optional callback keeps this helper independently testable.
 *
 * @param string[]     $names         Block names.
 * @param callable|null $is_registered Optional registration predicate.
 * @return string[]
 */
function waldorf_pb_find_unregistered_blocks( array $names, $is_registered = null ): array {
	if ( ! is_callable( $is_registered ) ) {
		$is_registered = static function ( string $name ): bool {
			return WP_Block_Type_Registry::get_instance()->is_registered( $name );
		};
	}

	return array_values(
		array_filter(
			$names,
			static function ( string $name ) use ( $is_registered ): bool {
				return ! (bool) call_user_func( $is_registered, $name );
			}
		)
	);
}

/**
 * Return source paths keyed by stable filename.
 *
 * @return array<string, string>
 */
function waldorf_pb_migration_source_paths(): array {
	$image_dir   = get_template_directory() . '/assets/images/';
	$download_dir = (string) apply_filters( 'waldorf_pb_download_source_directory', ABSPATH . 'downloads' );
	$download_dir = untrailingslashit( $download_dir );
	$sources      = array();

	foreach ( waldorf_pb_migration_photo_filenames() as $filename ) {
		$sources[ $filename ] = $image_dir . $filename;
	}

	foreach ( waldorf_pb_migration_pdf_filenames() as $filename ) {
		$sources[ $filename ] = $download_dir . '/' . $filename;
	}

	return $sources;
}

/**
 * Validate every source and return its expected SHA-256 hash.
 *
 * @param array<string, string> $sources Source paths.
 * @return array<string, array{path:string,hash:string}>|WP_Error
 */
function waldorf_pb_validate_migration_sources( array $sources ) {
	$validated = array();
	foreach ( $sources as $filename => $path ) {
		if ( ! is_string( $path ) || ! is_file( $path ) || ! is_readable( $path ) ) {
			return new WP_Error( 'missing_source', 'Quelldatei fehlt oder ist nicht lesbar: ' . (string) $path );
		}

		$hash = hash_file( 'sha256', $path );
		if ( false === $hash ) {
			return new WP_Error( 'source_hash_failed', 'Prüfsumme konnte nicht gelesen werden: ' . $filename );
		}

		$validated[ $filename ] = array(
			'path' => $path,
			'hash' => $hash,
		);
	}

	return $validated;
}

/**
 * Detect a Site Editor override that takes precedence over the theme template.
 */
function waldorf_pb_has_custom_front_page_template(): bool {
	$template = get_block_template( get_stylesheet() . '//front-page', 'wp_template' );

	return $template instanceof WP_Block_Template && 'custom' === $template->source && 'publish' === $template->status;
}

/**
 * Check all prerequisites before importing media or changing options/content.
 *
 * @return array<string, array{path:string,hash:string}>|WP_Error
 */
function waldorf_pb_preflight_content_migration( string $canonical ) {
	if ( waldorf_pb_complete_front_page_schema() !== waldorf_pb_front_page_schema_from_content( $canonical ) ) {
		return new WP_Error( 'canonical_schema_invalid', 'Die kanonische Startseite ist unvollständig oder strukturell ungültig.' );
	}

	$block_names = waldorf_pb_collect_waldorf_block_names( parse_blocks( $canonical ) );
	$missing     = waldorf_pb_find_unregistered_blocks( $block_names );
	if ( ! empty( $missing ) ) {
		return new WP_Error( 'blocks_unregistered', 'Nicht registrierte Waldorf-Blöcke: ' . implode( ', ', $missing ) );
	}

	if ( waldorf_pb_has_custom_front_page_template() ) {
		return new WP_Error(
			'custom_front_page_template',
			'Im Website-Editor existiert eine angepasste DB-Version des Templates „Startseite“. Unter Design > Website-Editor > Templates > Startseite bitte die Anpassungen löschen/zurücksetzen.'
		);
	}

	$sources = waldorf_pb_validate_migration_sources( waldorf_pb_migration_source_paths() );
	if ( is_wp_error( $sources ) ) {
		return $sources;
	}

	$uploads = wp_upload_dir( null, false, true );
	if ( ! empty( $uploads['error'] ) ) {
		return new WP_Error( 'uploads_unavailable', 'Upload-Verzeichnis ist nicht verfügbar: ' . $uploads['error'] );
	}

	$upload_base = isset( $uploads['basedir'] ) ? (string) $uploads['basedir'] : '';
	if ( '' === $upload_base || ! is_dir( $upload_base ) || ! wp_is_writable( $upload_base ) ) {
		return new WP_Error( 'uploads_not_writable', 'Das WordPress-Upload-Verzeichnis fehlt oder ist nicht beschreibbar: ' . $upload_base );
	}

	$temp_dir = get_temp_dir();
	if ( '' === $temp_dir || ! is_dir( $temp_dir ) || ! wp_is_writable( $temp_dir ) ) {
		return new WP_Error( 'temp_not_writable', 'Das temporäre Verzeichnis fehlt oder ist nicht beschreibbar: ' . $temp_dir );
	}

	return $sources;
}

/**
 * Find and validate one attachment by its stable source identity.
 *
 * @return int|WP_Error Zero if no attachment exists.
 */
function waldorf_pb_find_source_attachment( string $filename, string $expected_hash ) {
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

	$actual_hash = hash_file( 'sha256', $file );
	$stored_hash = (string) get_post_meta( $attachment_id, WALDORF_PB_SOURCE_HASH_META_KEY, true );
	if ( false === $actual_hash || $actual_hash !== $expected_hash || ( '' !== $stored_hash && $stored_hash !== $expected_hash ) ) {
		return new WP_Error( 'attachment_source_mismatch', 'Das markierte Medium stimmt nicht mehr mit der Quelle überein: ' . $filename );
	}

	if ( '' === $stored_hash && false === add_post_meta( $attachment_id, WALDORF_PB_SOURCE_HASH_META_KEY, $expected_hash, true ) ) {
		return new WP_Error( 'attachment_hash_marker_failed', 'Quellprüfsumme konnte nicht ergänzt werden: ' . $filename );
	}

	return $attachment_id;
}

/**
 * Import one exact source through the WordPress media pipeline.
 *
 * @param array{path:string,hash:string} $source Validated source.
 * @return int|WP_Error Attachment ID.
 */
function waldorf_pb_import_source_attachment( string $filename, array $source ) {
	$existing = waldorf_pb_find_source_attachment( $filename, $source['hash'] );
	if ( is_wp_error( $existing ) || $existing > 0 ) {
		return $existing;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$temp_file = wp_tempnam( $filename );
	if ( ! is_string( $temp_file ) || ! copy( $source['path'], $temp_file ) ) {
		return new WP_Error( 'source_copy_failed', 'Temporäre Kopie fehlgeschlagen: ' . $filename );
	}

	$file_array = array(
		'name'     => $filename,
		'tmp_name' => $temp_file,
	);
	$attachment = media_handle_sideload( $file_array, 0, pathinfo( $filename, PATHINFO_FILENAME ) );

	if ( is_wp_error( $attachment ) ) {
		if ( is_file( $temp_file ) ) {
			unlink( $temp_file );
		}
		return $attachment;
	}

	$attachment_id   = (int) $attachment;
	$attachment_file = get_attached_file( $attachment_id );
	$uploaded_hash   = is_string( $attachment_file ) && is_file( $attachment_file ) ? hash_file( 'sha256', $attachment_file ) : false;
	if ( $source['hash'] !== $uploaded_hash ) {
		wp_delete_attachment( $attachment_id, true );
		return new WP_Error( 'attachment_hash_mismatch', 'Die Mediendatei ist keine exakte Kopie von ' . $filename . '.' );
	}

	$filename_saved = add_post_meta( $attachment_id, WALDORF_PB_SOURCE_META_KEY, $filename, true );
	$hash_saved     = add_post_meta( $attachment_id, WALDORF_PB_SOURCE_HASH_META_KEY, $source['hash'], true );
	if ( ! $filename_saved || ! $hash_saved ) {
		wp_delete_attachment( $attachment_id, true );
		return new WP_Error( 'attachment_marker_failed', 'Quellmarkierungen konnten nicht gespeichert werden: ' . $filename );
	}

	return $attachment_id;
}

/**
 * Import validated migration sources and return attachment data by filename.
 *
 * @param array<string, array{path:string,hash:string}> $sources Validated sources.
 * @return array<string, array{id:int,url:string}>|WP_Error
 */
function waldorf_pb_import_migration_media( array $sources, string $lock_token = '' ) {
	$attachments = array();
	foreach ( $sources as $filename => $source ) {
		if ( '' !== $lock_token && ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
			return new WP_Error( 'migration_lock_lost', 'Die Migrationssperre ging während des Medienimports verloren.' );
		}

		$attachment_id = waldorf_pb_import_source_attachment( $filename, $source );
		if ( is_wp_error( $attachment_id ) ) {
			return $attachment_id;
		}
		if ( '' !== $lock_token && ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
			return new WP_Error( 'migration_lock_lost', 'Die Migrationssperre ging während des Medienimports verloren.' );
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
 * @param array[]                                  $blocks      Parsed blocks.
 * @param array<string, array{id:int,url:string}> $attachments Imported attachment data.
 * @param bool                                     $changed     Set when attributes change.
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
 * Parse a lock timestamp without trusting malformed option data.
 */
function waldorf_pb_lock_timestamp( string $token ): int {
	if ( 1 !== preg_match( '/^(\d+):[A-Za-z0-9-]+$/', $token, $matches ) ) {
		return 0;
	}

	return (int) $matches[1];
}

/**
 * Whether a token is old enough for fenced stale cleanup.
 */
function waldorf_pb_lock_token_is_stale( string $token, int $now = 0 ): bool {
	$timestamp = waldorf_pb_lock_timestamp( $token );
	$now       = $now > 0 ? $now : time();

	return $timestamp > 0 && $timestamp < $now - WALDORF_PB_MIGRATION_LOCK_SECONDS;
}

/**
 * Check current lock ownership.
 */
function waldorf_pb_migration_lock_is_owned( string $token ): bool {
	global $wpdb;

	$current = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT option_value FROM {$wpdb->options} WHERE option_name = %s LIMIT 1",
			WALDORF_PB_CONTENT_MIGRATION_LOCK
		)
	);
	$current = is_string( $current ) ? $current : '';

	return '' !== $token && strlen( $current ) === strlen( $token ) && hash_equals( $current, $token );
}

/**
 * Atomically delete only the exact token observed by this process.
 */
function waldorf_pb_delete_migration_lock_if_owned( string $token ): bool {
	global $wpdb;

	if ( '' === $token ) {
		return false;
	}

	$deleted = $wpdb->delete(
		$wpdb->options,
		array(
			'option_name'  => WALDORF_PB_CONTENT_MIGRATION_LOCK,
			'option_value' => maybe_serialize( $token ),
		),
		array( '%s', '%s' )
	);

	if ( 1 === $deleted ) {
		wp_cache_delete( WALDORF_PB_CONTENT_MIGRATION_LOCK, 'options' );
		wp_cache_delete( 'alloptions', 'options' );
		return true;
	}

	return false;
}

/**
 * Acquire an atomic, token-fenced migration lock.
 */
function waldorf_pb_acquire_migration_lock(): string {
	$current = (string) get_option( WALDORF_PB_CONTENT_MIGRATION_LOCK, '' );
	if ( '' !== $current ) {
		if ( ! waldorf_pb_lock_token_is_stale( $current ) || ! waldorf_pb_delete_migration_lock_if_owned( $current ) ) {
			return '';
		}
	}

	$token = time() . ':' . wp_generate_uuid4();
	if ( ! add_option( WALDORF_PB_CONTENT_MIGRATION_LOCK, $token, '', 'no' ) ) {
		return '';
	}

	return $token;
}

/**
 * Store an actionable failure for administrators without marking completion.
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
 * Validate and return the durable migration backup.
 *
 * @return array|null|WP_Error
 */
function waldorf_pb_get_content_backup( int $page_id ) {
	$backup = get_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP, null );
	if ( null === $backup || false === $backup ) {
		return null;
	}
	if ( ! is_array( $backup ) || $page_id !== absint( $backup['page_id'] ?? 0 ) ) {
		return new WP_Error( 'backup_conflict', 'Die vorhandene Migrationssicherung ist ungültig oder gehört zu einer anderen Seite.' );
	}

	$original = isset( $backup['content'] ) ? (string) $backup['content'] : '';
	if ( ! isset( $backup['hash'] ) || ! hash_equals( hash( 'sha256', $original ), (string) $backup['hash'] ) ) {
		return new WP_Error( 'backup_conflict', 'Die vorhandene Migrationssicherung hat ungültige Original- oder Zielprüfsummen.' );
	}
	if ( ! isset( $backup['target_content'], $backup['target_hash'] ) ) {
		$backup['target_content'] = null;
		$backup['target_hash']    = null;
		$backup['original_type']  = waldorf_pb_classify_front_page_content( $original );
		$backup['revision_id']    = absint( $backup['revision_id'] ?? 0 );

		return $backup;
	}

	$target = (string) $backup['target_content'];
	if ( ! hash_equals( hash( 'sha256', $target ), (string) $backup['target_hash'] ) ) {
		return new WP_Error( 'backup_conflict', 'Die vorhandene Migrationssicherung hat ungültige Original- oder Zielprüfsummen.' );
	}

	return $backup;
}

/**
 * Identify whether current page content is the durable original or target.
 *
 * @param array $backup Validated backup.
 * @return string One of original, target or divergent.
 */
function waldorf_pb_content_backup_state( string $content, array $backup ): string {
	$hash = hash( 'sha256', $content );
	if ( hash_equals( (string) $backup['hash'], $hash ) && $content === (string) $backup['content'] ) {
		return 'original';
	}
	if ( is_string( $backup['target_content'] ) && is_string( $backup['target_hash'] ) && hash_equals( $backup['target_hash'], $hash ) && $content === $backup['target_content'] ) {
		return 'target';
	}

	return 'divergent';
}

/**
 * Store the independently recoverable original and exact intended target.
 *
 * @return true|WP_Error
 */
function waldorf_pb_store_content_backup( int $page_id, string $original_content, string $target_content, string $original_type, string $current_content ) {
	$existing = get_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP, null );
	$backup   = array(
		'page_id'        => $page_id,
		'content'        => $original_content,
		'hash'           => hash( 'sha256', $original_content ),
		'target_content' => $target_content,
		'target_hash'    => hash( 'sha256', $target_content ),
		'original_type'  => $original_type,
		'revision_id'    => 0,
		'time'           => time(),
	);

	if ( is_array( $existing ) ) {
		$validated = waldorf_pb_get_content_backup( $page_id );
		if ( is_wp_error( $validated ) ) {
			return $validated;
		}
		if ( (string) $validated['content'] !== $original_content || (string) ( $validated['original_type'] ?? $original_type ) !== $original_type ) {
			return new WP_Error( 'backup_conflict', 'Die vorhandene Sicherung beschreibt einen anderen Originalzustand.' );
		}

		$state = waldorf_pb_content_backup_state( $current_content, $validated );
		if ( ! is_string( $validated['target_content'] ) && 'original' === $state ) {
			$backup['revision_id'] = absint( $validated['revision_id'] ?? 0 );
			$backup['time']        = isset( $validated['time'] ) ? (int) $validated['time'] : time();
			if ( ! update_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP, $backup, false ) ) {
				return new WP_Error( 'backup_update_failed', 'Die vorhandene Sicherung konnte nicht um das exakte Migrationsziel ergänzt werden.' );
			}

			return true;
		}
		if ( (string) $validated['target_content'] === $target_content ) {
			return true;
		}
		if ( 'target' !== $state ) {
			return new WP_Error( 'backup_conflict', 'Das neue Migrationsziel weicht von der vorhandenen Sicherung ab.' );
		}

		$backup['revision_id'] = absint( $validated['revision_id'] ?? 0 );
		$backup['time']        = isset( $validated['time'] ) ? (int) $validated['time'] : time();
		if ( ! update_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP, $backup, false ) ) {
			return new WP_Error( 'backup_update_failed', 'Das fortgeschriebene Migrationsziel konnte nicht gesichert werden.' );
		}

		return true;
	}

	if ( ! add_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP, $backup, '', 'no' ) ) {
		return new WP_Error( 'backup_failed', 'Die unabhängige Sicherung der Startseite konnte nicht gespeichert werden.' );
	}

	return true;
}

/**
 * Persist the verified revision ID into the durable backup.
 */
function waldorf_pb_store_backup_revision( int $page_id, int $revision_id ): bool {
	$backup = waldorf_pb_get_content_backup( $page_id );
	if ( ! is_array( $backup ) ) {
		return false;
	}

	$backup['revision_id'] = $revision_id;

	return update_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP, $backup, false ) || $revision_id === absint( get_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP, array() )['revision_id'] ?? 0 );
}

/**
 * Verify that the independent backup still contains exact original and target.
 */
function waldorf_pb_backup_contains_content( int $page_id, string $original_content, string $target_content ): bool {
	$backup = waldorf_pb_get_content_backup( $page_id );

	return is_array( $backup )
		&& 'original' === waldorf_pb_content_backup_state( $original_content, $backup )
		&& 'target' === waldorf_pb_content_backup_state( $target_content, $backup );
}

/**
 * Create or find a positive revision that exactly contains the legacy original.
 *
 * @return int|WP_Error
 */
function waldorf_pb_require_original_revision( WP_Post $page, string $original_content ) {
	if ( ! wp_revisions_enabled( $page ) ) {
		return new WP_Error( 'revisions_disabled', 'Für die Startseite sind Revisionen deaktiviert; Legacy-Inhalte wurden nicht ersetzt.' );
	}

	$revision_id = wp_save_post_revision( $page->ID );
	if ( is_wp_error( $revision_id ) ) {
		return $revision_id;
	}

	if ( ! is_int( $revision_id ) || $revision_id <= 0 ) {
		$revisions = wp_get_post_revisions( $page->ID, array( 'posts_per_page' => 20 ) );
		foreach ( $revisions as $revision ) {
			if ( (string) $revision->post_content === $original_content ) {
				$revision_id = (int) $revision->ID;
				break;
			}
		}
	}

	if ( ! is_int( $revision_id ) || $revision_id <= 0 || ! waldorf_pb_revision_contains_content( $revision_id, $page->ID, $original_content ) ) {
		return new WP_Error( 'revision_unverified', 'Es konnte keine positive, überprüfbare Revision der Legacy-Startseite angelegt werden.' );
	}

	return $revision_id;
}

/**
 * Verify that a revision remains independently recoverable.
 */
function waldorf_pb_revision_contains_content( int $revision_id, int $page_id, string $content ): bool {
	$revision = get_post( $revision_id );

	return $revision instanceof WP_Post
		&& 'revision' === $revision->post_type
		&& $page_id === (int) $revision->post_parent
		&& hash_equals( hash( 'sha256', $content ), hash( 'sha256', (string) $revision->post_content ) );
}

/**
 * Write post content through WordPress's slashed input contract.
 *
 * wp_update_post() unslashes array input before persistence. Explicitly slashing
 * here preserves JSON escapes and literal backslashes in serialized blocks.
 *
 * @return int|WP_Error
 */
function waldorf_pb_write_page_content( int $page_id, string $content ) {
	return wp_update_post(
		array(
			'ID'           => $page_id,
			'post_content' => wp_slash( $content ),
		),
		true
	);
}

/**
 * Restore original content after a verified migration write failure.
 *
 * @return WP_Error
 */
function waldorf_pb_restore_original_content( int $page_id, string $original_content, WP_Error $cause ): WP_Error {
	$restored = waldorf_pb_write_page_content( $page_id, $original_content );

	clean_post_cache( $page_id );
	$restored_page = get_post( $page_id );
	if ( is_wp_error( $restored ) || 0 === $restored || ! $restored_page instanceof WP_Post || (string) $restored_page->post_content !== $original_content ) {
		return new WP_Error( 'restore_failed', 'KRITISCH: Die Startseite konnte nach einem Migrationsfehler nicht automatisch wiederhergestellt werden. Sicherungsoption prüfen.' );
	}

	return $cause;
}

/**
 * Resolve a durable backup against current content before a retry.
 *
 * @return array|WP_Error Recovery context.
 */
function waldorf_pb_prepare_content_recovery( WP_Post $page, string $lock_token ) {
	$current_content = (string) $page->post_content;
	$current_type    = waldorf_pb_classify_front_page_content( $current_content );
	$context         = array(
		'starting_content' => $current_content,
		'rollback_content' => $current_content,
		'original_type'    => $current_type,
		'content_type'     => $current_type,
		'revision_id'      => 0,
		'recovery_state'   => 'none',
	);
	$backup = waldorf_pb_get_content_backup( $page->ID );
	if ( null === $backup ) {
		return $context;
	}
	if ( is_wp_error( $backup ) ) {
		return $backup;
	}

	$state = waldorf_pb_content_backup_state( $current_content, $backup );
	if ( 'divergent' === $state ) {
		return new WP_Error(
			'migration_state_divergent',
			'Der aktuelle Startseiteninhalt entspricht weder dem dauerhaft gesicherten Original noch dem exakten Migrationsziel. Er gilt als redaktionell bearbeitet und wurde nicht verändert; Seite und Sicherung müssen manuell geprüft werden.'
		);
	}

	$original_type = isset( $backup['original_type'] ) ? (string) $backup['original_type'] : waldorf_pb_classify_front_page_content( (string) $backup['content'] );
	if ( 'target' === $state && 'new' !== $current_type ) {
		return waldorf_pb_restore_original_content(
			$page->ID,
			(string) $backup['content'],
			new WP_Error( 'migration_target_invalid', 'Das gespeicherte Migrationsziel war nicht mehr vollständig; das gesicherte Original wurde wiederhergestellt.' )
		);
	}

	$context['rollback_content'] = (string) $backup['content'];
	$context['original_type']    = $original_type;
	$context['revision_id']      = absint( $backup['revision_id'] ?? 0 );
	$context['recovery_state']   = $state;

	return $context;
}

/**
 * Reconcile an exception against exact durable original and target hashes.
 */
function waldorf_pb_reconcile_after_throwable( string $lock_token, WP_Error $cause ): WP_Error {
	$page_id = absint( get_option( 'page_on_front', 0 ) );
	$page    = get_post( $page_id );
	$backup  = waldorf_pb_get_content_backup( $page_id );
	if ( ! $page instanceof WP_Post || ! is_array( $backup ) ) {
		return $cause;
	}

	$state = waldorf_pb_content_backup_state( (string) $page->post_content, $backup );
	if ( 'original' === $state ) {
		return $cause;
	}
	if ( 'divergent' === $state ) {
		return new WP_Error( 'migration_exception_divergent', $cause->get_error_message() . ' Der aktuelle Inhalt weicht von gesichertem Original und Ziel ab und wurde als redaktionell geschützt nicht verändert.' );
	}
	if ( ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
		return new WP_Error( 'migration_exception_recovery_pending', $cause->get_error_message() . ' Der Lock ging verloren; der nächste Lauf gleicht Ziel und Sicherung ab.' );
	}

	if ( 'target' === $state
		&& 'new' === waldorf_pb_classify_front_page_content( (string) $page->post_content )
		&& ! waldorf_pb_has_custom_front_page_template() ) {
		$revision_id  = absint( $backup['revision_id'] ?? 0 );
		$original_type = isset( $backup['original_type'] ) ? (string) $backup['original_type'] : '';
		if ( 'legacy' !== $original_type || ( $revision_id > 0 && waldorf_pb_revision_contains_content( $revision_id, $page_id, (string) $backup['content'] ) ) ) {
			$version_saved = update_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, WALDORF_PB_CONTENT_MIGRATION_VERSION, false );
			if ( $version_saved || WALDORF_PB_CONTENT_MIGRATION_VERSION === (int) get_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, 0 ) ) {
				return new WP_Error( 'migration_exception_reconciled', $cause->get_error_message() . ' Das exakt gesicherte Ziel wurde geprüft und die Migration sicher abgeschlossen.' );
			}
		}
	}

	return waldorf_pb_restore_original_content(
		$page_id,
		(string) $backup['content'],
		new WP_Error( 'migration_exception_restored', $cause->get_error_message() . ' Das gesicherte Original wurde wiederhergestellt.' )
	);
}

/**
 * Execute the locked migration. Direct calls remain suitable for CLI/deployment.
 *
 * @return true|WP_Error
 */
function waldorf_pb_run_content_migration() {
	if ( waldorf_pb_content_migration_is_complete() ) {
		return true;
	}

	$lock_token = waldorf_pb_acquire_migration_lock();
	if ( '' === $lock_token ) {
		return new WP_Error( 'migration_locked', 'Eine andere Startseiten-Migration läuft bereits.' );
	}

	try {
		return waldorf_pb_run_locked_content_migration( $lock_token );
	} catch ( Throwable $throwable ) {
		$cause = new WP_Error( 'migration_exception', 'Unerwarteter Migrationsfehler: ' . $throwable->getMessage() );
		try {
			return waldorf_pb_reconcile_after_throwable( $lock_token, $cause );
		} catch ( Throwable $recovery_throwable ) {
			return new WP_Error( 'migration_recovery_exception', $cause->get_error_message() . ' Auch der Sicherungsabgleich schlug fehl: ' . $recovery_throwable->getMessage() );
		}
	} finally {
		waldorf_pb_delete_migration_lock_if_owned( $lock_token );
	}
}

/**
 * Internal migration implementation. The lock token fences every destructive step.
 *
 * @return true|WP_Error
 */
function waldorf_pb_run_locked_content_migration( string $lock_token ) {
	if ( 'page' !== get_option( 'show_on_front' ) ) {
		return new WP_Error( 'front_page_not_static', 'Unter Einstellungen > Lesen ist keine statische Startseite aktiviert.' );
	}

	$page_id = absint( get_option( 'page_on_front', 0 ) );
	$page    = get_post( $page_id );
	if ( 0 === $page_id || ! $page instanceof WP_Post || 'page' !== $page->post_type ) {
		return new WP_Error( 'front_page_invalid', 'Die konfigurierte Startseite ist keine gültige Seite.' );
	}

	$recovery = waldorf_pb_prepare_content_recovery( $page, $lock_token );
	if ( is_wp_error( $recovery ) ) {
		return $recovery;
	}

	$starting_content = (string) $recovery['starting_content'];
	$starting_hash    = hash( 'sha256', $starting_content );
	$rollback_content = (string) $recovery['rollback_content'];
	$original_type    = (string) $recovery['original_type'];
	$content_type     = (string) $recovery['content_type'];
	$revision_id      = absint( $recovery['revision_id'] );
	if ( 'unknown' === $content_type ) {
		return new WP_Error( 'front_page_unrecognized', 'Die Startseite entspricht weder dem exakten Legacy-Hash noch dem vollständigen neuen Schema. Sie wurde nicht überschrieben.' );
	}

	$canonical = waldorf_pb_build_canonical_front_page_content();
	if ( is_wp_error( $canonical ) ) {
		return $canonical;
	}

	$sources = waldorf_pb_preflight_content_migration( $canonical );
	if ( is_wp_error( $sources ) ) {
		return $sources;
	}

	if ( ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
		return new WP_Error( 'migration_lock_lost', 'Die Migrationssperre ging während der Vorprüfung verloren.' );
	}

	$attachments = waldorf_pb_import_migration_media( $sources, $lock_token );
	if ( is_wp_error( $attachments ) ) {
		return $attachments;
	}

	$seed_content = 'new' === $content_type ? $starting_content : $canonical;
	$blocks       = parse_blocks( $seed_content );
	$changed      = false;
	$blocks       = waldorf_pb_hydrate_front_page_assets( $blocks, $attachments, $changed );
	$target       = 'new' === $content_type && ! $changed ? $starting_content : serialize_blocks( $blocks );

	clean_post_cache( $page_id );
	$fresh_page    = get_post( $page_id );
	$fresh_content = $fresh_page instanceof WP_Post ? (string) $fresh_page->post_content : '';
	$fresh_type    = waldorf_pb_classify_front_page_content( $fresh_content );
	if ( ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
		return new WP_Error( 'migration_lock_lost', 'Die Migrationssperre ging vor dem Schreiben verloren.' );
	}
	if ( ! $fresh_page instanceof WP_Post || ! hash_equals( $starting_hash, hash( 'sha256', $fresh_content ) ) || $fresh_type !== $content_type ) {
		return new WP_Error( 'front_page_changed', 'Die Startseite wurde während des Medienimports bearbeitet. Es wurde kein Seiteninhalt überschrieben.' );
	}

	$backup = waldorf_pb_store_content_backup( $page_id, $rollback_content, $target, $original_type, $starting_content );
	if ( is_wp_error( $backup ) ) {
		return $backup;
	}
	if ( ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
		return new WP_Error( 'migration_lock_lost', 'Die Migrationssperre ging vor der Revisionssicherung verloren.' );
	}

	if ( 'legacy' === $original_type && ( $revision_id <= 0 || ! waldorf_pb_revision_contains_content( $revision_id, $page_id, $rollback_content ) ) ) {
		$revision_id = waldorf_pb_require_original_revision( $page, $rollback_content );
		if ( is_wp_error( $revision_id ) ) {
			return $revision_id;
		}
	}
	if ( $revision_id > 0 && ! waldorf_pb_store_backup_revision( $page_id, $revision_id ) ) {
		return new WP_Error( 'backup_revision_failed', 'Die verifizierte Revisions-ID konnte nicht in der dauerhaften Sicherung gespeichert werden.' );
	}

	clean_post_cache( $page_id );
	$pre_update_page    = get_post( $page_id );
	$pre_update_content = $pre_update_page instanceof WP_Post ? (string) $pre_update_page->post_content : '';
	if ( ! $pre_update_page instanceof WP_Post || ! hash_equals( $starting_hash, hash( 'sha256', $pre_update_content ) ) || waldorf_pb_classify_front_page_content( $pre_update_content ) !== $content_type ) {
		return new WP_Error( 'front_page_changed', 'Die Startseite wurde unmittelbar vor dem Update bearbeitet. Es wurde kein Seiteninhalt überschrieben.' );
	}

	if ( ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
		return new WP_Error( 'migration_lock_lost', 'Die Migrationssperre ging unmittelbar vor dem Seitenupdate verloren.' );
	}

	$result = waldorf_pb_write_page_content( $page_id, $target );
	if ( is_wp_error( $result ) || 0 === $result ) {
		return is_wp_error( $result ) ? $result : new WP_Error( 'page_update_failed', 'Die Startseite konnte nicht aktualisiert werden.' );
	}

	if ( ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
		return new WP_Error( 'migration_lock_lost_after_update', 'Die Migrationssperre ging nach dem Seitenupdate verloren; Original und Ziel sind dauerhaft gesichert und werden beim nächsten Lauf abgeglichen.' );
	}

	clean_post_cache( $page_id );
	$updated_page = get_post( $page_id );
	if ( ! $updated_page instanceof WP_Post || (string) $updated_page->post_content !== $target ) {
		return waldorf_pb_restore_original_content( $page_id, $rollback_content, new WP_Error( 'page_update_mismatch', 'Das gespeicherte Seitenergebnis wich vom Zielinhalt ab; der Originalinhalt wurde wiederhergestellt.' ) );
	}

	if ( ! waldorf_pb_backup_contains_content( $page_id, $rollback_content, $target ) ) {
		return waldorf_pb_restore_original_content( $page_id, $rollback_content, new WP_Error( 'backup_lost', 'Die unabhängige Sicherung war nach dem Update nicht mehr wiederherstellbar; der Originalinhalt wurde wiederhergestellt.' ) );
	}

	if ( 'legacy' === $original_type && ( $revision_id <= 0 || ! waldorf_pb_revision_contains_content( $revision_id, $page_id, $rollback_content ) ) ) {
		return waldorf_pb_restore_original_content( $page_id, $rollback_content, new WP_Error( 'revision_lost', 'Die Originalrevision war nach dem Update nicht mehr wiederherstellbar; der Originalinhalt wurde wiederhergestellt.' ) );
	}

	if ( ! waldorf_pb_migration_lock_is_owned( $lock_token ) ) {
		return new WP_Error( 'migration_lock_lost_before_version', 'Die Migrationssperre ging vor dem Versionsupdate verloren; die Version wurde nicht gesetzt.' );
	}

	$version_saved = update_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, WALDORF_PB_CONTENT_MIGRATION_VERSION, false );
	if ( ! $version_saved && WALDORF_PB_CONTENT_MIGRATION_VERSION !== (int) get_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, 0 ) ) {
		return waldorf_pb_restore_original_content( $page_id, $rollback_content, new WP_Error( 'version_update_failed', 'Die Migrationsversion konnte nicht gesetzt werden; der Originalinhalt wurde wiederhergestellt.' ) );
	}

	delete_option( WALDORF_PB_CONTENT_MIGRATION_ERROR );

	return true;
}

/**
 * Run automatically only for an authenticated administrator, with throttling.
 */
function waldorf_pb_maybe_migrate_content(): void {
	if ( ! current_user_can( 'manage_options' ) || waldorf_pb_content_migration_is_complete() ) {
		return;
	}

	$force_retry = isset( $_GET['waldorf_pb_retry_migration'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $force_retry ) {
		check_admin_referer( 'waldorf_pb_retry_migration' );
	}

	$error = get_option( WALDORF_PB_CONTENT_MIGRATION_ERROR, array() );
	if ( ! $force_retry && is_array( $error ) && isset( $error['time'] ) && (int) $error['time'] > time() - WALDORF_PB_MIGRATION_RETRY_SECONDS ) {
		return;
	}

	$result = waldorf_pb_run_content_migration();
	if ( is_wp_error( $result ) ) {
		waldorf_pb_store_migration_error( $result, absint( get_option( 'page_on_front', 0 ) ) );
	}
}
add_action( 'admin_init', 'waldorf_pb_maybe_migrate_content', 100 );

/**
 * Surface persistent migration failures and a nonce-protected retry path.
 */
function waldorf_pb_content_migration_admin_notice(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$error = get_option( WALDORF_PB_CONTENT_MIGRATION_ERROR, array() );
	if ( ! is_array( $error ) || empty( $error['message'] ) ) {
		return;
	}

	$page_id   = isset( $error['page_id'] ) ? absint( $error['page_id'] ) : 0;
	$edit_url  = $page_id > 0 ? get_edit_post_link( $page_id, 'raw' ) : '';
	$retry_url = wp_nonce_url( add_query_arg( 'waldorf_pb_retry_migration', '1', admin_url() ), 'waldorf_pb_retry_migration' );
	$reconciled = 'migration_exception_reconciled' === ( $error['code'] ?? '' );
	?>
	<div class="notice <?php echo $reconciled ? 'notice-warning' : 'notice-error'; ?>">
		<p><strong><?php echo esc_html( $reconciled ? __( 'Startseiten-Migration abgeglichen:', 'waldorf-pfirsichbluete' ) : __( 'Startseiten-Migration angehalten:', 'waldorf-pfirsichbluete' ) ); ?></strong> <?php echo esc_html( (string) $error['message'] ); ?></p>
		<?php if ( ! $reconciled ) : ?>
		<p>
			<?php esc_html_e( 'Bis zum Erfolg zeigt die öffentliche Startseite das kanonische Fallback. Automatische Versuche sind fünf Minuten gedrosselt.', 'waldorf-pfirsichbluete' ); ?>
			<?php if ( is_string( $edit_url ) && '' !== $edit_url ) : ?>
				<a href="<?php echo esc_url( $edit_url ); ?>"><?php esc_html_e( 'Startseite prüfen', 'waldorf-pfirsichbluete' ); ?></a>
			<?php endif; ?>
			<a href="<?php echo esc_url( $retry_url ); ?>"><?php esc_html_e( 'Jetzt erneut versuchen', 'waldorf-pfirsichbluete' ); ?></a>
		</p>
		<?php endif; ?>
	</div>
	<?php
	if ( $reconciled ) {
		delete_option( WALDORF_PB_CONTENT_MIGRATION_ERROR );
	}
}
add_action( 'admin_notices', 'waldorf_pb_content_migration_admin_notice' );
