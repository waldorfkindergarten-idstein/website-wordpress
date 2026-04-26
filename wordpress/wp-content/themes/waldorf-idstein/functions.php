<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function waldorf_idstein_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'waldorf-idstein' ),
		)
	);
}
add_action( 'after_setup_theme', 'waldorf_idstein_setup' );

function waldorf_idstein_enqueue_assets() {
	wp_enqueue_style(
		'waldorf-idstein-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Infant:wght@400;500;600&family=Quicksand:wght@400;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'waldorf-idstein-style',
		get_stylesheet_directory_uri() . '/assets/css/site.css',
		array( 'waldorf-idstein-fonts' ),
		filemtime( get_stylesheet_directory() . '/assets/css/site.css' )
	);

	wp_enqueue_script(
		'waldorf-idstein-watercolor',
		get_stylesheet_directory_uri() . '/assets/js/watercolor-canvas.client.js',
		array(),
		filemtime( get_stylesheet_directory() . '/assets/js/watercolor-canvas.client.js' ),
		true
	);

	wp_enqueue_script(
		'waldorf-idstein-theme',
		get_stylesheet_directory_uri() . '/assets/js/theme.js',
		array(),
		filemtime( get_stylesheet_directory() . '/assets/js/theme.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'waldorf_idstein_enqueue_assets' );

function waldorf_idstein_relabel_posts() {
	global $wp_post_types;

	if ( empty( $wp_post_types['post'] ) ) {
		return;
	}

	$labels = &$wp_post_types['post']->labels;

	$labels->name                  = 'Aktuelles';
	$labels->singular_name         = 'Neuigkeit';
	$labels->menu_name             = 'Aktuelles';
	$labels->name_admin_bar        = 'Neuigkeit';
	$labels->add_new               = 'Neu hinzufügen';
	$labels->add_new_item          = 'Neuigkeit hinzufügen';
	$labels->edit_item             = 'Neuigkeit bearbeiten';
	$labels->new_item              = 'Neuigkeit';
	$labels->view_item             = 'Neuigkeit ansehen';
	$labels->view_items            = 'Neuigkeiten ansehen';
	$labels->search_items          = 'Neuigkeiten durchsuchen';
	$labels->not_found             = 'Keine Neuigkeiten gefunden';
	$labels->not_found_in_trash    = 'Keine Neuigkeiten im Papierkorb gefunden';
	$labels->all_items             = 'Alle Neuigkeiten';
	$labels->archives              = 'Neuigkeiten';
	$labels->insert_into_item      = 'In Neuigkeit einfügen';
	$labels->uploaded_to_this_item = 'Zu dieser Neuigkeit hochgeladen';

	$wp_post_types['post']->label = 'Aktuelles';
}
add_action( 'init', 'waldorf_idstein_relabel_posts', 20 );

function waldorf_idstein_register_block_patterns() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'waldorf-idstein',
			array(
				'label' => 'Waldorf Idstein',
			)
		);
	}

	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern(
		'waldorf-idstein/intro-section',
		array(
			'title'      => 'Intro-Bereich',
			'categories' => array( 'waldorf-idstein' ),
			'description'=> 'Badge, Überschrift und Einleitungstext.',
			'content'    =>
				'<!-- wp:group {"tagName":"section","className":"intro"} -->' .
				'<section class="wp-block-group intro">' .
				'<!-- wp:paragraph {"className":"badge"} --><p class="badge">Bereich</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":1} --><h1>Überschrift</h1><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"lede"} --><p class="lede">Kurze Einleitung für diesen Bereich.</p><!-- /wp:paragraph -->' .
				'</section><!-- /wp:group -->',
		)
	);

	register_block_pattern(
		'waldorf-idstein/panel-section',
		array(
			'title'      => 'Panel-Bereich',
			'categories' => array( 'waldorf-idstein' ),
			'description'=> 'Inhaltsbox mit Überschrift und Text.',
			'content'    =>
				'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
				'<section class="wp-block-group panel">' .
				'<!-- wp:heading {"level":2} --><h2>Überschrift</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph --><p>Hier steht der Inhalt dieses Abschnitts.</p><!-- /wp:paragraph -->' .
				'</section><!-- /wp:group -->',
		)
	);

	register_block_pattern(
		'waldorf-idstein/contact-columns',
		array(
			'title'      => 'Kontakt in zwei Spalten',
			'categories' => array( 'waldorf-idstein' ),
			'description'=> 'Zwei Spalten für Kontakt- und Vereinsinformationen, direkt im Block-Editor bearbeitbar.',
			'content'    =>
				'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
				'<section class="wp-block-group panel">' .
				'<!-- wp:columns {"className":"grid"} --><div class="wp-block-columns grid">' .
				'<!-- wp:column --><div class="wp-block-column">' .
				'<!-- wp:heading {"level":2} --><h2>Kontakt</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"contact"} --><p class="contact">Straße 1<br>65510 Idstein</p><!-- /wp:paragraph -->' .
				'<!-- wp:paragraph {"className":"contact"} --><p class="contact">06126 / 12345<br><span class="note">Erreichbarkeit</span></p><!-- /wp:paragraph -->' .
				'<!-- wp:paragraph {"className":"contact"} --><p class="contact"><a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a></p><!-- /wp:paragraph -->' .
				'</div><!-- /wp:column -->' .
				'<!-- wp:column --><div class="wp-block-column">' .
				'<!-- wp:heading {"level":2} --><h2>Verein</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"small"} --><p class="small">Kurze Zusatzinformation zum Verein.</p><!-- /wp:paragraph -->' .
				'<!-- wp:list {"className":"list"} --><ul class="list"><li><strong>Punkt 1:</strong> Inhalt</li><li><strong>Punkt 2:</strong> Inhalt</li><li><strong>Punkt 3:</strong> Inhalt</li></ul><!-- /wp:list -->' .
				'<!-- wp:group {"className":"links","layout":{"type":"flex","flexWrap":"wrap"}} --><div class="wp-block-group links"><!-- wp:paragraph --><p><a href="#">Link 1</a></p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="#">Link 2</a></p><!-- /wp:paragraph --></div><!-- /wp:group -->' .
				'</div><!-- /wp:column -->' .
				'</div><!-- /wp:columns -->' .
				'</section><!-- /wp:group -->',
		)
	);

	register_block_pattern(
		'waldorf-idstein/downloads-panel',
		array(
			'title'      => 'Downloads/Formulare',
			'categories' => array( 'waldorf-idstein' ),
			'description'=> 'Panel mit Download-Liste.',
			'content'    =>
				'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
				'<section class="wp-block-group panel">' .
				'<!-- wp:heading {"level":2} --><h2>Formulare und Downloads</h2><!-- /wp:heading -->' .
				'<!-- wp:list {"className":"list"} --><ul class="list"><li><a href="/downloads/anmeldung-familiengruppe.pdf">Anmeldung Familiengruppe</a></li><li><a href="/downloads/anmeldung-wiegenstube.pdf">Anmeldung Wiegenstube</a></li><li><a href="/downloads/vereinssatzung.pdf">Vereinssatzung</a></li></ul><!-- /wp:list -->' .
				'</section><!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'waldorf_idstein_register_block_patterns', 30 );

function waldorf_idstein_contact_page_block_content() {
	return
		'<!-- wp:group {"tagName":"section","className":"intro"} -->' .
		'<section class="wp-block-group intro">' .
		'<!-- wp:paragraph {"className":"badge"} --><p class="badge">Kontakt</p><!-- /wp:paragraph -->' .
		'<!-- wp:heading {"level":1} --><h1>Wir freuen uns auf Ihre Nachricht</h1><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"lede"} --><p class="lede">Fragen zu Anmeldung, Gruppen oder pädagogischen Themen? Melden Sie sich telefonisch oder per E-Mail – wir antworten zeitnah.</p><!-- /wp:paragraph -->' .
		'</section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
		'<section class="wp-block-group panel">' .
		'<!-- wp:columns {"className":"grid"} --><div class="wp-block-columns grid">' .
		'<!-- wp:column --><div class="wp-block-column">' .
		'<!-- wp:heading {"level":2} --><h2>Waldorfkindergarten Idstein</h2><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"contact"} --><p class="contact">Limburger Strasse 79<br>65510 Idstein</p><!-- /wp:paragraph -->' .
		'<!-- wp:paragraph {"className":"contact"} --><p class="contact">Telefon 06126-92141<br><span class="note">(Mo-Do 12:30-13:30 Uhr, Mi 9:00-12:00 Uhr)</span></p><!-- /wp:paragraph -->' .
		'<!-- wp:paragraph {"className":"contact"} --><p class="contact"><a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a></p><!-- /wp:paragraph -->' .
		'<!-- wp:paragraph {"className":"contact"} --><p class="contact"><a href="http://www.waldorfkindergarten-idstein.de">www.waldorfkindergarten-idstein.de</a></p><!-- /wp:paragraph -->' .
		'</div><!-- /wp:column -->' .
		'<!-- wp:column --><div class="wp-block-column">' .
		'<!-- wp:heading {"level":2} --><h2>Verein</h2><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"small"} --><p class="small">Verein zur Foerderung des Waldorfkindergartens Idstein e.V.</p><!-- /wp:paragraph -->' .
		'<!-- wp:list {"className":"list"} --><ul class="list"><li><strong>Geschaeftsfuehrerin:</strong> Monika Igl</li><li><strong>Geschaeftsfuehrender Vorstand:</strong> Kristina Falke, Diana Pietsch, Barbara Simon, Janka Steininger</li><li><strong>Paedagogische Vorstandsmitglieder:</strong> Nicola Kirberg, Christel Claassen</li><li><strong>Vereinsregister:</strong> Amtsgericht Idstein VR 5056</li></ul><!-- /wp:list -->' .
		'<!-- wp:group {"className":"links","layout":{"type":"flex","flexWrap":"wrap"}} --><div class="wp-block-group links"><!-- wp:paragraph --><p><a href="/downloads/vereinssatzung.pdf">Vereinssatzung (PDF)</a></p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/downloads/beitragsordnung-2022.pdf">Beitragsordnung (PDF)</a></p><!-- /wp:paragraph --></div><!-- /wp:group -->' .
		'</div><!-- /wp:column -->' .
		'</div><!-- /wp:columns -->' .
		'</section><!-- /wp:group -->';
}

function waldorf_idstein_migrate_contact_page_to_blocks() {
	if ( (int) get_option( 'waldorf_idstein_contact_blocks_version', 0 ) >= 1 ) {
		return;
	}

	$page = get_page_by_path( 'kontakt' );

	if ( ! $page ) {
		return;
	}

	$content = (string) get_post_field( 'post_content', $page->ID );

	if ( false === strpos( $content, '<section class="intro">' ) && false === strpos( $content, '<section class="panel grid">' ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => waldorf_idstein_contact_page_block_content(),
		)
	);

	update_option( 'waldorf_idstein_contact_blocks_version', 1 );
}
add_action( 'init', 'waldorf_idstein_migrate_contact_page_to_blocks', 35 );

function waldorf_idstein_downloads_page_block_content() {
	return
		'<!-- wp:group {"tagName":"section","className":"intro"} -->' .
		'<section class="wp-block-group intro">' .
		'<!-- wp:paragraph {"className":"badge"} --><p class="badge">Downloads</p><!-- /wp:paragraph -->' .
		'<!-- wp:heading {"level":1} --><h1>Formulare und Unterlagen</h1><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"lede"} --><p class="lede">Melden Sie sich gerne telefonisch oder per E-Mail fuer einen Platz oder laden Sie die passenden Formulare direkt herunter. Fuer Fragen stehen wir jederzeit zur Verfuegung.</p><!-- /wp:paragraph -->' .
		'<!-- wp:paragraph {"className":"contact"} --><p class="contact">Telefon: 06126/92141 · <a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a></p><!-- /wp:paragraph -->' .
		'</section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
		'<section class="wp-block-group panel">' .
		'<!-- wp:heading {"level":2} --><h2>Anmeldeformulare und Infos</h2><!-- /wp:heading -->' .
		'<!-- wp:list {"className":"list"} --><ul class="list"><li><a href="/downloads/anmeldung-familiengruppe.pdf">Anmeldung Familiengruppe</a></li><li><a href="/downloads/anmeldung-wiegenstube.pdf">Anmeldung Wiegenstube</a></li><li><a href="/downloads/anmeldung-kindergarten-u3.pdf">Anmeldung Kindergarten U3</a></li><li><a href="/downloads/beitragsordnung-2022.pdf">Beitragsordnung ab August 2022</a></li><li><a href="/downloads/vereinssatzung.pdf">Vereinssatzung</a></li></ul><!-- /wp:list -->' .
		'</section><!-- /wp:group -->';
}

function waldorf_idstein_migrate_downloads_page_to_blocks() {
	if ( (int) get_option( 'waldorf_idstein_downloads_blocks_version', 0 ) >= 1 ) {
		return;
	}

	$page = null;

	foreach ( array( 'formulare', 'formulare-2', 'downloads' ) as $slug ) {
		$page = get_page_by_path( $slug );

		if ( $page ) {
			break;
		}
	}

	if ( ! $page ) {
		return;
	}

	$content = (string) get_post_field( 'post_content', $page->ID );

	if ( false === strpos( $content, '<section class="intro">' ) && false === strpos( $content, '<section class="panel">' ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => waldorf_idstein_downloads_page_block_content(),
		)
	);

	update_option( 'waldorf_idstein_downloads_blocks_version', 1 );
}
add_action( 'init', 'waldorf_idstein_migrate_downloads_page_to_blocks', 36 );

function waldorf_idstein_gruppen_page_block_content() {
	return
		'<!-- wp:group {"tagName":"section","className":"intro"} -->' .
		'<section class="wp-block-group intro">' .
		'<!-- wp:paragraph {"className":"badge"} --><p class="badge">Unsere Arbeit</p><!-- /wp:paragraph -->' .
		'<!-- wp:heading {"level":1} --><h1>Gruppen, Rhythmus und Waldorfpädagogik</h1><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"lede"} --><p class="lede">Vom ersten Krippenjahr bis zum Schuleintritt bleiben die Kinder in vertrauten Gruppen und erleben Waldorfpaedagogik im Tagesrhythmus – mit viel Natur, Wiederholung und Geborgenheit.</p><!-- /wp:paragraph -->' .
		'</section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
		'<section class="wp-block-group panel">' .
		'<!-- wp:heading {"level":2} --><h2>Familiengruppen · Lerchennest und Spatzennest</h2><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"eyebrow"} --><p class="eyebrow">16 Kinder pro Gruppe · bis zu 4 Nestkinder (2 Jahre)</p><!-- /wp:paragraph -->' .
		'<!-- wp:list {"className":"list"} --><ul class="list"><li><strong>Zeiten:</strong> Mo-Do 07:30-12:45/13:00 Uhr (mit Mittagessen), optional bis 15:15 Uhr; Fr 07:30-12:30 Uhr ohne Mittagessen. Nestkinder: Mo-Do 07:30-12:00 Uhr.</li><li><strong>Geborgenheit und Kontinuitaet:</strong> gleiche Bezugsgruppe und Bezugserzieherin von der Krippe bis zum Schuleintritt.</li><li><strong>Tagesablauf:</strong> freies Spiel, Morgenkreis zur Jahreszeit, vollwertiges Fruehstueck, Garten oder Wald, Abschlusslied fuer Nestkinder; fuer die Grossen Mittagessen und Maerchen/Tischpuppenspiel.</li></ul><!-- /wp:list -->' .
		'</section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
		'<section class="wp-block-group panel">' .
		'<!-- wp:heading {"level":2} --><h2>Krippengruppe · Wiegenstube</h2><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"eyebrow"} --><p class="eyebrow">10 Kinder · 1-3 Jahre</p><!-- /wp:paragraph -->' .
		'<!-- wp:list {"className":"list"} --><ul class="list"><li><strong>Zeiten:</strong> Mo-Do 07:30-12:45 Uhr (mit Mittagessen), optional bis 15:15 Uhr; Fr 07:30-13:00 Uhr (mit Mittagessen).</li><li><strong>Atmosphaere:</strong> warmer, ruhiger Raum mit klaren Ritualen, Schlafzeiten und frisch gekochten Mahlzeiten.</li><li><strong>Erleben:</strong> behutsames Pflegen und Wickeln, Spaziergaenge, Zeit im Garten, Lieder, Handgestenspiele und freies Erkunden.</li></ul><!-- /wp:list -->' .
		'</section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
		'<section class="wp-block-group panel">' .
		'<!-- wp:heading {"level":2} --><h2>Schwerpunkte der Waldorfpaedagogik</h2><!-- /wp:heading -->' .
		'<!-- wp:columns {"className":"grid"} --><div class="wp-block-columns grid">' .
		'<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>Unterste Sinne staerken</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"small"} --><p class="small">Tast-, Bewegungs-, Gleichgewichts- und Lebenssinn</p><!-- /wp:paragraph --><!-- wp:list {"className":"list"} --><ul class="list"><li>Freies Spiel mit Naturmaterialien, Matschecke, Backen, Kneten</li><li>Finger- und Ballspiele, Balancieren, Klettern, Schaukeln</li><li>Raeume in warmen Farben, klare Tagesrhythmen fuer Behaglichkeit</li></ul><!-- /wp:list --></div><!-- /wp:column -->' .
		'<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>Naturverbundenheit</h3><!-- /wp:heading --><!-- wp:list {"className":"list"} --><ul class="list"><li>Waldtag jede Woche: Erde, Wasser, Wind und Jahreszeiten erleben</li><li>Feiern im Jahreslauf: Johanni, Erntedank, Michaeli u.a.</li><li>Bewegung und Sinneserfahrung draussen: Klettern, Balancieren, Rollen</li></ul><!-- /wp:list --></div><!-- /wp:column -->' .
		'<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>Schulkindfoerderung</h3><!-- /wp:heading --><!-- wp:list {"className":"list"} --><ul class="list"><li>Zweiter Waldtag mit Kraeuter sammeln und Beobachten</li><li>Weben, Schnitzen, Tischpuppen- und Marionettenspiele, Leier/Harfenspiel</li><li>Soziale Verantwortung: Grosse helfen Kleinen, Dienste fuer die Gemeinschaft</li></ul><!-- /wp:list --></div><!-- /wp:column -->' .
		'</div><!-- /wp:columns -->' .
		'</section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
		'<section class="wp-block-group panel">' .
		'<!-- wp:heading {"level":2} --><h2>Weitere Angebote</h2><!-- /wp:heading -->' .
		'<!-- wp:list {"className":"list"} --><ul class="list"><li>Elternfortbildungen: Themenabende, kuenstlerische und handwerkliche Kurse</li><li>Einzelberatung nach Vereinbarung, wenn Alltag oder Krisen belasten</li><li>E-Mail oder Telefon fuer Termine: <a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a>, 06126/92141</li></ul><!-- /wp:list -->' .
		'</section><!-- /wp:group -->';
}

function waldorf_idstein_migrate_gruppen_page_to_blocks() {
	if ( (int) get_option( 'waldorf_idstein_gruppen_blocks_version', 0 ) >= 1 ) {
		return;
	}

	$page = get_page_by_path( 'gruppen' );

	if ( ! $page ) {
		return;
	}

	$content = (string) get_post_field( 'post_content', $page->ID );

	if ( false === strpos( $content, '<section class="intro">' ) && false === strpos( $content, '<section class="panel">' ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => waldorf_idstein_gruppen_page_block_content(),
		)
	);

	update_option( 'waldorf_idstein_gruppen_blocks_version', 1 );
}
add_action( 'init', 'waldorf_idstein_migrate_gruppen_page_to_blocks', 37 );

function waldorf_idstein_impressum_page_block_content() {
	return
		'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
		'<section class="wp-block-group panel">' .
		'<!-- wp:heading {"level":1} --><h1>Impressum</h1><!-- /wp:heading -->' .
		'<!-- wp:heading {"level":2} --><h2>Herausgeber</h2><!-- /wp:heading -->' .
		'<!-- wp:paragraph --><p>Verein zur Foerderung des Waldorfkindergartens Idstein e.V.<br>Limburger Strasse 79<br>65510 Idstein</p><!-- /wp:paragraph -->' .
		'<!-- wp:paragraph --><p>Telefon 06126-92141 (Mo-Do 12:30-13:30 Uhr, Mi 9:00-12:00 Uhr)<br><a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a><br><a href="http://www.waldorfkindergarten-idstein.de">www.waldorfkindergarten-idstein.de</a></p><!-- /wp:paragraph -->' .
		'<!-- wp:paragraph --><p>Vereinsregister: Amtsgericht Idstein VR 5056</p><!-- /wp:paragraph -->' .
		'<!-- wp:heading {"level":2} --><h2>Vorstand</h2><!-- /wp:heading -->' .
		'<!-- wp:list {"className":"list"} --><ul class="list"><li><strong>Geschaeftsfuehrerin:</strong> Monika Igl</li><li><strong>Geschaeftsfuehrender Vorstand:</strong> Kristina Falke, Diana Pietsch, Barbara Simon, Janka Steininger</li><li><strong>Paedagogische Vorstandsmitglieder:</strong> Nicola Kirberg, Christel Claassen</li></ul><!-- /wp:list -->' .
		'<!-- wp:heading {"level":2} --><h2>Haftung / Nutzung</h2><!-- /wp:heading -->' .
		'<!-- wp:paragraph --><p>Der Waldorfkindergarten Idstein uebernimmt keine Gewaehrleistung und keine Haftung im Zusammenhang mit der Nutzung dieser Website oder fuer indirekte, zufaellige oder Folgeschaeden. Alle Informationen werden nach bestem Wissen zur Verfuegung gestellt; eine Garantie fuer Vollstaendigkeit, Richtigkeit und Aktualitaet kann nicht uebernommen werden. Angaben nach § 6 TDG und rechtliche Hinweise koennen jederzeit geaendert werden. Wir sind grundsaetzlich nicht bereit und nicht verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p><!-- /wp:paragraph -->' .
		'<!-- wp:heading {"level":2} --><h2>Warenzeichen</h2><!-- /wp:heading -->' .
		'<!-- wp:paragraph --><p>Alle erwaehnten Markenrechte stehen dem jeweiligen Rechtsinhaber zu. Die Publikation darf nur zu Informationszwecken genutzt, nicht veraendert und nicht zu gewerblichen oder politischen Zwecken verbreitet werden. Copyright-Hinweise sind auf jeder Kopie zu erhalten. Alle Rechte vorbehalten.</p><!-- /wp:paragraph -->' .
		'</section><!-- /wp:group -->';
}

function waldorf_idstein_migrate_impressum_page_to_blocks() {
	if ( (int) get_option( 'waldorf_idstein_impressum_blocks_version', 0 ) >= 1 ) {
		return;
	}

	$page = get_page_by_path( 'impressum' );

	if ( ! $page ) {
		return;
	}

	$content = (string) get_post_field( 'post_content', $page->ID );

	if ( false === strpos( $content, '<section class="panel">' ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => waldorf_idstein_impressum_page_block_content(),
		)
	);

	update_option( 'waldorf_idstein_impressum_blocks_version', 1 );
}
add_action( 'init', 'waldorf_idstein_migrate_impressum_page_to_blocks', 38 );

function waldorf_idstein_datenschutz_page_block_content() {
	return
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":1} --><h1>Datenschutzerklaerung</h1><!-- /wp:heading --><!-- wp:paragraph --><p>Wir freuen uns ueber Ihr Interesse an unserem Kindergarten. Datenschutz hat einen besonders hohen Stellenwert fuer die Geschaeftsleitung der Verein zur Foerderung des Waldorfkindergartens Idstein e.V. Die Nutzung unserer Website ist grundsaetzlich ohne Angabe personenbezogener Daten moeglich. Sofern besondere Services in Anspruch genommen werden, kann eine Verarbeitung personenbezogener Daten erforderlich werden. In diesem Fall holen wir, sofern keine gesetzliche Grundlage besteht, eine Einwilligung der betroffenen Person ein.</p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Verantwortlicher</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Verein zur Foerderung des Waldorfkindergartens Idstein e.V.<br>Limburger Strasse 79, 65510 Idstein<br>Tel.: 06126-92141 · <a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a><br><a href="http://www.waldorfkindergarten-idstein.de">www.waldorfkindergarten-idstein.de</a></p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Erhebung und Zweck</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Beim Aufruf unserer Seiten werden serverseitig u.a. Browsertyp, Betriebssystem, Referrer, Datum/Uhrzeit, IP-Adresse, ISP und abgerufene Unterseiten protokolliert. Eine Zuordnung zu einer Person erfolgt nicht. Die Daten dienen der Auslieferung von Inhalten, der technischen Stabilitaet, der Optimierung und zur Strafverfolgung im Falle von Angriffen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Rechtsgrundlagen</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Die Verarbeitung erfolgt je nach Zweck auf Basis von Art. 6 Abs. 1 lit. a DS-GVO (Einwilligung), lit. b (Vertrag/Vorvertrag), lit. c (rechtliche Verpflichtung), lit. d (lebenswichtige Interessen) oder lit. f (berechtigtes Interesse).</p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Speicherdauer</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Personenbezogene Daten werden nur solange gespeichert, wie es der Zweck oder gesetzliche Aufbewahrungsfristen erfordern. Entfaellt der Zweck oder laeuft die Frist ab, werden Daten geloescht oder gesperrt.</p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Ihre Rechte</h2><!-- /wp:heading --><!-- wp:list {"className":"list"} --><ul class="list"><li>Bestaetigung, ob Daten verarbeitet werden</li><li>Auskunft ueber gespeicherte Daten und Empfaenger</li><li>Berichtigung unrichtiger oder Vervollstaendigung unvollstaendiger Daten</li><li>Loeschung oder Einschraenkung der Verarbeitung im Rahmen gesetzlicher Vorgaben</li><li>Widerspruch gegen Verarbeitung auf Basis von Art. 6 Abs. 1 lit. e/f DS-GVO</li><li>Datenuebertragbarkeit (Art. 20 DS-GVO)</li><li>Widerruf erteilter Einwilligungen mit Wirkung fuer die Zukunft</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Zur Ausuebung Ihrer Rechte koennen Sie sich jederzeit an uns wenden.</p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Bewerbungen</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Uebermittelte Bewerbungsunterlagen verarbeiten wir zum Zweck der Abwicklung des Bewerbungsverfahrens. Bei Absage loeschen wir die Unterlagen zwei Monate nach Bescheid, sofern keine berechtigten Interessen entgegenstehen (z.B. Beweispflicht nach AGG). Bei Einstellung werden die Daten fuer das Beschaeftigungsverhaeltnis verarbeitet.</p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Keine automatisierte Entscheidungsfindung</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Wir setzen keine automatisierten Entscheidungen einschliesslich Profiling ein.</p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Bereitstellung von Daten</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Die Bereitstellung personenbezogener Daten kann gesetzlich oder vertraglich erforderlich sein oder zum Abschluss eines Vertrages notwendig werden. Ohne Bereitstellung kann ein Vertragsabschluss ggf. nicht erfolgen. Wir informieren im Einzelfall ueber Pflichtangaben.</p><!-- /wp:paragraph --></section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} --><section class="wp-block-group panel"><!-- wp:heading {"level":2} --><h2>Hinweis zur Streitbeilegung</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Wir sind nicht bereit und nicht verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->';
}

function waldorf_idstein_migrate_datenschutz_page_to_blocks() {
	if ( (int) get_option( 'waldorf_idstein_datenschutz_blocks_version', 0 ) >= 1 ) {
		return;
	}

	$page = null;

	foreach ( array( 'datenschutz', 'datenschutz-2' ) as $slug ) {
		$page = get_page_by_path( $slug );

		if ( $page ) {
			break;
		}
	}

	if ( ! $page ) {
		return;
	}

	$content = (string) get_post_field( 'post_content', $page->ID );

	if ( false === strpos( $content, '<section class="panel">' ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => waldorf_idstein_datenschutz_page_block_content(),
		)
	);

	update_option( 'waldorf_idstein_datenschutz_blocks_version', 1 );
}
add_action( 'init', 'waldorf_idstein_migrate_datenschutz_page_to_blocks', 39 );

function waldorf_idstein_intern_page_block_content() {
	return
		'<!-- wp:group {"tagName":"section","className":"intro"} -->' .
		'<section class="wp-block-group intro">' .
		'<!-- wp:paragraph {"className":"badge"} --><p class="badge">Intern</p><!-- /wp:paragraph -->' .
		'<!-- wp:heading {"level":1} --><h1>Interner Bereich</h1><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"lede"} --><p class="lede">Hier stellen wir Elternbriefe und Materialien fuer unsere Familien bereit. Bitte melden Sie sich im Buero, wenn Sie aktuelle Unterlagen per E-Mail erhalten moechten.</p><!-- /wp:paragraph -->' .
		'</section><!-- /wp:group -->' .
		'<!-- wp:group {"tagName":"section","className":"panel"} -->' .
		'<section class="wp-block-group panel">' .
		'<!-- wp:heading {"level":2} --><h2>Kontakt fuer Elternunterlagen</h2><!-- /wp:heading -->' .
		'<!-- wp:paragraph {"className":"contact"} --><p class="contact">Telefon 06126-92141 (Mo-Do 12:30-13:30 Uhr, Mi 9:00-12:00 Uhr)<br><a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a></p><!-- /wp:paragraph -->' .
		'<!-- wp:paragraph {"className":"note"} --><p class="note">Auf Wunsch senden wir Ihnen die neuesten Elternbriefe und Materialien digital zu.</p><!-- /wp:paragraph -->' .
		'</section><!-- /wp:group -->';
}

function waldorf_idstein_migrate_intern_page_to_blocks() {
	if ( (int) get_option( 'waldorf_idstein_intern_blocks_version', 0 ) >= 1 ) {
		return;
	}

	$page = null;

	foreach ( array( 'intern', 'intern-2' ) as $slug ) {
		$page = get_page_by_path( $slug );

		if ( $page ) {
			break;
		}
	}

	if ( ! $page ) {
		return;
	}

	$content = (string) get_post_field( 'post_content', $page->ID );

	if ( false === strpos( $content, '<section class="intro">' ) && false === strpos( $content, '<section class="panel">' ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => waldorf_idstein_intern_page_block_content(),
		)
	);

	update_option( 'waldorf_idstein_intern_blocks_version', 1 );
}
add_action( 'init', 'waldorf_idstein_migrate_intern_page_to_blocks', 40 );

function waldorf_idstein_update_post_menu_labels() {
	global $menu, $submenu;

	if ( ! is_array( $menu ) || ! is_array( $submenu ) ) {
		return;
	}

	foreach ( $menu as $index => $item ) {
		if ( isset( $item[2] ) && 'edit.php' === $item[2] ) {
			$menu[ $index ][0] = 'Aktuelles';
		}
	}

	if ( isset( $submenu['edit.php'] ) ) {
		$submenu['edit.php'][5][0]  = 'Alle Neuigkeiten';
		$submenu['edit.php'][10][0] = 'Neu hinzufügen';
	}
}
add_action( 'admin_menu', 'waldorf_idstein_update_post_menu_labels' );

function waldorf_idstein_fallback_news_items() {
	return array(
		array(
			'title'       => 'Kennenlerntag · 6. Oktober',
			'description' => '14:00–16:00 Uhr im Kindergarten. Führung, Einblicke, Zeit für Ihre Fragen. Anmeldung per E-Mail oder Telefon bis 04.10.',
			'url'         => 'mailto:info@waldorfkindergarten-idstein.de',
			'label'       => 'Jetzt anmelden',
		),
		array(
			'title'       => 'Kindersachen-Flohmarkt · 14. Oktober',
			'description' => '13:00–16:00 Uhr, Schwangere ab 12:30. Faire Kleidung, Spielzeug, Familienbedarf.',
			'url'         => 'mailto:michelle.kirberg@outlook.de',
			'label'       => 'Stand reservieren',
		),
		array(
			'title'       => 'Wir suchen Erzieher:innen',
			'description' => 'Teilzeit, staatlich anerkannt, Herz für Waldorfpädagogik. Familienähnliche Gruppen, wertschätzendes Team.',
			'url'         => 'mailto:info@waldorfkindergarten-idstein.de',
			'label'       => 'Bewerbung senden',
		),
	);
}

function waldorf_idstein_seed_news_posts() {
	if ( (int) get_option( 'waldorf_idstein_news_seed_version', 0 ) >= 1 ) {
		return;
	}

	foreach ( waldorf_idstein_fallback_news_items() as $item ) {
		$slug     = sanitize_title( remove_accents( $item['title'] ) );
		$existing = get_page_by_path( $slug, OBJECT, 'post' );
		$content  = '<p>' . esc_html( $item['description'] ) . '</p>';

		if ( false !== strpos( $item['url'], 'mailto:' ) ) {
			$email   = trim( str_replace( 'mailto:', '', $item['url'] ) );
			$content .= '<p><a href="' . esc_url( $item['url'] ) . '">' . esc_html( $email ) . '</a></p>';
		}

		$postarr = array(
			'post_type'    => 'post',
			'post_status'  => 'publish',
			'post_title'   => $item['title'],
			'post_name'    => $slug,
			'post_excerpt' => $item['description'],
			'post_content' => $content,
		);

		if ( $existing ) {
			$postarr['ID'] = $existing->ID;
			wp_update_post( wp_slash( $postarr ) );
		} else {
			wp_insert_post( wp_slash( $postarr ) );
		}
	}

	update_option( 'waldorf_idstein_news_seed_version', 1 );
}
add_action( 'init', 'waldorf_idstein_seed_news_posts', 25 );

function waldorf_idstein_render_news_panel_html() {
	$exclude_ids = array();

	foreach ( array( 'hello-world', 'hallo-welt' ) as $slug ) {
		$sample_post = get_page_by_path( $slug, OBJECT, 'post' );

		if ( $sample_post ) {
			$exclude_ids[] = (int) $sample_post->ID;
		}
	}

	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
			'post__not_in'        => $exclude_ids,
		)
	);

	ob_start();
	?>
	<div class="panel news-panel">
		<h2>Aktuelles</h2>
		<div class="card-grid">
			<?php if ( $query->have_posts() ) : ?>
				<?php while ( $query->have_posts() ) : ?>
					<?php
					$query->the_post();
					$excerpt = get_the_excerpt();

					if ( '' === trim( $excerpt ) ) {
						$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 24 );
					}
					?>
					<article class="card news-card">
						<p class="news-date-badge"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></p>
						<h3><?php the_title(); ?></h3>
						<p><?php echo esc_html( $excerpt ); ?></p>
						<a class="link" href="<?php the_permalink(); ?>">Mehr erfahren →</a>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( waldorf_idstein_fallback_news_items() as $item ) : ?>
					<article class="card news-card">
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['description'] ); ?></p>
						<a class="link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?> →</a>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
	<?php

	return trim( (string) ob_get_clean() );
}

