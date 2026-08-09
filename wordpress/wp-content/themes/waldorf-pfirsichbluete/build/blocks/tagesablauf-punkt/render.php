<?php
/**
 * Server-side rendering for a Waldorf daily schedule point.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_time        = isset( $attributes['time'] ) ? (string) $attributes['time'] : '';
$waldorf_pb_title       = isset( $attributes['title'] ) ? (string) $attributes['title'] : '';
$waldorf_pb_detail      = isset( $attributes['detail'] ) ? (string) $attributes['detail'] : '';
$waldorf_pb_is_extended = ! empty( $attributes['isExtended'] );
?>
<li class="pb-tl<?php echo $waldorf_pb_is_extended ? ' pb-tl--optional' : ''; ?>">
	<div class="pb-tl__time"><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_time ) ); ?><?php if ( $waldorf_pb_is_extended ) : ?><span class="pb-tl__badge"><?php esc_html_e( 'Verlängert', 'waldorf-pfirsichbluete' ); ?></span><?php endif; ?></div>
	<div class="pb-tl__title"><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_title ) ); ?></div>
	<div class="pb-tl__sub"><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_detail ) ); ?></div>
</li>
