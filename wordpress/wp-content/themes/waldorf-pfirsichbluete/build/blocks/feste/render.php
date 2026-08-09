<?php
/**
 * Server-side rendering for the festival grid.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var string $content Rendered inner blocks.
 */
?>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;margin-top:46px">
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered block content. ?>
</div>
