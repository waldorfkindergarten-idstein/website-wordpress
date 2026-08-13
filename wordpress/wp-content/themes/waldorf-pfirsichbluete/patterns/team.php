<?php
/**
 * Title: Team
 * Slug: waldorf-pfirsichbluete/team
 * Categories: waldorf-sections
 * Description: Fünf Personen mit Monogramm in organischer Form.
 */
?>
<!-- wp:group {"anchor":"team","metadata":{"name":"Unser Team"},"templateLock":"all","lock":{"remove":true},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="team" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"metadata":{"name":"Einleitung"},"className":"pb-reveal pb-sec-head","templateLock":"contentOnly","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Unser Team</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">Menschen, die den Tag tragen</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Ein festes Team begleitet die Kinder über Jahre – mit Ruhe, Humor und viel Erfahrung.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Teammitglieder"},"allowedBlocks":["waldorf/person"],"className":"pb-team","templateLock":"insert","style":{"spacing":{"margin":{"top":"44px"},"blockGap":"0"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group pb-team" style="margin-top:44px">
		<!-- wp:waldorf/person {"metadata":{"name":"Leitung"},"monogram":"I","name":"Iris Born","role":"Pädagogische Leitung"} /-->
		<!-- wp:waldorf/person {"metadata":{"name":"Stellvertretende Leitung"},"monogram":"A","name":"Anke Reinhold","role":"Stellvertretende Leitung"} /-->
		<!-- wp:waldorf/person {"metadata":{"name":"Lerchennest"},"monogram":"L","name":"Lerchennest","role":"Erzieherin & Gruppenleitung"} /-->
		<!-- wp:waldorf/person {"metadata":{"name":"Spatzennest"},"monogram":"S","name":"Spatzennest","role":"Erzieherin & Gruppenleitung"} /-->
		<!-- wp:waldorf/person {"metadata":{"name":"Wiegenstube"},"monogram":"W","name":"Wiegenstube","role":"Krippenpädagogin"} /-->
		<!-- wp:waldorf/person {"metadata":{"name":"Küche"},"monogram":"K","name":"Küche","role":"Frisch gekocht, jeden Tag"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:waldorf/team-hinweis {"metadata":{"name":"Team-Hinweis"}} /-->
</div>
<!-- /wp:group -->
