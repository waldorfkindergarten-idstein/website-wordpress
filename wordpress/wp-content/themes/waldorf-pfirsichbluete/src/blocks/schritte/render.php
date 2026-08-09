<?php
/**
 * Server-side rendering for the enrolment steps container.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var WP_Block $block Block instance.
 */
?>
<div class="pb-steps" style="margin-top:46px">
	<?php
	$waldorf_pb_step_index = 0;
	foreach ( $block->parsed_block['innerBlocks'] as $waldorf_pb_step_block ) {
		if ( ! isset( $waldorf_pb_step_block['blockName'] ) || 'waldorf/schritt' !== $waldorf_pb_step_block['blockName'] ) {
			continue;
		}

		++$waldorf_pb_step_index;
		$waldorf_pb_step_block['attrs']['number'] = $waldorf_pb_step_index;
		echo render_block( $waldorf_pb_step_block ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered by the registered child block.
	}
	?>
</div>
