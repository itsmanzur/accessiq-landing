<?php
/**
 * Remove all AccessIQ Landing data on uninstall.
 *
 * @package AccessIQDemo
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

foreach ( array( 'aiqd_settings', 'aiqd_links', 'aiqd_plans', 'aiqd_matrix', 'aiqd_header', 'aiqd_footer', 'aiqd_thanks', 'aiqd_design', 'aiqd_seo', 'aiqd_layout' ) as $aiqd_opt ) {
	delete_option( $aiqd_opt );
}
