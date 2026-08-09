<?php
/**
 * Server-side rendering for the Waldorf fact block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_value = isset( $attributes['value'] ) ? (string) $attributes['value'] : '';
$waldorf_pb_label = isset( $attributes['label'] ) ? (string) $attributes['label'] : '';
?>
<div class="pb-fact"><b><?php echo wp_kses( $waldorf_pb_value, array() ); ?></b><span><?php echo wp_kses( $waldorf_pb_label, array() ); ?></span></div>
