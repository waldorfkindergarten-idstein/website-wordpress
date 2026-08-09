<?php
/**
 * Title: Downloads und Formulare
 * Slug: waldorf-pfirsichbluete/downloads
 * Categories: waldorf-sections
 * Description: Zweispaltige Liste mit Dateitypen und Größenangaben.
 */

$waldorf_pb_files = array(
	array( 'PDF', 'Anmeldebogen',          '2 Seiten · 180 kB' ),
	array( 'PDF', 'Konzeption',            '24 Seiten · 1,4 MB' ),
	array( 'PDF', 'Gebührenordnung',       '1 Seite · 96 kB' ),
	array( 'PDF', 'Packliste Waldtag',     '1 Seite · 88 kB' ),
	array( 'PDF', 'Ferien &amp; Schließtage', '1 Seite · 74 kB' ),
	array( 'PDF', 'Satzung des Vereins',   '8 Seiten · 240 kB' ),
);
?>
<!-- wp:group {"anchor":"downloads","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="downloads" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"className":"pb-reveal","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group pb-reveal">
		<!-- wp:group {"layout":{"type":"constrained"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Downloads &amp; Formulare</p><!-- /wp:paragraph -->
			<!-- wp:heading {"fontSize":"2-x-large","style":{"spacing":{"margin":{"top":"0.28em"}}}} --><h2 class="wp-block-heading has-2-x-large-font-size" style="margin-top:0.28em">Alles Wichtige zum Mitnehmen</h2><!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"className":"pb-note-hand"} --><p class="pb-note-hand">Ihre eigenen Dateien ersetzen diese 1:1</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="pb-downloads" style="margin-top:38px">
		<?php foreach ( $waldorf_pb_files as $waldorf_pb_file ) : ?>
			<a class="pb-dl pb-reveal" href="#">
				<span class="pb-dl__ext"><?php echo esc_html( $waldorf_pb_file[0] ); ?></span>
				<span>
					<b><?php echo wp_kses_post( $waldorf_pb_file[1] ); ?></b>
					<small><?php echo wp_kses_post( $waldorf_pb_file[2] ); ?></small>
				</span>
				<span class="pb-dl__arrow" aria-hidden="true">↓</span>
			</a>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
