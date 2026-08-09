<?php
/**
 * Server-side rendering for the FAQ container.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var string $content Rendered inner blocks.
 */
?>
<div class="pb-faq">
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered by restricted registered child blocks. ?>
</div>
