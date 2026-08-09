<?php
/**
 * Destructive integration test for an isolated disposable WordPress database.
 *
 * Run only in a dedicated container with WALDORF_PB_INTEGRATION=1 and a DB name
 * beginning with waldorf_integration_. The script refuses every other target.
 */

declare( strict_types = 1 );

if ( '1' !== getenv( 'WALDORF_PB_INTEGRATION' ) ) {
	fwrite( STDERR, "Refusing to run without WALDORF_PB_INTEGRATION=1.\n" );
	exit( 2 );
}

$db_name = (string) getenv( 'WORDPRESS_DB_NAME' );
if ( 0 !== strpos( $db_name, 'waldorf_integration_' ) ) {
	fwrite( STDERR, "Refusing non-integration database: {$db_name}\n" );
	exit( 2 );
}

define( 'ABSPATH', rtrim( (string) getenv( 'WALDORF_WP_ROOT' ), '/\\' ) . '/' );
define( 'DB_NAME', $db_name );
define( 'DB_USER', (string) getenv( 'WORDPRESS_DB_USER' ) );
define( 'DB_PASSWORD', (string) getenv( 'WORDPRESS_DB_PASSWORD' ) );
define( 'DB_HOST', (string) getenv( 'WORDPRESS_DB_HOST' ) );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
define( 'AUTH_KEY', 'integration-auth-key' );
define( 'SECURE_AUTH_KEY', 'integration-secure-auth-key' );
define( 'LOGGED_IN_KEY', 'integration-logged-in-key' );
define( 'NONCE_KEY', 'integration-nonce-key' );
define( 'AUTH_SALT', 'integration-auth-salt' );
define( 'SECURE_AUTH_SALT', 'integration-secure-auth-salt' );
define( 'LOGGED_IN_SALT', 'integration-logged-in-salt' );
define( 'NONCE_SALT', 'integration-nonce-salt' );
define( 'WP_HOME', 'http://waldorf-integration.test' );
define( 'WP_SITEURL', 'http://waldorf-integration.test' );
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_INSTALLING', true );

$table_prefix = 'wp_';

require ABSPATH . 'wp-settings.php';
require_once ABSPATH . 'wp-admin/includes/upgrade.php';

$installation = wp_install( 'Waldorf Integration', 'integration-admin', 'integration@example.test', false, '', 'integration-password' );
wp_set_current_user( (int) $installation['user_id'] );
update_option( 'upload_path', '/tmp/waldorf-integration-uploads' );
update_option( 'upload_url_path', 'http://waldorf-integration.test/uploads' );
wp_mkdir_p( '/tmp/waldorf-integration-uploads' );
switch_theme( 'waldorf-pfirsichbluete' );

require_once ABSPATH . 'wp-content/themes/waldorf-pfirsichbluete/functions.php';
waldorf_pb_register_blocks();
require_once ABSPATH . 'wp-content/themes/waldorf-idstein/functions.php';

$checks = 0;

/**
 * Abort on failed integration assertion.
 */
function waldorf_pb_integration_verify( bool $condition, string $message ): void {
	global $checks;
	++$checks;
	if ( ! $condition ) {
		fwrite( STDERR, "FAIL: {$message}\n" );
		exit( 1 );
	}
}

$legacy = waldorf_idstein_home_page_block_content();
$legacy_hash = hash( 'sha256', waldorf_pb_normalize_legacy_content( $legacy ) );
waldorf_pb_integration_verify(
	'061df48f259bb2bf3dc5f2d4b823fffaf32bebedcbf7940b4e74a1e0b5177076' === $legacy_hash,
	'Old-theme legacy fixture is stable.'
);
add_filter(
	'waldorf_pb_legacy_content_hashes',
	static function ( array $hashes ) use ( $legacy_hash ): array {
		$hashes[] = $legacy_hash;
		return $hashes;
	}
);
waldorf_pb_integration_verify( 'legacy' === waldorf_pb_classify_front_page_content( $legacy ), 'Isolated old-theme fixture is explicitly allowlisted as legacy.' );

$page_id = wp_insert_post(
	array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => 'Start',
		'post_content' => wp_slash( $legacy ),
	),
	true
);
waldorf_pb_integration_verify( is_int( $page_id ) && $page_id > 0, 'Legacy front page was created.' );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $page_id );

delete_option( WALDORF_PB_CONTENT_MIGRATION_OPTION );
delete_option( WALDORF_PB_CONTENT_MIGRATION_LOCK );
delete_option( WALDORF_PB_CONTENT_MIGRATION_ERROR );
delete_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP );

