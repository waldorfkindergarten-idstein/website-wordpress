<?php
/**
 * Server-side rendering for the enrolment steps container.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var string $content Rendered inner blocks.
 */

$waldorf_pb_step_index   = 0;
$waldorf_pb_step_content = preg_replace_callback(
	'/<span class="pb-step__n">\d+<\/span>/',
	static function () use ( &$waldorf_pb_step_index ) {
		++$waldorf_pb_step_index;
		return '<span class="pb-step__n">' . $waldorf_pb_step_index . '</span>';
	},
	$content
);

if ( ! is_string( $waldorf_pb_step_content ) ) {
	$waldorf_pb_step_content = $content;
}
?>
<div class="pb-steps" style="margin-top:46px">
	<?php echo $waldorf_pb_step_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered once by restricted registered child blocks. ?>
</div>
