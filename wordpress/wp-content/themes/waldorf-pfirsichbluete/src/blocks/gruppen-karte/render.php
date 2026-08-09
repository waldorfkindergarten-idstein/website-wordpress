<?php
/**
 * Server-side rendering for the Waldorf group-card block.
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
$waldorf_pb_image_attributes = array(
	'sizes' => '(max-width: 782px) 100vw, 33vw',
);

if ( 0.5 !== $waldorf_pb_x || 0.5 !== $waldorf_pb_y ) {
	$waldorf_pb_image_attributes['style'] = sprintf(
		'object-position:%s%% %s%%;',
		number_format( $waldorf_pb_x * 100, 2, '.', '' ),
		number_format( $waldorf_pb_y * 100, 2, '.', '' )
	);
}

$waldorf_pb_image = waldorf_pb_render_image(
	isset( $attributes['id'] ) ? absint( $attributes['id'] ) : 0,
	isset( $attributes['fallback'] ) ? (string) $attributes['fallback'] : 'photo-morgenkreis.jpg',
	isset( $attributes['alt'] ) ? (string) $attributes['alt'] : '',
	$waldorf_pb_image_attributes
);
$waldorf_pb_caption = isset( $attributes['caption'] ) ? (string) $attributes['caption'] : '';
$waldorf_pb_tag     = isset( $attributes['tag'] ) ? (string) $attributes['tag'] : '';
$waldorf_pb_title   = isset( $attributes['title'] ) ? (string) $attributes['title'] : '';
$waldorf_pb_text    = isset( $attributes['text'] ) ? (string) $attributes['text'] : '';
$waldorf_pb_facts   = isset( $attributes['facts'] ) && is_array( $attributes['facts'] )
	? array_slice( $attributes['facts'], 0, 8 )
	: array();
$waldorf_pb_label = isset( $attributes['linkLabel'] ) ? (string) $attributes['linkLabel'] : '';
$waldorf_pb_url   = isset( $attributes['url'] ) ? (string) $attributes['url'] : '';
?>
<article class="pb-gcard pb-reveal">
	<figure class="pb-photo pb-gcard__photo">
		<?php echo $waldorf_pb_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by waldorf_pb_render_image(). ?>
		<?php if ( '' !== trim( wp_strip_all_tags( $waldorf_pb_caption ) ) ) : ?>
			<figcaption><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_caption ), ENT_QUOTES ) ); ?></figcaption>
		<?php endif; ?>
	</figure>
	<div class="pb-gcard__body">
		<span class="pb-tag"><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_tag ), ENT_QUOTES ) ); ?></span>
		<h3><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_title ), ENT_QUOTES ) ); ?></h3>
		<p><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_text ), ENT_QUOTES ) ); ?></p>
		<ul class="pb-meta-list">
			<?php foreach ( $waldorf_pb_facts as $waldorf_pb_fact ) : ?>
				<?php
				$waldorf_pb_fact_label = is_array( $waldorf_pb_fact ) && isset( $waldorf_pb_fact['label'] )
					? (string) $waldorf_pb_fact['label']
					: '';
				$waldorf_pb_fact_value = is_array( $waldorf_pb_fact ) && isset( $waldorf_pb_fact['value'] )
					? (string) $waldorf_pb_fact['value']
					: '';

				if ( '' === trim( wp_strip_all_tags( $waldorf_pb_fact_label ) ) && '' === trim( wp_strip_all_tags( $waldorf_pb_fact_value ) ) ) {
					continue;
				}
				?>
				<li><span><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_fact_label ), ENT_QUOTES ) ); ?></span><b><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_fact_value ), ENT_QUOTES ) ); ?></b></li>
			<?php endforeach; ?>
		</ul>
		<?php if ( '' !== trim( wp_strip_all_tags( $waldorf_pb_label ) ) ) : ?>
			<?php if ( '' !== trim( $waldorf_pb_url ) ) : ?>
				<a class="pb-more" href="<?php echo esc_url( $waldorf_pb_url ); ?>"><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_label ), ENT_QUOTES ) ); ?></a>
			<?php else : ?>
				<span class="pb-more"><?php echo esc_html( wp_specialchars_decode( wp_strip_all_tags( $waldorf_pb_label ), ENT_QUOTES ) ); ?></span>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</article>
