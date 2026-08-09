<?php
/**
 * Server-side rendering for a contact row.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_contact_label = isset( $attributes['label'] ) ? wp_strip_all_tags( (string) $attributes['label'] ) : '';
$waldorf_pb_contact_value = isset( $attributes['value'] ) ? (string) $attributes['value'] : '';
$waldorf_pb_contact_type  = isset( $attributes['linkType'] ) ? (string) $attributes['linkType'] : 'plain';
$waldorf_pb_contact_text  = wp_strip_all_tags( $waldorf_pb_contact_value );
$waldorf_pb_contact_html  = esc_html( $waldorf_pb_contact_text );

if ( 'address' === $waldorf_pb_contact_type ) {
	$waldorf_pb_contact_html = wp_kses( $waldorf_pb_contact_value, array( 'br' => array() ) );
} elseif ( 'telephone' === $waldorf_pb_contact_type ) {
	$waldorf_pb_contact_trimmed = ltrim( $waldorf_pb_contact_text );
	$waldorf_pb_contact_digits  = preg_replace( '/\D+/', '', $waldorf_pb_contact_trimmed );
	$waldorf_pb_contact_href    = ( 0 === strpos( $waldorf_pb_contact_trimmed, '+' ) ? '+' : '' ) . $waldorf_pb_contact_digits;
	if ( '' !== $waldorf_pb_contact_digits ) {
		$waldorf_pb_contact_html = sprintf(
			'<a href="%s">%s</a>',
			esc_url( 'tel:' . $waldorf_pb_contact_href ),
			esc_html( $waldorf_pb_contact_text )
		);
	}
} elseif ( 'email' === $waldorf_pb_contact_type ) {
	$waldorf_pb_contact_email = sanitize_email( trim( $waldorf_pb_contact_text ) );
	if ( is_email( $waldorf_pb_contact_email ) ) {
		$waldorf_pb_contact_html = sprintf(
			'<a href="%s">%s</a>',
			esc_url( 'mailto:' . $waldorf_pb_contact_email ),
			esc_html( $waldorf_pb_contact_text )
		);
	}
}
?>
<div class="pb-krow"><span><?php echo esc_html( $waldorf_pb_contact_label ); ?></span><b><?php echo $waldorf_pb_contact_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Every branch is escaped above. ?></b></div>
