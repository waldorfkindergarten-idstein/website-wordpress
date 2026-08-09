<?php
/**
 * Server-side rendering for the contact box.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks.
 */

$waldorf_pb_contact_heading = isset( $attributes['heading'] ) ? wp_strip_all_tags( (string) $attributes['heading'] ) : 'Kontakt & Öffnungszeiten';
?>
<div class="pb-kbox">
	<h3><?php echo esc_html( $waldorf_pb_contact_heading ); ?></h3>
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered by restricted registered child blocks. ?>
</div>
