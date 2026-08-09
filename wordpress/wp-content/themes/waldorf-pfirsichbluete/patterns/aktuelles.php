<?php
/**
 * Title: Aktuelles und Termine
 * Slug: waldorf-pfirsichbluete/aktuelles
 * Categories: waldorf-sections
 * Description: Neuigkeiten aus dem Blog mit hervorgehobenem Beitrag und Terminliste.
 */
?>
<!-- wp:group {"anchor":"aktuelles","metadata":{"name":"Aktuelles und Termine"},"lock":{"move":true,"remove":true},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"gradient":"wash-rose","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-wash-rose-gradient-background has-background" id="aktuelles" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group pb-reveal">
		<!-- wp:group {"layout":{"type":"constrained"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Aktuelles</p><!-- /wp:paragraph -->
			<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em"}}}} --><h2 class="wp-block-heading" style="margin-top:0.28em">Aus unserem Kindergarten</h2><!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-ghost is-small"} --><div class="wp-block-button is-style-ghost is-small"><a class="wp-block-button__link wp-element-button" href="/aktuelles">Alle Beiträge</a></div><!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"margin":{"top":"48px"},"blockGap":{"left":"44px"}}}} -->
	<div class="wp-block-columns" style="margin-top:48px">
		<!-- wp:column {"width":"62%"} -->
		<div class="wp-block-column" style="flex-basis:62%">
			<!-- wp:query {"queryId":10,"query":{"perPage":1,"pages":1,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"constrained"}} -->
			<div class="wp-block-query">
				<!-- wp:post-template -->
					<!-- wp:group {"className":"pb-ncard pb-ncard--featured","layout":{"type":"constrained"}} -->
					<div class="wp-block-group pb-ncard pb-ncard--featured">
						<!-- wp:post-date {"className":"pb-ncard__date","format":"j. F Y"} /-->
						<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"x-large","style":{"spacing":{"margin":{"top":"0.5em","bottom":"0.4em"}}}} /-->
						<!-- wp:post-excerpt {"excerptLength":34,"showMoreOnNewLine":false} /-->
					</div>
					<!-- /wp:group -->
				<!-- /wp:post-template -->

				<!-- wp:query-no-results -->
					<!-- wp:paragraph --><p>Sobald es Neuigkeiten gibt, erscheinen sie hier.</p><!-- /wp:paragraph -->
				<!-- /wp:query-no-results -->
			</div>
			<!-- /wp:query -->

			<!-- wp:query {"queryId":11,"query":{"perPage":4,"pages":1,"offset":1,"postType":"post","order":"desc","orderBy":"date","inherit":false},"style":{"spacing":{"margin":{"top":"24px"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-query" style="margin-top:24px">
				<!-- wp:post-template {"layout":{"type":"grid","columnCount":2}} -->
					<!-- wp:group {"className":"pb-ncard","layout":{"type":"constrained"}} -->
					<div class="wp-block-group pb-ncard">
						<!-- wp:post-date {"className":"pb-ncard__date","format":"j. F Y"} /-->
						<!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0.5em","bottom":"0.4em"}}}} /-->
						<!-- wp:post-excerpt {"excerptLength":26,"showMoreOnNewLine":false} /-->
					</div>
					<!-- /wp:group -->
				<!-- /wp:post-template -->
			</div>
			<!-- /wp:query -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:waldorf/termine {"heading":"Termine","metadata":{"name":"Termine"},"lock":{"move":true,"remove":true}} -->
				<!-- wp:waldorf/termin {"date":"2026-10-06","title":"Kennenlerntag","detail":"14:00 – 16:00 Uhr · ohne Anmeldung","metadata":{"name":"Termin: Kennenlerntag"}} /-->
				<!-- wp:waldorf/termin {"date":"2026-10-24","title":"Laternenbasteln","detail":"15:30 Uhr · für Familien","metadata":{"name":"Termin: Laternenbasteln"}} /-->
				<!-- wp:waldorf/termin {"date":"2026-11-11","title":"Martinsumzug","detail":"17:00 Uhr · Treffpunkt am Haus","metadata":{"name":"Termin: Martinsumzug"}} /-->
				<!-- wp:waldorf/termin {"date":"2026-12-06","title":"Adventsgarten","detail":"16:00 Uhr · nur mit Anmeldung","metadata":{"name":"Termin: Adventsgarten"}} /-->
			<!-- /wp:waldorf/termine -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
