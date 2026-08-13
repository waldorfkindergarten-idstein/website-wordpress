<?php
/**
 * Editor-owned content types.
 *
 * Termine and Team members used to live as hardcoded blocks inside the front
 * page, which meant every correction was a developer task and the hero's
 * "Nächster Termin" could never be anything but a fixed string. They are real
 * content, so they live in real post types that the Verein maintains in
 * wp-admin.
 *
 * @package WaldorfPfirsichbluete
 */

declare( strict_types = 1 );

const WALDORF_PB_CPT_TERMIN   = 'waldorf_termin';
const WALDORF_PB_CPT_PERSON   = 'waldorf_person';
const WALDORF_PB_TAX_TERMINART = 'waldorf_terminart';

const WALDORF_PB_META_TERMIN_VON    = '_waldorf_termin_von';
const WALDORF_PB_META_TERMIN_BIS    = '_waldorf_termin_bis';
const WALDORF_PB_META_TERMIN_DETAIL = '_waldorf_termin_detail';
const WALDORF_PB_META_PERSON_ROLLE  = '_waldorf_person_rolle';
const WALDORF_PB_META_PERSON_MONO   = '_waldorf_person_monogramm';

/**
 * The event categories, as slug => label.
 *
 * "intern" exists so board meetings and staff parties can be kept in the same
 * calendar without ever reaching the public list.
 *
 * @return array<string, string>
 */
function waldorf_pb_terminarten(): array {
	return array(
		'fest'        => __( 'Fest', 'waldorf-pfirsichbluete' ),
		'elternabend' => __( 'Elternabend', 'waldorf-pfirsichbluete' ),
		'ferien'      => __( 'Ferien & Schließtage', 'waldorf-pfirsichbluete' ),
		'intern'      => __( 'Intern', 'waldorf-pfirsichbluete' ),
	);
}

/**
 * Register both post types and the event taxonomy.
 */