function waldorf_idstein_replace_frontpage_news_panel( $content ) {
	if ( is_admin() || ! is_front_page() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( false === strpos( $content, 'class="hero"' ) ) {
		return $content;
	}

	$replacement = waldorf_idstein_render_news_panel_html();

	if ( '' === $replacement ) {
		return $content;
	}

	libxml_use_internal_errors( true );

	$document = new DOMDocument( '1.0', 'UTF-8' );
	$loaded   = $document->loadHTML(
		'<?xml encoding="utf-8" ?><div id="waldorf-root">' . $content . '</div>',
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);

	if ( ! $loaded ) {
		libxml_clear_errors();
		return $content;
	}

	$xpath = new DOMXPath( $document );
	$hero  = $xpath->query( '//*[contains(concat(" ", normalize-space(@class), " "), " hero ")]' )->item( 0 );

	if ( ! $hero ) {
		libxml_clear_errors();
		return $content;
	}

	$existing_panel = null;

	foreach ( $hero->childNodes as $child ) {
		if ( XML_ELEMENT_NODE !== $child->nodeType ) {
			continue;
		}

		$class_name = $child->attributes?->getNamedItem( 'class' )?->nodeValue ?? '';

		if ( false !== strpos( ' ' . $class_name . ' ', ' panel ' ) ) {
			$existing_panel = $child;
			break;
		}
	}

	$fragment_document = new DOMDocument( '1.0', 'UTF-8' );
	$fragment_loaded   = $fragment_document->loadHTML(
		'<?xml encoding="utf-8" ?>' . $replacement,
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);

	if ( ! $fragment_loaded ) {
		libxml_clear_errors();
		return $content;
	}

	$nodes = array();

	foreach ( $fragment_document->childNodes as $node ) {
		if ( XML_PI_NODE === $node->nodeType ) {
			continue;
		}

		$nodes[] = $document->importNode( $node, true );
	}

	if ( empty( $nodes ) ) {
		libxml_clear_errors();
		return $content;
	}

	if ( $existing_panel ) {
		$hero->replaceChild( $nodes[0], $existing_panel );

		for ( $index = 1; $index < count( $nodes ); $index++ ) {
			$hero->appendChild( $nodes[ $index ] );
		}
	} else {
		foreach ( $nodes as $node ) {
			$hero->appendChild( $node );
		}
	}

	$root = $document->getElementById( 'waldorf-root' );
	$html = '';

	if ( $root ) {
		foreach ( $root->childNodes as $child ) {
			$html .= $document->saveHTML( $child );
		}
	}

	libxml_clear_errors();

	return '' !== $html ? $html : $content;
}
add_filter( 'the_content', 'waldorf_idstein_replace_frontpage_news_panel', 20 );

function waldorf_idstein_contact_form_target_url() {
	$page = get_page_by_path( 'kontakt' );

	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/kontakt/' );
}

function waldorf_idstein_application_form_target_url() {
	foreach ( array( 'formulare', 'formulare-2', 'downloads' ) as $slug ) {
		$page = get_page_by_path( $slug );

		if ( $page ) {
			return get_permalink( $page );
		}
	}

	return home_url( '/formulare/' );
}

function waldorf_idstein_is_application_page() {
	if ( ! is_page() ) {
		return false;
	}

	$post = get_queried_object();

	if ( ! $post instanceof WP_Post ) {
		return false;
	}

	return in_array( $post->post_name, array( 'formulare', 'formulare-2', 'downloads' ), true ) || 'Downloads' === get_the_title( $post );
}

function waldorf_idstein_application_form_enabled() {
	return '1' === get_option( 'waldorf_idstein_application_form_enabled', '0' );
}

function waldorf_idstein_register_theme_settings() {
	register_setting(
		'general',
		'waldorf_idstein_application_form_enabled',
		array(
			'type'              => 'string',
			'sanitize_callback' => static function ( $value ) {
				return '1' === (string) $value ? '1' : '0';
			},
			'default'           => '0',
		)
	);

	add_settings_field(
		'waldorf_idstein_application_form_enabled',
		'Anmeldeformular aktiv',
		'waldorf_idstein_render_application_form_setting',
		'general'
	);
}
add_action( 'admin_init', 'waldorf_idstein_register_theme_settings' );

function waldorf_idstein_render_application_form_setting() {
	?>
	<label for="waldorf_idstein_application_form_enabled">
		<input id="waldorf_idstein_application_form_enabled" name="waldorf_idstein_application_form_enabled" type="checkbox" value="1" <?php checked( waldorf_idstein_application_form_enabled() ); ?>>
		Online-Anmeldeformular auf der Formular-Seite anzeigen
	</label>
	<p class="description">Wenn aktiviert, erscheint unter Downloads/Formulare ein Formular für neue Anfragen.</p>
	<?php
}

function waldorf_idstein_handle_contact_form() {
	if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
		return;
	}

	if ( empty( $_POST['action'] ) || 'waldorf_contact_form' !== $_POST['action'] ) {
		return;
	}

	$redirect_url = waldorf_idstein_contact_form_target_url();

	if ( ! isset( $_POST['waldorf_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['waldorf_contact_nonce'] ) ), 'waldorf_contact_form' ) ) {
		wp_safe_redirect( add_query_arg( 'contact_status', 'invalid', $redirect_url ) );
		exit;
	}

	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact_status', 'success', $redirect_url ) );
		exit;
	}

	$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$phone   = isset( $_POST['contact_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) ) : '';
	$message = isset( $_POST['contact_message'] ) ? trim( wp_unslash( $_POST['contact_message'] ) ) : '';

	if ( '' === $name || '' === $message || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'contact_status', 'invalid', $redirect_url ) );
		exit;
	}

	$subject = sprintf( 'Kontaktformular: %s', $name );
	$body    = array(
		'Neue Nachricht über das Kontaktformular der Website.',
		'',
		'Name: ' . $name,
		'E-Mail: ' . $email,
		'Telefon: ' . ( '' !== $phone ? $phone : '-' ),
		'',
		'Nachricht:',
		wp_strip_all_tags( $message ),
	);

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( 'info@waldorfkindergarten-idstein.de', $subject, implode( "\n", $body ), $headers );

	wp_safe_redirect( add_query_arg( 'contact_status', $sent ? 'success' : 'error', $redirect_url ) );
		exit;
}
add_action( 'template_redirect', 'waldorf_idstein_handle_contact_form' );

function waldorf_idstein_handle_application_form() {
	if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
		return;
	}

	if ( empty( $_POST['action'] ) || 'waldorf_application_form' !== $_POST['action'] ) {
		return;
	}

	$redirect_url = waldorf_idstein_application_form_target_url();

	if ( ! isset( $_POST['waldorf_application_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['waldorf_application_nonce'] ) ), 'waldorf_application_form' ) ) {
		wp_safe_redirect( add_query_arg( 'application_status', 'invalid', $redirect_url ) );
		exit;
	}

	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'application_status', 'success', $redirect_url ) );
		exit;
	}

	$child_name     = isset( $_POST['child_name'] ) ? sanitize_text_field( wp_unslash( $_POST['child_name'] ) ) : '';
	$child_birth    = isset( $_POST['child_birthdate'] ) ? sanitize_text_field( wp_unslash( $_POST['child_birthdate'] ) ) : '';
	$desired_start  = isset( $_POST['desired_start'] ) ? sanitize_text_field( wp_unslash( $_POST['desired_start'] ) ) : '';
	$group_interest = isset( $_POST['group_interest'] ) ? sanitize_text_field( wp_unslash( $_POST['group_interest'] ) ) : '';
	$parent_names   = isset( $_POST['parent_names'] ) ? sanitize_text_field( wp_unslash( $_POST['parent_names'] ) ) : '';
	$email          = isset( $_POST['application_email'] ) ? sanitize_email( wp_unslash( $_POST['application_email'] ) ) : '';
	$phone          = isset( $_POST['application_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['application_phone'] ) ) : '';
	$message        = isset( $_POST['application_message'] ) ? trim( wp_unslash( $_POST['application_message'] ) ) : '';
	$consent        = ! empty( $_POST['application_consent'] );

	if ( '' === $child_name || '' === $parent_names || '' === $desired_start || ! is_email( $email ) || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'application_status', 'invalid', $redirect_url ) );
		exit;
	}

	$subject = sprintf( 'Anfrage zur Anmeldung: %s', $child_name );
	$body    = array(
		'Neue Anfrage über das Online-Anmeldeformular.',
		'',
		'Kind: ' . $child_name,
		'Geburtsdatum: ' . ( '' !== $child_birth ? $child_birth : '-' ),
		'Gewünschter Start: ' . $desired_start,
		'Interesse an Gruppe: ' . ( '' !== $group_interest ? $group_interest : '-' ),
		'Eltern/Erziehungsberechtigte: ' . $parent_names,
		'E-Mail: ' . $email,
		'Telefon: ' . ( '' !== $phone ? $phone : '-' ),
		'',
		'Nachricht:',
		'' !== $message ? wp_strip_all_tags( $message ) : '-',
	);

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $parent_names . ' <' . $email . '>',
	);

	$sent = wp_mail( 'info@waldorfkindergarten-idstein.de', $subject, implode( "\n", $body ), $headers );

	wp_safe_redirect( add_query_arg( 'application_status', $sent ? 'success' : 'error', $redirect_url ) );
		exit;
}
add_action( 'template_redirect', 'waldorf_idstein_handle_application_form' );

