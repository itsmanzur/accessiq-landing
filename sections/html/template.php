<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
if ( ! empty( $d['code'] ) ) {
	echo '<div class="aiqd-custom">' . do_shortcode( $d['code'] ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput -- saved only by users with unfiltered_html.
}
