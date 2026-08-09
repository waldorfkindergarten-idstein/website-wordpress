<?php
/**
 * Title: Unser Haus mit Foto-Mosaik
 * Slug: waldorf-pfirsichbluete/haus
 * Categories: waldorf-sections
 * Description: Vier Fotos im Mosaik, darunter eine vierspaltige Raumliste.
 */
?>
<!-- wp:group {"anchor":"haus","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="haus" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group pb-reveal">
		<!-- wp:group {"className":"pb-sec-head","layout":{"type":"default"}} -->
		<div class="wp-block-group pb-sec-head">
			<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Unser Haus</p><!-- /wp:paragraph -->
			<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading" style="margin-top:0.28em;margin-bottom:0.35em">Räume, die zur Ruhe kommen lassen</h2><!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Naturmaterialien, warme Lasurfarben und viel Tageslicht. Jeder Bereich hat seine eigene Stimmung – und seine eigene Tätigkeit.</p><!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"className":"pb-note-hand"} --><p class="pb-note-hand">Ihre Fotos kommen genau hierhin ↓</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="pb-mosaic pb-reveal" style="margin-top:46px">
		<figure class="pb-photo pb-mosaic__1">
			<img src="<?php echo esc_url( waldorf_pb_img( 'photo-gruppenraum.jpg' ) ); ?>" alt="Gruppenraum mit Jahreszeitentisch" loading="lazy" decoding="async">
			<figcaption>Beispielbild · Gruppenraum &amp; Jahreszeitentisch</figcaption>
		</figure>
		<figure class="pb-photo pb-mosaic__2">
			<img src="<?php echo esc_url( waldorf_pb_img( 'photo-malecke.jpg' ) ); ?>" alt="Mal- und Handarbeitsecke" loading="lazy" decoding="async">
			<figcaption>Beispielbild · Mal- und Handarbeitsecke</figcaption>
		</figure>
		<figure class="pb-photo pb-mosaic__3">
			<img src="<?php echo esc_url( waldorf_pb_img( 'photo-holz.jpg' ) ); ?>" alt="Freies Spiel mit Holz" loading="lazy" decoding="async">
			<figcaption>Beispielbild · Freies Spiel mit Holz</figcaption>
		</figure>
		<figure class="pb-photo pb-mosaic__4">
			<img src="<?php echo esc_url( waldorf_pb_img( 'photo-garten.jpg' ) ); ?>" alt="Garten mit Obstbäumen und Sandbereich" loading="lazy" decoding="async">
			<figcaption>Beispielbild · Garten (Panorama)</figcaption>
		</figure>
	</div>
	<!-- /wp:html -->

	<!-- wp:columns {"style":{"spacing":{"margin":{"top":"32px"},"blockGap":{"left":"22px"}}}} -->
	<div class="wp-block-columns" style="margin-top:32px">
		<!-- wp:column {"style":{"border":{"top":{"color":"var(--wp--custom--line, rgba(120,18,70,.14))","width":"2px"}},"spacing":{"padding":{"top":"14px"}}}} -->
		<div class="wp-block-column" style="border-top-color:var(--wp--custom--line, rgba(120,18,70,.14));border-top-width:2px;padding-top:14px">
			<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Gruppenräume</h4><!-- /wp:heading -->
			<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color has-small-font-size" style="color:#6e5a55">In Lasur gestrichen, mit Spieltüchern, Holz und Wolle statt Plastik.</p><!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"style":{"border":{"top":{"color":"var(--wp--custom--line, rgba(120,18,70,.14))","width":"2px"}},"spacing":{"padding":{"top":"14px"}}}} -->
		<div class="wp-block-column" style="border-top-color:var(--wp--custom--line, rgba(120,18,70,.14));border-top-width:2px;padding-top:14px">
			<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Werkstatt</h4><!-- /wp:heading -->
			<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color has-small-font-size" style="color:#6e5a55">Sägen, Filzen, Weben – echtes Werkzeug in kindgerechter Größe.</p><!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"style":{"border":{"top":{"color":"var(--wp--custom--line, rgba(120,18,70,.14))","width":"2px"}},"spacing":{"padding":{"top":"14px"}}}} -->
		<div class="wp-block-column" style="border-top-color:var(--wp--custom--line, rgba(120,18,70,.14));border-top-width:2px;padding-top:14px">
			<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Garten</h4><!-- /wp:heading -->
			<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color has-small-font-size" style="color:#6e5a55">Obstbäume, Sandbereich, Weidenhaus und ein Hochbeet zum Ernten.</p><!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"style":{"border":{"top":{"color":"var(--wp--custom--line, rgba(120,18,70,.14))","width":"2px"}},"spacing":{"padding":{"top":"14px"}}}} -->
		<div class="wp-block-column" style="border-top-color:var(--wp--custom--line, rgba(120,18,70,.14));border-top-width:2px;padding-top:14px">
			<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Küche</h4><!-- /wp:heading -->
			<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color has-small-font-size" style="color:#6e5a55">Hier wird täglich frisch gekocht – die Kinder helfen beim Schnippeln.</p><!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
