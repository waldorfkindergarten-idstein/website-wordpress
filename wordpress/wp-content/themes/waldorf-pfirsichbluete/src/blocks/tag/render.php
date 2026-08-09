<?php
/**
 * Server-side rendering for the Waldorf weekday block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_weekday   = isset( $attributes['weekday'] ) ? (string) $attributes['weekday'] : '';
$waldorf_pb_title     = isset( $attributes['title'] ) ? (string) $attributes['title'] : '';
$waldorf_pb_text      = isset( $attributes['text'] ) ? (string) $attributes['text'] : '';
$waldorf_pb_is_forest = ! empty( $attributes['isForestDay'] );
?>
<div class="pb-day<?php echo $waldorf_pb_is_forest ? ' pb-day--forest' : ''; ?>">
	<div class="pb-day__name"><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_weekday ) ); ?></div>
	<h4><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_title ) ); ?></h4>
	<p><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_text ) ); ?></p>
</div>
