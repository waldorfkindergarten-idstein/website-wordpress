<?php
/**
 * Waldorf Pfirsichblüte — theme bootstrap.
 *
 * Block themes get almost everything from theme.json. This file only covers what
 * theme.json cannot express: asset loading, pattern categories and block styles.
 *
 * @package WaldorfPfirsichbluete
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const WALDORF_PB_VERSION = '1.0.0';

/**
 * Theme supports. Block themes imply most of these, but editor styles and
 * the responsive-embeds/HTML5 opt-ins still need declaring.
 */
function waldorf_pb_setup(): void {
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	add_editor_style( 'assets/css/components.css' );

	load_theme_textdomain( 'waldorf-pfirsichbluete', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'waldorf_pb_setup' );

/**
 * Front-end assets.
 *
 * components.css carries the handful of things theme.json has no vocabulary for:
 * organic blob clip-paths, the timeline rail, the photo mosaic grid and the
 * sticky-header transition.
 */
function waldorf_pb_enqueue_assets(): void {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	$css = '/assets/css/components.css';
	wp_enqueue_style(
		'waldorf-pb-components',
		$uri . $css,
		array(),
		(string) filemtime( $dir . $css )
	);

	$js = '/assets/js/theme.js';
	wp_enqueue_script(
		'waldorf-pb-theme',
		$uri . $js,
		array(),
		(string) filemtime( $dir . $js ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'waldorf_pb_enqueue_assets' );

/**
 * Preload the two font files used above the fold so the headline does not reflow.
 */
function waldorf_pb_preload_fonts(): void {
	$uri   = get_template_directory_uri() . '/assets/fonts/';
	$files = array( 'petrona-latin.woff2', 'nunito-sans-latin.woff2' );

	foreach ( $files as $file ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( $uri . $file )
		);
	}
}
add_action( 'wp_head', 'waldorf_pb_preload_fonts', 1 );

/**
 * Pattern categories used by the section patterns in /patterns.
 */
function waldorf_pb_register_pattern_categories(): void {
	register_block_pattern_category(
		'waldorf-sections',
		array(
			'label'       => __( 'Waldorf: Seitenabschnitte', 'waldorf-pfirsichbluete' ),
			'description' => __( 'Fertige Abschnitte im Stil des Kindergartens.', 'waldorf-pfirsichbluete' ),
		)
	);

	register_block_pattern_category(
		'waldorf-parts',
		array(
			'label'       => __( 'Waldorf: Bausteine', 'waldorf-pfirsichbluete' ),
			'description' => __( 'Kleinere wiederverwendbare Bausteine.', 'waldorf-pfirsichbluete' ),
		)
	);
}
add_action( 'init', 'waldorf_pb_register_pattern_categories' );

/**
 * Block style variations that the patterns rely on.
 */
function waldorf_pb_register_block_styles(): void {
	register_block_style(
		'core/button',
		array(
			'name'  => 'ghost',
			'label' => __( 'Zurückhaltend', 'waldorf-pfirsichbluete' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'card',
			'label' => __( 'Karte', 'waldorf-pfirsichbluete' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'glass',
			'label' => __( 'Milchglas', 'waldorf-pfirsichbluete' ),
		)
	);

	register_block_style(
		'core/image',
		array(
			'name'  => 'blob',
			'label' => __( 'Organische Form', 'waldorf-pfirsichbluete' ),
		)
	);

	register_block_style(
		'core/list',
		array(
			'name'  => 'dotted',
			'label' => __( 'Mit Pfirsich-Punkten', 'waldorf-pfirsichbluete' ),
		)
	);

	register_block_style(
		'core/separator',
		array(
			'name'  => 'hand-drawn',
			'label' => __( 'Handgezeichnet', 'waldorf-pfirsichbluete' ),
		)
	);
}
add_action( 'init', 'waldorf_pb_register_block_styles' );

/**
 * Resolve section anchors in the header and footer against the site home.
 *
 * The nav and footer link to sections of the front page (`#gruppen`, `#haus`, …).
 * Left bare, those anchors only resolve while the visitor is already on the front
 * page — on a post or any other view they point at nothing and the menu goes dead.
 * Rewriting them to `home_url() . '#section'` keeps them working everywhere, and
 * stays correct for installs in a subdirectory, which a hardcoded `/#section`
 * would not.
 *
 * Same-document navigation is preserved: on the front page the browser still
 * treats the rewritten URL as an in-page jump, so smooth scrolling applies.
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Parsed block.
 * @return string
 */
function waldorf_pb_resolve_section_anchors( string $block_content, array $block ): string {
	$slug = $block['attrs']['slug'] ?? '';

	if ( ! in_array( $slug, array( 'header', 'footer' ), true ) ) {
		return $block_content;
	}

	$home = esc_url( home_url( '/' ) );

	// Only bare in-page anchors — never `href="#"` on its own, which core uses
	// for control elements such as the mobile overlay toggle.
	return (string) preg_replace(
		'~href="#([A-Za-z][A-Za-z0-9_-]*)"~',
		'href="' . $home . '#$1"',
		$block_content
	);
}
add_filter( 'render_block_core/template-part', 'waldorf_pb_resolve_section_anchors', 10, 2 );

/**
 * Expose the theme's image directory to patterns without repeating the lookup.
 */
function waldorf_pb_img( string $file ): string {
	return get_template_directory_uri() . '/assets/images/' . ltrim( $file, '/' );
}