$query = new WP_Query( array( 'page_id' => $page_id ) );
$GLOBALS['wp_query'] = $query;
$GLOBALS['wp_the_query'] = $query;
do_action( 'wp', $GLOBALS['wp'] );
$wrapper = '<div class="wp-block-post-content entry-content integration-wrapper" data-preserved="yes">legacy</div>';
$instance = (object) array( 'context' => array( 'postId' => $page_id ) );
$fallback = waldorf_pb_render_front_page_fallback( $wrapper, array( 'attrs' => array() ), $instance );
waldorf_pb_integration_verify( 0 === strpos( $fallback, '<div class="wp-block-post-content entry-content integration-wrapper" data-preserved="yes">' ), 'Fallback preserves the actual core wrapper.' );
waldorf_pb_integration_verify( false === strpos( $fallback, '>legacy</div>' ) && false !== strpos( $fallback, 'Ein warmes Zuhause' ), 'Fallback renders canonical content before migration.' );
$empty_fallback = waldorf_pb_render_front_page_fallback( '', array( 'attrs' => array() ), $instance );
waldorf_pb_integration_verify( 0 === strpos( $empty_fallback, '<div class="entry-content wp-block-post-content is-layout-flow wp-block-post-content-is-layout-flow">' ), 'Actual empty post-content fallback emits the explicit core-equivalent flow wrapper.' );
waldorf_pb_integration_verify( false !== strpos( $empty_fallback, 'Ein warmes Zuhause' ), 'Actual empty post-content fallback contains canonical content.' );

$result = waldorf_pb_run_content_migration();
$migration_detail = is_wp_error( $result ) ? $result->get_error_code() . ': ' . $result->get_error_message() : gettype( $result );
waldorf_pb_integration_verify( true === $result, 'Known legacy migration completed; got ' . $migration_detail . '.' );
waldorf_pb_integration_verify( 2 === (int) get_option( WALDORF_PB_CONTENT_MIGRATION_OPTION ), 'Migration version 2 was stored.' );

$migrated = (string) get_post_field( 'post_content', $page_id );
waldorf_pb_integration_verify( 'new' === waldorf_pb_classify_front_page_content( $migrated ), 'Migrated page has the strict complete-new schema.' );
waldorf_pb_integration_verify( false === strpos( $migrated, 'wp:pattern' ), 'Migrated page contains concrete blocks.' );

$backup = waldorf_pb_get_content_backup( $page_id );
waldorf_pb_integration_verify( is_array( $backup ), 'Durable migration backup validates.' );
waldorf_pb_integration_verify( 'original' === waldorf_pb_content_backup_state( $legacy, $backup ), 'Backup retains the exact legacy original.' );
waldorf_pb_integration_verify( 'target' === waldorf_pb_content_backup_state( $migrated, $backup ), 'Backup retains the exact migrated target.' );
$revision_id = absint( $backup['revision_id'] ?? 0 );
waldorf_pb_integration_verify( $revision_id > 0 && waldorf_pb_revision_contains_content( $revision_id, $page_id, $legacy ), 'Positive revision recovers the legacy original.' );

$attachment_ids = get_posts(
	array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_key'       => WALDORF_PB_SOURCE_META_KEY,
	)
);
waldorf_pb_integration_verify( 15 === count( $attachment_ids ), 'Exactly 15 stable source attachments were imported.' );
foreach ( $attachment_ids as $attachment_id ) {
	$source_hash = (string) get_post_meta( $attachment_id, WALDORF_PB_SOURCE_HASH_META_KEY, true );
	waldorf_pb_integration_verify( 64 === strlen( $source_hash ), 'Imported attachment has source SHA-256 metadata.' );
}

$test_page_id = wp_insert_post(
	array(
		'post_type'    => 'page',
		'post_status'  => 'draft',
		'post_title'   => 'Slash contract',
		'post_content' => '',
	),
	true
);
$json_content = get_comment_delimited_block_content(
	'core/paragraph',
	array( 'metadata' => array( 'name' => 'Pfad C:\Kinder' ) ),
	'<p>Pfad</p>'
);
$slash_result = waldorf_pb_write_page_content( $test_page_id, $json_content );
waldorf_pb_integration_verify( ! is_wp_error( $slash_result ) && $json_content === (string) get_post_field( 'post_content', $test_page_id ), 'wp_slash preserves Gutenberg JSON backslashes exactly.' );
$json_blocks = parse_blocks( $json_content );
$parsed_name = isset( $json_blocks[0]['attrs']['metadata']['name'] ) ? (string) $json_blocks[0]['attrs']['metadata']['name'] : '';
waldorf_pb_integration_verify( 'Pfad C:\Kinder' === $parsed_name, 'Preserved Gutenberg JSON remains parseable; got ' . var_export( $parsed_name, true ) . '.' );

