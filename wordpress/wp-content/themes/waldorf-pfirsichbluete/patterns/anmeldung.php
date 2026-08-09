<?php
/**
 * Title: Anmeldung mit FAQ
 * Slug: waldorf-pfirsichbluete/anmeldung
 * Categories: waldorf-sections
 * Description: Vier Schritte zum Platz plus aufklappbare Fragen.
 */
?>
<!-- wp:group {"anchor":"anmeldung","metadata":{"name":"Anmeldung und FAQ"},"templateLock":"all","lock":{"remove":true},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"gradient":"wash-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-wash-white-gradient-background has-background" id="anmeldung" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Anmeldung</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">In vier Schritten zum Platz</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Wir nehmen uns Zeit für jede Familie. Melden Sie sich gern, auch wenn der Platz erst in einem Jahr gebraucht wird.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:waldorf/schritte {"metadata":{"name":"Vier Schritte zum Platz"},"lock":{"move":true,"remove":true}} -->
		<!-- wp:waldorf/schritt {"title":"Kennenlernen","text":"Kommen Sie zu einem Kennenlerntag oder rufen Sie uns an. Ohne Termin geht auch.","metadata":{"name":"Schritt: Kennenlernen"}} /-->
		<!-- wp:waldorf/schritt {"title":"Hospitieren","text":"Sie besuchen einen Morgen in der Gruppe und erleben den Rhythmus mit Ihrem Kind.","metadata":{"name":"Schritt: Hospitieren"}} /-->
		<!-- wp:waldorf/schritt {"title":"Anmeldebogen","text":"Formular ausfüllen und abgeben – digital oder auf Papier. Danach folgt das Gespräch.","metadata":{"name":"Schritt: Anmeldebogen"}} /-->
		<!-- wp:waldorf/schritt {"title":"Eingewöhnung","text":"Begleitet, in kleinen Schritten und im Tempo Ihres Kindes. Zwei bis vier Wochen.","metadata":{"name":"Schritt: Eingewöhnung"}} /-->
	<!-- /wp:waldorf/schritte -->

	<!-- wp:columns {"style":{"spacing":{"margin":{"top":"70px"},"blockGap":{"left":"56px"}}}} -->
	<div class="wp-block-columns" style="margin-top:70px">
		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column" style="flex-basis:40%">
			<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Häufige Fragen</p><!-- /wp:paragraph -->
			<!-- wp:heading {"fontSize":"2-x-large","style":{"spacing":{"margin":{"top":"0.3em","bottom":"0.4em"}}}} --><h2 class="wp-block-heading has-2-x-large-font-size" style="margin-top:0.3em;margin-bottom:0.4em">Gut zu wissen</h2><!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Ihre Frage ist nicht dabei? Rufen Sie uns einfach an.</p><!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:waldorf/faqs {"metadata":{"name":"Häufige Fragen"},"lock":{"move":true,"remove":true}} -->
				<!-- wp:waldorf/faq {"question":"Ab welchem Alter können Kinder aufgenommen werden?","answer":"In der Wiegenstube ab einem Jahr, in den Familiengruppen ab zwei Jahren. Entscheidend ist, dass Ihr Kind bereit für den Schritt ist – das besprechen wir gemeinsam.","metadata":{"name":"FAQ: Aufnahmealter"}} /-->
				<!-- wp:waldorf/faq {"question":"Was kostet ein Platz?","answer":"Die Beiträge richten sich nach Betreuungsumfang und Einkommen. Die aktuelle Gebührenordnung finden Sie bei den Downloads. Niemand soll aus finanziellen Gründen fernbleiben – sprechen Sie uns an.","metadata":{"name":"FAQ: Kosten"}} /-->
				<!-- wp:waldorf/faq {"question":"Müssen Eltern mitarbeiten?","answer":"Als Elterninitiative leben wir vom Mitmachen: Gartentage, Basteln für den Basar, Vorstandsarbeit. Der Umfang ist überschaubar und wird gemeinsam abgestimmt.","metadata":{"name":"FAQ: Elternmitarbeit"}} /-->
				<!-- wp:waldorf/faq {"question":"Wie läuft die Eingewöhnung ab?","answer":"Behutsam und individuell. In den ersten Tagen bleiben Sie dabei, danach lösen Sie sich schrittweise. Zwei bis vier Wochen sind üblich.","metadata":{"name":"FAQ: Eingewöhnung"}} /-->
				<!-- wp:waldorf/faq {"question":"Gibt es einen Waldtag bei jedem Wetter?","answer":"Ja. Mit passender Kleidung ist fast jedes Wetter gutes Wetter. Nur bei Sturm bleiben wir am Haus.","metadata":{"name":"FAQ: Waldtag"}} /-->
			<!-- /wp:waldorf/faqs -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
