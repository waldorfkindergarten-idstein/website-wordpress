<?php
/**
 * Five Leitbild page treatments, for choosing between.
 *
 * All copy is the Verein's own: the six principles come verbatim from
 * "Leitbild des Waldorfkindergartens", the nine educational aims from the
 * existing site's Waldorfpädagogik page, and the pedagogical focuses from the
 * webKITA content sheet. Nothing here is invented.
 *
 * The markup deliberately avoids inline `style` attributes on core blocks and
 * leans on class names instead. Hand-written inline styles are what drifted
 * from core's save() output and made the editor flag blocks as invalid.
 *
 * All five share the title "Leitbild" so each can be judged as the real page
 * would look; they are told apart by slug and by the menu.
 *
 * Run with:
 *   wp eval-file scripts/seed-leitbild-varianten.php
 *   ssh waldorfkindergarten '~/bin/wp eval-file -' < scripts/seed-leitbild-varianten.php
 *
 * Delete them all again with:
 *   wp post delete $(wp post list --post_type=page --name=leitbild-1 --format=ids) --force
 *
 * @package WaldorfPfirsichbluete
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit( "This script must be run through WP-CLI.\n" );
}

/** The Leitbild itself — heading, paragraph, and a short label for card layouts. */
$waldorf_pb_principles = array(
	array(
		'label' => 'Menschenkunde',
		'head'  => 'Unsere Verpflichtung zur Anthroposophischen Menschenkunde',
		'text'  => 'Wir orientieren uns an der Anthroposophischen Menschenkunde Rudolf Steiners als zentrale Grundlage der Waldorfpädagogik. Dieser Ansatz bildet das Fundament unserer Arbeit im Kindergarten und prägt unser pädagogisches Handeln.',
	),
	array(
		'label' => 'Haltung',
		'head'  => 'Achtung der freien Persönlichkeit und Gewaltfreiheit',
		'text'  => 'Seit der Gründung der Waldorfkindergartenbewegung im Jahr 1926 sind die Achtung der freien Persönlichkeit sowie die konsequente Gewaltfreiheit untrennbar mit der geistigen Quelle der Anthroposophie verbunden. Die Stuttgarter Erklärung gegen Diskriminierung aus dem Jahr 2007 hat diese Haltung nochmals klar bekräftigt. Eine Atmosphäre, die von Zuwendung und Verständnis geprägt ist, ist für unseren Kindergarten ein zentrales Anliegen. Gleichzeitig erfordert dies eine besondere Sensibilisierung in Bezug auf kinderschutzrechtliche Fragen, zu deren Berücksichtigung wir uns in besonderer Weise verpflichten.',
	),
	array(
		'label' => 'Lebenszeit',
		'head'  => 'Kindergartenzeit als Lebenszeit',
		'text'  => 'Wir betrachten die Zeit im Kindergarten als wertvolle Lebenszeit. Unsere pädagogische Arbeit soll den Kindern eine schützende und stärkende Hülle bieten, in der sich ihre Lebenskräfte entfalten können.',
	),
	array(
		'label' => 'Entwicklung',
		'head'  => 'Entwicklung im Einklang mit individuellen Anlagen',
		'text'  => 'Unser Kindergarten versteht sich als Ort, an dem sich die Kinder im Umgang mit lebensnahen Inhalten entsprechend ihren individuellen Anlagen und ihrem Entwicklungsstand entfalten dürfen. Dabei schaffen wir eine Atmosphäre, die von Liebe, Vertrauen und Humor getragen wird.',
	),
	array(
		'label' => 'Das Kind',
		'head'  => 'Das Kind im Mittelpunkt',
		'text'  => 'Im Zentrum unserer pädagogischen Arbeit steht das Kind. Wir begleiten die Kinder schützend und stärkend durch ihren Alltag und unterstützen sie in ihrer Entwicklung.',
	),
	array(
		'label' => 'Gemeinschaft',
		'head'  => 'Gemeinschaft, Akzeptanz und Vorbildfunktion',
		'text'  => 'Wir handeln im Bewusstsein der geistigen Kräfte, indem wir die Individualität jedes Einzelnen akzeptieren und die Gemeinschaft pflegen. Gleichzeitig nehmen wir die große Aufgabe wahr, für die Kinder als Vorbild zu wirken.',
	),
);