function waldorf_idstein_contact_form_notice() {
	$status = isset( $_GET['contact_status'] ) ? sanitize_key( wp_unslash( $_GET['contact_status'] ) ) : '';

	if ( '' === $status ) {
		return '';
	}

	if ( 'success' === $status ) {
		return '<p class="form-message form-message-success">Vielen Dank. Ihre Nachricht wurde versendet.</p>';
	}

	if ( 'invalid' === $status ) {
		return '<p class="form-message form-message-error">Bitte prüfen Sie Ihre Eingaben und versuchen Sie es erneut.</p>';
	}

	return '<p class="form-message form-message-error">Die Nachricht konnte gerade nicht versendet werden. Bitte versuchen Sie es später erneut.</p>';
}

function waldorf_idstein_render_contact_form() {
	$action_url = esc_url( waldorf_idstein_contact_form_target_url() );
	$notice     = waldorf_idstein_contact_form_notice();

	ob_start();
	?>
	<section class="panel contact-form-panel">
		<h2>Nachricht senden</h2>
		<p>Gerne können Sie uns direkt über das Formular schreiben. Wir melden uns schnellstmöglich zurück.</p>
		<?php if ( '' !== $notice ) : ?>
			<?php echo $notice; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>
		<form class="contact-form" method="post" action="<?php echo $action_url; ?>">
			<div class="form-grid">
				<p class="form-field">
					<label for="contact_name">Name</label>
					<input id="contact_name" name="contact_name" type="text" required>
				</p>
				<p class="form-field">
					<label for="contact_email">E-Mail</label>
					<input id="contact_email" name="contact_email" type="email" required>
				</p>
				<p class="form-field form-field-wide">
					<label for="contact_phone">Telefon optional</label>
					<input id="contact_phone" name="contact_phone" type="text">
				</p>
				<p class="form-field form-field-honeypot" aria-hidden="true">
					<label for="website">Website</label>
					<input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
				</p>
				<p class="form-field form-field-wide">
					<label for="contact_message">Nachricht</label>
					<textarea id="contact_message" name="contact_message" rows="6" required></textarea>
				</p>
			</div>
			<input type="hidden" name="action" value="waldorf_contact_form">
			<?php wp_nonce_field( 'waldorf_contact_form', 'waldorf_contact_nonce' ); ?>
			<p class="form-actions">
				<button class="button" type="submit">Nachricht senden</button>
			</p>
		</form>
	</section>
	<?php

	return trim( (string) ob_get_clean() );
}

