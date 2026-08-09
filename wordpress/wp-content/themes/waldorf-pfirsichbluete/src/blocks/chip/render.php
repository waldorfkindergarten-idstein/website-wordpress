<?php
/**
 * Server-side rendering for the Waldorf chip block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_text = isset( $attributes['text'] ) ? (string) $attributes['text'] : '';
?>
<span class="pb-chip"><?php echo wp_kses( $waldorf_pb_text, array() ); ?></span>
