<?php
/**
 * Server-side rendering for sortable Waldorf collections.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered child blocks.
 */

$waldorf_pb_variant = isset( $attributes['variant'] ) ? (string) $attributes['variant'] : 'chips';

if ( 'facts' === $waldorf_pb_variant ) {
	$waldorf_pb_class = 'pb-facts';
	$waldorf_pb_style = 'margin-top:36px';
} elseif ( 'testimonials' === $waldorf_pb_variant ) {
	$waldorf_pb_class = '';
	$waldorf_pb_style = 'display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;margin-top:44px';
} else {
	$waldorf_pb_class = 'pb-chips';
	$waldorf_pb_style = 'margin-top:30px';
}
?>
<div<?php echo '' !== $waldorf_pb_class ? ' class="' . esc_attr( $waldorf_pb_class ) . '"' : ''; ?> style="<?php echo esc_attr( $waldorf_pb_style ); ?>">
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered child blocks are escaped by their render callbacks. ?>
</div>
