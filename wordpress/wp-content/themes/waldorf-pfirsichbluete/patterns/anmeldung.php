<?php
/**
 * Title: Anmeldung mit FAQ
 * Slug: waldorf-pfirsichbluete/anmeldung
 * Categories: waldorf-sections
 * Description: Vier Schritte zum Platz plus aufklappbare Fragen.
 */

$waldorf_pb_steps = array(
	array( 'Kennenlernen',  'Kommen Sie zu einem Kennenlerntag oder rufen Sie uns an. Ohne Termin geht auch.' ),
	array( 'Hospitieren',   'Sie besuchen einen Morgen in der Gruppe und erleben den Rhythmus mit Ihrem Kind.' ),
	array( 'Anmeldebogen',  'Formular ausfüllen und abgeben – digital oder auf Papier. Danach folgt das Gespräch.' ),
	array( 'Eingewöhnung',  'Begleitet, in kleinen Schritten und im Tempo Ihres Kindes. Zwei bis vier Wochen.' ),
);

$waldorf_pb_faq = array(
	array( 'Ab welchem Alter können Kinder aufgenommen werden?', 'In der Wiegenstube ab einem Jahr, in den Familiengruppen ab zwei Jahren. Entscheidend ist, dass Ihr Kind bereit für den Schritt ist – das besprechen wir gemeinsam.' ),
	array( 'Was kostet ein Platz?', 'Die Beiträge richten sich nach Betreuungsumfang und Einkommen. Die aktuelle Gebührenordnung finden Sie bei den Downloads. Niemand soll aus finanziellen Gründen fernbleiben – sprechen Sie uns an.' ),
	array( 'Müssen Eltern mitarbeiten?', 'Als Elterninitiative leben wir vom Mitmachen: Gartentage, Basteln für den Basar, Vorstandsarbeit. Der Umfang ist überschaubar und wird gemeinsam abgestimmt.' ),
	array( 'Wie läuft die Eingewöhnung ab?', 'Behutsam und individuell. In den ersten Tagen bleiben Sie dabei, danach lösen Sie sich schrittweise. Zwei bis vier Wochen sind üblich.' ),
	array( 'Gibt es einen Waldtag bei jedem Wetter?', 'Ja. Mit passender Kleidung ist fast jedes Wetter gutes Wetter. Nur bei Sturm bleiben wir am Haus.' ),
);
?>
<!-- wp:group {"anchor":"anmeldung","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"gradient":"wash-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-wash-white-gradient-background has-background" id="anmeldung" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Anmeldung</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">In vier Schritten zum Platz</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Wir nehmen uns Zeit für jede Familie. Melden Sie sich gern, auch wenn der Platz erst in einem Jahr gebraucht wird.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="pb-steps" style="margin-top:46px">
		<?php $waldorf_pb_i = 1; foreach ( $waldorf_pb_steps as $waldorf_pb_s ) : ?>
			<div class="pb-step pb-reveal">
				<span class="pb-step__n"><?php echo (int) $waldorf_pb_i; ?></span>
				<h4><?php echo esc_html( $waldorf_pb_s[0] ); ?></h4>
				<p><?php echo esc_html( $waldorf_pb_s[1] ); ?></p>
			</div>
		<?php $waldorf_pb_i++; endforeach; ?>
	</div>
	<!-- /wp:html -->

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
			<!-- wp:html -->
			<div class="pb-faq">
				<?php foreach ( $waldorf_pb_faq as $waldorf_pb_q ) : ?>
					<details>
						<summary><?php echo esc_html( $waldorf_pb_q[0] ); ?></summary>
						<p><?php echo esc_html( $waldorf_pb_q[1] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
