<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
		<article class="entry-content front-content">
			<?php the_content(); ?>
		</article>
		<?php
	}
}

get_footer();