function waldorf_idstein_append_contact_form( $content ) {
	if ( is_admin() || ! is_page() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( ! is_page( 'kontakt' ) ) {
		return $content;
	}

	return $content . "\n" . waldorf_idstein_render_contact_form();
}
add_filter( 'the_content', 'waldorf_idstein_append_contact_form', 30 );

function waldorf_idstein_application_form_notice() {
	$status = isset( $_GET['application_status'] ) ? sanitize_key( wp_unslash( $_GET['application_status'] ) ) : '';

	if ( '' === $status ) {
		return '';
	}

	if ( 'success' === $status ) {
		return '<p class="form-message form-message-success">Vielen Dank. Ihre Anfrage wurde versendet.</p>';
	}

	if ( 'invalid' === $status ) {
		return '<p class="form-message form-message-error">Bitte füllen Sie die Pflichtfelder aus und bestätigen Sie die Datenschutzhinweise.</p>';
	}

	return '<p class="form-message form-message-error">Die Anfrage konnte gerade nicht versendet werden. Bitte versuchen Sie es später erneut.</p>';
}

function waldorf_idstein_render_application_form() {
	$action_url = esc_url( waldorf_idstein_application_form_target_url() );
	$notice     = waldorf_idstein_application_form_notice();

	ob_start();
	?>
	<section class="panel application-form-panel">
		<h2>Online-Anfrage zur Anmeldung</h2>
		<p>Wenn Sie sich für einen Platz interessieren, können Sie uns Ihre Anfrage direkt online senden. Wir melden uns anschließend bei Ihnen.</p>
		<?php if ( '' !== $notice ) : ?>
			<?php echo $notice; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>
		<form class="contact-form application-form" method="post" action="<?php echo $action_url; ?>">
			<div class="form-grid">
				<p class="form-field">
					<label for="child_name">Name des Kindes</label>
					<input id="child_name" name="child_name" type="text" required>
				</p>
				<p class="form-field">
					<label for="child_birthdate">Geburtsdatum</label>
					<input id="child_birthdate" name="child_birthdate" type="date">
				</p>
				<p class="form-field">
					<label for="desired_start">Gewünschter Start</label>
					<input id="desired_start" name="desired_start" type="text" placeholder="z. B. August 2027" required>
				</p>
				<p class="form-field">
					<label for="group_interest">Gewünschte Gruppe optional</label>
					<select id="group_interest" name="group_interest">
						<option value="">Bitte wählen</option>
						<option value="Familiengruppe">Familiengruppe</option>
						<option value="Wiegenstube">Wiegenstube</option>
						<option value="Noch offen">Noch offen</option>
					</select>
				</p>
				<p class="form-field form-field-wide">
					<label for="parent_names">Eltern / Erziehungsberechtigte</label>
					<input id="parent_names" name="parent_names" type="text" required>
				</p>
				<p class="form-field">
					<label for="application_email">E-Mail</label>
					<input id="application_email" name="application_email" type="email" required>
				</p>
				<p class="form-field">
					<label for="application_phone">Telefon</label>
					<input id="application_phone" name="application_phone" type="text">
				</p>
				<p class="form-field form-field-honeypot" aria-hidden="true">
					<label for="website_application">Website</label>
					<input id="website_application" name="website" type="text" tabindex="-1" autocomplete="off">
				</p>
				<p class="form-field form-field-wide">
					<label for="application_message">Weitere Informationen optional</label>
					<textarea id="application_message" name="application_message" rows="6"></textarea>
				</p>
				<p class="form-field form-field-wide form-consent-field">
					<label class="checkbox-label" for="application_consent">
						<input id="application_consent" name="application_consent" type="checkbox" value="1" required>
						<span>Ich stimme der Verarbeitung meiner Angaben zur Bearbeitung der Anfrage zu.</span>
					</label>
				</p>
			</div>
			<input type="hidden" name="action" value="waldorf_application_form">
			<?php wp_nonce_field( 'waldorf_application_form', 'waldorf_application_nonce' ); ?>
			<p class="form-actions">
				<button class="button" type="submit">Anfrage senden</button>
			</p>
		</form>
	</section>
	<?php

	return trim( (string) ob_get_clean() );
}

function waldorf_idstein_append_application_form( $content ) {
	if ( is_admin() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( ! waldorf_idstein_application_form_enabled() || ! waldorf_idstein_is_application_page() ) {
		return $content;
	}

	return $content . "\n" . waldorf_idstein_render_application_form();
}
add_filter( 'the_content', 'waldorf_idstein_append_application_form', 31 );

function waldorf_idstein_page_aliases() {
	return array(
		'start'                => array( 'start', 'start-2' ),
		'gruppen'              => array( 'gruppen' ),
		'anmeldung-formulare'  => array( 'anmeldung-formulare', 'formulare', 'formulare-2', 'downloads' ),
		'kontakt'              => array( 'kontakt' ),
		'impressum'            => array( 'impressum' ),
		'datenschutz'          => array( 'datenschutz', 'datenschutz-2' ),
		'intern'               => array( 'intern', 'intern-2' ),
		'aktuelles'            => array( 'aktuelles' ),
	);
}

function waldorf_idstein_find_page( $slug ) {
	$aliases = waldorf_idstein_page_aliases();
	$candidates = $aliases[ $slug ] ?? array( $slug );

	foreach ( $candidates as $candidate ) {
		$page = get_page_by_path( $candidate );

		if ( $page ) {
			return $page;
		}
	}

	return null;
}

function waldorf_idstein_page_url( $slug ) {
	$page = waldorf_idstein_find_page( $slug );

	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/' . trim( $slug, '/' ) . '/' );
}

function waldorf_idstein_default_menu_items() {
	return array(
		array(
			'label' => 'Start',
			'url'   => home_url( '/' ),
		),
		array(
			'label' => 'Gruppen',
			'url'   => waldorf_idstein_page_url( 'gruppen' ),
		),
		array(
			'label' => 'Anmeldung',
			'url'   => waldorf_idstein_page_url( 'anmeldung-formulare' ),
		),
		array(
			'label' => 'Kontakt',
			'url'   => waldorf_idstein_page_url( 'kontakt' ),
		),
	);
}

function waldorf_idstein_news_archive_url() {
	return waldorf_idstein_page_url( 'aktuelles' );
}

function waldorf_idstein_render_news_archive_html() {
	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 12,
			'ignore_sticky_posts' => true,
			'post__not_in'        => array_values(
				array_filter(
					array_map(
						static function ( $slug ) {
							$post = get_page_by_path( $slug, OBJECT, 'post' );
							return $post ? (int) $post->ID : 0;
						},
						array( 'hello-world', 'hallo-welt' )
					)
				)
			),
		)
	);

	ob_start();
	?>
	<section class="panel news-panel news-archive-panel">
		<h1>Aktuelles</h1>
		<div class="card-grid">
			<?php if ( $query->have_posts() ) : ?>
				<?php while ( $query->have_posts() ) : ?>
					<?php
					$query->the_post();
					$excerpt = get_the_excerpt();

					if ( '' === trim( $excerpt ) ) {
						$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 28 );
					}
					?>
					<article class="card news-card">
						<p class="news-date-badge"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></p>
						<h3><?php the_title(); ?></h3>
						<p><?php echo esc_html( $excerpt ); ?></p>
						<a class="link" href="<?php the_permalink(); ?>">Mehr erfahren →</a>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p>Noch keine Neuigkeiten vorhanden.</p>
			<?php endif; ?>
		</div>
	</section>
	<?php

	return trim( (string) ob_get_clean() );
}

