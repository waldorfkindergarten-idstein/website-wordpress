<?php
/**
 * Title: Unsere Gruppen
 * Slug: waldorf-pfirsichbluete/gruppen
 * Categories: waldorf-sections
 * Description: Drei Gruppenkarten mit Foto, Alters-Tag und Eckdaten.
 */

$waldorf_pb_groups = array(
	array(
		'image' => 'photo-morgenkreis.jpg',
		'alt'   => 'Familiengruppe beim Morgenkreis',
		'cap'   => 'Beispielbild · Morgenkreis',
		'tag'   => '2–6 Jahre',
		'title' => 'Familiengruppen',
		'text'  => 'Altersgemischte Gruppen, in denen Große für Kleine sorgen. Geschwister bleiben zusammen, Beziehungen wachsen über Jahre.',
		'meta'  => array(
			'Plätze'     => '2 × 20 Kinder',
			'Kernzeit'   => '7:30 – 12:00 Uhr',
			'Verlängert' => 'bis 15:15 Uhr',
			'Team'       => '2 Fachkräfte + Praktikum',
		),
	),
	array(
		'image' => 'photo-krippe.jpg',
		'alt'   => 'Krippenkind mit Naturmaterial',
		'cap'   => 'Beispielbild · Krippenkind mit Holzspielzeug',
		'tag'   => '1–3 Jahre',
		'title' => 'Krippe Wiegenstube',
		'text'  => 'Ein geborgener Start in kleiner Runde. Sanfte Eingewöhnung, viel Nähe und ein ruhiger Rhythmus für die Jüngsten.',
		'meta'  => array(
			'Plätze'        => '10 Kinder',
			'Kernzeit'      => '7:30 – 14:00 Uhr',
			'Eingewöhnung'  => '2–4 Wochen, begleitet',
			'Team'          => '3 Fachkräfte',
		),
	),
	array(
		'image' => 'photo-waldtag.jpg',
		'alt'   => 'Kinder auf dem Waldtag',
		'cap'   => 'Beispielbild · Waldtag',
		'tag'   => 'Freitags',
		'title' => 'Waldtag',
		'text'  => 'Jeden Freitag geht es hinaus: bei jedem Wetter, mit Seilen, Lupen und Zeit zum Entdecken.',
		'meta'  => array(
			'Wann'      => 'Freitag, ganztags',
			'Treffpunkt'=> '8:00 Uhr am Haus',
			'Alter'     => 'ab 3 Jahren',
			'Ausrüstung'=> 'Packliste zum Download',
		),
	),
);
?>
<!-- wp:group {"anchor":"gruppen","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"gradient":"wash-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-wash-white-gradient-background has-background" id="gruppen" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Unsere Gruppen</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading" style="margin-top:0.28em;margin-bottom:0.35em">Ein Platz für jedes Alter</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Vom ersten Krippenjahr bis zum Schuleintritt – altersgemischt, kontinuierlich und nah an der Natur.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px;margin-top:50px">
		<?php foreach ( $waldorf_pb_groups as $waldorf_pb_group ) : ?>
			<article class="pb-gcard pb-reveal">
				<figure class="pb-photo pb-gcard__photo">
					<img src="<?php echo esc_url( waldorf_pb_img( $waldorf_pb_group['image'] ) ); ?>" alt="<?php echo esc_attr( $waldorf_pb_group['alt'] ); ?>" loading="lazy" decoding="async">
					<figcaption><?php echo esc_html( $waldorf_pb_group['cap'] ); ?></figcaption>
				</figure>
				<div class="pb-gcard__body">
					<span class="pb-tag"><?php echo esc_html( $waldorf_pb_group['tag'] ); ?></span>
					<h3><?php echo esc_html( $waldorf_pb_group['title'] ); ?></h3>
					<p><?php echo esc_html( $waldorf_pb_group['text'] ); ?></p>
					<ul class="pb-meta-list">
						<?php foreach ( $waldorf_pb_group['meta'] as $waldorf_pb_key => $waldorf_pb_value ) : ?>
							<li><span><?php echo esc_html( $waldorf_pb_key ); ?></span><b><?php echo esc_html( $waldorf_pb_value ); ?></b></li>
						<?php endforeach; ?>
					</ul>
					<span class="pb-more">Mehr erfahren</span>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
