<?php
/**
 * Plugin Name:       AccessIQ Landing Page Builder
 * Plugin URI:        https://accessiq.thereadscope.com
 * Description:       Builds and manages the AccessIQ product landing page: reorderable sections, interactive demos, pricing plans with Freemius checkout, global links, header/footer, SEO, JSON-LD and llms.txt. Works independently of the AccessIQ plugins.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            readscope
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       accessiq-demo
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

define( 'AIQD_VERSION', '1.0.0' );
define( 'AIQD_FILE', __FILE__ );
define( 'AIQD_DIR', plugin_dir_path( __FILE__ ) );
define( 'AIQD_URL', plugin_dir_url( __FILE__ ) );

require_once AIQD_DIR . 'includes/helpers.php';
require_once AIQD_DIR . 'includes/legal.php';
require_once AIQD_DIR . 'includes/class-aiqd-defaults.php';
require_once AIQD_DIR . 'includes/class-aiqd-store.php';
require_once AIQD_DIR . 'includes/class-aiqd-registry.php';
require_once AIQD_DIR . 'includes/class-aiqd-render.php';
require_once AIQD_DIR . 'includes/class-aiqd-seo.php';

if ( is_admin() ) {
	require_once AIQD_DIR . 'includes/class-aiqd-admin.php';
}

/**
 * Boot the plugin.
 */
function aiqd_boot() {
	load_plugin_textdomain( 'accessiq-demo', false, dirname( plugin_basename( AIQD_FILE ) ) . '/languages' ); // phpcs:ignore PluginCheck.CodeAnalysis.DiscouragedFunctions
	AIQD_Registry::instance();
	AIQD_Render::instance();
	AIQD_SEO::instance();
	if ( is_admin() ) {
		AIQD_Admin::instance();
	}
}
add_action( 'init', 'aiqd_boot', -5 );

/**
 * Activation: create the landing, thank-you and legal pages once.
 */
function aiqd_activate() {
	aiqd_create_legal_pages();
	$settings = get_option( 'aiqd_settings', array() );
	$ty_id    = isset( $settings['thankyou_page_id'] ) ? (int) $settings['thankyou_page_id'] : 0;
	if ( ! $ty_id || ! get_post( $ty_id ) ) {
		$new_ty = wp_insert_post(
			array(
				'post_title'   => 'Thank you',
				'post_name'    => 'thank-you',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '<!-- AccessIQ Landing thank-you page: edit in AccessIQ Landing → Header, Footer & Thank-you -->',
			)
		);
		if ( $new_ty && ! is_wp_error( $new_ty ) ) {
			$settings['thankyou_page_id'] = (int) $new_ty;
			update_option( 'aiqd_settings', $settings );
		}
	}
	$page_id = isset( $settings['page_id'] ) ? (int) $settings['page_id'] : 0;
	if ( $page_id && get_post( $page_id ) ) {
		return;
	}
	$new_id = wp_insert_post(
		array(
			'post_title'   => 'AccessIQ',
			'post_name'    => 'accessiq-demo',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '<!-- AccessIQ Landing landing page: content is managed in AccessIQ Landing → Page Builder -->',
		)
	);
	if ( $new_id && ! is_wp_error( $new_id ) ) {
		$settings['page_id'] = (int) $new_id;
		update_option( 'aiqd_settings', $settings );
	}
}
register_activation_hook( AIQD_FILE, 'aiqd_activate' );
