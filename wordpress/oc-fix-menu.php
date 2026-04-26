<?php

$token = 'waldorf-idstein-menu-fix-2026';

if ( ! isset( $_GET['token'] ) || $_GET['token'] !== $token ) {
	http_response_code( 403 );
	exit( 'Forbidden' );
}

require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

$menu = wp_get_nav_menu_object( 'Hauptnavigation' );

if ( ! $menu ) {
	header( 'Content-Type: text/plain; charset=utf-8' );
	echo "Menu not found.\n";
	exit;
}

$items = wp_get_nav_menu_items( $menu->term_id );

if ( $items ) {
	foreach ( $items as $item ) {
		wp_delete_post( $item->ID, true );
	}
}

$targets = array(
	array(
		'title' => 'Start',
		'type'  => 'custom',
		'url'   => home_url( '/' ),
	),
	array(
		'title' => 'Gruppen',
		'type'  => 'page',
		'slug'  => 'gruppen',
	),
	array(
		'title' => 'Downloads',
		'type'  => 'page',
		'slug'  => 'formulare',
	),
	array(
		'title' => 'Kontakt',
		'type'  => 'page',
		'slug'  => 'kontakt',
	),
);

foreach ( $targets as $target ) {
	if ( 'custom' === $target['type'] ) {
		wp_update_nav_menu_item(
			$menu->term_id,
			0,
			array(
				'menu-item-title'  => $target['title'],
				'menu-item-url'    => $target['url'],
				'menu-item-type'   => 'custom',
				'menu-item-status' => 'publish',
			)
		);
		continue;
	}

	$page = get_page_by_path( $target['slug'] );

	if ( ! $page ) {
		continue;
	}

	wp_update_nav_menu_item(
		$menu->term_id,
		0,
		array(
			'menu-item-title'     => $target['title'],
			'menu-item-object'    => 'page',
			'menu-item-object-id' => (int) $page->ID,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		)
	);
}

header( 'Content-Type: text/plain; charset=utf-8' );
echo "Menu rebuilt.\n";