function waldorf_idstein_replace_news_archive_page( $content ) {
	if ( is_admin() || ! is_page() || ! in_the_loop() || ! is_main_query() || ! is_page( 'aktuelles' ) ) {
		return $content;
	}

	return waldorf_idstein_render_news_archive_html();
}
add_filter( 'the_content', 'waldorf_idstein_replace_news_archive_page', 25 );

function waldorf_idstein_clean_page_structure() {
	if ( (int) get_option( 'waldorf_idstein_page_cleanup_version', 0 ) >= 1 ) {
		return;
	}

	$updates = array(
		array(
			'from'  => 'start-2',
			'title' => 'Start',
			'slug'  => 'start',
		),
		array(
			'from'  => 'formulare-2',
			'title' => 'Anmeldung & Formulare',
			'slug'  => 'anmeldung-formulare',
		),
		array(
			'from'  => 'datenschutz-2',
			'title' => 'Datenschutz',
			'slug'  => 'datenschutz',
		),
		array(
			'from'  => 'intern-2',
			'title' => 'Intern',
			'slug'  => 'intern',
		),
	);

	foreach ( $updates as $update ) {
		$page = get_page_by_path( $update['from'] );

		if ( ! $page ) {
			continue;
		}

		$conflict = get_page_by_path( $update['slug'] );

		if ( $conflict && (int) $conflict->ID !== (int) $page->ID ) {
			continue;
		}

		wp_update_post(
			array(
				'ID'         => $page->ID,
				'post_title' => $update['title'],
				'post_name'  => $update['slug'],
			)
		);
	}

	if ( ! waldorf_idstein_find_page( 'aktuelles' ) ) {
		wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Aktuelles',
				'post_name'    => 'aktuelles',
				'post_content' => '<!-- wp:paragraph --><p>Aktuelle Neuigkeiten aus unserem Kindergarten.</p><!-- /wp:paragraph -->',
			)
		);
	}

	flush_rewrite_rules();
	update_option( 'waldorf_idstein_page_cleanup_version', 1 );
}
add_action( 'init', 'waldorf_idstein_clean_page_structure', 41 );

