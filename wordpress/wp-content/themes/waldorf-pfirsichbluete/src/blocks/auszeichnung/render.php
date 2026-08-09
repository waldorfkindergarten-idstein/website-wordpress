<?php
/**
 * Server-side rendering for a Waldorf food badge.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_text = isset( $attributes['text'] ) ? (string) $attributes['text'] : '';
?>
<span><?php echo esc_html( wp_strip_all_tags( $waldorf_pb_text ) ); ?></span>
