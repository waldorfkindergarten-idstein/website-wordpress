<?php
/**
 * Server-side rendering for non-content page decorations.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_variant = isset( $attributes['variant'] ) ? (string) $attributes['variant'] : 'hero-background';

if ( 'back-to-top' === $waldorf_pb_variant ) :
	?>
<button class="pb-totop" type="button" aria-label="<?php echo esc_attr__( 'Nach oben', 'waldorf-pfirsichbluete' ); ?>">↑</button>
	<?php
else :
	?>
<div class="pb-hero__bg" aria-hidden="true"></div>
	<?php
endif;
