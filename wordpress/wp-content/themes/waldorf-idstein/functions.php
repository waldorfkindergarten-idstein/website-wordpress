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
