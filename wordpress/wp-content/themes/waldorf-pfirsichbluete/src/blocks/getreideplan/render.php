<?php
/**
 * Server-side rendering for the Waldorf grain plan block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var string $content Rendered inner blocks.
 */
?>
<ul class="pb-grain" style="margin-top:24px">
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Inner blocks are rendered and escaped by WordPress. ?>
</ul>
