<?php
// This file is generated. Do not modify it manually.
return array(
	'gruppen-karte' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/gruppen-karte',
		'version' => '1.0.0',
		'title' => 'Gruppenkarte',
		'category' => 'waldorf',
		'icon' => 'index-card',
		'description' => 'Eine Gruppe mit Foto, Beschreibung, Eckdaten und Link.',
		'keywords' => array(
			'Gruppe',
			'Karte',
			'Kindergarten'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'parent' => array(
			'waldorf/gruppen-raster'
		),
		'attributes' => array(
			'id' => array(
				'type' => 'integer',
				'default' => 0
			),
			'fallback' => array(
				'type' => 'string',
				'default' => 'photo-morgenkreis.jpg'
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
			'caption' => array(
				'type' => 'string',
				'default' => ''
			),
			'tag' => array(
				'type' => 'string',
				'default' => '2–6 Jahre'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Familiengruppen'
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'facts' => array(
				'type' => 'array',
				'default' => array(
					array(
						'label' => 'Plätze',
						'value' => '2 × 20 Kinder'
					),
					array(
						'label' => 'Kernzeit',
						'value' => '7:30 – 12:00 Uhr'
					),
					array(
						'label' => 'Verlängert',
						'value' => 'bis 15:15 Uhr'
					),
					array(
						'label' => 'Team',
						'value' => '2 Fachkräfte + Praktikum'
					)
				)
			),
			'linkLabel' => array(
				'type' => 'string',
				'default' => 'Mehr erfahren'
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'render' => 'file:./render.php'
	),
	'gruppen-raster' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/gruppen-raster',
		'version' => '1.0.0',
		'title' => 'Gruppenkarten-Raster',
		'category' => 'waldorf',
		'icon' => 'grid-view',
		'description' => 'Ein geschütztes, responsives Raster für Gruppenkarten.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/gruppen-karte'
		),
		'supports' => array(
			'html' => false,
			'inserter' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'mosaik' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/mosaik',
		'version' => '1.0.0',
		'title' => 'Foto-Mosaik',
		'category' => 'waldorf',
		'icon' => 'images-alt2',
		'description' => 'Vier frei sortierbare Fotos in einem festen Mosaik-Raster.',
		'keywords' => array(
			'Bild',
			'Foto',
			'Galerie'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/photo'
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'person' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/person',
		'version' => '1.0.0',
		'title' => 'Teammitglied',
		'category' => 'waldorf',
		'icon' => 'admin-users',
		'description' => 'Ein Teammitglied mit Foto oder Monogramm.',
		'keywords' => array(
			'Person',
			'Team',
			'Mitarbeiter'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'id' => array(
				'type' => 'integer',
				'default' => 0
			),
			'fallback' => array(
				'type' => 'string',
				'default' => ''
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
			'monogram' => array(
				'type' => 'string',
				'default' => 'L'
			),
			'name' => array(
				'type' => 'string',
				'default' => 'Leitung'
			),
			'role' => array(
				'type' => 'string',
				'default' => 'Pädagogische Gesamtleitung'
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
	)
);
