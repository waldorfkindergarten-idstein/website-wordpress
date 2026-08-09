<?php
/**
 * Server-side rendering for the Waldorf person block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_focal = isset( $attributes['focalPoint'] ) && is_array( $attributes['focalPoint'] )
	? $attributes['focalPoint']
	: array();
$waldorf_pb_x     = isset( $waldorf_pb_focal['x'] ) && is_numeric( $waldorf_pb_focal['x'] )
	? min( 1, max( 0, (float) $waldorf_pb_focal['x'] ) )
	: 0.5;
$waldorf_pb_y     = isset( $waldorf_pb_focal['y'] ) && is_numeric( $waldorf_pb_focal['y'] )
	? min( 1, max( 0, (float) $waldorf_pb_focal['y'] ) )
	: 0.5;
$waldorf_pb_image = waldorf_pb_render_image(
	isset( $attributes['id'] ) ? absint( $attributes['id'] ) : 0,
	isset( $attributes['fallback'] ) ? (string) $attributes['fallback'] : '',
	isset( $attributes['alt'] ) ? (string) $attributes['alt'] : '',
	array(
		'sizes' => '(max-width: 620px) 50vw, 230px',
		'style' => sprintf(
			'object-position:%s%% %s%%;',
			number_format( $waldorf_pb_x * 100, 2, '.', '' ),
			number_format( $waldorf_pb_y * 100, 2, '.', '' )
		),
	)
);
$waldorf_pb_monogram = isset( $attributes['monogram'] ) ? (string) $attributes['monogram'] : '';
$waldorf_pb_name     = isset( $attributes['name'] ) ? (string) $attributes['name'] : '';
$waldorf_pb_role     = isset( $attributes['role'] ) ? (string) $attributes['role'] : '';
?>
<div class="pb-person pb-reveal">
	<div class="pb-photo pb-shape-person pb-person__photo">
		<?php if ( '' !== $waldorf_pb_image ) : ?>
			<?php echo $waldorf_pb_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by waldorf_pb_render_image(). ?>
		<?php else : ?>
			<span class="pb-person__mono"><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_monogram ), ENT_QUOTES ) ); ?></span>
		<?php endif; ?>
	</div>
	<h4><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_name ), ENT_QUOTES ) ); ?></h4>
	<span><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_role ), ENT_QUOTES ) ); ?></span>
</div>
