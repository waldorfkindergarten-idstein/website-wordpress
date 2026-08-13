<?php
/**
 * Server-side rendering for the events list.
 *
 * Entries come from the waldorf_termin post type, ordered by date and filtered
 * to those that have not passed. Anything filed as "Intern" (board meetings,
 * staff parties) never reaches the public list.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_events_heading = isset( $attributes['heading'] ) ? wp_strip_all_tags( (string) $attributes['heading'] ) : 'Termine';
$waldorf_pb_events_count   = isset( $attributes['count'] ) ? max( 1, min( 12, (int) $attributes['count'] ) ) : 4;
$waldorf_pb_events         = waldorf_pb_upcoming_termine( $waldorf_pb_events_count );

if ( array() === $waldorf_pb_events ) {
	return;
}

$waldorf_pb_months = waldorf_pb_months_short();
?>
<aside class="pb-termine pb-reveal">
	<h3><?php echo esc_html( $waldorf_pb_events_heading ); ?></h3>
	<ul>
		<?php foreach ( $waldorf_pb_events as $waldorf_pb_event ) : ?>
			<?php
			$waldorf_pb_von    = (string) get_post_meta( $waldorf_pb_event->ID, WALDORF_PB_META_TERMIN_VON, true );
			$waldorf_pb_bis    = (string) get_post_meta( $waldorf_pb_event->ID, WALDORF_PB_META_TERMIN_BIS, true );
			$waldorf_pb_detail = (string) get_post_meta( $waldorf_pb_event->ID, WALDORF_PB_META_TERMIN_DETAIL, true );
			$waldorf_pb_day    = substr( $waldorf_pb_von, 8, 2 );
			$waldorf_pb_month  = $waldorf_pb_months[ (int) substr( $waldorf_pb_von, 5, 2 ) ];

			// A multi-day entry shows its span in the detail line rather than
			// pretending to be a single day in the date badge.
			if ( waldorf_pb_is_date( $waldorf_pb_bis ) && $waldorf_pb_bis > $waldorf_pb_von ) {
				$waldorf_pb_range  = waldorf_pb_format_date_range( $waldorf_pb_von, $waldorf_pb_bis );
				$waldorf_pb_detail = '' !== $waldorf_pb_detail
					? $waldorf_pb_range . ' · ' . $waldorf_pb_detail
					: $waldorf_pb_range;
			}
			?>
			<li>
				<time class="pb-termine__date" datetime="<?php echo esc_attr( $waldorf_pb_von ); ?>"><b><?php echo esc_html( $waldorf_pb_day ); ?></b><span><?php echo esc_html( $waldorf_pb_month ); ?></span></time>
				<div class="pb-termine__info"><b><?php echo esc_html( get_the_title( $waldorf_pb_event ) ); ?></b><span><?php echo esc_html( $waldorf_pb_detail ); ?></span></div>
			</li>
		<?php endforeach; ?>
	</ul>
</aside>
