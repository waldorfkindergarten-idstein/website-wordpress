<?php
/**
 * Settle on one Leitbild treatment.
 *
 * Five variants were published side by side so the layout could be chosen by
 * looking at it. Variant 1 (Manifest) won: one narrow column of type, no
 * images, the six principles as real headings. This promotes it to /leitbild/
 * and removes the rest.
 *
 * Idempotent, and safe on an install where it has already run.
 *
 * Run with:
 *   wp eval-file scripts/choose-leitbild.php
 *   ssh waldorfkindergarten '~/bin/wp eval-file -' < scripts/choose-leitbild.php
 *
 * @package WaldorfPfirsichbluete
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit( "This script must be run through WP-CLI.\n" );
}

$keeper = get_page_by_path( 'leitbild-1' );
$final  = get_page_by_path( 'leitbild' );

if ( $keeper instanceof WP_Post ) {
	if ( $final instanceof WP_Post && $final->ID !== $keeper->ID ) {
		WP_CLI::error( 'A page already occupies /leitbild/ — refusing to guess which to keep.' );
	}
	$res = wp_update_post(
		wp_slash(
			array(
				'ID'        => $keeper->ID,
				'post_name' => 'leitbild',
			)
		),
		true
	);
	if ( is_wp_error( $res ) ) {
		WP_CLI::error( $res->get_error_message() );
	}
	WP_CLI::log( sprintf( '  kept  #%d  -> /leitbild/', $keeper->ID ) );
} elseif ( $final instanceof WP_Post ) {
	WP_CLI::log( sprintf( '  kept  #%d  -> /leitbild/ (already done)', $final->ID ) );
} else {
	WP_CLI::error( 'Neither /leitbild-1/ nor /leitbild/ exists.' );
}

foreach ( array( 'leitbild-2', 'leitbild-3', 'leitbild-4', 'leitbild-5' ) as $slug ) {
	$page = get_page_by_path( $slug );
	if ( ! $page instanceof WP_Post ) {
		continue;
	}
	wp_delete_post( $page->ID, true );
	WP_CLI::log( sprintf( '  removed #%d  /%s/', $page->ID, $slug ) );
}

WP_CLI::success( 'Leitbild consolidated.' );
