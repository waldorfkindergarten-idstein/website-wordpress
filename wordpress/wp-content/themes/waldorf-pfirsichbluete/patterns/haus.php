<?php
/**
 * Title: Unser Haus mit Foto-Mosaik
 * Slug: waldorf-pfirsichbluete/haus
 * Categories: waldorf-sections
 * Description: Vier Fotos im Mosaik, darunter eine vierspaltige Raumliste.
 */
?>
<!-- wp:group {"anchor":"haus","metadata":{"name":"Unser Haus"},"templateLock":"all","lock":{"remove":true},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="haus" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"metadata":{"name":"Einleitung"},"className":"pb-reveal","templateLock":"contentOnly","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
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

	<!-- wp:waldorf/mosaik {"metadata":{"name":"Fotos aus dem Haus"}} -->
		<!-- wp:waldorf/photo {"metadata":{"name":"Gruppenraum"},"shape":"mosaic1","fallback":"photo-gruppenraum.jpg","alt":"Gruppenraum mit Jahreszeitentisch","caption":"Beispielbild · Gruppenraum & Jahreszeitentisch"} /-->
		<!-- wp:waldorf/photo {"metadata":{"name":"Mal- und Handarbeitsecke"},"shape":"mosaic2","fallback":"photo-malecke.jpg","alt":"Mal- und Handarbeitsecke","caption":"Beispielbild · Mal- und Handarbeitsecke"} /-->
		<!-- wp:waldorf/photo {"metadata":{"name":"Freies Spiel mit Holz"},"shape":"mosaic3","fallback":"photo-holz.jpg","alt":"Freies Spiel mit Holz","caption":"Beispielbild · Freies Spiel mit Holz"} /-->
		<!-- wp:waldorf/photo {"metadata":{"name":"Garten"},"shape":"mosaic4","fallback":"photo-garten.jpg","alt":"Garten mit Obstbäumen und Sandbereich","caption":"Beispielbild · Garten (Panorama)"} /-->
	<!-- /wp:waldorf/mosaik -->

	<!-- wp:columns {"metadata":{"name":"Räume im Überblick"},"templateLock":"contentOnly","style":{"spacing":{"margin":{"top":"32px"},"blockGap":{"left":"22px"}}}} -->
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
