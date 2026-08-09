<?php
/**
 * Focused, database-free checks for the front-page migration contract.
 */

declare( strict_types = 1 );

$repository = dirname( __DIR__ );
$theme      = $repository . '/wordpress/wp-content/themes/waldorf-pfirsichbluete';

define( 'ABSPATH', $repository . '/wordpress/' );
define( 'MINUTE_IN_SECONDS', 60 );

class WP_Error {
	/** @var string */
	private $code;
	/** @var string */
	private $message;

	public function __construct( string $code = '', string $message = '' ) {
		$this->code    = $code;
		$this->message = $message;
	}

	public function get_error_code(): string {
		return $this->code;
	}

	public function get_error_message(): string {
		return $this->message;
	}
}

function add_action(): void {}
function is_wp_error( $value ): bool {
	return $value instanceof WP_Error;
}
function get_template_directory(): string {
	global $theme;
	return $theme;
}
function wp_basename( string $path ): string {
	return basename( $path );
}
function absint( $value ): int {
	return abs( (int) $value );
}
function wp_strip_all_tags( string $value ): string {
	return strip_tags( $value );
}

require $theme . '/inc/content-migration.php';

$checks = 0;

/**
 * @param bool   $condition Assertion result.
 * @param string $message   Failure description.
 */
function verify( bool $condition, string $message ): void {
	global $checks;
	++$checks;
	if ( ! $condition ) {
		fwrite( STDERR, "FAIL: {$message}\n" );
		exit( 1 );
	}
}

verify( 'empty' === waldorf_pb_classify_front_page_content( " \n" ), 'A truly empty page is seedable.' );
verify( 'new' === waldorf_pb_classify_front_page_content( '<!-- wp:waldorf/photo /-->' ), 'New Waldorf content is never reseeded.' );
verify( 'unknown' === waldorf_pb_classify_front_page_content( '<!-- wp:paragraph --><p>Editor text</p><!-- /wp:paragraph -->' ), 'Editor-owned content is rejected.' );

$legacy = '<!-- wp:group --><div class="wp-block-group hero"><!-- wp:waldorf-idstein/news-panel /--><!-- wp:waldorf-idstein/tagesrhythmus /--></div><!-- /wp:group -->';
verify( 'legacy' === waldorf_pb_classify_front_page_content( $legacy ), 'All legacy signatures are required and recognized.' );
verify( 'unknown' === waldorf_pb_classify_front_page_content( '<!-- wp:waldorf-idstein/news-panel /-->' ), 'Partial legacy content is rejected.' );

$canonical = waldorf_pb_build_canonical_front_page_content();
verify( ! is_wp_error( $canonical ), 'Canonical local patterns load.' );
verify( false === strpos( $canonical, 'wp:pattern' ), 'Canonical content has no persisted pattern references.' );
verify( false !== strpos( $canonical, '"variant":"back-to-top"' ), 'Canonical content includes back-to-top decoration.' );

$front_pattern = file_get_contents( $theme . '/patterns/front-page.php' );
preg_match_all( '/"slug":"waldorf-pfirsichbluete\/([a-z-]+)"/', $front_pattern, $front_pattern_matches );
verify( waldorf_pb_front_page_pattern_slugs() === $front_pattern_matches[1], 'Migration order matches the complete front-page pattern.' );

$last_position = -1;
foreach ( waldorf_pb_front_page_pattern_slugs() as $slug ) {
	$pattern = waldorf_pb_load_migration_pattern( $slug );
	verify( ! is_wp_error( $pattern ), 'Pattern loads: ' . $slug );
	$position = strpos( $canonical, $pattern );
	verify( false !== $position && $position > $last_position, 'Pattern is concrete and ordered: ' . $slug );
	$last_position = (int) $position;

	$opening_end = strpos( $pattern, '-->' );
	$opening     = false === $opening_end ? '' : substr( $pattern, 0, $opening_end );
	verify( false !== strpos( $opening, '"metadata":{"name"' ), 'Section root has an editor name: ' . $slug );
	verify( false !== strpos( $opening, '"templateLock":"all"' ), 'Section root protects its structure: ' . $slug );
	verify( false !== strpos( $opening, '"lock":{"remove":true}' ), 'Section root is removal-locked: ' . $slug );
	verify( false === strpos( $opening, '"move":true' ), 'Section root remains movable: ' . $slug );
}

preg_match_all( '/"fallback":"(photo-[^"]+\.jpg)"/', $canonical, $fallback_matches );
$fallbacks = array_values( array_unique( $fallback_matches[1] ) );
sort( $fallbacks );
$photos = waldorf_pb_migration_photo_filenames();
sort( $photos );
verify( $photos === $fallbacks, 'All and only the ten portable photo fallbacks are imported.' );

foreach ( $photos as $photo ) {
	verify( hash_file( 'sha256', $theme . '/assets/images/' . $photo ) !== false, 'Photo source exists: ' . $photo );
}
foreach ( waldorf_pb_migration_pdf_filenames() as $pdf ) {
	verify( hash_file( 'sha256', ABSPATH . 'downloads/' . $pdf ) !== false, 'PDF source exists: ' . $pdf );
}

