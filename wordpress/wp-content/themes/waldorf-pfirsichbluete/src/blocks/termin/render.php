<?php
/**
 * Server-side rendering for an event date.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_event_date   = isset( $attributes['date'] ) ? (string) $attributes['date'] : '';
$waldorf_pb_event_title  = isset( $attributes['title'] ) ? wp_strip_all_tags( (string) $attributes['title'] ) : '';
$waldorf_pb_event_detail = isset( $attributes['detail'] ) ? wp_strip_all_tags( (string) $attributes['detail'] ) : '';
$waldorf_pb_event_day    = '--';
$waldorf_pb_event_month  = '---';
$waldorf_pb_event_iso    = '';
$waldorf_pb_months       = array( 'Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez' );

if ( preg_match( '/^\d{4}-(\d{2})-(\d{2})$/', $waldorf_pb_event_date, $waldorf_pb_event_matches ) ) {
	$waldorf_pb_event_month_number = (int) $waldorf_pb_event_matches[1];
	$waldorf_pb_event_day_number   = (int) $waldorf_pb_event_matches[2];

	if ( checkdate( $waldorf_pb_event_month_number, $waldorf_pb_event_day_number, (int) substr( $waldorf_pb_event_date, 0, 4 ) ) ) {
		$waldorf_pb_event_day   = sprintf( '%02d', $waldorf_pb_event_day_number );
		$waldorf_pb_event_month = $waldorf_pb_months[ $waldorf_pb_event_month_number - 1 ];
		$waldorf_pb_event_iso   = $waldorf_pb_event_date;
	}
}
?>
<li>
	<time class="pb-termine__date"<?php if ( '' !== $waldorf_pb_event_iso ) : ?> datetime="<?php echo esc_attr( $waldorf_pb_event_iso ); ?>"<?php endif; ?>><b><?php echo esc_html( $waldorf_pb_event_day ); ?></b><span><?php echo esc_html( $waldorf_pb_event_month ); ?></span></time>
	<div class="pb-termine__info"><b><?php echo esc_html( $waldorf_pb_event_title ); ?></b><span><?php echo esc_html( $waldorf_pb_event_detail ); ?></span></div>
</li>
