<?php
/**
 * One-off seed for the Termin and Team post types.
 *
 * Dates are transcribed from the Verein's own "Terminkalender 01.01.2026 –
 * 31.12.2026". Board meetings and the staff Christmas party are filed as
 * "intern" so they stay out of the public list while remaining in the calendar.
 *
 * Idempotent: an entry is matched on title + start date, so re-running updates
 * rather than duplicates.
 *
 * Run with:
 *   wp eval-file scripts/seed-termine-team.php
 *   ssh waldorfkindergarten '~/bin/wp eval-file -' < scripts/seed-termine-team.php
 *
 * @package WaldorfPfirsichbluete
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit( "This script must be run through WP-CLI.\n" );
}

if ( ! post_type_exists( WALDORF_PB_CPT_TERMIN ) ) {
	WP_CLI::error( 'The waldorf_termin post type is not registered — is the theme active and deployed?' );
}

/*
 * title, start, end (or ''), detail, Terminart
 */
$waldorf_pb_termine = array(
	array( 'Weihnachtsferien', '2026-01-01', '2026-01-02', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Ferienbetreuung', '2026-01-05', '2026-01-09', 'verbindliche Anmeldung notwendig', 'ferien' ),
	array( 'Vorstandssitzung', '2026-01-19', '', '19:00 Uhr', 'intern' ),
	array( 'Fachtagung', '2026-01-29', '2026-01-31', 'Kindergarten am 29. und 30.01. geschlossen', 'ferien' ),
	array( 'Vorstandssitzung', '2026-02-02', '', '19:00 Uhr', 'intern' ),
	array( 'Faschingsfeier', '2026-02-16', '', 'ohne Eltern', 'fest' ),
	array( 'Vorstandssitzung', '2026-03-02', '', '19:00 Uhr', 'intern' ),
	array( 'Ferienbetreuung', '2026-03-30', '2026-04-10', 'verbindliche Anmeldung notwendig', 'ferien' ),
	array( 'Karfreitag', '2026-04-03', '', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Ostermontag', '2026-04-06', '', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Vorstandssitzung', '2026-04-20', '', '19:00 Uhr', 'intern' ),
	array( 'Maifeiertag', '2026-05-01', '', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Vorstandssitzung', '2026-05-04', '', '19:00 Uhr', 'intern' ),
	array( 'Christi Himmelfahrt', '2026-05-14', '', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Konzeptionstag', '2026-05-15', '2026-05-16', 'Kindergarten am 15.05. geschlossen', 'ferien' ),
	array( 'Mitgliederversammlung', '2026-05-20', '', '20:00 Uhr', 'elternabend' ),
	array( 'Pfingstmontag', '2026-05-25', '', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Fronleichnam', '2026-06-04', '', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Brückentag', '2026-06-05', '', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Vorstandssitzung', '2026-06-08', '', '19:00 Uhr', 'intern' ),
	array( 'Königskinderfest', '2026-06-12', '', '14:00 – 16:00 Uhr · für die Schulkinder', 'fest' ),
	array( 'Johannifest', '2026-06-26', '', '15:30 – 18:00 Uhr · mit Eltern', 'fest' ),
	array( 'Waldwoche', '2026-06-29', '2026-07-03', 'verbindliche Anmeldung notwendig', 'fest' ),
	array( 'Gruppenräume ausräumen', '2026-07-03', '', 'Kindergarten ab 12:00 Uhr geschlossen, Wiegenstube kein Mittagessen', 'ferien' ),
	array( 'Sommerferien', '2026-07-06', '2026-07-24', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Gruppenräume einräumen', '2026-07-24', '2026-07-25', '', 'intern' ),
	array( 'Ferienbetreuung', '2026-07-27', '2026-07-31', 'verbindliche Anmeldung notwendig', 'ferien' ),
	array( 'Ferienbetreuung', '2026-08-03', '2026-08-07', 'verbindliche Anmeldung notwendig', 'ferien' ),
	array( 'Vorstandssitzung', '2026-08-17', '', '19:00 Uhr', 'intern' ),
	array( 'Vorstandssitzung', '2026-09-07', '', '19:00 Uhr', 'intern' ),
	array( 'Elternabend Spatzennest', '2026-09-15', '', '19:00 Uhr', 'elternabend' ),
	array( 'Elternabend Lerchennest', '2026-09-16', '', '19:00 Uhr', 'elternabend' ),
	array( 'Elternabend Wiegenstube', '2026-09-17', '', '19:00 Uhr', 'elternabend' ),
	array( 'Michaelifeier', '2026-09-29', '', 'nur Kinder', 'fest' ),
	array( 'Gemeinsames Drachensteigen', '2026-10-02', '', '15:00 Uhr', 'fest' ),
	array( 'Herbstferien', '2026-10-05', '2026-10-09', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Betriebsausflug', '2026-10-12', '', 'Kindergarten geschlossen', 'ferien' ),
	array( 'Ferienbetreuung', '2026-10-13', '2026-10-16', 'verbindliche Anmeldung notwendig', 'ferien' ),
	array( 'Vorstandssitzung', '2026-10-19', '', '19:00 Uhr', 'intern' ),
	array( 'Erntedankfest', '2026-10-23', '', '', 'fest' ),
	array( 'Gesamtelternabend Laternenbasteln', '2026-11-03', '', '19:00 Uhr', 'elternabend' ),
	array( 'Vorstandssitzung', '2026-11-09', '', '19:00 Uhr', 'intern' ),
	array( 'Laternenfest', '2026-11-13', '', 'ab 17:00 Uhr · Kindergarten ab 12:00 Uhr geschlossen, Wiegenstube kein Mittagessen', 'fest' ),
	array( 'Adventsgärtlein', '2026-11-27', '', 'ab 17:00 Uhr Lerchennest, ab 18:00 Uhr Spatzennest · Kindergartengruppen ab 12:00 Uhr geschlossen', 'fest' ),
	array( 'Weihnachtsmarkt Idstein', '2026-12-04', '2026-12-06', '', 'fest' ),
	array( 'Weihnachtsfeier Personal und Vorstand', '2026-12-11', '', '', 'intern' ),
	array( 'Weihnachtsferien', '2026-12-23', '2027-01-05', 'Kindergarten geschlossen', 'ferien' ),
);

/*
 * title, role, monogram, order
 */
$waldorf_pb_team = array(
	array( 'Iris Born', 'Pädagogische Leitung', 'I', 10 ),
	array( 'Anke Reinhold', 'Stellvertretende Leitung', 'A', 20 ),
	array( 'Lerchennest', 'Erzieherin & Gruppenleitung', 'L', 30 ),
	array( 'Spatzennest', 'Erzieherin & Gruppenleitung', 'S', 40 ),
	array( 'Wiegenstube', 'Krippenpädagogin', 'W', 50 ),
	array( 'Küche', 'Frisch gekocht, jeden Tag', 'K', 60 ),
);

/**
 * Find an existing post of a type by exact title, optionally also by start date.
 *
 * @param string $type  Post type.
 * @param string $title Post title.
 * @param string $von   Optional start date to disambiguate repeated titles.
 */
function waldorf_pb_seed_find( string $type, string $title, string $von = '' ): ?int {
	$args = array(
		'post_type'        => $type,
		'post_status'      => array( 'publish', 'draft' ),
		'posts_per_page'   => 50,
		'title'            => $title,
		'no_found_rows'    => true,
		'suppress_filters' => false,
	);

	foreach ( get_posts( $args ) as $candidate ) {
		if ( '' === $von ) {
			return (int) $candidate->ID;
		}
		if ( (string) get_post_meta( $candidate->ID, WALDORF_PB_META_TERMIN_VON, true ) === $von ) {
			return (int) $candidate->ID;
		}
	}

	return null;
}

$created = 0;
$updated = 0;

foreach ( $waldorf_pb_termine as list( $title, $von, $bis, $detail, $art ) ) {
	$existing = waldorf_pb_seed_find( WALDORF_PB_CPT_TERMIN, $title, $von );

	if ( null === $existing ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => WALDORF_PB_CPT_TERMIN,
				'post_title'  => $title,
				'post_status' => 'publish',
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			WP_CLI::warning( sprintf( 'Could not create "%s": %s', $title, $post_id->get_error_message() ) );
			continue;
		}
		++$created;
	} else {
		$post_id = $existing;
		++$updated;
	}

	update_post_meta( $post_id, WALDORF_PB_META_TERMIN_VON, $von );
	update_post_meta( $post_id, WALDORF_PB_META_TERMIN_BIS, $bis );
	update_post_meta( $post_id, WALDORF_PB_META_TERMIN_DETAIL, $detail );
	wp_set_object_terms( $post_id, $art, WALDORF_PB_TAX_TERMINART, false );
}

WP_CLI::log( sprintf( 'Termine: %d created, %d updated.', $created, $updated ) );

$created = 0;
$updated = 0;

foreach ( $waldorf_pb_team as list( $name, $role, $mono, $order ) ) {
	$existing = waldorf_pb_seed_find( WALDORF_PB_CPT_PERSON, $name );

	if ( null === $existing ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => WALDORF_PB_CPT_PERSON,
				'post_title'  => $name,
				'post_status' => 'publish',
				'menu_order'  => $order,
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			WP_CLI::warning( sprintf( 'Could not create "%s": %s', $name, $post_id->get_error_message() ) );
			continue;
		}
		++$created;
	} else {
		$post_id = $existing;
		wp_update_post(
			array(
				'ID'         => $post_id,
				'menu_order' => $order,
			)
		);
		++$updated;
	}

	update_post_meta( $post_id, WALDORF_PB_META_PERSON_ROLLE, $role );
	update_post_meta( $post_id, WALDORF_PB_META_PERSON_MONO, $mono );
}

WP_CLI::log( sprintf( 'Team: %d created, %d updated.', $created, $updated ) );
WP_CLI::success( 'Seed complete.' );
