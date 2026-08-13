<?php
/**
 * Title: Hero mit Foto und Kennzahlen
 * Slug: waldorf-pfirsichbluete/hero
 * Categories: waldorf-sections
 * Description: Aufmacher mit Aquarell-Hintergrund, Foto in organischer Form, Siegel und Terminhinweis.
 */
?>
<!-- wp:group {"className":"pb-hero","style":{"spacing":{"padding":{"top":"96px","bottom":"70px"}}},"layout":{"type":"constrained"},"templateLock":"all","lock":{"remove":true},"metadata":{"name":"Hero"}} -->
<div class="wp-block-group pb-hero" style="padding-top:96px;padding-bottom:70px">
	<!-- wp:waldorf/dekoration {"variant":"hero-background","lock":{"move":true,"remove":true},"metadata":{"name":"Aquarell-Hintergrund"}} /-->

	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"56px"}}},"metadata":{"name":"Hero-Inhalt"}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"52%","templateLock":"all","metadata":{"name":"Hero-Text"}} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%">
			<!-- wp:paragraph {"className":"pb-kicker"} -->
			<p class="pb-kicker">Schön, dass Sie da sind</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"top":"0.3em","bottom":"0.45em"}},"typography":{"textWrap":"balance"}}} -->
			<h1 class="wp-block-heading" style="margin-top:0.3em;margin-bottom:0.45em;text-wrap:balance">Ein warmes Zuhause zum <em>Großwerden</em></h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"large","style":{"color":{"text":"#5a4046"}}} -->
			<p class="has-text-color has-large-font-size" style="color:#5a4046">Geborgenheit, Rhythmus und Naturverbundenheit für Kinder ab einem Jahr – in familienähnlichen Gruppen vom Krippenalter bis zum Schuleintritt.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"28px"},"blockGap":"14px"}}} -->
			<div class="wp-block-buttons" style="margin-top:28px">
				<!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#kontakt">Kennenlerntag vereinbaren</a></div><!-- /wp:button -->
				<!-- wp:button {"className":"is-style-ghost"} --><div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#anmeldung">So läuft die Anmeldung</a></div><!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

			<!-- wp:waldorf/sammlung {"variant":"chips","metadata":{"name":"Merkmale"}} -->
				<!-- wp:waldorf/chip {"text":"Familiengruppen · 3–6 Jahre"} /-->
				<!-- wp:waldorf/chip {"text":"Krippe Wiegenstube · 1–3 Jahre"} /-->
				<!-- wp:waldorf/chip {"text":"Waldtag am Freitag"} /-->
			<!-- /wp:waldorf/sammlung -->

			<!-- wp:waldorf/sammlung {"variant":"facts","metadata":{"name":"Kennzahlen"}} -->
				<!-- wp:waldorf/fakt {"value":"39","label":"Jahre Elterninitiative"} /-->
				<!-- wp:waldorf/fakt {"value":"3","label":"Gruppen im Haus"} /-->
				<!-- wp:waldorf/fakt {"value":"1–6","label":"Jahre Aufnahmealter"} /-->
			<!-- /wp:waldorf/sammlung -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","className":"pb-hero__figure pb-reveal","templateLock":"all","metadata":{"name":"Hero-Foto und Hinweise"}} -->
		<div class="wp-block-column is-vertically-aligned-center pb-hero__figure pb-reveal">
			<!-- wp:waldorf/photo {"caption":"Beispielbild · Freispiel im Garten","shape":"hero","alt":"Kinder beim Freispiel im Garten","fallback":"photo-hero.jpg","metadata":{"name":"Hero-Foto"}} /-->

			<!-- wp:waldorf/siegel {"heading":"Seit<br>1987","label":"Elterninitiative","metadata":{"name":"Gründungssiegel"}} /-->

			<!-- wp:waldorf/datum {"eyebrow":"Nächster Termin","title":"Kennenlerntag","date":"Di, 6. Oktober · 14–16 Uhr","metadata":{"name":"Nächster Termin"}} /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:separator {"className":"is-style-hand-drawn"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-hand-drawn"/>
<!-- /wp:separator -->
