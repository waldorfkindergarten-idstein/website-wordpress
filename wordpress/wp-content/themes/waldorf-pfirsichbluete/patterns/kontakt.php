<?php
/**
 * Title: Kontakt und Öffnungszeiten
 * Slug: waldorf-pfirsichbluete/kontakt
 * Categories: waldorf-sections
 * Description: Kontaktdaten als Tabelle neben einem Platz für die Karte.
 */
?>
<!-- wp:group {"anchor":"kontakt","metadata":{"name":"Kontakt und Öffnungszeiten"},"lock":{"move":true,"remove":true},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="kontakt" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Kontakt</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">So erreichen Sie uns</h2><!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"margin":{"top":"46px"},"blockGap":{"left":"40px"}}}} -->
	<div class="wp-block-columns" style="margin-top:46px">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:waldorf/kontaktbox {"heading":"Kontakt & Öffnungszeiten","metadata":{"name":"Kontaktdaten"},"lock":{"move":true,"remove":true}} -->
				<!-- wp:waldorf/kontaktzeile {"label":"Adresse","value":"Limburger Str. 79<br>65510 Idstein","linkType":"address","metadata":{"name":"Adresse"}} /-->
				<!-- wp:waldorf/kontaktzeile {"label":"Telefon","value":"06126 / 92141","linkType":"tel","metadata":{"name":"Telefon"}} /-->
				<!-- wp:waldorf/kontaktzeile {"label":"E-Mail","value":"info@waldorfkindergarten-idstein.de","linkType":"email","metadata":{"name":"E-Mail"}} /-->
				<!-- wp:waldorf/kontaktzeile {"label":"Kernzeit","value":"Mo–Fr 7:30 – 12:00 Uhr","metadata":{"name":"Kernzeit"}} /-->
				<!-- wp:waldorf/kontaktzeile {"label":"Verlängert","value":"Mo–Do bis 15:15 Uhr · Fr bis 14:00 Uhr","metadata":{"name":"Verlängerte Öffnungszeit"}} /-->
				<!-- wp:waldorf/kontaktzeile {"label":"Büro","value":"Di & Do 9:00 – 12:00 Uhr","metadata":{"name":"Bürozeiten"}} /-->
				<!-- wp:waldorf/kontaktzeile {"label":"Träger","value":"Idsteiner Waldorfkindergarten e.V.","metadata":{"name":"Träger"}} /-->
			<!-- /wp:waldorf/kontaktbox -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"pb-kbox","style":{"dimensions":{"minHeight":"320px"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group pb-kbox" style="min-height:320px">
				<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Anfahrt</h3><!-- /wp:heading -->
				<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6e5a55"}}} -->
				<p class="has-text-color has-small-font-size" style="color:#6e5a55">Mit dem Bus bis Haltestelle Limburger Straße, von dort zwei Minuten zu Fuß. Parkplätze finden Sie direkt am Haus.</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6e5a55"}}} -->
				<p class="has-text-color has-small-font-size" style="color:#6e5a55"><em>Hier lässt sich eine Karte einbinden — aus Datenschutzgründen erst nach Einwilligung.</em></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
