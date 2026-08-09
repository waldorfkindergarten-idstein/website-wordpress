<?php
/**
 * Server-side rendering for the Waldorf photo block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_shapes = array(
	'hero'    => array( 'pb-shape-hero', 'aspect-ratio:4 / 4.4;' ),
	'mosaic1' => array( 'pb-mosaic__1', '' ),
	'mosaic2' => array( 'pb-mosaic__2', '' ),
	'mosaic3' => array( 'pb-mosaic__3', '' ),
	'mosaic4' => array( 'pb-mosaic__4', '' ),
	'group'   => array( 'pb-gcard__photo', '' ),
	'rhythm'  => array( 'pb-shape-rhythm', 'aspect-ratio:4 / 4.2;' ),
	'food'    => array( 'pb-shape-food', 'aspect-ratio:4 / 3.6;' ),
	'person'  => array( 'pb-shape-person pb-person__photo', '' ),
	'round'   => array( 'pb-shape-round', '' ),
);

$waldorf_pb_shape = isset( $attributes['shape'], $waldorf_pb_shapes[ $attributes['shape'] ] )
	? $attributes['shape']
	: 'hero';
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
	isset( $attributes['fallback'] ) ? (string) $attributes['fallback'] : 'photo-hero.jpg',
	isset( $attributes['alt'] ) ? (string) $attributes['alt'] : '',
	array(
		'sizes' => '(max-width: 782px) 100vw, 50vw',
		'style' => sprintf(
			'object-position:%s%% %s%%;',
			number_format( $waldorf_pb_x * 100, 2, '.', '' ),
			number_format( $waldorf_pb_y * 100, 2, '.', '' )
		),
	)
);

if ( '' === $waldorf_pb_image ) {
	return;
}

$waldorf_pb_wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'pb-photo ' . $waldorf_pb_shapes[ $waldorf_pb_shape ][0],
		'style' => $waldorf_pb_shapes[ $waldorf_pb_shape ][1],
	)
);
$waldorf_pb_caption            = isset( $attributes['caption'] ) ? (string) $attributes['caption'] : '';
?>
<figure <?php echo $waldorf_pb_wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by get_block_wrapper_attributes(). ?>>
	<?php echo $waldorf_pb_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by waldorf_pb_render_image(). ?>
	<?php if ( '' !== trim( wp_strip_all_tags( $waldorf_pb_caption ) ) ) : ?>
		<figcaption class="wp-element-caption"><?php echo wp_kses_post( $waldorf_pb_caption ); ?></figcaption>
	<?php endif; ?>
</figure>