function waldorf_pb_register_content_types(): void {
	register_post_type(
		WALDORF_PB_CPT_TERMIN,
		array(
			'labels'            => array(
				'name'               => __( 'Termine', 'waldorf-pfirsichbluete' ),
				'singular_name'      => __( 'Termin', 'waldorf-pfirsichbluete' ),
				'add_new_item'       => __( 'Neuen Termin anlegen', 'waldorf-pfirsichbluete' ),
				'edit_item'          => __( 'Termin bearbeiten', 'waldorf-pfirsichbluete' ),
				'search_items'       => __( 'Termine durchsuchen', 'waldorf-pfirsichbluete' ),
				'not_found'          => __( 'Keine Termine vorhanden.', 'waldorf-pfirsichbluete' ),
				'menu_name'          => __( 'Termine', 'waldorf-pfirsichbluete' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_rest'      => true,
			'menu_position'     => 21,
			'menu_icon'         => 'dashicons-calendar-alt',
			'supports'          => array( 'title' ),
			'has_archive'       => false,
			'rewrite'           => false,
			'query_var'         => false,
		)
	);

	register_taxonomy(
		WALDORF_PB_TAX_TERMINART,
		array( WALDORF_PB_CPT_TERMIN ),
		array(
			'labels'            => array(
				'name'          => __( 'Terminarten', 'waldorf-pfirsichbluete' ),
				'singular_name' => __( 'Terminart', 'waldorf-pfirsichbluete' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => false,
			'query_var'         => false,
		)
	);

	register_post_type(
		WALDORF_PB_CPT_PERSON,
		array(
			'labels'            => array(
				'name'          => __( 'Team', 'waldorf-pfirsichbluete' ),
				'singular_name' => __( 'Teammitglied', 'waldorf-pfirsichbluete' ),
				'add_new_item'  => __( 'Teammitglied hinzufügen', 'waldorf-pfirsichbluete' ),
				'edit_item'     => __( 'Teammitglied bearbeiten', 'waldorf-pfirsichbluete' ),
				'not_found'     => __( 'Noch keine Teammitglieder angelegt.', 'waldorf-pfirsichbluete' ),
				'menu_name'     => __( 'Team', 'waldorf-pfirsichbluete' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_rest'      => true,
			'menu_position'     => 22,
			'menu_icon'         => 'dashicons-groups',
			'supports'          => array( 'title', 'thumbnail', 'page-attributes' ),
			'has_archive'       => false,
			'rewrite'           => false,
			'query_var'         => false,
		)
	);

	$waldorf_pb_string_meta = array(
		WALDORF_PB_CPT_TERMIN => array(
			WALDORF_PB_META_TERMIN_VON,
			WALDORF_PB_META_TERMIN_BIS,
			WALDORF_PB_META_TERMIN_DETAIL,
		),
		WALDORF_PB_CPT_PERSON => array(
			WALDORF_PB_META_PERSON_ROLLE,
			WALDORF_PB_META_PERSON_MONO,
		),
	);

	foreach ( $waldorf_pb_string_meta as $waldorf_pb_type => $waldorf_pb_keys ) {
		foreach ( $waldorf_pb_keys as $waldorf_pb_key ) {
			register_post_meta(
				$waldorf_pb_type,
				$waldorf_pb_key,
				array(
					'type'              => 'string',
					'single'            => true,
					'default'           => '',
					'show_in_rest'      => true,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function (): bool {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
}
add_action( 'init', 'waldorf_pb_register_content_types' );

/**
 * Seed the four event categories once the taxonomy exists.
 */
function waldorf_pb_seed_terminarten(): void {
	foreach ( waldorf_pb_terminarten() as $waldorf_pb_slug => $waldorf_pb_label ) {
		if ( ! term_exists( $waldorf_pb_slug, WALDORF_PB_TAX_TERMINART ) ) {
			wp_insert_term( $waldorf_pb_label, WALDORF_PB_TAX_TERMINART, array( 'slug' => $waldorf_pb_slug ) );
		}
	}
}
add_action( 'init', 'waldorf_pb_seed_terminarten', 11 );

/* -------------------------------------------------------------------------
 * Editing UI
 * ---------------------------------------------------------------------- */

/**
 * Add the meta boxes for both post types.
 */
function waldorf_pb_add_meta_boxes(): void {
	add_meta_box(
		'waldorf-pb-termin',
		__( 'Termindaten', 'waldorf-pfirsichbluete' ),
		'waldorf_pb_render_termin_meta_box',
		WALDORF_PB_CPT_TERMIN,
		'normal',
		'high'
	);
	add_meta_box(
		'waldorf-pb-person',
		__( 'Angaben zur Person', 'waldorf-pfirsichbluete' ),
		'waldorf_pb_render_person_meta_box',
		WALDORF_PB_CPT_PERSON,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'waldorf_pb_add_meta_boxes' );

/**
 * Event fields.
 *
 * @param WP_Post $post Current post.
 */
function waldorf_pb_render_termin_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'waldorf_pb_save_termin', 'waldorf_pb_termin_nonce' );

	$waldorf_pb_von    = (string) get_post_meta( $post->ID, WALDORF_PB_META_TERMIN_VON, true );
	$waldorf_pb_bis    = (string) get_post_meta( $post->ID, WALDORF_PB_META_TERMIN_BIS, true );
	$waldorf_pb_detail = (string) get_post_meta( $post->ID, WALDORF_PB_META_TERMIN_DETAIL, true );
	?>
	<p>
		<label for="waldorf-pb-von"><strong><?php esc_html_e( 'Datum', 'waldorf-pfirsichbluete' ); ?></strong></label><br>
		<input type="date" id="waldorf-pb-von" name="waldorf_pb_von" value="<?php echo esc_attr( $waldorf_pb_von ); ?>" required>
	</p>
	<p>
		<label for="waldorf-pb-bis"><strong><?php esc_html_e( 'Enddatum', 'waldorf-pfirsichbluete' ); ?></strong></label><br>
		<input type="date" id="waldorf-pb-bis" name="waldorf_pb_bis" value="<?php echo esc_attr( $waldorf_pb_bis ); ?>">
		<span class="description"><?php esc_html_e( 'Nur bei mehrtägigen Terminen, z. B. Ferien.', 'waldorf-pfirsichbluete' ); ?></span>
	</p>
	<p>
		<label for="waldorf-pb-detail"><strong><?php esc_html_e( 'Uhrzeit und Hinweis', 'waldorf-pfirsichbluete' ); ?></strong></label><br>
		<input type="text" class="large-text" id="waldorf-pb-detail" name="waldorf_pb_detail" value="<?php echo esc_attr( $waldorf_pb_detail ); ?>"
			placeholder="<?php esc_attr_e( '19:00 Uhr · verbindliche Anmeldung notwendig', 'waldorf-pfirsichbluete' ); ?>">
	</p>
	<?php
}

/**
 * Person fields.
 *
 * @param WP_Post $post Current post.
 */
function waldorf_pb_render_person_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'waldorf_pb_save_person', 'waldorf_pb_person_nonce' );

	$waldorf_pb_rolle = (string) get_post_meta( $post->ID, WALDORF_PB_META_PERSON_ROLLE, true );
	$waldorf_pb_mono  = (string) get_post_meta( $post->ID, WALDORF_PB_META_PERSON_MONO, true );
	?>
	<p>
		<label for="waldorf-pb-rolle"><strong><?php esc_html_e( 'Rolle', 'waldorf-pfirsichbluete' ); ?></strong></label><br>
		<input type="text" class="large-text" id="waldorf-pb-rolle" name="waldorf_pb_rolle" value="<?php echo esc_attr( $waldorf_pb_rolle ); ?>"
			placeholder="<?php esc_attr_e( 'Erzieherin & Gruppenleitung', 'waldorf-pfirsichbluete' ); ?>">
	</p>
	<p>
		<label for="waldorf-pb-mono"><strong><?php esc_html_e( 'Monogramm', 'waldorf-pfirsichbluete' ); ?></strong></label><br>
		<input type="text" id="waldorf-pb-mono" name="waldorf_pb_mono" size="4" maxlength="2" value="<?php echo esc_attr( $waldorf_pb_mono ); ?>">
		<span class="description"><?php esc_html_e( 'Ein bis zwei Buchstaben. Wird nur angezeigt, solange kein Beitragsbild gesetzt ist.', 'waldorf-pfirsichbluete' ); ?></span>
	</p>
	<?php
}

/**
 * Persist both meta boxes.
 *
 * @param int $post_id Post being saved.
 */
function waldorf_pb_save_meta( int $post_id ): void {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$waldorf_pb_nonce = isset( $_POST['waldorf_pb_termin_nonce'] )
		? sanitize_text_field( wp_unslash( $_POST['waldorf_pb_termin_nonce'] ) )
		: '';

	if ( '' !== $waldorf_pb_nonce && wp_verify_nonce( $waldorf_pb_nonce, 'waldorf_pb_save_termin' ) ) {
		foreach ( array(
			'waldorf_pb_von'    => WALDORF_PB_META_TERMIN_VON,
			'waldorf_pb_bis'    => WALDORF_PB_META_TERMIN_BIS,
			'waldorf_pb_detail' => WALDORF_PB_META_TERMIN_DETAIL,
		) as $waldorf_pb_field => $waldorf_pb_key ) {
			$waldorf_pb_value = isset( $_POST[ $waldorf_pb_field ] )
				? sanitize_text_field( wp_unslash( $_POST[ $waldorf_pb_field ] ) )
				: '';
			update_post_meta( $post_id, $waldorf_pb_key, $waldorf_pb_value );
		}
	}

	$waldorf_pb_nonce = isset( $_POST['waldorf_pb_person_nonce'] )
		? sanitize_text_field( wp_unslash( $_POST['waldorf_pb_person_nonce'] ) )
		: '';

	if ( '' !== $waldorf_pb_nonce && wp_verify_nonce( $waldorf_pb_nonce, 'waldorf_pb_save_person' ) ) {
		foreach ( array(
			'waldorf_pb_rolle' => WALDORF_PB_META_PERSON_ROLLE,
			'waldorf_pb_mono'  => WALDORF_PB_META_PERSON_MONO,
		) as $waldorf_pb_field => $waldorf_pb_key ) {
			$waldorf_pb_value = isset( $_POST[ $waldorf_pb_field ] )
				? sanitize_text_field( wp_unslash( $_POST[ $waldorf_pb_field ] ) )
				: '';
			update_post_meta( $post_id, $waldorf_pb_key, $waldorf_pb_value );
		}
	}
}
add_action( 'save_post', 'waldorf_pb_save_meta' );

/**
 * Show the date in the Termine list table, and sort by it by default.
 *
 * @param array<string, string> $columns Existing columns.
 * @return array<string, string>
 */
function waldorf_pb_termin_columns( array $columns ): array {
	$waldorf_pb_new = array();
	foreach ( $columns as $waldorf_pb_key => $waldorf_pb_label ) {
		$waldorf_pb_new[ $waldorf_pb_key ] = $waldorf_pb_label;
		if ( 'title' === $waldorf_pb_key ) {
			$waldorf_pb_new['waldorf_pb_datum'] = __( 'Datum', 'waldorf-pfirsichbluete' );
		}
	}
	return $waldorf_pb_new;
}
add_filter( 'manage_' . WALDORF_PB_CPT_TERMIN . '_posts_columns', 'waldorf_pb_termin_columns' );

/**
 * Fill the date column.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function waldorf_pb_termin_column_content( string $column, int $post_id ): void {
	if ( 'waldorf_pb_datum' !== $column ) {
		return;
	}
	$waldorf_pb_von = (string) get_post_meta( $post_id, WALDORF_PB_META_TERMIN_VON, true );
	$waldorf_pb_bis = (string) get_post_meta( $post_id, WALDORF_PB_META_TERMIN_BIS, true );

	if ( '' === $waldorf_pb_von ) {
		echo '<em>' . esc_html__( 'kein Datum', 'waldorf-pfirsichbluete' ) . '</em>';
		return;
	}

	echo esc_html( waldorf_pb_format_date_range( $waldorf_pb_von, $waldorf_pb_bis ) );
}
add_action( 'manage_' . WALDORF_PB_CPT_TERMIN . '_posts_custom_column', 'waldorf_pb_termin_column_content', 10, 2 );

/**
 * Order the Termine list table chronologically instead of by creation date.
 *
 * @param WP_Query $query Current admin query.
 */
function waldorf_pb_termin_admin_order( WP_Query $query ): void {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( WALDORF_PB_CPT_TERMIN !== $query->get( 'post_type' ) || '' !== (string) $query->get( 'orderby' ) ) {
		return;
	}
	$query->set( 'meta_key', WALDORF_PB_META_TERMIN_VON );
	$query->set( 'orderby', 'meta_value' );
	$query->set( 'order', 'ASC' );
}
add_action( 'pre_get_posts', 'waldorf_pb_termin_admin_order' );
