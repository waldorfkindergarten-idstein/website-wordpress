<?php
/**
 * Title: Jahreslauf und Feste
 * Slug: waldorf-pfirsichbluete/jahreslauf
 * Categories: waldorf-sections
 * Description: Sechs Festkarten mit Aquarell-Motiven.
 */

$waldorf_pb_feste = array(
	array( 'September', 'Michaeli',            'Mut und Kraft: Drachenbrot backen, gemeinsam etwas wagen.' ),
	array( 'November',  'Martini',             'Laternen ziehen durch die Dämmerung, Lieder wärmen.' ),
	array( 'Dezember',  'Advent',             'Der Adventsgarten mit Moos, Kerzen und leiser Musik.' ),
	array( 'Februar',   'Fasching',            'Verkleiden mit Tüchern statt Kostümen – und Krapfen für alle.' ),
	array( 'April',     'Ostern',              'Kressegärtchen säen, Eier mit Zwiebelschalen färben, Suche im Garten.' ),
	array( 'Juni',      'Johanni',             'Das Sommerfest am längsten Tag: Blumenkränze, Springen, Musik.' ),
);
?>
<!-- wp:group {"anchor":"jahreslauf","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"gradient":"wash-rose","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-wash-rose-gradient-background has-background" id="jahreslauf" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"className":"pb-reveal pb-sec-head","layout":{"type":"default"}} -->
	<div class="wp-block-group pb-reveal pb-sec-head">
		<!-- wp:paragraph {"className":"pb-eyebrow"} --><p class="pb-eyebrow">Jahreslauf</p><!-- /wp:paragraph -->
		<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0.28em","bottom":"0.35em"}}}} --><h2 class="wp-block-heading">Feste, die das Jahr gliedern</h2><!-- /wp:heading -->
		<!-- wp:paragraph {"style":{"color":{"text":"#6e5a55"}}} --><p class="has-text-color" style="color:#6e5a55">Jedes Fest wird über Wochen vorbereitet. Die Vorfreude gehört genauso dazu wie der Tag selbst.</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;margin-top:46px">
		<?php foreach ( $waldorf_pb_feste as $waldorf_pb_f ) : ?>
			<div class="pb-fest pb-reveal">
				<div class="pb-meta"><?php echo esc_html( $waldorf_pb_f[0] ); ?></div>
				<h4><?php echo esc_html( $waldorf_pb_f[1] ); ?></h4>
				<p><?php echo esc_html( $waldorf_pb_f[2] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
