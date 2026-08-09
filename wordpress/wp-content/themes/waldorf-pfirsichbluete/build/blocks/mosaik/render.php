<?php
/**
 * Server-side rendering for the Waldorf photo mosaic block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var string $content Rendered inner photo blocks.
 */
?>
<div class="pb-mosaic pb-reveal" style="margin-top:46px">
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered block content. ?>
</div>