$links = waldorf_pb_migration_download_links();
verify( 3 === count( $links ), 'Exactly three semantically known downloads are linked.' );
verify( ! isset( $links['Konzeption'] ) && ! isset( $links['Packliste Waldtag'] ) && ! isset( $links['Ferien & Schließtage'] ), 'Unknown download placeholders remain unlinked.' );

$attachments = array(
	'photo-hero.jpg'                => array( 'id' => 101, 'url' => 'https://example.test/photo-hero.jpg' ),
	'anmeldung-familiengruppe.pdf' => array( 'id' => 201, 'url' => 'https://example.test/anmeldung.pdf' ),
);
$blocks = array(
	array(
		'blockName'   => 'core/group',
		'attrs'       => array(),
		'innerBlocks' => array(
			array( 'blockName' => 'waldorf/photo', 'attrs' => array( 'id' => 0, 'fallback' => 'photo-hero.jpg' ), 'innerBlocks' => array() ),
			array( 'blockName' => 'waldorf/photo', 'attrs' => array( 'id' => 999, 'fallback' => 'photo-hero.jpg' ), 'innerBlocks' => array() ),
			array( 'blockName' => 'waldorf/download', 'attrs' => array( 'id' => 0, 'fileUrl' => '#', 'title' => 'Anmeldebogen' ), 'innerBlocks' => array() ),
			array( 'blockName' => 'waldorf/download', 'attrs' => array( 'id' => 0, 'fileUrl' => '#', 'title' => 'Konzeption' ), 'innerBlocks' => array() ),
			array( 'blockName' => 'waldorf/download', 'attrs' => array( 'id' => 0, 'fileUrl' => 'https://editor.test/file.pdf', 'title' => 'Anmeldebogen' ), 'innerBlocks' => array() ),
		),
	),
);

$changed = false;
$blocks  = waldorf_pb_hydrate_front_page_assets( $blocks, $attachments, $changed );
$children = $blocks[0]['innerBlocks'];
verify( $changed && 101 === $children[0]['attrs']['id'], 'Missing photo ID is hydrated recursively.' );
verify( 999 === $children[1]['attrs']['id'], 'Existing editor photo ID is preserved.' );
verify( 201 === $children[2]['attrs']['id'] && 'https://example.test/anmeldung.pdf' === $children[2]['attrs']['fileUrl'], 'Known placeholder receives attachment ID and URL.' );
verify( 0 === $children[3]['attrs']['id'] && '#' === $children[3]['attrs']['fileUrl'], 'Unknown placeholder is not mislinked.' );
verify( 0 === $children[4]['attrs']['id'] && 'https://editor.test/file.pdf' === $children[4]['attrs']['fileUrl'], 'Editor URL is never overwritten.' );

$changed = false;
$blocks  = waldorf_pb_hydrate_front_page_assets( $blocks, $attachments, $changed );
verify( ! $changed, 'A second hydration pass is idempotent.' );

$front_template = file_get_contents( $theme . '/templates/front-page.html' );
verify( false !== strpos( $front_template, 'wp:post-content' ) && false === strpos( $front_template, 'wp:pattern' ), 'Front template renders post content only.' );
$functions = file_get_contents( $theme . '/functions.php' );
verify( false !== strpos( $functions, "add_editor_style( 'assets/css/components.css' )" ), 'Shared component styles load in the editor.' );

$migration_source = file_get_contents( $theme . '/inc/content-migration.php' );
$page_update       = strpos( $migration_source, '$result = wp_update_post(' );
$version_update    = strpos( $migration_source, 'update_option( WALDORF_PB_CONTENT_MIGRATION_OPTION' );
verify( false !== $page_update && false !== $version_update && $page_update < $version_update, 'Completion is recorded only after the page update path.' );
verify( 0 === preg_match( '/page_on_front[^\n]*\b12\b/', $migration_source ), 'No front-page ID is hardcoded.' );
verify( false !== strpos( $migration_source, "'_waldorf_pb_source_filename'" ), 'Stable source attachment marker is declared.' );
verify( false !== strpos( $migration_source, 'add_option( WALDORF_PB_CONTENT_MIGRATION_LOCK' ), 'Migration uses an atomic option lock.' );

$pattern_files = glob( $theme . '/patterns/*.php' );
foreach ( $pattern_files as $pattern_file ) {
	$source = file_get_contents( $pattern_file );
	verify( false === strpos( $source, 'wp:html' ), 'No raw HTML block in ' . basename( $pattern_file ) );
	verify( 0 === preg_match( '/\$[A-Za-z_][A-Za-z0-9_]*\s*=\s*(?:array\s*\(|\[)/', $source ), 'No PHP content array in ' . basename( $pattern_file ) );
}

fwrite( STDOUT, "OK: {$checks} migration checks passed.\n" );
