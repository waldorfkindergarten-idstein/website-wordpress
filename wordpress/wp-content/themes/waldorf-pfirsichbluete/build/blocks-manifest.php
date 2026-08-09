<?php
// This file is generated. Do not modify it manually.
return array(
	'chip' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/chip',
		'version' => '1.0.0',
		'title' => 'Merkmal',
		'category' => 'waldorf',
		'icon' => 'tag',
		'description' => 'Ein kurzes Merkmal im Hero-Bereich.',
		'parent' => array(
			'waldorf/sammlung'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'text' => array(
				'type' => 'string',
				'default' => 'Merkmal'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'credo' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/credo',
		'version' => '1.0.0',
		'title' => 'Pädagogisches Leitbild',
		'category' => 'waldorf',
		'icon' => 'format-quote',
		'description' => 'Ein hervorgehobenes Zitat aus dem pädagogischen Leitbild.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'quote' => array(
				'type' => 'string',
				'default' => 'Erziehen heißt, dem Kind Raum geben – und ihm dabei ein gutes Vorbild sein.'
			),
			'citation' => array(
				'type' => 'string',
				'default' => 'Unser pädagogisches Leitbild'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'datum' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/datum',
		'version' => '1.0.0',
		'title' => 'Terminhinweis',
		'category' => 'waldorf',
		'icon' => 'calendar-alt',
		'description' => 'Ein hervorgehobener Termin am Hero-Foto.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Nächster Termin'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Kennenlerntag'
			),
			'date' => array(
				'type' => 'string',
				'default' => 'Di, 6. Oktober · 14–16 Uhr'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'dekoration' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/dekoration',
		'version' => '1.0.0',
		'title' => 'Seitendekoration',
		'category' => 'waldorf',
		'icon' => 'art',
		'description' => 'Ein geschütztes, nicht-inhaltliches Gestaltungselement.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'variant' => array(
				'type' => 'string',
				'enum' => array(
					'hero-background',
					'back-to-top'
				),
				'default' => 'hero-background'
			)
		),
		'supports' => array(
			'html' => false,
			'inserter' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'fakt' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/fakt',
		'version' => '1.0.0',
		'title' => 'Kennzahl',
		'category' => 'waldorf',
		'icon' => 'chart-bar',
		'description' => 'Eine Kennzahl mit kurzer Erläuterung.',
		'parent' => array(
			'waldorf/sammlung'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'value' => array(
				'type' => 'string',
				'default' => '39'
			),
			'label' => array(
				'type' => 'string',
				'default' => 'Jahre Elterninitiative'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
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
	),
	'sammlung' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/sammlung',
		'version' => '1.0.0',
		'title' => 'Waldorf-Sammlung',
		'category' => 'waldorf',
		'icon' => 'screenoptions',
		'description' => 'Eine geschützte, sortierbare Sammlung passender Waldorf-Bausteine.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'variant' => array(
				'type' => 'string',
				'enum' => array(
					'chips',
					'facts',
					'testimonials'
				),
				'default' => 'chips'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'siegel' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/siegel',
		'version' => '1.0.0',
		'title' => 'Siegel',
		'category' => 'waldorf',
		'icon' => 'awards',
		'description' => 'Das runde Siegel am Hero-Foto.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => 'Seit<br>1987'
			),
			'label' => array(
				'type' => 'string',
				'default' => 'Elterninitiative'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'stimme' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/stimme',
		'version' => '1.0.0',
		'title' => 'Elternstimme',
		'category' => 'waldorf',
		'icon' => 'format-quote',
		'description' => 'Ein Zitat mit Quellenangabe.',
		'parent' => array(
			'waldorf/sammlung'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'quote' => array(
				'type' => 'string',
				'default' => 'Was Familien über uns erzählen.'
			),
			'source' => array(
				'type' => 'string',
				'default' => 'Eine Familie'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	)
);
