<?php
/**
 * Front-end rendering: page template, shortcode, section wrapper, assets, design tokens.
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

class AIQD_Render {

	private static $instance = null;

	/**
	 * Whether assets are needed on this request.
	 *
	 * @var bool
	 */
	private $needs_assets = false;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_filter( 'template_include', array( $this, 'template_include' ), 99 );
		add_shortcode( 'accessiq_demo', array( $this, 'shortcode' ) );
		add_shortcode( 'accessiq_section', array( $this, 'shortcode_section' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_action( 'wp_head', array( $this, 'preload_fonts' ), 2 );
	}

	/**
	 * Is the current request the assigned landing page?
	 */
	public function is_landing() {
		$page_id = (int) AIQD_Store::setting( 'page_id', 0 );
		return $page_id && is_page( $page_id );
	}

	/**
	 * Is the current request the thank-you page?
	 */
	public function is_thankyou() {
		$page_id = (int) AIQD_Store::setting( 'thankyou_page_id', 0 );
		return $page_id && is_page( $page_id );
	}

	public function body_class( $classes ) {
		if ( $this->is_landing() || $this->is_thankyou() ) {
			$classes[] = 'aiqd-landing';
		}
		return $classes;
	}

	public function template_include( $template ) {
		if ( $this->is_landing() || $this->is_thankyou() ) {
			$this->needs_assets = true;
			return AIQD_DIR . 'templates/landing.php';
		}
		return $template;
	}

	/**
	 * Enqueue front assets (landing page or any post using the shortcode).
	 */
	public function enqueue() {
		global $post;
		$use = $this->is_landing() || $this->is_thankyou();
		if ( ! $use && $post instanceof WP_Post && ( has_shortcode( $post->post_content, 'accessiq_demo' ) || has_shortcode( $post->post_content, 'accessiq_section' ) ) ) {
			$use = true;
		}
		if ( ! $use ) {
			return;
		}
		$this->needs_assets = true;
		wp_enqueue_style( 'aiqd-fonts', AIQD_URL . 'assets/css/fonts.css', array(), AIQD_VERSION );
		wp_enqueue_style( 'aiqd-front', AIQD_URL . 'assets/css/front.css', array( 'aiqd-fonts' ), AIQD_VERSION );
		wp_enqueue_style( 'aiqd-sections', AIQD_URL . 'assets/css/sections.css', array( 'aiqd-front' ), AIQD_VERSION );
		wp_enqueue_style( 'aiqd-visuals', AIQD_URL . 'assets/css/visuals.css', array( 'aiqd-sections' ), AIQD_VERSION );
		wp_add_inline_style( 'aiqd-visuals', $this->design_css() );
		$checkout = $this->checkout_config();
		$deps     = array();
		if ( $checkout['ready'] ) {
			// Freemius overlay checkout. Without a real public key the buttons stay plain links.
			wp_enqueue_script( 'freemius-checkout', 'https://checkout.freemius.com/js/v1/', array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			$deps[] = 'freemius-checkout';
		}
		wp_enqueue_script( 'aiqd-front', AIQD_URL . 'assets/js/front.js', $deps, AIQD_VERSION, true );
		wp_localize_script(
			'aiqd-front',
			'AIQD',
			array(
				'motion'   => AIQD_Store::design()['motion'],
				'checkout' => $checkout,
				'i18n'     => array(
					'scanning'     => __( 'Scanning…', 'accessiq-demo' ),
					'scanAgain'    => __( 'Scan again', 'accessiq-demo' ),
					'issues'       => __( 'issues', 'accessiq-demo' ),
					'perfect'      => __( 'Perfect score!', 'accessiq-demo' ),
					'copied'       => __( 'Copied', 'accessiq-demo' ),
					'perYear'      => __( '/year', 'accessiq-demo' ),
					'perOnce'      => __( 'one-time', 'accessiq-demo' ),
					'billedYear'   => __( 'billed yearly', 'accessiq-demo' ),
					'billedOnce'   => __( 'pay once, use forever', 'accessiq-demo' ),
				),
			)
		);
	}

	/**
	 * Freemius checkout config handed to front.js. IDs come from Settings + Pricing Plans.
	 */
	public function checkout_config() {
		$s    = AIQD_Store::settings();
		$key  = trim( (string) $s['freemius_public_key'] );
		$plans = array();
		foreach ( AIQD_Store::plans() as $p ) {
			if ( ! empty( $p['plan_id'] ) ) {
				$plans[ $p['id'] ] = array(
					'plan_id'    => (string) $p['plan_id'],
					'pricing_id' => (string) $p['pricing_id'],
				);
			}
		}
		$success = trim( (string) $s['success_url'] );
		return array(
			'product_id'  => (string) $s['freemius_plugin_id'],
			'public_key'  => $key,
			'name'        => (string) $s['checkout_name'],
			'success_url' => '' !== $success ? $success : '/thank-you/',
			'plans'       => (object) $plans,
			// A placeholder such as pk_XXXXXXXX counts as "not configured yet".
			'ready'       => (bool) ( preg_match( '/^pk_[A-Za-z0-9]{8,}$/', $key ) && ! preg_match( '/^pk_X+$/i', $key ) && $plans ),
		);
	}

	/**
	 * Preload the two fonts that paint first (hero heading + body) to avoid a late swap.
	 */
	public function preload_fonts() {
		if ( ! ( $this->is_landing() || $this->is_thankyou() ) || 'brand' !== AIQD_Store::design()['font'] ) {
			return;
		}
		foreach ( array( 'sg-700', 'inter-400' ) as $f ) {
			echo '<link rel="preload" href="' . esc_url( AIQD_URL . 'assets/fonts/' . $f . '.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "
"; // phpcs:ignore WordPress.Security.EscapeOutput
		}
	}

	/**
	 * CSS variables from the Design tab.
	 */
	public function design_css() {
		$d     = AIQD_Store::design();
		$sys   = 'ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
		// [ display (headings, prices), body ]. Hind Siliguri is the Bengali fallback (loaded only when Bengali text is present).
		$fonts = array(
			'brand'   => array( '"Space Grotesk",Inter,"Hind Siliguri",' . $sys, 'Inter,"Hind Siliguri",' . $sys ),
			'system'  => array( '"Hind Siliguri",' . $sys, '"Hind Siliguri",' . $sys ),
			'rounded' => array( 'ui-rounded,"SF Pro Rounded",Quicksand,Nunito,"Hind Siliguri",system-ui,sans-serif', 'ui-rounded,"SF Pro Rounded",Quicksand,Nunito,"Hind Siliguri",system-ui,sans-serif' ),
			'serif'   => array( 'ui-serif,Georgia,"Times New Roman","Hind Siliguri",serif', 'ui-serif,Georgia,"Times New Roman","Hind Siliguri",serif' ),
		);
		$font  = isset( $fonts[ $d['font'] ] ) ? $fonts[ $d['font'] ] : $fonts['brand'];
		$css   = '.aiqd-root{'
			. '--aiqd-primary:' . sanitize_hex_color( $d['primary'] ) . ';'
			. '--aiqd-accent:' . sanitize_hex_color( $d['accent'] ) . ';'
			. '--aiqd-warm:' . sanitize_hex_color( $d['warm'] ) . ';'
			. '--aiqd-danger:' . sanitize_hex_color( $d['danger'] ) . ';'
			. '--aiqd-dark-bg:' . sanitize_hex_color( $d['dark_bg'] ) . ';'
			. '--aiqd-light-bg:' . sanitize_hex_color( $d['light_bg'] ) . ';'
			. '--aiqd-radius:' . (int) $d['radius'] . 'px;'
			. '--aiqd-max:' . (int) $d['max_width'] . 'px;'
			. '--aiqd-font-display:' . $font[0] . ';'
			. '--aiqd-font-body:' . $font[1] . ';'
			. '}';
		if ( ! empty( $d['custom_css'] ) ) {
			$css .= wp_strip_all_tags( $d['custom_css'] );
		}
		return $css;
	}

	/**
	 * Output the opening wrapper (+ early theme script to avoid a flash).
	 */
	public function open_root() {
		$d = AIQD_Store::design();
		echo '<div class="aiqd-root" data-theme="' . esc_attr( 'system' === $d['default_theme'] ? 'dark' : $d['default_theme'] ) . '" data-default-theme="' . esc_attr( $d['default_theme'] ) . '" data-motion="' . esc_attr( $d['motion'] ) . '"' . ( $d['grain'] ? ' data-grain="1"' : '' ) . '>';
		echo '<script>(function(){try{var r=document.currentScript.parentNode;r.classList.add("aiqd-js");var s=localStorage.getItem("aiqd-theme"),d=r.getAttribute("data-default-theme");var t=s||d;if(t==="system"){t=window.matchMedia&&window.matchMedia("(prefers-color-scheme: light)").matches?"light":"dark";}r.setAttribute("data-theme",t);}catch(e){}})();</script>';
	}

	public function close_root() {
		echo '</div>';
	}

	/**
	 * Render the thank-you page body.
	 */
	public function render_thankyou() {
		$inst         = AIQD_Store::zone_instance( 'thanks' );
		$inst['style'] = array( 'space' => 'lg' );
		$this->render_section( $inst );
	}

	/**
	 * Render the page body (all enabled sections).
	 */
	public function render_body() {
		foreach ( AIQD_Store::layout() as $inst ) {
			if ( empty( $inst['enabled'] ) ) {
				continue;
			}
			$this->render_section( $inst );
		}
	}

	/**
	 * Render a single section instance wrapped in its <section>.
	 */
	public function render_section( $inst, $wrap = true ) {
		$reg  = AIQD_Registry::instance();
		$type = $reg->get_type( $inst['type'] );
		if ( ! $type ) {
			return;
		}
		$tpl = $reg->template_path( $inst['type'] );
		if ( ! $tpl ) {
			return;
		}
		$d  = AIQD_Store::section_data( $inst );
		$st = wp_parse_args(
			isset( $inst['style'] ) ? $inst['style'] : array(),
			array(
				'bg'    => 'default',
				'space' => 'md',
				'hide'  => '',
				'class' => '',
				'nav'   => '',
			)
		);
		$s  = array(
			'uid'    => $inst['uid'],
			'type'   => $inst['type'],
			'anchor' => $inst['anchor'],
			'style'  => $st,
		);
		if ( ! $wrap ) {
			$this->include_template( $tpl, $d, $s );
			return;
		}
		$classes = array(
			'aiqd-sec',
			'aiqd-sec--' . $inst['type'],
			'aiqd-bg-' . $st['bg'],
			'aiqd-space-' . $st['space'],
		);
		if ( $st['hide'] ) {
			$classes[] = 'aiqd-hide-' . $st['hide'];
		}
		if ( $st['class'] ) {
			$classes[] = $st['class'];
		}
		$id    = $inst['anchor'] ? sanitize_html_class( $inst['anchor'] ) : $inst['uid'];
		$label = $st['nav'] ? $st['nav'] : ( ! empty( $d['eyebrow'] ) ? aiqd_plain( $d['eyebrow'] ) : $type['label'] );
		echo '<section id="' . esc_attr( $id ) . '" class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', $classes ) ) ) . '" data-aiqd-uid="' . esc_attr( $inst['uid'] ) . '" data-nav="' . esc_attr( $label ) . '"' . ( ! empty( $d['title'] ) ? ' aria-labelledby="' . esc_attr( $inst['uid'] ) . '-title"' : '' ) . '>';
		echo '<div class="aiqd-glow" aria-hidden="true"></div>';
		if ( empty( $type['wide'] ) ) {
			echo '<div class="aiqd-container">';
		}
		$this->include_template( $tpl, $d, $s );
		if ( empty( $type['wide'] ) ) {
			echo '</div>';
		}
		echo '</section>';
	}

	/**
	 * Render the header or footer zone.
	 */
	public function render_zone( $zone ) {
		$inst = AIQD_Store::zone_instance( $zone );
		$this->render_section( $inst, false );
	}

	/**
	 * Floating UI: progress bar, side dots, back-to-top, floating CTA.
	 */
	public function render_floaters() {
		$s = AIQD_Store::settings();
		if ( $s['show_progress'] ) {
			echo '<div class="aiqd-progress" aria-hidden="true"><span></span></div>';
		}
		if ( $s['show_dots_nav'] ) {
			echo '<nav class="aiqd-dots" aria-label="' . esc_attr__( 'Page sections', 'accessiq-demo' ) . '"></nav>';
		}
		echo '<div class="aiqd-fab-stack">';
		if ( $s['show_float_cta'] && $s['float_cta_label'] ) {
			aiqd_btn( $s['float_cta_label'], $s['float_cta_link'], 'aiqd-btn--primary aiqd-float-cta', 'download' );
		}
		if ( $s['show_back_to_top'] ) {
			echo '<button type="button" class="aiqd-totop" aria-label="' . esc_attr__( 'Back to top', 'accessiq-demo' ) . '">';
			aiqd_e_icon( 'arrow-up', 20 );
			echo '</button>';
		}
		echo '</div>';
	}

	private function include_template( $tpl, $d, $s ) {
		$render = function () use ( $tpl, $d, $s ) {
			include $tpl;
		};
		$render();
	}

	/**
	 * [accessiq_demo] — renders the full body (no header/footer).
	 */
	public function shortcode( $atts ) {
		$atts = shortcode_atts( array( 'only' => '' ), $atts );
		$this->needs_assets = true;
		ob_start();
		$this->open_root();
		if ( $atts['only'] ) {
			$only = array_map( 'trim', explode( ',', $atts['only'] ) );
			foreach ( AIQD_Store::layout() as $inst ) {
				if ( ! empty( $inst['enabled'] ) && ( in_array( $inst['uid'], $only, true ) || in_array( $inst['type'], $only, true ) ) ) {
					$this->render_section( $inst );
				}
			}
		} else {
			$this->render_body();
		}
		$this->close_root();
		return ob_get_clean();
	}

	/**
	 * [accessiq_section type="pricing"] — render the first enabled section of a type.
	 */
	public function shortcode_section( $atts ) {
		$atts = shortcode_atts( array( 'type' => '' ), $atts );
		return $this->shortcode( array( 'only' => $atts['type'] ) );
	}

	/**
	 * Parse the plan feature textarea.
	 *
	 * @return array list of [ text, included(bool), strong(bool) ]
	 */
	public static function parse_features( $text ) {
		$out = array();
		foreach ( aiqd_lines( $text ) as $line ) {
			$inc    = true;
			$strong = false;
			if ( '-' === $line[0] ) {
				$inc  = false;
				$line = ltrim( substr( $line, 1 ) );
			} elseif ( '!' === $line[0] ) {
				$strong = true;
				$line   = ltrim( substr( $line, 1 ) );
			} elseif ( '+' === $line[0] ) {
				$line = ltrim( substr( $line, 1 ) );
			}
			// "annual text || lifetime text" → a different line per billing cycle.
			$alt = '';
			if ( false !== strpos( $line, '||' ) ) {
				list( $line, $alt ) = array_map( 'trim', explode( '||', $line, 2 ) );
			}
			$out[] = array(
				'text'   => $line,
				'alt'    => $alt,
				'inc'    => $inc,
				'strong' => $strong,
			);
		}
		return $out;
	}

	/**
	 * Parse the plan matrix textarea.
	 *
	 * @return array rows: [ type=group|row, label, cells[] ]
	 */
	public static function parse_matrix( $text ) {
		$rows = array();
		foreach ( aiqd_lines( $text ) as $line ) {
			if ( '#' === $line[0] ) {
				$rows[] = array(
					'type'  => 'group',
					'label' => trim( ltrim( $line, '# ' ) ),
				);
				continue;
			}
			$cells = array_map( 'trim', explode( '|', $line ) );
			$label = array_shift( $cells );
			$rows[] = array(
				'type'  => 'row',
				'label' => $label,
				'cells' => $cells,
			);
		}
		return $rows;
	}
}