function waldorf_idstein_normalize_news_posts() {
	if ( (int) get_option( 'waldorf_idstein_news_cleanup_version', 0 ) >= 1 ) {
		return;
	}

	$canonical = array(
		'Kennenlerntag · 6. Oktober'           => 'kennenlerntag-6-oktober',
		'Kindersachen-Flohmarkt · 14. Oktober' => 'kindersachen-flohmarkt-14-oktober',
		'Wir suchen Erzieher:innen'            => 'wir-suchen-erzieherinnen',
	);

	foreach ( $canonical as $title => $slug ) {
		$posts = get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => array( 'publish', 'draft', 'pending', 'future', 'private', 'trash' ),
				'title'          => $title,
				'posts_per_page' => -1,
			)
		);

		if ( empty( $posts ) ) {
			continue;
		}

		$keep = array_shift( $posts );

		foreach ( $posts as $duplicate ) {
			wp_delete_post( $duplicate->ID, true );
		}

		wp_update_post(
			array(
				'ID'        => $keep->ID,
				'post_name' => $slug,
			)
		);
	}

	flush_rewrite_rules();
	update_option( 'waldorf_idstein_news_cleanup_version', 1 );
}
add_action( 'init', 'waldorf_idstein_normalize_news_posts', 42 );

function waldorf_idstein_footer_links() {
	return array(
		array(
			'label' => 'Impressum',
			'url'   => waldorf_idstein_page_url( 'impressum' ),
		),
		array(
			'label' => 'Datenschutz',
			'url'   => waldorf_idstein_page_url( 'datenschutz' ),
		),
		array(
			'label' => 'Intern',
			'url'   => waldorf_idstein_page_url( 'intern' ),
		),
	);
}