/** From the existing site's Waldorfpädagogik page. */
$waldorf_pb_ziele = array(
	'Achtung von der Individualität des Kindes',
	'Umfassende Gesundheitsförderung im Sinne der Salutogenese',
	'Zeit lassen für individuelle Entwicklung',
	'Achtung und Verbundenheit mit der Natur',
	'Förderung der Sinne',
	'Förderung der Sprachkompetenz',
	'Bewegungsförderung',
	'Altersgemäße individuelle Förderung der Vorschulkinder',
	'Umfassende Familienberatung und Elternkurse',
);

/** From the webKITA content sheet, "Pädagogische Schwerpunkte". */
$waldorf_pb_schwerpunkte = array(
	'Waldorfpädagogik nach R. Steiner',
	'Feste Gruppenstruktur und Bezugsperson',
	'Geschützte Umgebung',
	'Sinnesschulung',
	'Rhythmische Tages- und Wocheneinteilung',
	'Achtung und Verbundenheit mit der Natur',
	'Tiergestützte Pädagogik',
	'Feiern der christlichen Feste im Jahreslauf',
);

$waldorf_pb_lead = 'Was uns in der täglichen Arbeit mit den Kindern trägt — und woran wir uns messen lassen.';

/* ---------------------------------------------------------------- helpers */

function waldorf_pb_h( string $text ): string {
	return esc_html( $text );
}

function waldorf_pb_p( string $text, string $class = '' ): string {
	$attrs = '' === $class ? '' : ' {"className":"' . $class . '"}';
	$cls   = '' === $class ? '' : ' class="' . $class . '"';
	return "<!-- wp:paragraph{$attrs} --><p{$cls}>" . waldorf_pb_h( $text ) . "</p><!-- /wp:paragraph -->\n";
}

function waldorf_pb_heading( string $text, int $level = 2 ): string {
	return "<!-- wp:heading {\"level\":{$level}} --><h{$level} class=\"wp-block-heading\">"
		. waldorf_pb_h( $text ) . "</h{$level}><!-- /wp:heading -->\n";
}

function waldorf_pb_rule(): string {
	return "<!-- wp:separator {\"className\":\"is-style-hand-drawn\"} -->\n"
		. "<hr class=\"wp-block-separator has-alpha-channel-opacity is-style-hand-drawn\"/>\n"
		. "<!-- /wp:separator -->\n";
}

function waldorf_pb_intro( string $lead ): string {
	return "<!-- wp:group {\"className\":\"pb-sec-head\"} -->\n<div class=\"wp-block-group pb-sec-head\">\n"
		. waldorf_pb_p( 'Grundsätze und pädagogische Haltung', 'pb-eyebrow' )
		. waldorf_pb_p( $lead )
		. "</div>\n<!-- /wp:group -->\n";
}

/** Split a paragraph into its first sentence and the remainder. */
function waldorf_pb_split_sentence( string $text ): array {
	if ( preg_match( '/^(.+?\.)\s+(.*)$/su', $text, $m ) ) {
		return array( $m[1], $m[2] );
	}
	return array( $text, '' );
}

function waldorf_pb_photo( string $file, string $alt, string $shape = 'round' ): string {
	return '<!-- wp:waldorf/photo {"shape":"' . $shape . '","fallback":"' . $file . '","alt":"'
		. esc_attr( $alt ) . '"} /-->' . "\n";
}

/* --------------------------------------------------------------- variants */

