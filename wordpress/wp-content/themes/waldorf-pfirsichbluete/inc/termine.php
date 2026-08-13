<?php
/**
 * Queries and date formatting for the Termin and Team content types.
 *
 * Kept separate from registration so the blocks have one obvious place to pull
 * content from, and so the German date formatting exists exactly once.
 *
 * @package WaldorfPfirsichbluete
 */

declare( strict_types = 1 );

/**
 * Short German month names, indexed 1–12.
 *
 * @return array<int, string>
 */
function waldorf_pb_months_short(): array {
	return array(
		1 => 'Jan',
		2 => 'Feb',
		3 => 'Mär',
		4 => 'Apr',
		5 => 'Mai',
		6 => 'Jun',
		7 => 'Jul',
		8 => 'Aug',
		9 => 'Sep',
		10 => 'Okt',
		11 => 'Nov',
		12 => 'Dez',
	);
}

/**
 * Today in the site's timezone, as Y-m-d.
 */
function waldorf_pb_today(): string {
	return wp_date( 'Y-m-d' );
}

/**
 * Validate a Y-m-d string.
 *
 * @param string $date Candidate date.
 */
function waldorf_pb_is_date( string $date ): bool {
	if ( ! preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $date, $waldorf_pb_m ) ) {
		return false;
	}
	return checkdate( (int) $waldorf_pb_m[2], (int) $waldorf_pb_m[3], (int) $waldorf_pb_m[1] );
}

/**
 * Render a date, or a range, the way the printed Terminkalender does.
 *
 * Single day  -> "23. Okt"
 * Same month  -> "05.–09. Okt"
 * Two months  -> "27. Nov – 02. Dez"
 *
 * @param string $von Start date, Y-m-d.
 * @param string $bis Optional end date, Y-m-d.
 */
function waldorf_pb_format_date_range( string $von, string $bis = '' ): string {
	if ( ! waldorf_pb_is_date( $von ) ) {
		return '';
	}
	$waldorf_pb_months = waldorf_pb_months_short();
	$waldorf_pb_vm     = (int) substr( $von, 5, 2 );
	$waldorf_pb_vd     = (int) substr( $von, 8, 2 );

	if ( ! waldorf_pb_is_date( $bis ) || $bis === $von ) {
		return sprintf( '%02d. %s', $waldorf_pb_vd, $waldorf_pb_months[ $waldorf_pb_vm ] );
	}

	$waldorf_pb_bm = (int) substr( $bis, 5, 2 );
	$waldorf_pb_bd = (int) substr( $bis, 8, 2 );

	if ( $waldorf_pb_vm === $waldorf_pb_bm ) {
		return sprintf( '%02d.–%02d. %s', $waldorf_pb_vd, $waldorf_pb_bd, $waldorf_pb_months[ $waldorf_pb_vm ] );
	}

	return sprintf(
		'%02d. %s – %02d. %s',
		$waldorf_pb_vd,
		$waldorf_pb_months[ $waldorf_pb_vm ],
		$waldorf_pb_bd,
		$waldorf_pb_months[ $waldorf_pb_bm ]
	);
}

/**
 * Long form used by the hero pill, e.g. "Di, 29. September".
 *
 * @param string $date Y-m-d.
 */
function waldorf_pb_format_long_date( string $date ): string {
	if ( ! waldorf_pb_is_date( $date ) ) {
		return '';
	}
	$waldorf_pb_days   = array( 'So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa' );
	$waldorf_pb_months = array(
		1 => 'Januar',
		2 => 'Februar',
		3 => 'März',
		4 => 'April',
		5 => 'Mai',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'August',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Dezember',
	);

	$waldorf_pb_ts = strtotime( $date . ' 12:00:00' );
	if ( false === $waldorf_pb_ts ) {
		return '';
	}

	return sprintf(
		'%s, %d. %s',
		$waldorf_pb_days[ (int) gmdate( 'w', $waldorf_pb_ts ) ],
		(int) substr( $date, 8, 2 ),
		$waldorf_pb_months[ (int) substr( $date, 5, 2 ) ]
	);
}

