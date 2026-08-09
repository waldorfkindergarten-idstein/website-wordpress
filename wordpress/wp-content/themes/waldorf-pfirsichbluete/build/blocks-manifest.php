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
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'getreideplan' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/getreideplan',
		'version' => '1.0.0',
		'title' => 'Getreideplan',
		'category' => 'waldorf',
		'icon' => 'editor-ul',
		'description' => 'Ein sortierbarer Wochenplan für die Getreidetage.',
		'keywords' => array(
			'Getreide',
			'Essen',
			'Wochenplan'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
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
		'parent' => array(
			'waldorf/getreideplan'
		),
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
					'plain',
					'address',
					'telephone',
					'email'
				),
				'default' => 'plain'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
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
		'description' => 'Vier feste Fotoplätze. Bilder werden direkt in ihren Plätzen ersetzt.',
		'keywords' => array(
			'Bild',
			'Foto',
			'Galerie'
		),
		'textdomain' => 'waldorf-pfirsichbluete',
		'allowedBlocks' => array(
			'waldorf/photo'
		),
		'attributes' => array(
			'isMosaic' => array(
				'type' => 'boolean',
				'default' => true
			)
		),
		'providesContext' => array(
			'waldorf/isMosaic' => 'isMosaic'
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
		'usesContext' => array(
			'waldorf/isMosaic'
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
	),
	'team-hinweis' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'waldorf/team-hinweis',
		'version' => '1.0.0',
		'title' => 'Team-Hinweis',
		'category' => 'waldorf',
		'icon' => 'info-outline',
		'description' => 'Der kurze Hinweis unter den Teammitgliedern.',
		'textdomain' => 'waldorf-pfirsichbluete',
		'attributes' => array(
			'text' => array(
				'type' => 'string',
				'default' => 'Gerne stellen wir Ihnen das Team beim Kennenlerntag persönlich vor.'
			)
		),
		'supports' => array(
			'html' => false,
			'inserter' => false
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