/** 1 — Manifest: one narrow column of type, nothing else. */
function waldorf_pb_variant_manifest( array $principles, string $lead ): string {
	$out = waldorf_pb_intro( $lead );
	foreach ( $principles as $i => $p ) {
		if ( $i > 0 ) {
			$out .= waldorf_pb_rule();
		}
		$out .= waldorf_pb_heading( $p['head'] ) . waldorf_pb_p( $p['text'] );
	}
	$out .= '<!-- wp:waldorf/credo {"quote":"Im Zentrum unserer pädagogischen Arbeit steht das Kind.","citation":"Leitbild des Waldorfkindergartens Idstein"} /-->' . "\n";
	return $out;
}

/** 2 — Leitsätze: the six principles as glass cards, two per row. */
function waldorf_pb_variant_karten( array $principles, string $lead ): string {
	$out = waldorf_pb_intro( $lead );
	foreach ( array_chunk( $principles, 2 ) as $row ) {
		$out .= "<!-- wp:columns -->\n<div class=\"wp-block-columns\">\n";
		foreach ( $row as $p ) {
			$out .= "<!-- wp:column {\"className\":\"is-style-glass\"} -->\n<div class=\"wp-block-column is-style-glass\">\n"
				. waldorf_pb_p( $p['label'], 'pb-kicker' )
				. waldorf_pb_heading( $p['head'], 3 )
				. waldorf_pb_p( $p['text'] )
				. "</div>\n<!-- /wp:column -->\n";
		}
		$out .= "</div>\n<!-- /wp:columns -->\n";
	}
	return $out;
}

/** 3 — Bild und Text: alternating photo/text rows. */
function waldorf_pb_variant_bildtext( array $principles, string $lead ): string {
	$photos = array(
		array( 'photo-gruppenraum.jpg', 'Blick in einen Gruppenraum' ),
		array( 'photo-morgenkreis.jpg', 'Kinder im Morgenkreis' ),
		array( 'photo-garten.jpg', 'Der Garten des Kindergartens' ),
		array( 'photo-holz.jpg', 'Freies Spiel mit Holzmaterial' ),
		array( 'photo-malecke.jpg', 'Die Mal- und Handarbeitsecke' ),
		array( 'photo-krippe.jpg', 'Ein Krippenkind beim Spiel' ),
	);
	$out = waldorf_pb_intro( $lead );
	foreach ( $principles as $i => $p ) {
		list( $file, $alt ) = $photos[ $i % count( $photos ) ];
		$text = "<!-- wp:column {\"verticalAlignment\":\"center\"} -->\n<div class=\"wp-block-column is-vertically-aligned-center\">\n"
			. waldorf_pb_p( $p['label'], 'pb-eyebrow' )
			. waldorf_pb_heading( $p['head'], 3 )
			. waldorf_pb_p( $p['text'] )
			. "</div>\n<!-- /wp:column -->\n";
		$img = "<!-- wp:column {\"verticalAlignment\":\"center\"} -->\n<div class=\"wp-block-column is-vertically-aligned-center\">\n"
			. waldorf_pb_photo( $file, $alt )
			. "</div>\n<!-- /wp:column -->\n";

		$out .= "<!-- wp:columns {\"verticalAlignment\":\"center\"} -->\n<div class=\"wp-block-columns are-vertically-aligned-center\">\n"
			. ( 0 === $i % 2 ? $img . $text : $text . $img )
			. "</div>\n<!-- /wp:columns -->\n";
	}
	return $out;
}

