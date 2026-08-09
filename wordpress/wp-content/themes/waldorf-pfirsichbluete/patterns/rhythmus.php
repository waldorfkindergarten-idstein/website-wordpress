<?php
/**
 * Title: Tagesrhythmus mit Zeitstrahl
 * Slug: waldorf-pfirsichbluete/rhythmus
 * Categories: waldorf-sections
 * Description: Zeitstrahl des Tagesablaufs plus Wochenübersicht mit Waldtag.
 */

$waldorf_pb_day = array(
	array( '7:30',  'Ankommen und Freispiel',        'Die Kinder kommen an, hängen ihre Jacken auf und finden ins Spiel.', false ),
	array( '8:30',  'Frühstück in der Gruppe',       'Gemeinsam gedeckt, gemeinsam gegessen – jeden Tag zur selben Zeit.', false ),
	array( '9:15',  'Morgenkreis',                   'Lieder, Reime und Fingerspiele, passend zur Jahreszeit.', false ),
	array( '9:45',  'Freies Spiel drinnen',          'Bauen, malen, verkleiden – begleitet, aber nicht gelenkt.', false ),
	array( '10:45', 'Garten und frische Luft',       'Bei jedem Wetter nach draußen.', false ),
	array( '11:45', 'Mittagessen',                   'Frisch gekocht, bio-vegetarisch, am gedeckten Tisch.', false ),
	array( '12:30', 'Abholzeit Kernzeit',            'Ende der Kernzeit für alle Familien.', false ),
	array( '13:00', 'Ruhezeit und Nachmittag',       'Schlafen, vorlesen, ruhiges Spiel bis zur Abholung.', true ),
);

$waldorf_pb_week = array(
	array( 'Montag',     'Malen',        'Mit Aquarellfarben auf großem Papier.', false ),
	array( 'Dienstag',   'Eurythmie',    'Bewegung zu Sprache und Musik.', false ),
	array( 'Mittwoch',   'Backtag',      'Teig kneten, formen, warten, essen.', false ),
	array( 'Donnerstag', 'Handarbeit',   'Filzen, weben, erste Nadelstiche.', false ),
	array( 'Freitag',    'Waldtag',      'Den ganzen Vormittag draußen.', true ),
);
?>
<!-- wp:group {"anchor":"rhythmus","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="rhythmus" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Tagesrhythmus</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">Ein Tag, der atmet</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Wiederkehrende Abläufe geben Sicherheit. Die Kinder wissen, was als Nächstes kommt – und können sich ganz dem Spiel überlassen.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"margin":{"top":"18px"},"blockGap":{"left":"64px"}}}} -->
	<div class="wp-block-columns" style="margin-top:18px">
		<!-- wp:column {"width":"42%"} -->
		<div class="wp-block-column" style="flex-basis:42%">
			<!-- wp:html -->
			<figure class="pb-photo pb-shape-rhythm pb-reveal" style="aspect-ratio:4/4.2;margin-top:26px">
				<img src="<?php echo esc_url( waldorf_pb_img( 'photo-rhythmus.jpg' ) ); ?>" alt="Kinder im Morgenkreis" loading="lazy" decoding="async">
				<figcaption>Beispielbild · Morgenkreis</figcaption>
			</figure>
			<!-- /wp:html -->

			<!-- wp:group {"className":"is-style-glass","style":{"spacing":{"margin":{"top":"26px"},"padding":{"top":"20px","bottom":"20px","left":"22px","right":"22px"}},"border":{"radius":"22px"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-glass" style="border-radius:22px;margin-top:26px;padding:20px 22px">
				<!-- wp:paragraph {"style":{"typography":{"fontFamily":"var(--wp--preset--font-family--serif)","fontSize":"1.05rem","fontWeight":"600"}}} --><p style="font-family:var(--wp--preset--font-family--serif);font-size:1.05rem;font-weight:600">Ein- und Ausatmen</p><!-- /wp:paragraph -->
				<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color has-small-font-size" style="color:#6e5a55">Auf jede Phase der Sammlung folgt eine Phase der Weite. Dieser Wechsel trägt den ganzen Tag.</p><!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:html -->
			<ol class="pb-timeline">
				<?php foreach ( $waldorf_pb_day as $waldorf_pb_slot ) : ?>
					<li class="pb-tl<?php echo $waldorf_pb_slot[3] ? ' pb-tl--optional' : ''; ?>">
						<div class="pb-tl__time"><?php echo esc_html( $waldorf_pb_slot[0] ); ?><?php echo $waldorf_pb_slot[3] ? '<span class="pb-tl__badge">Verlängert</span>' : ''; ?></div>
						<div class="pb-tl__title"><?php echo esc_html( $waldorf_pb_slot[1] ); ?></div>
						<div class="pb-tl__sub"><?php echo esc_html( $waldorf_pb_slot[2] ); ?></div>
					</li>
				<?php endforeach; ?>
			</ol>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:html -->
	<div class="pb-week" style="margin-top:56px">
		<?php foreach ( $waldorf_pb_week as $waldorf_pb_d ) : ?>
			<div class="pb-day<?php echo $waldorf_pb_d[3] ? ' pb-day--forest' : ''; ?>">
				<div class="pb-day__name"><?php echo esc_html( $waldorf_pb_d[0] ); ?></div>
				<h4><?php echo esc_html( $waldorf_pb_d[1] ); ?></h4>
				<p><?php echo esc_html( $waldorf_pb_d[2] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
