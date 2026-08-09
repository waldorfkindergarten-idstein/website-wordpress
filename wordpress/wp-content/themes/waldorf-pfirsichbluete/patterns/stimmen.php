<?php
/**
 * Title: Elternstimmen
 * Slug: waldorf-pfirsichbluete/stimmen
 * Categories: waldorf-sections
 * Description: Drei Zitatkarten von Familien.
 */

$waldorf_pb_voices = array(
	array( 'Unsere Tochter kam als schüchternes Krippenkind und geht heute als selbstbewusstes Schulkind. Diesen Weg haben wir hier begleitet gesehen.', 'Mutter von zwei Kindern' ),
	array( 'Der gleichbleibende Tagesablauf war für unseren Sohn ein Geschenk. Er weiß morgens, was kommt – und ist deshalb ruhig.', 'Vater aus Idstein' ),
	array( 'Als Elterninitiative packt man mit an. Genau das macht es aus: man kennt die anderen Familien wirklich.', 'Mutter, Vorstand' ),
);
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Elternstimmen</p><!-- /wp:paragraph -->
		<!-- wp:heading {"fontSize":"2-x-large"} --><h2 class="wp-block-heading has-2-x-large-font-size">Was Familien uns erzählen</h2><!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;margin-top:44px">
		<?php foreach ( $waldorf_pb_voices as $waldorf_pb_v ) : ?>
			<figure class="pb-quote pb-reveal">
				<p><?php echo esc_html( $waldorf_pb_v[0] ); ?></p>
				<footer><?php echo esc_html( $waldorf_pb_v[1] ); ?></footer>
			</figure>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
