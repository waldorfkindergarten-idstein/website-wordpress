<?php
/**
 * Server-side rendering for the Waldorf testimonial block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_quote  = isset( $attributes['quote'] ) ? (string) $attributes['quote'] : '';
$waldorf_pb_source = isset( $attributes['source'] ) ? (string) $attributes['source'] : '';
?>
<figure class="pb-quote pb-reveal">
	<p><?php echo wp_kses( $waldorf_pb_quote, array() ); ?></p>
	<footer><?php echo wp_kses( $waldorf_pb_source, array() ); ?></footer>
</figure>
