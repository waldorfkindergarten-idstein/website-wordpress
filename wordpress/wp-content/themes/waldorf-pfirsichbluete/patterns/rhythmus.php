<?php
/**
 * Title: Tagesrhythmus mit Zeitstrahl
 * Slug: waldorf-pfirsichbluete/rhythmus
 * Categories: waldorf-sections
 * Description: Zeitstrahl des Tagesablaufs plus Wochenübersicht mit Waldtag.
 */
?>
<!-- wp:group {"anchor":"rhythmus","metadata":{"name":"Tagesrhythmus"},"templateLock":"all","lock":{"remove":true},"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" id="rhythmus" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"metadata":{"name":"Einleitung Tagesrhythmus"},"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Tagesrhythmus</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">Ein Tag, der atmet</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Wiederkehrende Abläufe geben Sicherheit. Die Kinder wissen, was als Nächstes kommt – und können sich ganz dem Spiel überlassen.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"metadata":{"name":"Foto und Tagesablauf"},"style":{"spacing":{"margin":{"top":"18px"},"blockGap":{"left":"64px"}}}} -->
	<div class="wp-block-columns" style="margin-top:18px">
		<!-- wp:column {"width":"42%"} -->
		<div class="wp-block-column" style="flex-basis:42%">
			<!-- wp:group {"metadata":{"name":"Foto Morgenkreis"},"lock":{"move":true,"remove":true},"style":{"spacing":{"margin":{"top":"26px"},"blockGap":"0"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group" style="margin-top:26px">
				<!-- wp:waldorf/photo {"caption":"Beispielbild · Morgenkreis","shape":"rhythm","alt":"Kinder im Morgenkreis","fallback":"photo-rhythmus.jpg","className":"pb-reveal","metadata":{"name":"Foto Morgenkreis"}} /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"metadata":{"name":"Ein- und Ausatmen"},"className":"is-style-glass","style":{"spacing":{"margin":{"top":"26px"},"padding":{"top":"20px","bottom":"20px","left":"22px","right":"22px"}},"border":{"radius":"22px"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-glass" style="border-radius:22px;margin-top:26px;padding-top:20px;padding-right:22px;padding-bottom:20px;padding-left:22px">
				<!-- wp:paragraph {"style":{"typography":{"fontFamily":"var(--wp--preset--font-family--serif)","fontSize":"1.05rem","fontWeight":"600"}}} --><p style="font-family:var(--wp--preset--font-family--serif);font-size:1.05rem;font-weight:600">Ein- und Ausatmen</p><!-- /wp:paragraph -->
				<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color has-small-font-size" style="color:#6e5a55">Auf jede Phase der Sammlung folgt eine Phase der Weite. Dieser Wechsel trägt den ganzen Tag.</p><!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:waldorf/tagesablauf {"metadata":{"name":"Tagesablauf"},"lock":{"move":true,"remove":true}} -->
				<!-- wp:waldorf/tagesablauf-punkt {"time":"7:30","title":"Ankommen und Freispiel","detail":"Die Kinder kommen an, hängen ihre Jacken auf und finden ins Spiel.","metadata":{"name":"7:30 · Ankommen und Freispiel"}} /-->
				<!-- wp:waldorf/tagesablauf-punkt {"time":"8:30","title":"Frühstück in der Gruppe","detail":"Gemeinsam gedeckt, gemeinsam gegessen – jeden Tag zur selben Zeit.","metadata":{"name":"8:30 · Frühstück in der Gruppe"}} /-->
				<!-- wp:waldorf/tagesablauf-punkt {"time":"9:15","title":"Morgenkreis","detail":"Lieder, Reime und Fingerspiele, passend zur Jahreszeit.","metadata":{"name":"9:15 · Morgenkreis"}} /-->
				<!-- wp:waldorf/tagesablauf-punkt {"time":"9:45","title":"Freies Spiel drinnen","detail":"Bauen, malen, verkleiden – begleitet, aber nicht gelenkt.","metadata":{"name":"9:45 · Freies Spiel drinnen"}} /-->
				<!-- wp:waldorf/tagesablauf-punkt {"time":"10:45","title":"Garten und frische Luft","detail":"Bei jedem Wetter nach draußen.","metadata":{"name":"10:45 · Garten und frische Luft"}} /-->
				<!-- wp:waldorf/tagesablauf-punkt {"time":"11:45","title":"Mittagessen","detail":"Frisch gekocht, bio-vegetarisch, am gedeckten Tisch.","metadata":{"name":"11:45 · Mittagessen"}} /-->
				<!-- wp:waldorf/tagesablauf-punkt {"time":"13:00","title":"Abholzeit Vormittagsplatz","detail":"Ende des Vormittagsplatzes – freitags bereits um 12:45 Uhr.","metadata":{"name":"13:00 · Abholzeit Vormittagsplatz"}} /-->
				<!-- wp:waldorf/tagesablauf-punkt {"time":"13:00 – 15:15","title":"Ruhezeit und Nachmittag","detail":"Ganztagsplatz: schlafen, vorlesen, ruhiges Spiel bis zur Abholung.","isExtended":true,"metadata":{"name":"13:00 – 15:15 · Ruhezeit und Nachmittag"}} /-->
			<!-- /wp:waldorf/tagesablauf -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:group {"tagName":"div","metadata":{"name":"Wochenrhythmus"},"allowedBlocks":["waldorf/tag"],"templateLock":false,"className":"pb-week","style":{"spacing":{"margin":{"top":"56px"},"blockGap":"0"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group pb-week" style="margin-top:56px">
		<!-- wp:waldorf/tag {"weekday":"Montag","title":"Malen","text":"Mit Aquarellfarben auf großem Papier.","metadata":{"name":"Montag · Malen"}} /-->
		<!-- wp:waldorf/tag {"weekday":"Dienstag","title":"Eurythmie","text":"Bewegung zu Sprache und Musik.","metadata":{"name":"Dienstag · Eurythmie"}} /-->
		<!-- wp:waldorf/tag {"weekday":"Mittwoch","title":"Backtag","text":"Teig kneten, formen, warten, essen.","metadata":{"name":"Mittwoch · Backtag"}} /-->
		<!-- wp:waldorf/tag {"weekday":"Donnerstag","title":"Handarbeit","text":"Filzen, weben, erste Nadelstiche.","metadata":{"name":"Donnerstag · Handarbeit"}} /-->
		<!-- wp:waldorf/tag {"weekday":"Freitag","title":"Waldtag","text":"Den ganzen Vormittag draußen.","isForestDay":true,"metadata":{"name":"Freitag · Waldtag"}} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
