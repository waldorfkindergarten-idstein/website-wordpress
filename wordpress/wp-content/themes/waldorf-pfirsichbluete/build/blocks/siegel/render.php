<?php
/**
 * Server-side rendering for the Waldorf seal block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_heading = isset( $attributes['heading'] ) ? (string) $attributes['heading'] : '';
$waldorf_pb_label   = isset( $attributes['label'] ) ? (string) $attributes['label'] : '';
?>
<div class="pb-seal"><div><b><?php echo wp_kses( $waldorf_pb_heading, array( 'br' => array() ) ); ?></b><span><?php echo wp_kses( $waldorf_pb_label, array() ); ?></span></div></div>
