<?php
/**
 * Server-side rendering for the Waldorf date block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_eyebrow = isset( $attributes['eyebrow'] ) ? (string) $attributes['eyebrow'] : '';
$waldorf_pb_title   = isset( $attributes['title'] ) ? (string) $attributes['title'] : '';
$waldorf_pb_date    = isset( $attributes['date'] ) ? (string) $attributes['date'] : '';
?>
<div class="pb-date-pill">
	<span class="pb-eyebrow"><?php echo wp_kses( $waldorf_pb_eyebrow, array() ); ?></span>
	<b><?php echo wp_kses( $waldorf_pb_title, array() ); ?></b>
	<span><?php echo wp_kses( $waldorf_pb_date, array() ); ?></span>
</div>