/** 4 — Zitate: each principle opens with its own first sentence, set large. */
function waldorf_pb_variant_zitate( array $principles, array $ziele, string $lead ): string {
	$out = waldorf_pb_intro( $lead );
	foreach ( $principles as $p ) {
		list( $quote, $rest ) = waldorf_pb_split_sentence( $p['text'] );
		$out .= '<!-- wp:waldorf/credo {"quote":"' . esc_attr( $quote ) . '","citation":"' . esc_attr( $p['head'] ) . '"} /-->' . "\n";
		if ( '' !== $rest ) {
			$out .= waldorf_pb_p( $rest );
		}
	}
	$out .= waldorf_pb_rule() . waldorf_pb_heading( 'Unsere Bildungs- und Erziehungsziele' );
	$out .= "<!-- wp:list {\"className\":\"list\"} -->\n<ul class=\"wp-block-list list\">\n";
	foreach ( $ziele as $z ) {
		$out .= '<!-- wp:list-item --><li>' . waldorf_pb_h( $z ) . '</li><!-- /wp:list-item -->' . "\n";
	}
	$out .= "</ul>\n<!-- /wp:list -->\n";
	return $out;
}

/** 5 — Kapitel: focuses as chips, principles as expandable chapters. */
function waldorf_pb_variant_kapitel( array $principles, array $schwerpunkte, string $lead ): string {
	$out = waldorf_pb_intro( $lead );
	$out .= "<!-- wp:waldorf/sammlung {\"variant\":\"chips\"} -->\n";
	foreach ( $schwerpunkte as $s ) {
		$out .= '<!-- wp:waldorf/chip {"text":"' . esc_attr( $s ) . '"} /-->' . "\n";
	}
	$out .= "<!-- /wp:waldorf/sammlung -->\n";
	$out .= waldorf_pb_heading( 'Unsere Grundsätze im Einzelnen' );
	$out .= "<!-- wp:waldorf/faqs -->\n";
	foreach ( $principles as $p ) {
		$out .= '<!-- wp:waldorf/faq {"question":"' . esc_attr( $p['head'] ) . '","answer":"' . esc_attr( $p['text'] ) . '"} /-->' . "\n";
	}
	$out .= "<!-- /wp:waldorf/faqs -->\n";
	return $out;
}

/* ------------------------------------------------------------------ write */

$waldorf_pb_variants = array(
	'leitbild-1' => array( 'Manifest', waldorf_pb_variant_manifest( $waldorf_pb_principles, $waldorf_pb_lead ) ),
	'leitbild-2' => array( 'Leitsätze als Karten', waldorf_pb_variant_karten( $waldorf_pb_principles, $waldorf_pb_lead ) ),
	'leitbild-3' => array( 'Bild und Text', waldorf_pb_variant_bildtext( $waldorf_pb_principles, $waldorf_pb_lead ) ),
	'leitbild-4' => array( 'Zitatgeführt', waldorf_pb_variant_zitate( $waldorf_pb_principles, $waldorf_pb_ziele, $waldorf_pb_lead ) ),
	'leitbild-5' => array( 'Kapitel zum Aufklappen', waldorf_pb_variant_kapitel( $waldorf_pb_principles, $waldorf_pb_schwerpunkte, $waldorf_pb_lead ) ),
);

foreach ( $waldorf_pb_variants as $slug => list( $note, $content ) ) {
	$existing = get_page_by_path( $slug );

	$postarr = array(
		'post_type'    => 'page',
		'post_title'   => 'Leitbild',
		'post_name'    => $slug,
		'post_status'  => 'publish',
		'post_content' => $content,
	);

	if ( $existing instanceof WP_Post ) {
		$postarr['ID'] = $existing->ID;
		// wp_update_post() unslashes what it is given; without wp_slash() every
		// backslash in the block markup would be destroyed.
		$id = wp_update_post( wp_slash( $postarr ), true );
		$verb = 'updated';
	} else {
		$id = wp_insert_post( wp_slash( $postarr ), true );
		$verb = 'created';
	}

	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( sprintf( '%s: %s', $slug, $id->get_error_message() ) );
		continue;
	}
	WP_CLI::log( sprintf( '  %-12s %-8s /%s/  (%s, %d bytes)', $slug, $verb, $slug, $note, strlen( $content ) ) );
}

WP_CLI::success( 'Five Leitbild variants ready.' );
