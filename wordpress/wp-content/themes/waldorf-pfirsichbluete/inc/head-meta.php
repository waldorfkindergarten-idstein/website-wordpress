<?php
/**
 * Icons and social preview metadata.
 *
 * The theme shipped none of this: no favicon, no manifest, no Open Graph, no
 * description. A link shared into WhatsApp or Facebook showed the bare URL.
 *
 * WordPress's own Site Icon feature covers the PNG/ICO icons and the admin,
 * so those are emitted only when no Site Icon is configured — otherwise the
 * page would carry two competing sets. The SVG icon, the web app manifest and
 * the theme colour have no core equivalent and are always emitted.
 *
 * @package WaldorfPfirsichbluete
 */

declare( strict_types = 1 );

const WALDORF_PB_THEME_COLOR = '#781246';

/**
 * The description used when a page has no hand-written excerpt.
 *
 * Taken from the Verein's own hero copy rather than invented.
 */
function waldorf_pb_default_description(): string {
	return __(
		'Waldorfkindergarten Idstein: Geborgenheit, Rhythmus und Naturverbundenheit für Kinder ab einem Jahr – in familienähnlichen Gruppen vom Krippenalter bis zum Schuleintritt.',
		'waldorf-pfirsichbluete'
	);
}

/**
 * A description for the current view.
 */
function waldorf_pb_meta_description(): string {
	if ( is_singular() ) {
		$waldorf_pb_post = get_queried_object();

		if ( $waldorf_pb_post instanceof WP_Post && '' !== trim( (string) $waldorf_pb_post->post_excerpt ) ) {
			return wp_strip_all_tags( (string) $waldorf_pb_post->post_excerpt );
		}
	}

	return waldorf_pb_default_description();
}

/**
 * The canonical URL of the current view.
 */
function waldorf_pb_current_url(): string {
	if ( is_singular() ) {
		$waldorf_pb_link = get_permalink();

		if ( is_string( $waldorf_pb_link ) && '' !== $waldorf_pb_link ) {
			return $waldorf_pb_link;
		}
	}

	return home_url( '/' );
}

/**
 * Print icons, manifest and social preview tags.
 */
function waldorf_pb_head_meta(): void {
	$waldorf_pb_dir = get_template_directory_uri();
	$waldorf_pb_img = $waldorf_pb_dir . '/assets/images/og-image.jpg';
	$waldorf_pb_desc = waldorf_pb_meta_description();
	$waldorf_pb_title = wp_get_document_title();
	$waldorf_pb_url = waldorf_pb_current_url();

	// An SVG favicon stays sharp at every size and follows the tab's colour
	// scheme; WordPress has no setting for it.
	printf(
		'<link rel="icon" href="%s" type="image/svg+xml">' . "\n",
		esc_url( $waldorf_pb_dir . '/assets/favicon/favicon.svg' )
	);
	printf(
		'<link rel="manifest" href="%s">' . "\n",
		esc_url( $waldorf_pb_dir . '/assets/favicon/site.webmanifest' )
	);
	printf(
		'<meta name="theme-color" content="%s">' . "\n",
		esc_attr( WALDORF_PB_THEME_COLOR )
	);

	if ( ! has_site_icon() ) {
		printf(
			'<link rel="icon" href="%s" sizes="32x32">' . "\n",
			esc_url( $waldorf_pb_dir . '/assets/favicon/favicon.ico' )
		);
		printf(
			'<link rel="icon" href="%s" type="image/png" sizes="96x96">' . "\n",
			esc_url( $waldorf_pb_dir . '/assets/favicon/favicon-96x96.png' )
		);
		printf(
			'<link rel="apple-touch-icon" href="%s" sizes="180x180">' . "\n",
			esc_url( $waldorf_pb_dir . '/assets/favicon/apple-touch-icon.png' )
		);
	}

	printf(
		'<meta name="description" content="%s">' . "\n",
		esc_attr( $waldorf_pb_desc )
	);

	$waldorf_pb_tags = array(
		'og:type'        => is_singular( 'post' ) ? 'article' : 'website',
		'og:site_name'   => get_bloginfo( 'name' ),
		'og:locale'      => 'de_DE',
		'og:title'       => $waldorf_pb_title,
		'og:description' => $waldorf_pb_desc,
		'og:url'         => $waldorf_pb_url,
		'og:image'       => $waldorf_pb_img,
		'og:image:type'  => 'image/jpeg',
		'og:image:width' => '1200',
		'og:image:height' => '630',
		'og:image:alt'   => __( 'Kinder des Waldorfkindergartens Idstein spielen gemeinsam im Garten', 'waldorf-pfirsichbluete' ),
	);

	foreach ( $waldorf_pb_tags as $waldorf_pb_property => $waldorf_pb_content ) {
		printf(
			'<meta property="%s" content="%s">' . "\n",
			esc_attr( $waldorf_pb_property ),
			esc_attr( (string) $waldorf_pb_content )
		);
	}

	$waldorf_pb_twitter = array(
		'twitter:card'        => 'summary_large_image',
		'twitter:title'       => $waldorf_pb_title,
		'twitter:description' => $waldorf_pb_desc,
		'twitter:image'       => $waldorf_pb_img,
	);

	foreach ( $waldorf_pb_twitter as $waldorf_pb_name => $waldorf_pb_content ) {
		printf(
			'<meta name="%s" content="%s">' . "\n",
			esc_attr( $waldorf_pb_name ),
			esc_attr( (string) $waldorf_pb_content )
		);
	}
}
add_action( 'wp_head', 'waldorf_pb_head_meta', 5 );

/**
 * Point a bare /favicon.ico request at the theme's icon.
 *
 * With no Site Icon configured, WordPress redirects /favicon.ico to its own
 * blue "W" logo — so anything that asks for the icon by convention rather than
 * by reading the link tags shows the WordPress mark instead of ours.
 */
function waldorf_pb_favicon_ico(): void {
	if ( has_site_icon() ) {
		return;
	}

	wp_safe_redirect( get_template_directory_uri() . '/assets/favicon/favicon.ico', 302 );
	exit;
}
add_action( 'do_faviconico', 'waldorf_pb_favicon_ico', 5 );
