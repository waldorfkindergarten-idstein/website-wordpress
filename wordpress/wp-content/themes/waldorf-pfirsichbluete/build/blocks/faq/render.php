<?php
/**
 * Server-side rendering for a frequently asked question.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_faq_question = isset( $attributes['question'] ) ? wp_strip_all_tags( (string) $attributes['question'] ) : '';
$waldorf_pb_faq_answer   = isset( $attributes['answer'] ) ? wp_strip_all_tags( (string) $attributes['answer'] ) : '';
?>
<details>
	<summary><?php echo esc_html( $waldorf_pb_faq_question ); ?></summary>
	<p><?php echo esc_html( $waldorf_pb_faq_answer ); ?></p>
</details>
