<?php
/**
 * Title: Team
 * Slug: waldorf-pfirsichbluete/team
 * Categories: waldorf-sections
 * Description: Fünf Personen mit Monogramm in organischer Form.
 */

$waldorf_pb_team = array(
	array( 'L', 'Leitung',            'Pädagogische Gesamtleitung' ),
	array( 'S', 'Sonnengruppe',       'Erzieherin &amp; Gruppenleitung' ),
	array( 'R', 'Regenbogengruppe',   'Erzieherin &amp; Gruppenleitung' ),
	array( 'W', 'Wiegenstube',        'Krippenpädagogin' ),
	array( 'K', 'Küche',              'Frisch gekocht, jeden Tag' ),
);
?>
<!-- wp:group {"anchor":"team","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="team" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Unser Team</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">Menschen, die den Tag tragen</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Ein festes Team begleitet die Kinder über Jahre – mit Ruhe, Humor und viel Erfahrung.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="pb-team" style="margin-top:44px">
		<?php foreach ( $waldorf_pb_team as $waldorf_pb_p ) : ?>
			<div class="pb-person pb-reveal">
				<div class="pb-photo pb-shape-person pb-person__photo">
					<span class="pb-person__mono"><?php echo esc_html( $waldorf_pb_p[0] ); ?></span>
				</div>
				<h4><?php echo esc_html( $waldorf_pb_p[1] ); ?></h4>
				<span><?php echo wp_kses_post( $waldorf_pb_p[2] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>

	<p class="pb-team-note" style="margin-top:28px;font-size:.92rem;color:#6e5a55">Gerne stellen wir Ihnen das Team beim Kennenlerntag persönlich vor.</p>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
