<?php
/**
 * Title: Verpflegung mit Wochenplan
 * Slug: waldorf-pfirsichbluete/verpflegung
 * Categories: waldorf-sections
 * Description: Getreide-Wochenplan mit Foto und Bio-Auszeichnungen.
 */
?>
<!-- wp:group {"anchor":"verpflegung","metadata":{"name":"Verpflegung"},"templateLock":"all","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="verpflegung" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:columns {"metadata":{"name":"Getreideplan und Foto"},"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"56px"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Verpflegung</p><!-- /wp:paragraph -->
			<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.3em","bottom":"0.4em"}}}} --><h2 class="wp-block-heading">Jeder Tag hat sein Getreide</h2><!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Bio-vegetarisch, frisch gekocht und im festen Wochenrhythmus. Die Kinder helfen beim Schnippeln und Tischdecken.</p><!-- /wp:paragraph -->

			<!-- wp:group {"tagName":"ul","metadata":{"name":"Getreide-Wochenplan"},"allowedBlocks":["waldorf/getreidetag"],"templateLock":false,"className":"pb-grain","style":{"spacing":{"margin":{"top":"24px"},"blockGap":"0"}},"layout":{"type":"default"}} -->
			<ul class="wp-block-group pb-grain" style="margin-top:24px">
				<!-- wp:waldorf/getreidetag {"day":"Montag","grain":"Reis","note":"mit Gemüse der Saison","metadata":{"name":"Montag · Reis"}} /-->
				<!-- wp:waldorf/getreidetag {"day":"Dienstag","grain":"Gerste","note":"als Eintopf oder Auflauf","metadata":{"name":"Dienstag · Gerste"}} /-->
				<!-- wp:waldorf/getreidetag {"day":"Mittwoch","grain":"Hirse","note":"süß oder herzhaft","metadata":{"name":"Mittwoch · Hirse"}} /-->
				<!-- wp:waldorf/getreidetag {"day":"Donnerstag","grain":"Roggen","note":"frisch gebackenes Brot","metadata":{"name":"Donnerstag · Roggen"}} /-->
				<!-- wp:waldorf/getreidetag {"day":"Freitag","grain":"Hafer","note":"Müsli und Suppe für den Waldtag","metadata":{"name":"Freitag · Hafer"}} /-->
			</ul>
			<!-- /wp:group -->

			<!-- wp:group {"metadata":{"name":"Essens-Auszeichnungen"},"allowedBlocks":["waldorf/auszeichnung"],"templateLock":false,"className":"pb-badges","style":{"spacing":{"margin":{"top":"24px"},"blockGap":"0"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group pb-badges" style="margin-top:24px">
				<!-- wp:waldorf/auszeichnung {"text":"100 % Bio","metadata":{"name":"100 % Bio"}} /-->
				<!-- wp:waldorf/auszeichnung {"text":"Vegetarisch","metadata":{"name":"Vegetarisch"}} /-->
				<!-- wp:waldorf/auszeichnung {"text":"Regional eingekauft","metadata":{"name":"Regional eingekauft"}} /-->
				<!-- wp:waldorf/auszeichnung {"text":"Ohne Zucker­zusatz","metadata":{"name":"Ohne Zuckerzusatz"}} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
			<!-- wp:waldorf/photo {"caption":"Beispielbild · Mittagessen","shape":"food","alt":"Frisch gekochtes Mittagessen","fallback":"photo-essen.jpg","className":"pb-reveal","metadata":{"name":"Foto Mittagessen"},"lock":{"move":true,"remove":true}} /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