/**
 * Upcoming Termine, chronologically.
 *
 * A multi-day Termin stays "upcoming" until its end date has passed, so a
 * holiday week does not vanish from the list on its second day.
 *
 * @param int           $limit    Maximum number of entries.
 * @param array<string> $exclude  Terminart slugs to leave out.
 * @return array<int, WP_Post>
 */
function waldorf_pb_upcoming_termine( int $limit = 4, array $exclude = array( 'intern' ) ): array {
	if ( ! post_type_exists( WALDORF_PB_CPT_TERMIN ) ) {
		return array();
	}

	// Discard the past in SQL. Filtering only in PHP would fill the fetch
	// window with expired dates and silently return too few entries.
	// The 90-day grace period keeps multi-day Termine that started earlier but
	// have not ended yet — the end-date rule below decides those.
	$waldorf_pb_cutoff = gmdate( 'Y-m-d', strtotime( waldorf_pb_today() . ' -90 days' ) );

	$waldorf_pb_args = array(
		'post_type'              => WALDORF_PB_CPT_TERMIN,
		'post_status'            => 'publish',
		'posts_per_page'         => max( 1, $limit ) + 30,
		'meta_query'             => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			'von' => array(
				'key'     => WALDORF_PB_META_TERMIN_VON,
				'value'   => $waldorf_pb_cutoff,
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
		'orderby'                => array( 'von' => 'ASC' ),
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'ignore_sticky_posts'    => true,
	);

	if ( array() !== $exclude ) {
		$waldorf_pb_args['tax_query'] = array(
			array(
				'taxonomy' => WALDORF_PB_TAX_TERMINART,
				'field'    => 'slug',
				'terms'    => $exclude,
				'operator' => 'NOT IN',
			),
		);
	}

	$waldorf_pb_today = waldorf_pb_today();
	$waldorf_pb_out   = array();

	foreach ( get_posts( $waldorf_pb_args ) as $waldorf_pb_post ) {
		$waldorf_pb_von = (string) get_post_meta( $waldorf_pb_post->ID, WALDORF_PB_META_TERMIN_VON, true );
		$waldorf_pb_bis = (string) get_post_meta( $waldorf_pb_post->ID, WALDORF_PB_META_TERMIN_BIS, true );

		if ( ! waldorf_pb_is_date( $waldorf_pb_von ) ) {
			continue;
		}

		$waldorf_pb_last = waldorf_pb_is_date( $waldorf_pb_bis ) && $waldorf_pb_bis > $waldorf_pb_von
			? $waldorf_pb_bis
			: $waldorf_pb_von;

		if ( $waldorf_pb_last < $waldorf_pb_today ) {
			continue;
		}

		$waldorf_pb_out[] = $waldorf_pb_post;

		if ( count( $waldorf_pb_out ) >= $limit ) {
			break;
		}
	}

	return $waldorf_pb_out;
}

/**
 * The single next Termin, for the hero pill.
 *
 * @param array<string> $only Terminart slugs to restrict to; empty means any public one.
 */
function waldorf_pb_next_termin( array $only = array( 'fest' ) ): ?WP_Post {
	$waldorf_pb_all = waldorf_pb_upcoming_termine( 40 );

	foreach ( $waldorf_pb_all as $waldorf_pb_post ) {
		if ( array() === $only ) {
			return $waldorf_pb_post;
		}
		if ( has_term( $only, WALDORF_PB_TAX_TERMINART, $waldorf_pb_post ) ) {
			return $waldorf_pb_post;
		}
	}

	return null;
}

/**
 * Team members in their configured order.
 *
 * @return array<int, WP_Post>
 */
function waldorf_pb_team_members(): array {
	if ( ! post_type_exists( WALDORF_PB_CPT_PERSON ) ) {
		return array();
	}

	return get_posts(
		array(
			'post_type'              => WALDORF_PB_CPT_PERSON,
			'post_status'            => 'publish',
			'posts_per_page'         => 40,
			'orderby'                => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => true,
		)
	);
}
