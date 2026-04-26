<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/favicon.svg' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'page wash-enabled' ); ?> data-wash-enabled="true">
<?php wp_body_open(); ?>
<div class="background-wash">
	<div class="watercolor-shell page-wash" aria-hidden="true">
		<canvas id="watercolor-canvas"></canvas>
	</div>
</div>
<div class="site-shell">
	<header class="site-header collapsed">
		<div class="brand">
			<a class="brand-mark" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Waldorfkindergarten Idstein Startseite">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/logo-tinted.png' ); ?>" alt="Waldorfkindergarten Idstein">
			</a>
			<div>
				<p class="eyebrow">Waldorfkindergarten Idstein e.V.</p>
				<p class="tagline">Geborgenheit, Rhythmus, Gemeinschaft</p>
			</div>
		</div>
		<div class="nav-rail">
			<input type="checkbox" id="nav-toggle" class="nav-toggle" aria-label="Navigation oeffnen">
			<label for="nav-toggle" class="nav-toggle-label">
				<span>Menue</span>
				<span class="chevron">▾</span>
			</label>
			<nav class="nav" aria-label="Hauptnavigation">
				<?php foreach ( waldorf_idstein_default_menu_items() as $item ) : ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<?php endforeach; ?>
			</nav>
		</div>
	</header>
	<main class="content">
