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

function waldorf_idstein_page_url( $slug ) {
	$page = get_page_by_path( $slug );

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
			'label' => 'Downloads',
			'url'   => waldorf_idstein_page_url( 'formulare' ),
		),
		array(
			'label' => 'Kontakt',
			'url'   => waldorf_idstein_page_url( 'kontakt' ),
		),
	);
}

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
