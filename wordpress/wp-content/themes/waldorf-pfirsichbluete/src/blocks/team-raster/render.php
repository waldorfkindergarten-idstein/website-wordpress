<?php
/**
 * Server-side rendering for the team grid.
 *
 * Members come from the waldorf_person post type so the Verein can maintain
 * them in wp-admin. Markup matches waldorf/person exactly, so the existing
 * .pb-team styling applies unchanged.
 *
 * @package WaldorfPfirsichbluete
 */

$waldorf_pb_members = waldorf_pb_team_members();

if ( array() === $waldorf_pb_members ) {
	return;
}
?>
<div class="pb-team">
	<?php foreach ( $waldorf_pb_members as $waldorf_pb_member ) : ?>
		<?php
		$waldorf_pb_name  = get_the_title( $waldorf_pb_member );
		$waldorf_pb_role  = (string) get_post_meta( $waldorf_pb_member->ID, WALDORF_PB_META_PERSON_ROLLE, true );
		$waldorf_pb_mono  = (string) get_post_meta( $waldorf_pb_member->ID, WALDORF_PB_META_PERSON_MONO, true );
		$waldorf_pb_image = waldorf_pb_render_image(
			(int) get_post_thumbnail_id( $waldorf_pb_member ),
			'',
			$waldorf_pb_name,
			array( 'sizes' => '(max-width: 620px) 50vw, 230px' )
		);

		if ( '' === $waldorf_pb_mono ) {
			$waldorf_pb_mono = mb_substr( wp_strip_all_tags( $waldorf_pb_name ), 0, 1 );
		}
		?>
		<div class="pb-person pb-reveal">
			<div class="pb-photo pb-shape-person pb-person__photo">
				<?php if ( '' !== $waldorf_pb_image ) : ?>
					<?php echo $waldorf_pb_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by waldorf_pb_render_image(). ?>
				<?php else : ?>
					<span class="pb-person__mono"><?php echo esc_html( $waldorf_pb_mono ); ?></span>
				<?php endif; ?>
			</div>
			<h4><?php echo esc_html( $waldorf_pb_name ); ?></h4>
			<span><?php echo esc_html( $waldorf_pb_role ); ?></span>
		</div>
	<?php endforeach; ?>
</div>
