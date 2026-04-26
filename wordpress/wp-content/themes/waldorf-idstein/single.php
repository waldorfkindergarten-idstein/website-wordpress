<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
		<article <?php post_class( 'entry-content page-content news-single' ); ?>>
			<section class="panel news-single-panel">
				<div class="news-header-meta">
					<p class="badge">Aktuelles</p>
					<p class="badge news-date-badge"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></p>
				</div>
				<h1><?php the_title(); ?></h1>
				<div class="news-body">
					<?php the_content(); ?>
				</div>
				<p><a class="link" href="<?php echo esc_url( home_url( '/' ) ); ?>">Zur Startseite →</a></p>
			</section>
		</article>
		<?php
	}
}

get_footer();
