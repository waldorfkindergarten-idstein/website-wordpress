<?php

$token = 'waldorf-idstein-seed-news-2026';

if ( ! isset( $_GET['token'] ) || $_GET['token'] !== $token ) {
	http_response_code( 403 );
	exit( 'Forbidden' );
}

require_once dirname( __DIR__, 3 ) . '/wp-load.php';

$items = array(
	array(
		'slug'    => 'kennenlerntag-6-oktober',
		'title'   => 'Kennenlerntag · 6. Oktober',
		'excerpt' => '14:00–16:00 Uhr im Kindergarten. Führung, Einblicke, Zeit für Ihre Fragen. Anmeldung per E-Mail oder Telefon bis 04.10.',
		'content' => '<p>14:00–16:00 Uhr im Kindergarten. Führung, Einblicke, Zeit für Ihre Fragen. Anmeldung per E-Mail oder Telefon bis 04.10.</p><p>Bei Interesse freuen wir uns über Ihre Nachricht an <a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a>.</p>',
	),
	array(
		'slug'    => 'kindersachen-flohmarkt-14-oktober',
		'title'   => 'Kindersachen-Flohmarkt · 14. Oktober',
		'excerpt' => '13:00–16:00 Uhr, Schwangere ab 12:30. Faire Kleidung, Spielzeug, Familienbedarf.',
		'content' => '<p>13:00–16:00 Uhr, Schwangere ab 12:30. Faire Kleidung, Spielzeug, Familienbedarf.</p><p>Standreservierungen bitte an <a href="mailto:michelle.kirberg@outlook.de">michelle.kirberg@outlook.de</a>.</p>',
	),
	array(
		'slug'    => 'wir-suchen-erzieherinnen',
		'title'   => 'Wir suchen Erzieher:innen',
		'excerpt' => 'Teilzeit, staatlich anerkannt, Herz für Waldorfpädagogik. Familienähnliche Gruppen, wertschätzendes Team.',
		'content' => '<p>Teilzeit, staatlich anerkannt, Herz für Waldorfpädagogik. Familienähnliche Gruppen, wertschätzendes Team.</p><p>Wir freuen uns auf Bewerbungen per E-Mail an <a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a>.</p>',
	),
);

foreach ( $items as $item ) {
	$existing = get_page_by_path( $item['slug'], OBJECT, 'post' );
	$postarr  = array(
		'post_type'    => 'post',
		'post_status'  => 'publish',
		'post_title'   => $item['title'],
		'post_name'    => $item['slug'],
		'post_excerpt' => $item['excerpt'],
		'post_content' => $item['content'],
	);

	if ( $existing ) {
		$postarr['ID'] = $existing->ID;
		$id            = wp_update_post( wp_slash( $postarr ), true );
	} else {
		$id = wp_insert_post( wp_slash( $postarr ), true );
	}

	if ( is_wp_error( $id ) ) {
		echo $item['slug'] . ':ERROR:' . $id->get_error_message() . "\n";
	} else {
		echo $item['slug'] . ':' . $id . "\n";
	}
}
