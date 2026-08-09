<?php
/**
 * Server-side rendering for the season strip.
 *
 * The historical section used Core Group layout support. Rendering the same
 * nested groups here preserves its flex classes and generated layout styles.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks.
 */

$waldorf_pb_season_values = array(
	'season'    => 'Sommer',
	'ringLabel' => 'Jahreszeit',
	'eyebrow'   => 'Jahreszeitentisch',
	'title'     => 'Der Sommer steht auf dem Tisch',
	'text'      => 'Ein kleiner Tisch im Gruppenraum erzählt vom Lauf des Jahres.',
);

foreach ( $waldorf_pb_season_values as $waldorf_pb_season_key => $waldorf_pb_season_default ) {
	if ( isset( $attributes[ $waldorf_pb_season_key ] ) && is_string( $attributes[ $waldorf_pb_season_key ] ) ) {
		$waldorf_pb_season_values[ $waldorf_pb_season_key ] = $attributes[ $waldorf_pb_season_key ];
	}
}

$waldorf_pb_season_colors = array(
	'colorOne'   => '#e8c66a',
	'colorTwo'   => '#8fa9c9',
	'colorThree' => '#cdd6b6',
	'colorFour'  => '#efc3ae',
);

foreach ( $waldorf_pb_season_colors as $waldorf_pb_color_key => $waldorf_pb_color_default ) {
	$waldorf_pb_color = isset( $attributes[ $waldorf_pb_color_key ] ) && is_string( $attributes[ $waldorf_pb_color_key ] )
		? sanitize_hex_color( $attributes[ $waldorf_pb_color_key ] )
		: null;
	$waldorf_pb_season_colors[ $waldorf_pb_color_key ] = $waldorf_pb_color ?? $waldorf_pb_color_default;
}

$waldorf_pb_outer_group_attributes = array(
	'className' => 'pb-season pb-reveal',
	'layout'    => array(
		'type'                => 'flex',
		'flexWrap'            => 'wrap',
		'verticalAlignment'   => 'center',
		'justifyContent'      => 'space-between',
	),
	'style'     => array(
		'spacing' => array(
			'blockGap' => '34px',
		),
	),
);
$waldorf_pb_text_group_attributes  = array(
	'className' => 'pb-sec-head pb-sec-head--wide',
	'style'     => array(
		'layout' => array(
			'selfStretch' => 'fill',
			'flexSize'    => null,
		),
	),
	'layout'    => array(
		'type' => 'default',
	),
);

$waldorf_pb_season_markup = sprintf(
	'<!-- wp:group %1$s --><div class="wp-block-group pb-season pb-reveal">' .
	'<div class="pb-season__ring"><div><b>%2$s</b><span>%3$s</span></div></div>' .
	'<!-- wp:group %4$s --><div class="wp-block-group pb-sec-head pb-sec-head--wide">' .
	'<p class="pb-eyebrow">%5$s</p>' .
	'<h3 class="wp-block-heading" style="margin-top:0.2em;margin-bottom:0.25em">%6$s</h3>' .
	'<p class="has-text-color" style="color:#5a4046">%7$s</p>' .
	'<div class="pb-swatches" style="margin-top:14px"><i style="background:%8$s"></i><i style="background:%9$s"></i><i style="background:%10$s"></i><i style="background:%11$s"></i></div>' .
	'</div><!-- /wp:group -->%12$s</div><!-- /wp:group -->',
	wp_json_encode( $waldorf_pb_outer_group_attributes ),
	esc_html( $waldorf_pb_season_values['season'] ),
	esc_html( $waldorf_pb_season_values['ringLabel'] ),
	wp_json_encode( $waldorf_pb_text_group_attributes ),
	esc_html( $waldorf_pb_season_values['eyebrow'] ),
	esc_html( $waldorf_pb_season_values['title'] ),
	esc_html( $waldorf_pb_season_values['text'] ),
	esc_attr( $waldorf_pb_season_colors['colorOne'] ),
	esc_attr( $waldorf_pb_season_colors['colorTwo'] ),
	esc_attr( $waldorf_pb_season_colors['colorThree'] ),
	esc_attr( $waldorf_pb_season_colors['colorFour'] ),
	$content
);

echo do_blocks( $waldorf_pb_season_markup ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Values are escaped above; $content is rendered block content.
