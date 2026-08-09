<?php
/**
 * Server-side rendering for an enrolment step.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_step_number = isset( $attributes['number'] ) ? max( 1, absint( $attributes['number'] ) ) : 1;
$waldorf_pb_step_title  = isset( $attributes['title'] ) ? wp_strip_all_tags( (string) $attributes['title'] ) : '';
$waldorf_pb_step_text   = isset( $attributes['text'] ) ? wp_strip_all_tags( (string) $attributes['text'] ) : '';
?>
<div class="pb-step pb-reveal">
	<span class="pb-step__n"><?php echo esc_html( (string) $waldorf_pb_step_number ); ?></span>
	<h4><?php echo esc_html( $waldorf_pb_step_title ); ?></h4>
	<p><?php echo esc_html( $waldorf_pb_step_text ); ?></p>
</div>
