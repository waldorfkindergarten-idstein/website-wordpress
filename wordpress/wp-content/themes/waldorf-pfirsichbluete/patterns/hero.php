<?php
/**
 * Title: Hero mit Foto und Kennzahlen
 * Slug: waldorf-pfirsichbluete/hero
 * Categories: waldorf-sections
 * Description: Aufmacher mit Aquarell-Hintergrund, Foto in organischer Form, Siegel und Terminhinweis.
 */
?>
<!-- wp:group {"className":"pb-hero","style":{"spacing":{"padding":{"top":"96px","bottom":"70px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-hero" style="padding-top:96px;padding-bottom:70px">
	<!-- wp:html --><div class="pb-hero__bg" aria-hidden="true"></div><!-- /wp:html -->

	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"56px"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
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

			<!-- wp:html -->
			<div class="pb-chips" style="margin-top:30px">
				<span class="pb-chip">Familiengruppen · 2–6 Jahre</span>
				<span class="pb-chip">Krippe Wiegenstube · 1–3 Jahre</span>
				<span class="pb-chip">Waldtag am Freitag</span>
			</div>
			<!-- /wp:html -->

			<!-- wp:paragraph {"className":"pb-note-hand","style":{"spacing":{"margin":{"top":"20px"}}}} -->
			<p class="pb-note-hand" style="margin-top:20px">Alle Fotos sind Beispielbilder – Ihre eigenen setzen wir 1:1 an dieselben Stellen.</p>
			<!-- /wp:paragraph -->

			<!-- wp:html -->
			<div class="pb-facts" style="margin-top:36px">
				<div class="pb-fact"><b>39</b><span>Jahre Elterninitiative</span></div>
				<div class="pb-fact"><b>3</b><span>Gruppen im Haus</span></div>
				<div class="pb-fact"><b>1–6</b><span>Jahre Aufnahmealter</span></div>
			</div>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","className":"pb-hero__figure pb-reveal"} -->
		<div class="wp-block-column is-vertically-aligned-center pb-hero__figure pb-reveal">
			<!-- wp:image {"className":"pb-photo pb-shape-hero","style":{"layout":{"aspectRatio":"4/4.4"}}} -->
			<figure class="wp-block-image pb-photo pb-shape-hero" style="aspect-ratio:4/4.4"><img src="<?php echo esc_url( waldorf_pb_img( 'photo-hero.jpg' ) ); ?>" alt="Kinder beim Freispiel im Garten"/><figcaption class="wp-element-caption">Beispielbild · Freispiel im Garten</figcaption></figure>
			<!-- /wp:image -->

			<!-- wp:html -->
			<div class="pb-seal"><div><b>Seit<br>1987</b><span>Elterninitiative</span></div></div>
			<div class="pb-date-pill">
				<span class="pb-eyebrow">Nächster Termin</span>
				<b>Kennenlerntag</b>
				<span>Di, 6. Oktober · 14–16 Uhr</span>
			</div>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:separator {"className":"is-style-hand-drawn"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-hand-drawn"/>
<!-- /wp:separator -->
