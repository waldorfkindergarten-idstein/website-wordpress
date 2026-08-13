<?php
/**
 * Title: Unsere Gruppen
 * Slug: waldorf-pfirsichbluete/gruppen
 * Categories: waldorf-sections
 * Description: Drei Gruppenkarten mit Foto, Alters-Tag und Eckdaten.
 */
?>
<!-- wp:group {"anchor":"gruppen","metadata":{"name":"Unsere Gruppen"},"templateLock":"all","lock":{"remove":true},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"gradient":"wash-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-wash-white-gradient-background has-background" id="gruppen" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"metadata":{"name":"Einleitung"},"className":"pb-reveal pb-sec-head","templateLock":"contentOnly","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Unsere Gruppen</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading" style="margin-top:0.28em;margin-bottom:0.35em">Ein Platz für jedes Alter</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Vom ersten Krippenjahr bis zum Schuleintritt – altersgemischt, kontinuierlich und nah an der Natur.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:waldorf/gruppen-raster {"metadata":{"name":"Gruppenkarten"}} -->
		<!-- wp:waldorf/gruppen-karte {"metadata":{"name":"Familiengruppen"},"fallback":"photo-morgenkreis.jpg","alt":"Familiengruppe beim Morgenkreis","caption":"Beispielbild · Morgenkreis","tag":"3–6 Jahre","title":"Familiengruppen","text":"Altersgemischte Gruppen, in denen Große für Kleine sorgen. Geschwister bleiben zusammen, Beziehungen wachsen über Jahre.","facts":[{"label":"Plätze","value":"2 × max. 22 Kinder"},{"label":"Vormittag","value":"7:30 – 13:00 Uhr"},{"label":"Ganztags","value":"7:30 – 15:15 Uhr (Mo–Do)"},{"label":"Freitag","value":"7:30 – 12:45 Uhr"}],"linkLabel":"Mehr erfahren"} /-->
		<!-- wp:waldorf/gruppen-karte {"metadata":{"name":"Krippe Wiegenstube"},"fallback":"photo-krippe.jpg","alt":"Krippenkind mit Naturmaterial","caption":"Beispielbild · Krippenkind mit Holzspielzeug","tag":"1–3 Jahre","title":"Krippe Wiegenstube","text":"Ein geborgener Start in kleiner Runde. Sanfte Eingewöhnung, viel Nähe und ein ruhiger Rhythmus für die Jüngsten.","facts":[{"label":"Plätze","value":"10 Kinder"},{"label":"Vormittag","value":"7:30 – 13:00 Uhr"},{"label":"Ganztags","value":"7:30 – 15:15 Uhr (Mo–Do)"},{"label":"Freitag","value":"7:30 – 12:45 Uhr"}],"linkLabel":"Mehr erfahren"} /-->
		<!-- wp:waldorf/gruppen-karte {"metadata":{"name":"Waldtag"},"fallback":"photo-waldtag.jpg","alt":"Kinder auf dem Waldtag","caption":"Beispielbild · Waldtag","tag":"Freitags","title":"Waldtag","text":"Jeden Freitag geht es hinaus: bei jedem Wetter, mit Seilen, Lupen und Zeit zum Entdecken.","facts":[{"label":"Wann","value":"Freitag, 7:30 – 12:45 Uhr"},{"label":"Treffpunkt","value":"8:00 Uhr am Haus"},{"label":"Alter","value":"ab 3 Jahren"}],"linkLabel":"Mehr erfahren"} /-->
	<!-- /wp:waldorf/gruppen-raster -->
</div>
<!-- /wp:group -->