function waldorf_idstein_sync_content() {
	if ( (int) get_option( 'waldorf_idstein_content_version', 0 ) >= 2 ) {
		return;
	}

	$start = get_page_by_path( 'start' );

	if ( $start ) {
		wp_update_post(
			array(
				'ID'           => $start->ID,
				'post_content' => <<<'HTML'
<section class="hero">
  <div class="hero-text">
    <p class="badge">Seit 1987 in Elterninitiative</p>
    <h1>Herzlich willkommen im Waldorfkindergarten Idstein</h1>
    <p class="lede">Geborgenheit, Rhythmus und Naturverbundenheit für Kinder ab 1 Jahr. Unsere Familiengruppen bieten Kontinuität vom Krippenalter bis zum Schuleintritt – mit vertrauten Bezugspersonen und einer warmen Tagesstruktur.</p>
    <div class="hero-actions">
      <a class="button" href="mailto:info@waldorfkindergarten-idstein.de">Kontakt aufnehmen</a>
      <a class="ghost" href="/formulare/">Downloads &amp; Formulare</a>
    </div>
    <ul class="tags">
      <li>Familiengruppen (2–6 Jahre)</li>
      <li>Krippe Wiegenstube (1–3 Jahre)</li>
      <li>Waldtag am Freitag</li>
    </ul>
  </div>
  <div class="panel">
    <h2>Aktuelles</h2>
    <div class="card-grid">
      <article class="card">
        <h3>Kennenlerntag · 6. Oktober</h3>
        <p>14:00–16:00 Uhr im Kindergarten. Führung, Einblicke, Zeit für Ihre Fragen. Anmeldung per E-Mail oder Telefon bis 04.10.</p>
        <a class="link" href="mailto:info@waldorfkindergarten-idstein.de">Jetzt anmelden →</a>
      </article>
      <article class="card">
        <h3>Kindersachen-Flohmarkt · 14. Oktober</h3>
        <p>13:00–16:00 Uhr, Schwangere ab 12:30. Faire Kleidung, Spielzeug, Familienbedarf.</p>
        <a class="link" href="mailto:michelle.kirberg@outlook.de">Stand reservieren →</a>
      </article>
      <article class="card">
        <h3>Wir suchen Erzieher:innen</h3>
        <p>Teilzeit, staatlich anerkannt, Herz für Waldorfpädagogik. Familienähnliche Gruppen, wertschätzendes Team.</p>
        <a class="link" href="mailto:info@waldorfkindergarten-idstein.de">Bewerbung senden →</a>
      </article>
    </div>
  </div>
</section>
<section class="rhythm">
  <div>
    <p class="badge">Tagesrhythmus</p>
    <h2>Verlässliche Abläufe geben Sicherheit</h2>
    <p>Wir gestalten den Tag so, dass Kinder durch Nachahmung und Wiederholung lernen. Offenes Spiel, ritualisierte Kreise, gemeinsames Essen und Waldzeit wechseln sich ab – ruhig, überschaubar und liebevoll geführt.</p>
  </div>
  <div class="timeline">
    <div class="time-row"><div class="time">07:30</div><div class="time-text">Ankommen &amp; freies Spiel mit Naturmaterialien (Krippe &amp; Familiengruppen)</div></div>
    <div class="time-row"><div class="time">09:00</div><div class="time-text">Morgenkreis mit Liedern und Reimen zur Jahreszeit</div></div>
    <div class="time-row"><div class="time">09:30</div><div class="time-text">Gemeinsames vollwertiges Frühstück</div></div>
    <div class="time-row"><div class="time">10:00</div><div class="time-text">Garten oder Wald: Bewegung, Sinneserfahrungen, Ruhe (Fr: Waldtag)</div></div>
    <div class="time-row"><div class="time">12:00</div><div class="time-text">Abschlusslied und Abholung der Nestkinder (2 Jahre)</div></div>
    <div class="time-row"><div class="time">12:45</div><div class="time-text">Mittagessen &amp; Märchen/Tischpuppenspiel für die Größeren</div></div>
    <div class="time-row"><div class="time">15:15</div><div class="time-text">Optional: Nachmittagsbetreuung (Mo–Do) mit ruhigem Spiel &amp; Gartenzeit</div></div>
  </div>
</section>
HTML,
			)
		);
	}

	$menu = wp_get_nav_menu_object( 'Hauptnavigation' );

	if ( $menu ) {
		$items = wp_get_nav_menu_items( $menu->term_id );

		if ( $items ) {
			foreach ( $items as $item ) {
				wp_delete_post( $item->ID, true );
			}
		}

		foreach ( waldorf_idstein_default_menu_items() as $item ) {
			wp_update_nav_menu_item(
				$menu->term_id,
				0,
				array(
					'menu-item-title'  => $item['label'],
					'menu-item-url'    => $item['url'],
					'menu-item-type'   => 'custom',
					'menu-item-status' => 'publish',
				)
			);
		}
	}

	update_option( 'waldorf_idstein_content_version', 2 );
}
add_action( 'init', 'waldorf_idstein_sync_content' );
