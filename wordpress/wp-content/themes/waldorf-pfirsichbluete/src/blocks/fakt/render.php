<?php
/**
 * Server-side rendering for a single key figure.
 *
 * With countFromYear set, the value is the number of years since that year
 * rather than a typed-in number. "39 Jahre Elterninitiative" was hardcoded and
 * would have quietly become wrong every January.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_value = isset( $attributes['value'] ) ? (string) $attributes['value'] : '';
$waldorf_pb_label = isset( $attributes['label'] ) ? (string) $attributes['label'] : '';
$waldorf_pb_from  = isset( $attributes['countFromYear'] ) ? (int) $attributes['countFromYear'] : 0;

if ( $waldorf_pb_from > 0 ) {
	$waldorf_pb_value = (string) max( 0, (int) wp_date( 'Y' ) - $waldorf_pb_from );
}
?>
<div class="pb-fact"><b><?php echo wp_kses( $waldorf_pb_value, array() ); ?></b><span><?php echo wp_kses( $waldorf_pb_label, array() ); ?></span></div>
