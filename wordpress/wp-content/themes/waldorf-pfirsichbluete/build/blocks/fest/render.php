<?php
/**
 * Server-side rendering for a festival card.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_fest_motifs = array(
	'c'      => 'deco-c.png',
	'summer' => 'deco-summer.png',
	'e'      => 'deco-e.png',
	'f'      => 'deco-f.png',
	'b'      => 'deco-b.png',
	'd'      => 'deco-d.png',
);
$waldorf_pb_fest_motif  = isset( $attributes['motif'] )
	&& is_string( $attributes['motif'] )
	&& isset( $waldorf_pb_fest_motifs[ $attributes['motif'] ] )
	? $attributes['motif']
	: 'c';
$waldorf_pb_fest_style  = sprintf(
	'--waldorf-fest-motif:url("%s");',
	esc_url( get_theme_file_uri( '/assets/images/' . $waldorf_pb_fest_motifs[ $waldorf_pb_fest_motif ] ) )
);
$waldorf_pb_fest_month  = isset( $attributes['month'] ) && is_string( $attributes['month'] ) ? $attributes['month'] : '';
$waldorf_pb_fest_title  = isset( $attributes['title'] ) && is_string( $attributes['title'] ) ? $attributes['title'] : '';
$waldorf_pb_fest_text   = isset( $attributes['text'] ) && is_string( $attributes['text'] ) ? $attributes['text'] : '';
?>
<div class="pb-fest pb-reveal" style="<?php echo esc_attr( $waldorf_pb_fest_style ); ?>">
	<div class="pb-meta"><?php echo esc_html( $waldorf_pb_fest_month ); ?></div>
	<h4><?php echo esc_html( $waldorf_pb_fest_title ); ?></h4>
	<p><?php echo esc_html( $waldorf_pb_fest_text ); ?></p>
</div>