$attachment_count = count( $attachment_ids );
$revision_count   = count( wp_get_post_revisions( $page_id ) );
delete_option( WALDORF_PB_CONTENT_MIGRATION_OPTION );
$throw_once = static function ( $value ) {
	static $thrown = false;
	if ( ! $thrown ) {
		$thrown = true;
		throw new RuntimeException( 'Injected post-write version failure.' );
	}

	return $value;
};
add_filter( 'pre_update_option_' . WALDORF_PB_CONTENT_MIGRATION_OPTION, $throw_once );
$throwable_result = waldorf_pb_run_content_migration();
remove_filter( 'pre_update_option_' . WALDORF_PB_CONTENT_MIGRATION_OPTION, $throw_once );
waldorf_pb_integration_verify( is_wp_error( $throwable_result ) && 'migration_exception_reconciled' === $throwable_result->get_error_code(), 'Post-write Throwable is returned and exact target is safely reconciled.' );
waldorf_pb_integration_verify( 2 === (int) get_option( WALDORF_PB_CONTENT_MIGRATION_OPTION ) && $migrated === (string) get_post_field( 'post_content', $page_id ), 'Throwable reconciliation leaves version and exact target consistent.' );

delete_option( WALDORF_PB_CONTENT_MIGRATION_OPTION );
$recovery_result = waldorf_pb_run_content_migration();
waldorf_pb_integration_verify( true === $recovery_result, 'Complete-new page with existing legacy backup finishes recovery without conflict.' );

$second_result = waldorf_pb_run_content_migration();
waldorf_pb_integration_verify( true === $second_result, 'Completed second migration pass is a successful no-op.' );
waldorf_pb_integration_verify( $attachment_count === count( get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => -1, 'fields' => 'ids', 'meta_key' => WALDORF_PB_SOURCE_META_KEY ) ) ), 'Second pass creates no duplicate attachments.' );
waldorf_pb_integration_verify( $revision_count === count( wp_get_post_revisions( $page_id ) ), 'Recovery and completed passes create no extra revision.' );

$after_fallback = waldorf_pb_render_front_page_fallback( $wrapper, array( 'attrs' => array() ), $instance );
waldorf_pb_integration_verify( $wrapper === $after_fallback, 'Fallback disappears after successful version.' );

$editor_content = str_replace( 'Ein warmes Zuhause', 'Ein redaktionell geändertes Zuhause', $migrated );
waldorf_pb_integration_verify( $editor_content !== $migrated && 'new' === waldorf_pb_classify_front_page_content( $editor_content ), 'Editor regression fixture remains structurally complete-new.' );
$backup_before_editor = get_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP );
$editor_write = waldorf_pb_write_page_content( $page_id, $editor_content );
waldorf_pb_integration_verify( ! is_wp_error( $editor_write ) && $editor_content === (string) get_post_field( 'post_content', $page_id ), 'Editor modification was persisted byte-for-byte.' );
delete_option( WALDORF_PB_CONTENT_MIGRATION_OPTION );
$divergent_result = waldorf_pb_run_content_migration();
waldorf_pb_integration_verify( is_wp_error( $divergent_result ) && 'migration_state_divergent' === $divergent_result->get_error_code(), 'Retry halts for complete-new content differing from durable original and target.' );
waldorf_pb_integration_verify( $editor_content === (string) get_post_field( 'post_content', $page_id ), 'Divergent editor content is preserved byte-for-byte.' );
waldorf_pb_integration_verify( $backup_before_editor === get_option( WALDORF_PB_CONTENT_MIGRATION_BACKUP ), 'Divergent retry leaves durable backup unchanged.' );
waldorf_pb_integration_verify( (int) get_option( WALDORF_PB_CONTENT_MIGRATION_OPTION, 0 ) < WALDORF_PB_CONTENT_MIGRATION_VERSION, 'Divergent retry leaves migration version incomplete.' );

fwrite( STDOUT, "OK: {$checks} isolated WordPress integration checks passed.\n" );
