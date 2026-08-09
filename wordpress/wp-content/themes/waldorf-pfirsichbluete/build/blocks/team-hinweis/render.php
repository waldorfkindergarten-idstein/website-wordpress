<?php
/**
 * Server-side rendering for the team note.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_team_note = isset( $attributes['text'] ) ? (string) $attributes['text'] : '';
?>
<p class="pb-team-note" style="margin-top:28px;font-size:.92rem;color:#6e5a55"><?php echo wp_kses_post( $waldorf_pb_team_note ); ?></p>
