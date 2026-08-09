<?php
/**
 * Focused, database-free checks for pure/static migration contracts.
 *
 * This is not a WordPress integration test: it does not exercise options,
 * database templates, revisions, uploads, capabilities, hooks or concurrent
 * requests. Those behaviors require the documented post-merge DB test.
 */

declare( strict_types = 1 );

$repository = dirname( __DIR__ );
$theme      = $repository . '/wordpress/wp-content/themes/waldorf-pfirsichbluete';

define( 'ABSPATH', $repository . '/wordpress/' );
define( 'MINUTE_IN_SECONDS', 60 );

require ABSPATH . 'wp-includes/class-wp-block-parser-block.php';
require ABSPATH . 'wp-includes/class-wp-block-parser-frame.php';
require ABSPATH . 'wp-includes/class-wp-block-parser.php';

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

$registered_actions = array();
$registered_filters = array();
$test_filters       = array();
$test_options       = array();
$test_is_admin      = false;
$test_is_front_page = false;
$test_did_wp        = 0;

function add_action( string $hook, string $callback ): void {
	global $registered_actions;
	$registered_actions[ $hook ][] = $callback;
}
function add_filter( string $hook, string $callback ): void {
	global $registered_filters;
	$registered_filters[ $hook ][] = $callback;
}
function apply_filters( string $hook, $value ) {
	global $test_filters;
	if ( isset( $test_filters[ $hook ] ) && is_callable( $test_filters[ $hook ] ) ) {
		return call_user_func_array( $test_filters[ $hook ], array_slice( func_get_args(), 1 ) );
	}

	return $value;
}
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
function untrailingslashit( string $value ): string {
	return rtrim( $value, '/\\' );
}
function parse_blocks( string $content ): array {
	return ( new WP_Block_Parser() )->parse( $content );
}
function get_option( string $name, $default = false ) {
	global $test_options;
	return array_key_exists( $name, $test_options ) ? $test_options[ $name ] : $default;
}
function is_admin(): bool {
	global $test_is_admin;
	return $test_is_admin;
}
function is_front_page(): bool {
	global $test_is_front_page;
	return $test_is_front_page;
}
function did_action( string $hook ): int {
	global $test_did_wp;
	return 'wp' === $hook ? $test_did_wp : 0;
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

verify(
	array( '024fa4d26f210e3f6a87b53fbe1118e5d7f328e9ffab5473c99b5f4103791252' ) === waldorf_pb_legacy_content_hashes(),
	'Default legacy allowlist contains only the reviewed normalized hash.'
);
verify( 2 === WALDORF_PB_CONTENT_MIGRATION_VERSION, 'Hardened migration reruns after any version-1 test deployment.' );
verify( 'empty' === waldorf_pb_classify_front_page_content( " \n" ), 'A truly empty page is seedable.' );
verify( 'unknown' === waldorf_pb_classify_front_page_content( '<!-- wp:waldorf/photo /-->' ), 'One partial new block is rejected.' );
verify( 'unknown' === waldorf_pb_classify_front_page_content( '<!-- wp:paragraph --><p>Editor text</p><!-- /wp:paragraph -->' ), 'Editor-owned content is rejected.' );

$test_options[ WALDORF_PB_CONTENT_MIGRATION_OPTION ] = 0;
$test_is_front_page = true;
$test_did_wp        = 1;
verify( waldorf_pb_should_render_front_page_fallback(), 'Incomplete migration enables fallback on the queried frontend front page.' );
$test_is_admin = true;
verify( ! waldorf_pb_should_render_front_page_fallback(), 'Fallback is disabled in admin requests.' );
$test_is_admin = false;
$test_options[ WALDORF_PB_CONTENT_MIGRATION_OPTION ] = WALDORF_PB_CONTENT_MIGRATION_VERSION;
verify( ! waldorf_pb_should_render_front_page_fallback(), 'Fallback disappears at the successful migration version.' );
$test_options[ WALDORF_PB_CONTENT_MIGRATION_OPTION ] = 0;
$test_is_front_page = false;
verify( ! waldorf_pb_should_render_front_page_fallback(), 'Fallback does not affect other frontend views.' );

$legacy_fixture = '<!-- wp:group --> <div>Known legacy fixture</div> <!-- /wp:group -->';
$test_filters['waldorf_pb_legacy_content_hashes'] = static function () use ( $legacy_fixture ): array {
	return array( hash( 'sha256', waldorf_pb_normalize_legacy_content( $legacy_fixture ) ) );
};
verify( 'legacy' === waldorf_pb_classify_front_page_content( $legacy_fixture ), 'An exactly allowlisted normalized legacy hash is recognized.' );
verify( 'unknown' === waldorf_pb_classify_front_page_content( $legacy_fixture . '<p>edited</p>' ), 'Edited or extra legacy content is rejected.' );
unset( $test_filters['waldorf_pb_legacy_content_hashes'] );

$canonical = waldorf_pb_build_canonical_front_page_content();
verify( ! is_wp_error( $canonical ), 'Canonical local patterns load.' );
$canonical_schema = waldorf_pb_front_page_schema_from_content( $canonical );
verify( 'new' === waldorf_pb_classify_front_page_content( $canonical ), 'The complete canonical schema is recognized as new: ' . implode( ', ', $canonical_schema ) );
verify( 'new' === waldorf_pb_classify_front_page_content( str_replace( 'Herzlich willkommen', 'Willkommen', $canonical ) ), 'Legitimate text edits retain complete-new recognition.' );
verify( false === strpos( $canonical, 'wp:pattern' ), 'Canonical content has no persisted pattern references.' );
verify( false !== strpos( $canonical, '"variant":"back-to-top"' ), 'Canonical content includes back-to-top decoration.' );

$front_pattern = file_get_contents( $theme . '/patterns/front-page.php' );
preg_match_all( '/"slug":"waldorf-pfirsichbluete\/([a-z-]+)"/', $front_pattern, $front_pattern_matches );
verify( waldorf_pb_front_page_pattern_slugs() === $front_pattern_matches[1], 'Migration order matches the complete front-page pattern.' );

$last_position     = -1;
$concrete_sections = array();
foreach ( waldorf_pb_front_page_pattern_slugs() as $slug ) {
	$pattern = waldorf_pb_load_migration_pattern( $slug );
	verify( ! is_wp_error( $pattern ), 'Pattern loads: ' . $slug );
	$concrete_sections[] = $pattern;
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

$reordered = implode( "\n\n", array_reverse( $concrete_sections ) ) . "\n\n" . '<!-- wp:waldorf/dekoration {"variant":"back-to-top"} /-->';
verify( 'new' === waldorf_pb_classify_front_page_content( $reordered ), 'Reordered complete sections remain legitimate new content.' );
verify( 'unknown' === waldorf_pb_classify_front_page_content( str_replace( $concrete_sections[0], '', $canonical ) ), 'A missing canonical section is rejected as partial new content.' );

$waldorf_names = waldorf_pb_collect_waldorf_block_names( parse_blocks( $canonical ) );
verify( in_array( 'waldorf/photo', $waldorf_names, true ) && in_array( 'waldorf/download', $waldorf_names, true ), 'Recursive preflight collection finds nested Waldorf blocks.' );
verify( array() === waldorf_pb_find_unregistered_blocks( $waldorf_names, static function (): bool { return true; } ), 'Registration preflight accepts a complete registry.' );
$missing = waldorf_pb_find_unregistered_blocks(
	$waldorf_names,
	static function ( string $name ): bool {
		return 'waldorf/photo' !== $name;
	}
);
verify( array( 'waldorf/photo' ) === $missing, 'Registration preflight reports a missing block.' );

preg_match_all( '/"fallback":"(photo-[^"]+\.jpg)"/', $canonical, $fallback_matches );
$fallbacks = array_values( array_unique( $fallback_matches[1] ) );
sort( $fallbacks );
$photos = waldorf_pb_migration_photo_filenames();
sort( $photos );
verify( $photos === $fallbacks, 'All and only the ten portable photo fallbacks are imported.' );

$source_paths = waldorf_pb_migration_source_paths();
verify( 15 === count( $source_paths ), 'Source preflight covers ten photos and five PDFs.' );
$validated_sources = waldorf_pb_validate_migration_sources( $source_paths );
verify( ! is_wp_error( $validated_sources ) && 15 === count( $validated_sources ), 'All source files exist and have readable SHA-256 hashes.' );
foreach ( $validated_sources as $filename => $source ) {
	verify( 64 === strlen( $source['hash'] ) && hash_file( 'sha256', $source['path'] ) === $source['hash'], 'Source hash is stable: ' . $filename );
}

$test_filters['waldorf_pb_download_source_directory'] = static function (): string {
	return '/portable/download-source/';
};
$filtered_sources = waldorf_pb_migration_source_paths();
verify( '/portable/download-source/anmeldung-familiengruppe.pdf' === $filtered_sources['anmeldung-familiengruppe.pdf'], 'Download source directory is filterable and normalized.' );
unset( $test_filters['waldorf_pb_download_source_directory'] );

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

$now = 2000000000;
verify( $now - 601 === waldorf_pb_lock_timestamp( ( $now - 601 ) . ':test-token' ), 'Lock timestamp parser accepts a valid token.' );
verify( 0 === waldorf_pb_lock_timestamp( 'malformed' ), 'Lock timestamp parser rejects malformed data.' );
verify( waldorf_pb_lock_token_is_stale( ( $now - 601 ) . ':test-token', $now ), 'Lock expires only beyond its TTL.' );
verify( ! waldorf_pb_lock_token_is_stale( ( $now - 599 ) . ':test-token', $now ), 'A live lock is not stale.' );

$front_template = file_get_contents( $theme . '/templates/front-page.html' );
verify( false !== strpos( $front_template, 'wp:post-content' ) && false === strpos( $front_template, 'wp:pattern' ), 'Front template retains post-content only.' );
verify( isset( $registered_filters['render_block_core/post-content'] ), 'Frontend post-content fallback filter is registered.' );
verify( isset( $registered_filters['pre_get_block_template'] ), 'Incomplete migration protects against a DB template override before its DB result returns.' );
verify( isset( $registered_actions['admin_init'] ) && ! isset( $registered_actions['init'] ), 'Automatic writes are registered only on admin_init.' );

$functions = file_get_contents( $theme . '/functions.php' );
verify( false !== strpos( $functions, "add_editor_style( 'assets/css/components.css' )" ), 'Shared component styles load in the editor.' );

$migration_source = file_get_contents( $theme . '/inc/content-migration.php' );
$page_update       = strpos( $migration_source, '$result = wp_update_post(' );
$version_update    = strpos( $migration_source, 'update_option( WALDORF_PB_CONTENT_MIGRATION_OPTION' );
verify( false !== $page_update && false !== $version_update && $page_update < $version_update, 'Completion is recorded only after the page update path.' );
verify( 0 === preg_match( '/page_on_front[^\n]*\b12\b/', $migration_source ), 'No front-page ID is hardcoded.' );
verify( false !== strpos( $migration_source, "'_waldorf_pb_source_filename'" ) && false !== strpos( $migration_source, "'_waldorf_pb_source_sha256'" ), 'Filename and SHA-256 attachment identity markers are declared.' );
verify( false !== strpos( $migration_source, "'waldorf_pb_content_migration_backup'" ), 'Independent backup option is declared.' );
verify( false !== strpos( $migration_source, '$wpdb->delete(' ), 'Stale cleanup and release use token-fenced compare/delete.' );
verify( false !== strpos( $migration_source, 'SELECT option_value FROM' ), 'Ownership checks bypass request-local option caches.' );
verify( substr_count( $migration_source, 'waldorf_pb_migration_lock_is_owned( $lock_token )' ) >= 4, 'Lock ownership is revalidated around destructive writes.' );
verify( false !== strpos( $migration_source, 'clean_post_cache( $page_id )' ) && false !== strpos( $migration_source, "'front_page_changed'" ), 'Page content is reloaded and optimistically checked after imports.' );
verify( false !== strpos( $migration_source, 'waldorf_pb_require_original_revision' ) && false !== strpos( $migration_source, 'waldorf_pb_restore_original_content' ), 'Revision verification and rollback paths are present.' );
verify( false !== strpos( $migration_source, "'custom_front_page_template'" ) && false !== strpos( $migration_source, "'custom' === \$template->source" ), 'Supported template API detects DB overrides.' );
verify( false !== strpos( $migration_source, 'WALDORF_PB_MIGRATION_RETRY_SECONDS' ) && false !== strpos( $migration_source, 'check_admin_referer' ), 'Failure retries are throttled with a nonce-protected manual path.' );
verify( false !== strpos( $migration_source, "did_action( 'wp' ) > 0" ), 'Fallback condition only evaluates front-page query state after the frontend query exists.' );

$aktuelles = file_get_contents( $theme . '/patterns/aktuelles.php' );
verify( false !== strpos( $aktuelles, 'href="./aktuelles/"' ) && false === strpos( $aktuelles, 'href="/aktuelles"' ), 'Aktuelles link is portable.' );

$readme = file_get_contents( $theme . '/readme.md' );
foreach ( array( 'admin_init', 'Fallback', WALDORF_PB_CONTENT_MIGRATION_BACKUP, 'Website-Editor', 'atomar' ) as $documentation_term ) {
	verify( false !== strpos( $readme, $documentation_term ), 'Documentation covers: ' . $documentation_term );
}

$pattern_files = glob( $theme . '/patterns/*.php' );
foreach ( $pattern_files as $pattern_file ) {
	$source = file_get_contents( $pattern_file );
	verify( false === strpos( $source, 'wp:html' ), 'No raw HTML block in ' . basename( $pattern_file ) );
	verify( 0 === preg_match( '/\$[A-Za-z_][A-Za-z0-9_]*\s*=\s*(?:array\s*\(|\[)/', $source ), 'No PHP content array in ' . basename( $pattern_file ) );
}

fwrite( STDOUT, "OK: {$checks} focused migration checks passed (no DB/runtime integration).\n" );
