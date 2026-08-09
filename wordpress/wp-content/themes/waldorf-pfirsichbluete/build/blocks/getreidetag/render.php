<?php
/**
 * Server-side rendering for a Waldorf grain-plan day.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_day   = isset( $attributes['day'] ) ? (string) $attributes['day'] : '';
$waldorf_pb_grain = isset( $attributes['grain'] ) ? (string) $attributes['grain'] : '';
$waldorf_pb_note  = isset( $attributes['note'] ) ? (string) $attributes['note'] : '';
?>
<li>
	<span class="pb-grain__day"><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_day ) ); ?></span>
	<b><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_grain ) ); ?></b>
	<span><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_note ) ); ?></span>
</li>
