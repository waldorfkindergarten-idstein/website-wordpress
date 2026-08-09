<?php
// This file is generated. Do not modify it manually.
return array(
	'fest' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/fest',
		'version' => '1.0.0',
		'title' => 'Fest',
		'category' => 'waldorf',
		'icon' => 'calendar-alt',
		'description' => 'Ein Fest im Jahreslauf.',
		'keywords' => array(
			'Fest',
			'Jahreslauf',
			'Waldorf'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'parent' => array(
			'waldorf/feste'
		),
		'attributes' => array(
			'month' => array(
				'type' => 'string',
				'default' => 'Monat',
				'role' => 'content'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Fest',
				'role' => 'content'
			),
			'text' => array(
				'type' => 'string',
				'default' => 'Beschreibung des Festes.',
				'role' => 'content'
			),
			'motif' => array(
				'type' => 'string',
				'enum' => array(
					'c',
					'summer',
					'e',
					'f',
					'b',
					'd'
				),
				'default' => 'c'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'feste' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/feste',
		'version' => '1.0.0',
		'title' => 'Feste',
		'category' => 'waldorf',
		'icon' => 'screenoptions',
		'description' => 'Ein geschütztes Raster für Feste im Jahreslauf.',
		'keywords' => array(
			'Feste',
			'Jahreslauf',
			'Raster'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/fest'
		),
		'attributes' => array(
			'templateLock' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js'
	),
	'jahreszeiten' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/jahreszeiten',
		'version' => '1.0.0',
		'title' => 'Jahreszeiten',
		'category' => 'waldorf',
		'icon' => 'palmtree',
		'description' => 'Ein geschützter Jahreszeiten-Streifen mit frei bearbeitbaren Inhalten.',
		'keywords' => array(
			'Jahreszeit',
			'Jahreszeitentisch',
			'Waldorf'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'core/buttons'
		),
		'attributes' => array(
			'season' => array(
				'type' => 'string',
				'default' => 'Sommer',
				'role' => 'content'
			),
			'ringLabel' => array(
				'type' => 'string',
				'default' => 'Jahreszeit',
				'role' => 'content'
			),
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Jahreszeitentisch',
				'role' => 'content'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Der Sommer steht auf dem Tisch',
				'role' => 'content'
			),
			'text' => array(
				'type' => 'string',
				'default' => 'Ein kleiner Tisch im Gruppenraum erzählt vom Lauf des Jahres.',
				'role' => 'content'
			),
			'colorOne' => array(
				'type' => 'string',
				'default' => '#e8c66a'
			),
			'colorTwo' => array(
				'type' => 'string',
				'default' => '#8fa9c9'
			),
			'colorThree' => array(
				'type' => 'string',
				'default' => '#cdd6b6'
			),
			'colorFour' => array(
				'type' => 'string',
				'default' => '#efc3ae'
			),
			'templateLock' => array(
				'type' => 'string',
				'default' => 'all'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css'
	),
	'photo' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/photo',
		'version' => '1.0.0',
		'title' => 'Foto',
		'category' => 'waldorf',
		'icon' => 'format-image',
		'description' => 'Ein Foto in einer organischen Waldorf-Form.',
		'keywords' => array(
			'Bild',
			'Foto',
			'Waldorf'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'id' => array(
				'type' => 'integer',
				'default' => 0
			),
			'caption' => array(
				'type' => 'string',
				'default' => ''
			),
			'shape' => array(
				'type' => 'string',
				'enum' => array(
					'hero',
					'mosaic1',
					'mosaic2',
					'mosaic3',
					'mosaic4',
					'group',
					'rhythm',
					'food',
					'person',
					'round'
				),
				'default' => 'hero'
			),
			'focalPoint' => array(
				'type' => 'object',
				'default' => array(
					'x' => 0.5,
					'y' => 0.5
				)
			),
			'alt' => array(
				'type' => 'string',
				'default' => ''
			),
			'fallback' => array(
				'type' => 'string',
				'default' => 'photo-hero.jpg'
			)
		),
		'supports' => array(
			'html' => false
		),
		'example' => array(
			'attributes' => array(
				'caption' => 'Beispielbild · Freispiel im Garten'
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'render' => 'file:./render.php'
	)
);
