<?php
/**
 * Server-side rendering for the Waldorf daily schedule block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var string $content Rendered inner blocks.
 */
?>
<ol class="pb-timeline">
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Inner blocks are rendered and escaped by WordPress. ?>
</ol>
