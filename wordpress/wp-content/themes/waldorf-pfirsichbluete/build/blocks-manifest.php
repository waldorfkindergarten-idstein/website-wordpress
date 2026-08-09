<?php
// This file is generated. Do not modify it manually.
return array(
	'download' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/download',
		'version' => '1.0.0',
		'title' => 'Download',
		'category' => 'waldorf',
		'icon' => 'download',
		'description' => 'Eine Datei aus der Mediathek mit Titel und Beschreibung.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'parent' => array(
			'waldorf/downloads'
		),
		'attributes' => array(
			'id' => array(
				'type' => 'integer',
				'default' => 0
			),
			'fileUrl' => array(
				'type' => 'string',
				'default' => '#'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Dokument'
			),
			'description' => array(
				'type' => 'string',
				'default' => ''
			),
			'fallbackType' => array(
				'type' => 'string',
				'default' => 'PDF'
			),
			'fallbackSize' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'downloads' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/downloads',
		'version' => '1.0.0',
		'title' => 'Downloadliste',
		'category' => 'waldorf',
		'icon' => 'download',
		'description' => 'Eine geschützte zweispaltige Downloadliste.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/download'
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'faq' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/faq',
		'version' => '1.0.0',
		'title' => 'Häufige Frage',
		'category' => 'waldorf',
		'icon' => 'editor-help',
		'description' => 'Eine aufklappbare Frage mit Antwort.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'parent' => array(
			'waldorf/faqs'
		),
		'attributes' => array(
			'question' => array(
				'type' => 'string',
				'default' => 'Ihre Frage'
			),
			'answer' => array(
				'type' => 'string',
				'default' => 'Die passende Antwort.'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'faqs' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/faqs',
		'version' => '1.0.0',
		'title' => 'FAQ-Liste',
		'category' => 'waldorf',
		'icon' => 'editor-help',
		'description' => 'Eine geschützte Liste häufig gestellter Fragen.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/faq'
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'kontaktbox' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/kontaktbox',
		'version' => '1.0.0',
		'title' => 'Kontaktbox',
		'category' => 'waldorf',
		'icon' => 'id-alt',
		'description' => 'Eine geschützte Liste mit Kontaktdaten und Öffnungszeiten.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/kontaktzeile'
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => 'Kontakt & Öffnungszeiten'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'kontaktzeile' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/kontaktzeile',
		'version' => '1.0.0',
		'title' => 'Kontaktzeile',
		'category' => 'waldorf',
		'icon' => 'id-alt',
		'description' => 'Eine Bezeichnung mit Kontaktangabe oder Öffnungszeit.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'parent' => array(
			'waldorf/kontaktbox'
		),
		'attributes' => array(
			'label' => array(
				'type' => 'string',
				'default' => 'Bezeichnung'
			),
			'value' => array(
				'type' => 'string',
				'default' => 'Angabe'
			),
			'linkType' => array(
				'type' => 'string',
				'enum' => array(
					'none',
					'address',
					'tel',
					'email'
				),
				'default' => 'none'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
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
	'schritt' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/schritt',
		'version' => '1.0.0',
		'title' => 'Anmeldeschritt',
		'category' => 'waldorf',
		'icon' => 'editor-ol',
		'description' => 'Ein nummerierter Schritt auf dem Weg zum Kindergartenplatz.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'parent' => array(
			'waldorf/schritte'
		),
		'attributes' => array(
			'title' => array(
				'type' => 'string',
				'default' => 'Schritt'
			),
			'text' => array(
				'type' => 'string',
				'default' => 'Beschreibung des Schritts.'
			),
			'number' => array(
				'type' => 'integer',
				'default' => 1
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'schritte' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/schritte',
		'version' => '1.0.0',
		'title' => 'Anmeldeschritte',
		'category' => 'waldorf',
		'icon' => 'editor-ol',
		'description' => 'Eine geschützte Liste nummerierter Anmeldeschritte.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/schritt'
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'termin' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/termin',
		'version' => '1.0.0',
		'title' => 'Termin',
		'category' => 'waldorf',
		'icon' => 'calendar-alt',
		'description' => 'Ein Termin mit Datum, Titel und Zusatzinformation.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'parent' => array(
			'waldorf/termine'
		),
		'attributes' => array(
			'date' => array(
				'type' => 'string',
				'default' => '2026-10-06'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Termin'
			),
			'detail' => array(
				'type' => 'string',
				'default' => 'Uhrzeit und Hinweise'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'termine' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/termine',
		'version' => '1.0.0',
		'title' => 'Terminliste',
		'category' => 'waldorf',
		'icon' => 'calendar-alt',
		'description' => 'Eine geschützte Liste kommender Termine.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/termin'
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => 'Termine'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	)
);
