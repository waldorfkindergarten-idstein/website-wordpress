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

require_once get_template_directory() . '/inc/content-migration.php';
require_once get_template_directory() . '/inc/content-types.php';
require_once get_template_directory() . '/inc/termine.php';
require_once get_template_directory() . '/inc/head-meta.php';

/**
 * Theme supports. Block themes imply most of these, but editor styles and
 * the responsive-embeds/HTML5 opt-ins still need declaring.
 */
function waldorf_pb_setup(): void {
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	// editor.css must follow components.css: it neutralises the reveal-on-scroll
	// start state, which has no scroll and no theme.js inside the editor canvas.
	add_editor_style(
		array(
			'assets/css/components.css',
			'assets/css/editor.css',
		)
	);

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
 * Register all compiled theme blocks.
 *
 * WordPress 6.8+ can register the generated metadata collection in one pass.
 * Older supported releases discover the same block directories from the
 * manifest, so adding a block never requires another hardcoded PHP entry.
 */
function waldorf_pb_register_blocks(): void {
	$build_dir  = get_template_directory() . '/build';
	$blocks_dir = $build_dir . '/blocks';
	$manifest   = $build_dir . '/blocks-manifest.php';

	if ( ! file_exists( $manifest ) ) {
		return;
	}

	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( $blocks_dir, $manifest );
		return;
	}

	$block_metadata = require $manifest;
	if ( ! is_array( $block_metadata ) ) {
		return;
	}

	foreach ( array_keys( $block_metadata ) as $block_path ) {
		register_block_type( $blocks_dir . '/' . $block_path );
	}
}
add_action( 'init', 'waldorf_pb_register_blocks' );

/**
 * Add the theme block category to the inserter.
 *
 * @param array $categories Existing block categories.
 * @return array
 */
function waldorf_pb_register_block_category( array $categories ): array {
	foreach ( $categories as $category ) {
		if ( isset( $category['slug'] ) && 'waldorf' === $category['slug'] ) {
			return $categories;
		}
	}

	$categories[] = array(
		'slug'  => 'waldorf',
		'title' => __( 'Waldorf', 'waldorf-pfirsichbluete' ),
	);

	return $categories;
}
add_filter( 'block_categories_all', 'waldorf_pb_register_block_category' );

/**
 * Give block editor scripts a portable base URL for theme-image fallbacks.
 *
 * @param array $settings Block editor settings.
 * @return array
 */
function waldorf_pb_block_editor_settings( array $settings ): array {
	$settings['waldorfPhotoImageBaseUrl'] = trailingslashit( get_template_directory_uri() . '/assets/images' );

	return $settings;
}
add_filter( 'block_editor_settings_all', 'waldorf_pb_block_editor_settings' );

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
 * Resolve section anchors and bare page paths in the header and footer against
 * the site's actual URLs.
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
 * The footer also links to ordinary pages (`/impressum`, `/datenschutz`, …) with
 * the same bare root-relative style. Those are rewritten too, resolving each path
 * against the published page of that slug via `get_permalink()` — which keeps
 * working in a subdirectory install and if a page's permalink structure ever
 * changes. A path with no matching published page falls back to the literal
 * path under `home_url()`, so it still renders rather than disappearing.
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
	$block_content = (string) preg_replace(
		'~href="#([A-Za-z][A-Za-z0-9_-]*)"~',
		'href="' . $home . '#$1"',
		$block_content
	);

	// Bare single-segment page paths, e.g. `href="/impressum"`.
	return (string) preg_replace_callback(
		'~href="/([A-Za-z0-9_-]+)/?"~',
		static function ( array $matches ): string {
			$page = get_page_by_path( $matches[1] );
			$url  = $page instanceof WP_Post ? get_permalink( $page ) : home_url( '/' . $matches[1] . '/' );

			return 'href="' . esc_url( (string) $url ) . '"';
		},
		$block_content
	);
}
add_filter( 'render_block_core/template-part', 'waldorf_pb_resolve_section_anchors', 10, 2 );

/**
 * Put the navigation's overlay toggles into German.
 *
 * The block renders text toggles rather than a hamburger and an X, because the
 * two stock glyphs sit outside this theme's iconography. With `hasIcon` off,
 * core labels them with its own `Menu` and `Close` strings — and this install
 * runs under `en_US` while every word on the site is German, so they arrive in
 * English. Everything else in the theme states its German copy outright; these
 * two are the same case and are handled the same way.
 *
 * @param string $block_content Rendered block HTML.
 * @return string
 */
function waldorf_pb_translate_navigation_toggles( string $block_content ): string {
	return str_replace(
		array(
			'>' . __( 'Menu' ) . '</button>',
			'>' . __( 'Close' ) . '</button>',
		),
		array(
			'>' . esc_html__( 'Menü', 'waldorf-pfirsichbluete' ) . '</button>',
			'>' . esc_html__( 'Schließen', 'waldorf-pfirsichbluete' ) . '</button>',
		),
		$block_content
	);
}
add_filter( 'render_block_core/navigation', 'waldorf_pb_translate_navigation_toggles' );

/**
 * Expose the theme's image directory to patterns without repeating the lookup.
 */
function waldorf_pb_img( string $file ): string {
	return get_template_directory_uri() . '/assets/images/' . ltrim( $file, '/' );
}

/**
 * Render an attachment image with a safe theme-file fallback.
 *
 * The fallback contract is a filename from assets/images, not a persisted site
 * URL. This keeps pattern content portable between domains and installations.
 * Supported extra image attributes are class, sizes, loading, decoding and
 * style. An empty explicit alt uses the attachment's media-library alt text.
 *
 * @param int    $attachment_id Attachment ID, or zero to use the fallback.
 * @param string $fallback_file Filename from the theme's assets/images folder.
 * @param string $alt           Explicit alt text, or empty for media alt text.
 * @param array  $attributes    Allowlisted HTML attributes for the image.
 * @return string
 */
function waldorf_pb_render_image( int $attachment_id, string $fallback_file, string $alt = '', array $attributes = array() ): string {
	$allowed_attributes = array( 'class', 'sizes', 'loading', 'decoding', 'style' );
	$image_attributes   = array(
		'loading'  => 'lazy',
		'decoding' => 'async',
	);

	foreach ( $allowed_attributes as $attribute_name ) {
		if ( isset( $attributes[ $attribute_name ] ) ) {
			$image_attributes[ $attribute_name ] = (string) $attributes[ $attribute_name ];
		}
	}

	if ( '' !== $alt ) {
		$image_attributes['alt'] = $alt;
	}

	if ( $attachment_id > 0 && wp_attachment_is_image( $attachment_id ) ) {
		return (string) wp_get_attachment_image( $attachment_id, 'full', false, $image_attributes );
	}

	$fallback_file = sanitize_file_name( wp_basename( $fallback_file ) );
	$fallback_path = get_template_directory() . '/assets/images/' . $fallback_file;

	if ( '' === $fallback_file || ! is_file( $fallback_path ) ) {
		return '';
	}

	$image_attributes['src'] = waldorf_pb_img( $fallback_file );
	$image_attributes['alt'] = $alt;
	$attribute_markup        = array();

	foreach ( $image_attributes as $attribute_name => $attribute_value ) {
		$attribute_markup[] = sprintf(
			'%s="%s"',
			esc_attr( $attribute_name ),
			esc_attr( $attribute_value )
		);
	}

	return '<img ' . implode( ' ', $attribute_markup ) . '>';
}
