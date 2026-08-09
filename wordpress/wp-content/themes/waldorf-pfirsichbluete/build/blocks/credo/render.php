<?php
/**
 * Server-side rendering for the Waldorf credo block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_quote    = isset( $attributes['quote'] ) ? (string) $attributes['quote'] : '';
$waldorf_pb_citation = isset( $attributes['citation'] ) ? (string) $attributes['citation'] : '';
?>
<div class="pb-credo pb-reveal" style="margin-top:44px">
	<blockquote><?php echo wp_kses( $waldorf_pb_quote, array() ); ?></blockquote>
	<cite><?php echo wp_kses( $waldorf_pb_citation, array() ); ?></cite>
</div>
