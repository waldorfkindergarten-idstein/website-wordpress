<?php
/**
 * Server-side rendering for a downloadable attachment.
 *
 * @package WaldorfPfirsichbluete
 *
 * @var array $attributes Block attributes.
 */

$waldorf_pb_download_id          = isset( $attributes['id'] ) ? absint( $attributes['id'] ) : 0;
$waldorf_pb_download_url         = isset( $attributes['fileUrl'] ) ? (string) $attributes['fileUrl'] : '#';
$waldorf_pb_download_title       = isset( $attributes['title'] ) ? wp_strip_all_tags( (string) $attributes['title'] ) : '';
$waldorf_pb_download_description = isset( $attributes['description'] ) ? wp_strip_all_tags( (string) $attributes['description'] ) : '';
$waldorf_pb_download_type        = isset( $attributes['fallbackType'] ) ? wp_strip_all_tags( (string) $attributes['fallbackType'] ) : 'PDF';
$waldorf_pb_download_size        = isset( $attributes['fallbackSize'] ) ? wp_strip_all_tags( (string) $attributes['fallbackSize'] ) : '';

if ( $waldorf_pb_download_id ) {
	$waldorf_pb_attachment_url = wp_get_attachment_url( $waldorf_pb_download_id );
	$waldorf_pb_attachment_file = get_attached_file( $waldorf_pb_download_id );
	$waldorf_pb_attachment_meta = wp_get_attachment_metadata( $waldorf_pb_download_id );

	if ( $waldorf_pb_attachment_url ) {
		$waldorf_pb_download_url = $waldorf_pb_attachment_url;
	}

	$waldorf_pb_download_path = wp_parse_url( $waldorf_pb_download_url, PHP_URL_PATH );
	$waldorf_pb_download_ext  = is_string( $waldorf_pb_download_path ) ? pathinfo( $waldorf_pb_download_path, PATHINFO_EXTENSION ) : '';
	if ( '' !== $waldorf_pb_download_ext ) {
		$waldorf_pb_download_type = strtoupper( sanitize_key( $waldorf_pb_download_ext ) );
	}

	$waldorf_pb_download_bytes = 0;
	if ( is_array( $waldorf_pb_attachment_meta ) && isset( $waldorf_pb_attachment_meta['filesize'] ) ) {
		$waldorf_pb_download_bytes = absint( $waldorf_pb_attachment_meta['filesize'] );
	} elseif ( is_string( $waldorf_pb_attachment_file ) && is_file( $waldorf_pb_attachment_file ) ) {
		$waldorf_pb_file_size = filesize( $waldorf_pb_attachment_file );
		$waldorf_pb_download_bytes = false === $waldorf_pb_file_size ? 0 : (int) $waldorf_pb_file_size;
	}

	if ( $waldorf_pb_download_bytes >= 1048576 ) {
		$waldorf_pb_download_size = number_format_i18n( $waldorf_pb_download_bytes / 1048576, 1 ) . ' MB';
	} elseif ( $waldorf_pb_download_bytes >= 1024 ) {
		$waldorf_pb_download_size = number_format_i18n( round( $waldorf_pb_download_bytes / 1024 ), 0 ) . ' kB';
	} elseif ( $waldorf_pb_download_bytes > 0 ) {
		$waldorf_pb_download_size = number_format_i18n( $waldorf_pb_download_bytes, 0 ) . ' B';
	}
}

$waldorf_pb_download_meta = implode(
	' · ',
	array_filter(
		array( $waldorf_pb_download_description, $waldorf_pb_download_size ),
		static function ( $waldorf_pb_value ) {
			return '' !== $waldorf_pb_value;
		}
	)
);
$waldorf_pb_download_href = '#' === $waldorf_pb_download_url ? '#' : esc_url( $waldorf_pb_download_url );
?>
<a class="pb-dl pb-reveal" href="<?php echo esc_attr( $waldorf_pb_download_href ); ?>">
	<span class="pb-dl__ext"><?php echo esc_html( $waldorf_pb_download_type ); ?></span>
	<span>
		<b><?php echo esc_html( $waldorf_pb_download_title ); ?></b>
		<small><?php echo esc_html( $waldorf_pb_download_meta ); ?></small>
	</span>
	<span class="pb-dl__arrow" aria-hidden="true">↓</span>
</a>
