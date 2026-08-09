<?php
/**
 * Server-side rendering for the Waldorf group-card grid block.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var string $content Rendered inner group-card blocks.
 */
?>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px;margin-top:50px">
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered block content. ?>
</div>
