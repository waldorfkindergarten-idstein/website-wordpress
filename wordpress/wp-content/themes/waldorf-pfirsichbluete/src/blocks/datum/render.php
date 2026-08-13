<?php
/**
 * Server-side rendering for the Waldorf date pill.
 *
 * In "auto" mode the pill shows the next upcoming Fest from the Termine post
 * type and hides itself when there is none — so it can never sit on the front
 * page advertising a date that has passed. "manual" keeps the typed values.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_source  = isset( $attributes['source'] ) ? (string) $attributes['source'] : 'auto';
$waldorf_pb_eyebrow = isset( $attributes['eyebrow'] ) ? (string) $attributes['eyebrow'] : '';
$waldorf_pb_title   = isset( $attributes['title'] ) ? (string) $attributes['title'] : '';
$waldorf_pb_date    = isset( $attributes['date'] ) ? (string) $attributes['date'] : '';

if ( 'auto' === $waldorf_pb_source ) {
	$waldorf_pb_next = waldorf_pb_next_termin();

	if ( ! $waldorf_pb_next instanceof WP_Post ) {
		return;
	}

	$waldorf_pb_von    = (string) get_post_meta( $waldorf_pb_next->ID, WALDORF_PB_META_TERMIN_VON, true );
	$waldorf_pb_detail = (string) get_post_meta( $waldorf_pb_next->ID, WALDORF_PB_META_TERMIN_DETAIL, true );
	$waldorf_pb_long   = waldorf_pb_format_long_date( $waldorf_pb_von );

	$waldorf_pb_title = get_the_title( $waldorf_pb_next );
	$waldorf_pb_date  = '' !== $waldorf_pb_detail && '' !== $waldorf_pb_long
		? $waldorf_pb_long . ' · ' . $waldorf_pb_detail
		: $waldorf_pb_long . $waldorf_pb_detail;
}
?>
<div class="pb-date-pill">
	<span class="pb-eyebrow"><?php echo wp_kses( $waldorf_pb_eyebrow, array() ); ?></span>
	<b><?php echo wp_kses( $waldorf_pb_title, array() ); ?></b>
	<span><?php echo wp_kses( $waldorf_pb_date, array() ); ?></span>
</div>
