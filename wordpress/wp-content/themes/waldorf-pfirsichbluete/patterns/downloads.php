<?php
/**
 * Title: Downloads und Formulare
 * Slug: waldorf-pfirsichbluete/downloads
 * Categories: waldorf-sections
 * Description: Zweispaltige Liste mit Dateitypen und Größenangaben.
 */
?>
<!-- wp:group {"anchor":"downloads","metadata":{"name":"Downloads und Formulare"},"templateLock":"all","lock":{"remove":true},"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="downloads" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"className":"pb-reveal","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group pb-reveal">
		<!-- wp:group {"layout":{"type":"constrained"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Downloads &amp; Formulare</p><!-- /wp:paragraph -->
			<!-- wp:heading {"fontSize":"2-x-large","style":{"spacing":{"margin":{"top":"0.28em"}}}} --><h2 class="wp-block-heading has-2-x-large-font-size" style="margin-top:0.28em">Alles Wichtige zum Mitnehmen</h2><!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:waldorf/downloads {"metadata":{"name":"Dokumente"},"lock":{"move":true,"remove":true}} -->
		<!-- wp:waldorf/download {"fileUrl":"#","title":"Anmeldebogen","description":"2 Seiten","fallbackType":"PDF","fallbackSize":"180 kB","metadata":{"name":"Download: Anmeldebogen"}} /-->
		<!-- wp:waldorf/download {"fileUrl":"#","title":"Gebührenordnung","description":"1 Seite","fallbackType":"PDF","fallbackSize":"96 kB","metadata":{"name":"Download: Gebührenordnung"}} /-->
		<!-- wp:waldorf/download {"fileUrl":"#","title":"Satzung des Vereins","description":"8 Seiten","fallbackType":"PDF","fallbackSize":"240 kB","metadata":{"name":"Download: Satzung"}} /-->
	<!-- /wp:waldorf/downloads -->
</div>
<!-- /wp:group -->
