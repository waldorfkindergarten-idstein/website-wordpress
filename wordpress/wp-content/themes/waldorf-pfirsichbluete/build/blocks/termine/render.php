<?php
/**
 * Server-side rendering for the events container.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks.
 */

$waldorf_pb_events_heading = isset( $attributes['heading'] ) ? wp_strip_all_tags( (string) $attributes['heading'] ) : 'Termine';
?>
<aside class="pb-termine pb-reveal">
	<h3><?php echo esc_html( $waldorf_pb_events_heading ); ?></h3>
	<ul>
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered by restricted registered child blocks. ?>
	</ul>
</aside>
