<?php
/**
 * Title: Verpflegung mit Wochenplan
 * Slug: waldorf-pfirsichbluete/verpflegung
 * Categories: waldorf-sections
 * Description: Getreide-Wochenplan mit Foto und Bio-Auszeichnungen.
 */

$waldorf_pb_grain = array(
	array( 'Montag',     'Reis',    'mit Gemüse der Saison' ),
	array( 'Dienstag',   'Gerste',  'als Eintopf oder Auflauf' ),
	array( 'Mittwoch',   'Hirse',   'süß oder herzhaft' ),
	array( 'Donnerstag', 'Roggen',  'frisch gebackenes Brot' ),
	array( 'Freitag',    'Hafer',   'Müsli und Suppe für den Waldtag' ),
);
?>
<!-- wp:group {"anchor":"verpflegung","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="verpflegung" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"56px"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Verpflegung</p><!-- /wp:paragraph -->
			<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.3em","bottom":"0.4em"}}}} --><h2 class="wp-block-heading">Jeder Tag hat sein Getreide</h2><!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Bio-vegetarisch, frisch gekocht und im festen Wochenrhythmus. Die Kinder helfen beim Schnippeln und Tischdecken.</p><!-- /wp:paragraph -->

			<!-- wp:html -->
			<ul class="pb-grain" style="margin-top:24px">
				<?php foreach ( $waldorf_pb_grain as $waldorf_pb_g ) : ?>
					<li>
						<span class="pb-grain__day"><?php echo esc_html( $waldorf_pb_g[0] ); ?></span>
						<b><?php echo esc_html( $waldorf_pb_g[1] ); ?></b>
						<span><?php echo esc_html( $waldorf_pb_g[2] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="pb-badges" style="margin-top:24px">
				<span>100 % Bio</span><span>Vegetarisch</span><span>Regional eingekauft</span><span>Ohne Zucker­zusatz</span>
			</div>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
			<!-- wp:html -->
			<figure class="pb-photo pb-shape-food pb-reveal" style="aspect-ratio:4/3.6">
				<img src="<?php echo esc_url( waldorf_pb_img( 'photo-essen.jpg' ) ); ?>" alt="Frisch gekochtes Mittagessen" loading="lazy" decoding="async">
				<figcaption>Beispielbild · Mittagessen</figcaption>
			</figure>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
