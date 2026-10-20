<?php
/**
 * Data store. Every setting group lives in one option; unsaved groups fall back to defaults.
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

class AIQD_Store {

	const OPTIONS = array(
		'settings' => 'aiqd_settings',
		'links'    => 'aiqd_links',
		'plans'    => 'aiqd_plans',
		'matrix'   => 'aiqd_matrix',
		'header'   => 'aiqd_header',
		'footer'   => 'aiqd_footer',
		'thanks'   => 'aiqd_thanks',
		'design'   => 'aiqd_design',
		'seo'      => 'aiqd_seo',
		'layout'   => 'aiqd_layout',
	);

	/**
	 * Per-request cache.
	 *
	 * @var array
	 */
	private static $cache = array();

	/**
	 * Read a group (saved value merged over defaults for associative groups).
	 *
	 * @param string $group Group key.
	 * @return mixed
	 */
	public static function get( $group ) {
		if ( isset( self::$cache[ $group ] ) ) {
			return self::$cache[ $group ];
		}
		$defaults = call_user_func( array( 'AIQD_Defaults', $group ) );
		$saved    = get_option( self::OPTIONS[ $group ], null );
		if ( null === $saved || false === $saved ) {
			$value = $defaults;
		} elseif ( in_array( $group, array( 'plans', 'layout', 'links', 'matrix' ), true ) ) {
			$value = $saved; // Whole-list groups replace defaults.
		} elseif ( is_array( $saved ) ) {
			$value = array_replace( $defaults, $saved );
		} else {
			$value = $defaults;
		}
		self::$cache[ $group ] = $value;
		return $value;
	}

	/**
	 * Save a group.
	 */
	public static function set( $group, $value ) {
		update_option( self::OPTIONS[ $group ], $value, false );
		unset( self::$cache[ $group ] );
	}

	/**
	 * Delete a group (back to defaults).
	 */
	public static function reset( $group ) {
		delete_option( self::OPTIONS[ $group ] );
		unset( self::$cache[ $group ] );
	}

	public static function settings() {
		return self::get( 'settings' );
	}

	public static function setting( $key, $default = '' ) {
		$s = self::settings();
		return isset( $s[ $key ] ) ? $s[ $key ] : $default;
	}

	public static function links() {
		return self::get( 'links' );
	}

	public static function plans() {
		return self::get( 'plans' );
	}

	public static function matrix() {
		return self::get( 'matrix' );
	}

	public static function header() {
		return self::get( 'header' );
	}

	public static function footer() {
		return self::get( 'footer' );
	}

	public static function thanks() {
		return self::get( 'thanks' );
	}

	public static function design() {
		return self::get( 'design' );
	}

	public static function seo() {
		return self::get( 'seo' );
	}

	public static function layout() {
		return self::get( 'layout' );
	}

	/**
	 * Section data = type defaults overlaid with the instance's saved data.
	 *
	 * @param array $inst Section instance.
	 * @return array
	 */
	public static function section_data( $inst ) {
		$type = AIQD_Registry::instance()->get_type( $inst['type'] );
		$base = $type ? $type['defaults'] : array();
		$data = isset( $inst['data'] ) && is_array( $inst['data'] ) ? $inst['data'] : array();
		return array_replace( $base, $data );
	}

	/**
	 * Find a section instance by uid.
	 */
	public static function find_section( $uid ) {
		foreach ( self::layout() as $i => $inst ) {
			if ( $inst['uid'] === $uid ) {
				return array( $i, $inst );
			}
		}
		return null;
	}

	/**
	 * Header/footer zone data are "section data" too (type header/footer).
	 */
	public static function zone_instance( $zone ) {
		return array(
			'uid'     => 'z-' . $zone,
			'type'    => $zone,
			'enabled' => 1,
			'anchor'  => '',
			'style'   => array(),
			'data'    => self::get( $zone ),
		);
	}

	/**
	 * Resolve plan checkout URL for a billing cycle.
	 *
	 * @param array  $plan  Plan row.
	 * @param string $cycle annual|lifetime.
	 * @return string No-JS fallback URL (the overlay checkout is opened by front.js).
	 */
	public static function plan_url( $plan, $cycle = 'annual' ) {
		if ( ! empty( $plan['cta_link'] ) ) {
			$l = aiqd_link( $plan['cta_link'] );
			return $l['url'];
		}
		if ( empty( $plan['plan_id'] ) ) {
			return '#pricing';
		}
		$s    = self::settings();
		$base = rtrim( $s['freemius_checkout'], '/' );
		$url  = $base . '/plugin/' . rawurlencode( $s['freemius_plugin_id'] ) . '/plan/' . rawurlencode( $plan['plan_id'] ) . '/';
		$args = array( 'billing_cycle' => ( 'lifetime' === $cycle ? 'lifetime' : 'annual' ) );
		if ( isset( $plan['licenses'] ) && '' !== $plan['licenses'] ) {
			$args['licenses'] = (int) $plan['licenses'] > 0 ? (int) $plan['licenses'] : 'unlimited';
		}
		return add_query_arg( $args, $url );
	}
}
