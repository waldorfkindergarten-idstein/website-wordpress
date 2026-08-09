<?php
// This file is generated. Do not modify it manually.
return array(
	'auszeichnung' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/auszeichnung',
		'version' => '1.0.0',
		'title' => 'Essens-Auszeichnung',
		'category' => 'waldorf',
		'icon' => 'yes-alt',
		'description' => 'Eine kurze Auszeichnung für die Verpflegung.',
		'keywords' => array(
			'Bio',
			'Essen',
			'Auszeichnung'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'text' => array(
				'type' => 'string',
				'default' => '100 % Bio'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'getreidetag' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/getreidetag',
		'version' => '1.0.0',
		'title' => 'Getreidetag',
		'category' => 'waldorf',
		'icon' => 'food',
		'description' => 'Ein Wochentag im Getreideplan.',
		'keywords' => array(
			'Getreide',
			'Essen',
			'Wochenplan'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'day' => array(
				'type' => 'string',
				'default' => 'Montag'
			),
			'grain' => array(
				'type' => 'string',
				'default' => 'Reis'
			),
			'note' => array(
				'type' => 'string',
				'default' => 'mit Gemüse der Saison'
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
	'tag' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/tag',
		'version' => '1.0.0',
		'title' => 'Wochentag',
		'category' => 'waldorf',
		'icon' => 'calendar-alt',
		'description' => 'Ein wiederkehrendes Angebot im Wochenrhythmus.',
		'keywords' => array(
			'Tag',
			'Woche',
			'Waldtag'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'weekday' => array(
				'type' => 'string',
				'default' => 'Montag'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Malen'
			),
			'text' => array(
				'type' => 'string',
				'default' => 'Mit Aquarellfarben auf großem Papier.'
			),
			'isForestDay' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'tagesablauf' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/tagesablauf',
		'version' => '1.0.0',
		'title' => 'Tagesablauf',
		'category' => 'waldorf',
		'icon' => 'clock',
		'description' => 'Ein sortierbarer Zeitstrahl für den Tagesablauf.',
		'keywords' => array(
			'Zeit',
			'Zeitstrahl',
			'Rhythmus'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'tagesablauf-punkt' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/tagesablauf-punkt',
		'version' => '1.0.0',
		'title' => 'Tagesablauf-Punkt',
		'category' => 'waldorf',
		'icon' => 'marker',
		'description' => 'Eine Uhrzeit mit Titel und Zusatz im Tagesablauf.',
		'keywords' => array(
			'Uhrzeit',
			'Termin',
			'Tagesablauf'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'parent' => array(
			'waldorf/tagesablauf'
		),
		'attributes' => array(
			'time' => array(
				'type' => 'string',
				'default' => '8:00'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Programmpunkt'
			),
			'detail' => array(
				'type' => 'string',
				'default' => 'Beschreibung ergänzen'
			),
			'isExtended' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	)
);
