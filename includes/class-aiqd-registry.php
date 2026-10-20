<?php
/**
 * Section type registry.
 *
 * A section type is a folder: sections/<type>/config.php (+ template.php).
 * Drop a new folder in (or register via the `aiqd_section_types` filter) and it
 * appears in the builder's "Add section" picker automatically.
 *
 * config.php returns:
 *   label, icon, desc, zone (body|header|footer), group, schema[], defaults[]
 *
 * Field schema item:
 *   key, type, label, help, default, options (select), fields (repeater), item_label (repeater)
 *   types: text textarea richtext link select toggle number color icon image repeater lines
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

class AIQD_Registry {

	private static $instance = null;

	/**
	 * @var array type => config
	 */
	private $types = array();

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->discover();
	}

	/**
	 * Discover bundled + filtered section types.
	 */
	private function discover() {
		$found = array();
		$dirs  = glob( AIQD_DIR . 'sections/*', GLOB_ONLYDIR );
		if ( $dirs ) {
			foreach ( $dirs as $dir ) {
				$cfg_file = $dir . '/config.php';
				if ( ! file_exists( $cfg_file ) ) {
					continue;
				}
				$type = basename( $dir );
				$cfg  = include $cfg_file;
				if ( is_array( $cfg ) ) {
					$cfg['dir']      = $dir;
					$found[ $type ] = $cfg;
				}
			}
		}
		/**
		 * Filter section types. Add your own: $types['my-type'] = [ label, icon, schema, defaults, template ]
		 */
		$found = apply_filters( 'aiqd_section_types', $found );
		foreach ( $found as $type => $cfg ) {
			$this->types[ $type ] = wp_parse_args(
				$cfg,
				array(
					'label'    => ucfirst( $type ),
					'icon'     => 'layers',
					'desc'     => '',
					'zone'     => 'body',
					'group'    => 'content',
					'schema'   => array(),
					'defaults' => array(),
					'template' => '',
					'dir'      => '',
				)
			);
			$this->types[ $type ]['type'] = $type;
		}
	}

	public function all() {
		return $this->types;
	}

	/**
	 * Types usable in the body (add-section picker).
	 */
	public function body_types() {
		return array_filter(
			$this->types,
			function ( $t ) {
				return 'body' === $t['zone'];
			}
		);
	}

	public function get_type( $type ) {
		return isset( $this->types[ $type ] ) ? $this->types[ $type ] : null;
	}

	/**
	 * Locate a template: theme override first (theme/accessiq-demo/sections/<type>.php), then plugin.
	 */
	public function template_path( $type ) {
		$t = $this->get_type( $type );
		if ( ! $t ) {
			return '';
		}
		$override = locate_template( 'accessiq-demo/sections/' . $type . '.php' );
		if ( $override ) {
			return $override;
		}
		if ( ! empty( $t['template'] ) && file_exists( $t['template'] ) ) {
			return $t['template'];
		}
		$file = $t['dir'] . '/template.php';
		return file_exists( $file ) ? $file : '';
	}

	/**
	 * Standard heading fields reused by most sections.
	 */
	public static function head_fields() {
		return array(
			array( 'key' => 'eyebrow', 'type' => 'text', 'label' => __( 'Eyebrow (small label)', 'accessiq-demo' ) ),
			array( 'key' => 'title', 'type' => 'text', 'label' => __( 'Heading (H2)', 'accessiq-demo' ), 'help' => __( 'Wrap words in [[double brackets]] for gradient highlight.', 'accessiq-demo' ) ),
			array( 'key' => 'subtitle', 'type' => 'textarea', 'label' => __( 'Sub-heading', 'accessiq-demo' ) ),
		);
	}

	/**
	 * Common per-instance style options (rendered by the builder for every section).
	 */
	public static function style_fields() {
		return array(
			array(
				'key'     => 'bg',
				'type'    => 'select',
				'label'   => __( 'Background', 'accessiq-demo' ),
				'options' => array(
					'default' => __( 'Default', 'accessiq-demo' ),
					'alt'     => __( 'Soft panel', 'accessiq-demo' ),
					'dark'    => __( 'Always dark', 'accessiq-demo' ),
					'grad'    => __( 'Gradient glow', 'accessiq-demo' ),
					'grid'    => __( 'Dotted grid', 'accessiq-demo' ),
				),
			),
			array(
				'key'     => 'space',
				'type'    => 'select',
				'label'   => __( 'Vertical spacing', 'accessiq-demo' ),
				'options' => array(
					'md' => __( 'Medium', 'accessiq-demo' ),
					'sm' => __( 'Compact', 'accessiq-demo' ),
					'lg' => __( 'Large', 'accessiq-demo' ),
					'xl' => __( 'Extra large', 'accessiq-demo' ),
				),
			),
			array(
				'key'     => 'hide',
				'type'    => 'select',
				'label'   => __( 'Visibility', 'accessiq-demo' ),
				'options' => array(
					''        => __( 'Show everywhere', 'accessiq-demo' ),
					'mobile'  => __( 'Hide on mobile', 'accessiq-demo' ),
					'desktop' => __( 'Hide on desktop', 'accessiq-demo' ),
				),
			),
			array(
				'key'   => 'nav',
				'type'  => 'text',
				'label' => __( 'Label in the side dot-navigation', 'accessiq-demo' ),
			),
			array(
				'key'   => 'class',
				'type'  => 'text',
				'label' => __( 'Extra CSS class', 'accessiq-demo' ),
			),
		);
	}
}
