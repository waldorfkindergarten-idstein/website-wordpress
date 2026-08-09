<?php
/**
 * Title: Jahreslauf und Feste
 * Slug: waldorf-pfirsichbluete/jahreslauf
 * Categories: waldorf-sections
 * Description: Sechs Festkarten mit Aquarell-Motiven.
 */
?>
<!-- wp:group {"anchor":"jahreslauf","metadata":{"name":"Jahreslauf und Feste"},"templateLock":"all","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"gradient":"wash-rose","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-wash-rose-gradient-background has-background" id="jahreslauf" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"metadata":{"name":"Überschrift"},"templateLock":"contentOnly","className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Jahreslauf</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">Feste, die das Jahr gliedern</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Jedes Fest wird über Wochen vorbereitet. Die Vorfreude gehört genauso dazu wie der Tag selbst.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:waldorf/feste {"metadata":{"name":"Feste"},"templateLock":false} -->
	<div class="wp-block-waldorf-feste" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;margin-top:46px">
		<!-- wp:waldorf/fest {"month":"September","title":"Michaeli","text":"Mut und Kraft: Drachenbrot backen, gemeinsam etwas wagen.","motif":"c","metadata":{"name":"Michaeli (September)"}} /-->
		<!-- wp:waldorf/fest {"month":"November","title":"Martini","text":"Laternen ziehen durch die Dämmerung, Lieder wärmen.","motif":"summer","metadata":{"name":"Martini (November)"}} /-->
		<!-- wp:waldorf/fest {"month":"Dezember","title":"Advent","text":"Der Adventsgarten mit Moos, Kerzen und leiser Musik.","motif":"e","metadata":{"name":"Advent (Dezember)"}} /-->
		<!-- wp:waldorf/fest {"month":"Februar","title":"Fasching","text":"Verkleiden mit Tüchern statt Kostümen – und Krapfen für alle.","motif":"f","metadata":{"name":"Fasching (Februar)"}} /-->
		<!-- wp:waldorf/fest {"month":"April","title":"Ostern","text":"Kressegärtchen säen, Eier mit Zwiebelschalen färben, Suche im Garten.","motif":"b","metadata":{"name":"Ostern (April)"}} /-->
		<!-- wp:waldorf/fest {"month":"Juni","title":"Johanni","text":"Das Sommerfest am längsten Tag: Blumenkränze, Springen, Musik.","motif":"d","metadata":{"name":"Johanni (Juni)"}} /-->
	</div>
	<!-- /wp:waldorf/feste -->
</div>
<!-- /wp:group -->
