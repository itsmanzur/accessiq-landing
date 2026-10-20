<?php
/**
 * Admin: dashboard, page builder, pricing, links, header/footer, design, SEO, settings, import/export, docs.
 * All editing screens are schema-driven: PHP provides schemas + data, admin.js renders forms,
 * PHP re-sanitises every value by the same schema on save.
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

class AIQD_Admin {

	private static $instance = null;

	const CAP = 'manage_options';

	/**
	 * Admin pages: slug => [ menu label, page title, js page key ].
	 */
	private $pages = array();

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->pages = array(
			'aiqd'          => array( __( 'Dashboard', 'accessiq-demo' ), 'dashboard' ),
			'aiqd-builder'  => array( __( 'Page Builder', 'accessiq-demo' ), 'builder' ),
			'aiqd-pricing'  => array( __( 'Pricing Plans', 'accessiq-demo' ), 'plans' ),
			'aiqd-links'    => array( __( 'Links & Buttons', 'accessiq-demo' ), 'links' ),
			'aiqd-hf'       => array( __( 'Header, Footer & Thank-you', 'accessiq-demo' ), 'hf' ),
			'aiqd-design'   => array( __( 'Design', 'accessiq-demo' ), 'design' ),
			'aiqd-seo'      => array( __( 'SEO & LLM', 'accessiq-demo' ), 'seo' ),
			'aiqd-settings' => array( __( 'Settings', 'accessiq-demo' ), 'settings' ),
			'aiqd-io'       => array( __( 'Import / Export', 'accessiq-demo' ), 'io' ),
			'aiqd-docs'     => array( __( 'Documentation', 'accessiq-demo' ), 'docs' ),
		);
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'wp_ajax_aiqd_save', array( $this, 'ajax_save' ) );
		add_action( 'wp_ajax_aiqd_reset', array( $this, 'ajax_reset' ) );
		add_action( 'wp_ajax_aiqd_import', array( $this, 'ajax_import' ) );
		add_action( 'admin_post_aiqd_export', array( $this, 'export' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( AIQD_FILE ), array( $this, 'action_links' ) );
	}

	public function action_links( $links ) {
		array_unshift(
			$links,
			'<a href="' . esc_url( admin_url( 'admin.php?page=aiqd-builder' ) ) . '">' . esc_html__( 'Page Builder', 'accessiq-demo' ) . '</a>',
			'<a href="' . esc_url( admin_url( 'admin.php?page=aiqd' ) ) . '">' . esc_html__( 'Dashboard', 'accessiq-demo' ) . '</a>'
		);
		return $links;
	}

	public function menu() {
		add_menu_page( __( 'AccessIQ Landing', 'accessiq-demo' ), __( 'AccessIQ Landing', 'accessiq-demo' ), self::CAP, 'aiqd', array( $this, 'render' ), 'dashicons-layout', 58 );
		foreach ( $this->pages as $slug => $p ) {
			add_submenu_page( 'aiqd', $p[0] . ' — AccessIQ Landing', $p[0], self::CAP, $slug, array( $this, 'render' ) );
		}
	}

	private function current_page_key() {
		$slug = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
		return isset( $this->pages[ $slug ] ) ? $this->pages[ $slug ][1] : '';
	}

	/* ───────────── rendering ───────────── */

	public function render() {
		$key = $this->current_page_key();
		if ( ! $key ) {
			return;
		}
		echo '<div class="wrap aiqda-wrap"><h1 class="screen-reader-text">' . esc_html__( 'AccessIQ Landing', 'accessiq-demo' ) . '</h1>';
		$this->nav( $key );
		if ( 'dashboard' === $key ) {
			include AIQD_DIR . 'admin/views/dashboard.php';
		} elseif ( 'docs' === $key ) {
			include AIQD_DIR . 'admin/views/docs.php';
		} else {
			echo '<div id="aiqda-app" class="aiqda-app" data-page="' . esc_attr( $key ) . '"><p class="aiqda-loading">' . esc_html__( 'Loading…', 'accessiq-demo' ) . '</p></div>';
			echo '<noscript><p>' . esc_html__( 'This screen needs JavaScript.', 'accessiq-demo' ) . '</p></noscript>';
		}
		echo '</div>';
	}

	private function nav( $current ) {
		echo '<header class="aiqda-top"><div class="aiqda-brand"><span class="aiqda-brand__mark"><span class="dashicons dashicons-layout"></span></span><div><strong>AccessIQ Landing</strong><small>v' . esc_html( AIQD_VERSION ) . '</small></div></div>';
		echo '<nav class="aiqda-nav" aria-label="' . esc_attr__( 'AccessIQ Landing', 'accessiq-demo' ) . '">';
		foreach ( $this->pages as $slug => $p ) {
			printf(
				'<a href="%s"%s>%s</a>',
				esc_url( admin_url( 'admin.php?page=' . $slug ) ),
				$p[1] === $current ? ' class="is-active" aria-current="page"' : '',
				esc_html( $p[0] )
			);
		}
		echo '</nav>';
		$url = $this->landing_url();
		if ( $url ) {
			echo '<a class="aiqda-btn aiqda-btn--primary" target="_blank" rel="noopener" href="' . esc_url( $url ) . '">' . esc_html__( 'View landing page', 'accessiq-demo' ) . ' ↗</a>';
		}
		echo '</header>';
	}

	private function landing_url() {
		$id = (int) AIQD_Store::setting( 'page_id', 0 );
		return ( $id && 'publish' === get_post_status( $id ) ) ? get_permalink( $id ) : '';
	}

	/* ───────────── assets ───────────── */

	public function assets( $hook ) {
		if ( false === strpos( (string) $hook, 'aiqd' ) ) {
			return;
		}
		$key = $this->current_page_key();
		wp_enqueue_style( 'aiqd-admin', AIQD_URL . 'assets/css/admin.css', array(), AIQD_VERSION );
		if ( in_array( $key, array( 'dashboard', 'docs' ), true ) ) {
			wp_enqueue_script( 'aiqd-admin-lite', AIQD_URL . 'assets/js/admin-lite.js', array(), AIQD_VERSION, true );
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script( 'aiqd-admin', AIQD_URL . 'assets/js/admin.js', array( 'jquery', 'jquery-ui-sortable' ), AIQD_VERSION, true );
		wp_localize_script( 'aiqd-admin', 'AIQDA', $this->js_data( $key ) );
	}

	/**
	 * Data handed to admin.js for the current screen.
	 */
	private function js_data( $key ) {
		$reg   = AIQD_Registry::instance();
		$types = array();
		foreach ( $reg->all() as $type => $cfg ) {
			$types[ $type ] = array(
				'label'    => $cfg['label'],
				'icon'     => $cfg['icon'],
				'desc'     => $cfg['desc'],
				'zone'     => $cfg['zone'],
				'group'    => $cfg['group'],
				'schema'   => $cfg['schema'],
				'defaults' => (object) $cfg['defaults'],
			);
		}
		$icons = array();
		foreach ( aiqd_icon_set() as $name => $svg ) {
			$icons[ $name ] = $svg;
		}
		$link_keys = array();
		foreach ( AIQD_Store::links() as $k => $l ) {
			$link_keys[ $k ] = $l['label'];
		}

		$links_rows = array();
		foreach ( AIQD_Store::links() as $k => $l ) {
			$links_rows[] = array(
				'key'   => $k,
				'label' => $l['label'],
				'url'   => $l['url'],
				'new'   => ! empty( $l['new'] ) ? 1 : 0,
			);
		}

		$data = array(
			'ajax'      => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'aiqd_admin' ),
			'exportUrl' => wp_nonce_url( admin_url( 'admin-post.php?action=aiqd_export' ), 'aiqd_admin' ),
			'page'      => $key,
			'siteUrl'   => $this->landing_url(),
			'canHtml'   => current_user_can( 'unfiltered_html' ),
			'icons'     => (object) $icons,
			'linkKeys'  => (object) $link_keys,
			'types'     => (object) $types,
			'styleFields' => AIQD_Registry::style_fields(),
			'schemas'   => array(
				'plans'    => $this->plans_schema(),
				'links'    => $this->links_schema(),
				'design'   => $this->design_schema(),
				'seo'      => $this->seo_schema(),
				'settings' => $this->settings_schema(),
			),
			'data'      => array(
				'layout'   => AIQD_Store::layout(),
				'plans'    => AIQD_Store::plans(),
				'matrix'   => AIQD_Store::matrix(),
				'links'    => $links_rows,
				'header'   => (object) AIQD_Store::header(),
				'footer'   => (object) AIQD_Store::footer(),
				'thanks'   => (object) AIQD_Store::thanks(),
				'design'   => (object) AIQD_Store::design(),
				'seo'      => (object) AIQD_Store::seo(),
				'settings' => (object) AIQD_Store::settings(),
			),
			'i18n'      => array(
				'save'        => __( 'Save changes', 'accessiq-demo' ),
				'saved'       => __( 'Saved', 'accessiq-demo' ),
				'saving'      => __( 'Saving…', 'accessiq-demo' ),
				'unsaved'     => __( 'Unsaved changes', 'accessiq-demo' ),
				'error'       => __( 'Could not save. Please try again.', 'accessiq-demo' ),
				'addSection'  => __( 'Add section', 'accessiq-demo' ),
				'edit'        => __( 'Edit', 'accessiq-demo' ),
				'duplicate'   => __( 'Duplicate', 'accessiq-demo' ),
				'delete'      => __( 'Delete', 'accessiq-demo' ),
				'confirmDel'  => __( 'Delete this item?', 'accessiq-demo' ),
				'moveUp'      => __( 'Move up', 'accessiq-demo' ),
				'moveDown'    => __( 'Move down', 'accessiq-demo' ),
				'enabled'     => __( 'Visible', 'accessiq-demo' ),
				'hidden'      => __( 'Hidden', 'accessiq-demo' ),
				'resetSec'    => __( 'Reset to defaults', 'accessiq-demo' ),
				'confirmReset' => __( 'Reset this section’s content to its defaults?', 'accessiq-demo' ),
				'addItem'     => __( 'Add item', 'accessiq-demo' ),
				'choose'      => __( 'Choose image', 'accessiq-demo' ),
				'remove'      => __( 'Remove', 'accessiq-demo' ),
				'preview'     => __( 'Live preview', 'accessiq-demo' ),
				'content'     => __( 'Content', 'accessiq-demo' ),
				'style'       => __( 'Style & visibility', 'accessiq-demo' ),
				'anchor'      => __( 'Anchor ID (for #links)', 'accessiq-demo' ),
				'insertHere'  => __( 'Insert a section here', 'accessiq-demo' ),
				'noSections'  => __( 'No sections yet. Add your first one.', 'accessiq-demo' ),
				'link'        => __( 'Link', 'accessiq-demo' ),
				'linkHelp'    => __( 'Pick a saved link (@name) or paste any URL / #anchor.', 'accessiq-demo' ),
			),
		);
		return $data;
	}

	/* ───────────── schemas ───────────── */

	private function pages_options() {
		$out   = array( '0' => __( '— none (use shortcode) —', 'accessiq-demo' ) );
		$pages = get_pages( array( 'post_status' => 'publish,draft,private', 'number' => 200 ) );
		foreach ( $pages as $p ) {
			$out[ (string) $p->ID ] = $p->post_title . ' (#' . $p->ID . ')';
		}
		return $out;
	}

	public function settings_schema() {
		return array(
			array( 'key' => 'page_id', 'type' => 'select', 'label' => __( 'Landing page', 'accessiq-demo' ), 'help' => __( 'The WordPress page that shows the landing design. Set it as your static front page in Settings → Reading if you want it on the home URL.', 'accessiq-demo' ), 'options' => $this->pages_options() ),
			array( 'key' => 'thankyou_page_id', 'type' => 'select', 'label' => __( 'Thank-you page', 'accessiq-demo' ), 'help' => __( 'Shown after a Freemius purchase (URL set in “After-purchase redirect URL”). Always noindex.', 'accessiq-demo' ), 'options' => $this->pages_options() ),
			array( 'key' => 'header_source', 'type' => 'select', 'label' => __( 'Header comes from', 'accessiq-demo' ), 'options' => array( 'plugin' => __( 'This plugin (Header section)', 'accessiq-demo' ), 'theme' => __( 'Active theme', 'accessiq-demo' ), 'none' => __( 'Nothing', 'accessiq-demo' ) ) ),
			array( 'key' => 'footer_source', 'type' => 'select', 'label' => __( 'Footer comes from', 'accessiq-demo' ), 'options' => array( 'plugin' => __( 'This plugin (Footer section)', 'accessiq-demo' ), 'theme' => __( 'Active theme', 'accessiq-demo' ), 'none' => __( 'Nothing', 'accessiq-demo' ) ) ),
			array( 'key' => 'brand_name', 'type' => 'text', 'label' => __( 'Brand name', 'accessiq-demo' ) ),
			array( 'key' => 'brand_logo', 'type' => 'image', 'label' => __( 'Logo (used in schema.org data)', 'accessiq-demo' ) ),
			array( 'key' => 'currency', 'type' => 'text', 'label' => __( 'Currency symbol', 'accessiq-demo' ), 'help' => __( '$, €, £, ৳ … Used in pricing and structured data.', 'accessiq-demo' ) ),
			array( 'key' => 'freemius_plugin_id', 'type' => 'text', 'label' => __( 'Freemius product (plugin) ID', 'accessiq-demo' ), 'help' => __( 'Used to build checkout links: https://checkout.freemius.com/plugin/{id}/plan/{plan id}/', 'accessiq-demo' ) ),
			array( 'key' => 'freemius_checkout', 'type' => 'text', 'label' => __( 'Freemius checkout base URL (no-JS fallback links)', 'accessiq-demo' ) ),
			array( 'key' => 'freemius_public_key', 'type' => 'text', 'label' => __( 'Freemius public key', 'accessiq-demo' ), 'help' => __( 'Freemius → Settings → Keys (pk_…). Until a real key is set, buy buttons stay plain links instead of opening the overlay.', 'accessiq-demo' ) ),
			array( 'key' => 'checkout_name', 'type' => 'text', 'label' => __( 'Checkout product name', 'accessiq-demo' ) ),
			array( 'key' => 'success_url', 'type' => 'text', 'label' => __( 'After-purchase redirect URL', 'accessiq-demo' ) ),
			array( 'key' => '_h1', 'type' => 'notice', 'label' => __( 'Floating elements', 'accessiq-demo' ) ),
			array( 'key' => 'show_progress', 'type' => 'toggle', 'label' => __( 'Scroll progress bar', 'accessiq-demo' ) ),
			array( 'key' => 'show_dots_nav', 'type' => 'toggle', 'label' => __( 'Side dot navigation (desktop)', 'accessiq-demo' ) ),
			array( 'key' => 'show_back_to_top', 'type' => 'toggle', 'label' => __( 'Back-to-top button', 'accessiq-demo' ) ),
			array( 'key' => 'show_theme_toggle', 'type' => 'toggle', 'label' => __( 'Light / dark toggle in header', 'accessiq-demo' ) ),
			array( 'key' => 'show_float_cta', 'type' => 'toggle', 'label' => __( 'Floating call-to-action button', 'accessiq-demo' ) ),
			array( 'key' => 'float_cta_label', 'type' => 'text', 'label' => __( 'Floating button label', 'accessiq-demo' ) ),
			array( 'key' => 'float_cta_link', 'type' => 'link', 'label' => __( 'Floating button link', 'accessiq-demo' ) ),
		);
	}

	public function design_schema() {
		return array(
			array( 'key' => 'default_theme', 'type' => 'select', 'label' => __( 'Default theme', 'accessiq-demo' ), 'options' => array( 'dark' => __( 'Dark', 'accessiq-demo' ), 'light' => __( 'Light', 'accessiq-demo' ), 'system' => __( 'Follow visitor’s system', 'accessiq-demo' ) ) ),
			array( 'key' => 'primary', 'type' => 'color', 'label' => __( 'Primary colour', 'accessiq-demo' ), 'help' => __( 'Buttons use dark text on this colour — keep it light/mid-tone for AA contrast.', 'accessiq-demo' ) ),
			array( 'key' => 'accent', 'type' => 'color', 'label' => __( 'Accent colour (gradients)', 'accessiq-demo' ) ),
			array( 'key' => 'warm', 'type' => 'color', 'label' => __( 'Warm highlight', 'accessiq-demo' ) ),
			array( 'key' => 'danger', 'type' => 'color', 'label' => __( 'Danger colour', 'accessiq-demo' ) ),
			array( 'key' => 'dark_bg', 'type' => 'color', 'label' => __( 'Dark theme background', 'accessiq-demo' ) ),
			array( 'key' => 'light_bg', 'type' => 'color', 'label' => __( 'Light theme background', 'accessiq-demo' ) ),
			array( 'key' => 'radius', 'type' => 'number', 'label' => __( 'Corner radius (px)', 'accessiq-demo' ) ),
			array( 'key' => 'max_width', 'type' => 'number', 'label' => __( 'Content max width (px)', 'accessiq-demo' ) ),
			array( 'key' => 'font', 'type' => 'select', 'label' => __( 'Fonts', 'accessiq-demo' ), 'help' => __( 'Bengali text automatically uses the bundled Hind Siliguri.', 'accessiq-demo' ), 'options' => array( 'brand' => __( 'Brand: Space Grotesk + Inter (self-hosted)', 'accessiq-demo' ), 'system' => __( 'System sans (no font files)', 'accessiq-demo' ), 'rounded' => __( 'Rounded', 'accessiq-demo' ), 'serif' => __( 'Serif', 'accessiq-demo' ) ) ),
			array( 'key' => 'motion', 'type' => 'select', 'label' => __( 'Animations', 'accessiq-demo' ), 'options' => array( 'on' => __( 'On (respects reduced-motion)', 'accessiq-demo' ), 'off' => __( 'Off', 'accessiq-demo' ) ) ),
			array( 'key' => 'grain', 'type' => 'toggle', 'label' => __( 'Subtle grain', 'accessiq-demo' ) ),
			array( 'key' => 'custom_css', 'type' => 'css', 'rows' => 8, 'label' => __( 'Custom CSS', 'accessiq-demo' ), 'help' => __( 'Prefix selectors with .aiqd-root. Variables: --primary, --accent, --radius …', 'accessiq-demo' ) ),
		);
	}

	public function seo_schema() {
		return array(
			array( 'key' => 'title', 'type' => 'text', 'label' => __( 'SEO title', 'accessiq-demo' ), 'help' => __( '30–65 characters.', 'accessiq-demo' ) ),
			array( 'key' => 'description', 'type' => 'textarea', 'label' => __( 'Meta description', 'accessiq-demo' ), 'help' => __( '80–170 characters. Also used for Open Graph and schema.', 'accessiq-demo' ) ),
			array( 'key' => 'keywords', 'type' => 'text', 'label' => __( 'Keywords (comma separated)', 'accessiq-demo' ) ),
			array( 'key' => 'og_image', 'type' => 'image', 'label' => __( 'Open Graph / social image (1200×630)', 'accessiq-demo' ) ),
			array( 'key' => 'twitter', 'type' => 'text', 'label' => __( 'X / Twitter handle', 'accessiq-demo' ) ),
			array( 'key' => 'noindex', 'type' => 'toggle', 'label' => __( 'Hide from search engines (noindex) — keep ON while testing locally', 'accessiq-demo' ) ),
			array( 'key' => '_h1', 'type' => 'notice', 'label' => __( 'Structured data & LLM', 'accessiq-demo' ) ),
			array( 'key' => 'schema', 'type' => 'toggle', 'label' => __( 'Output JSON-LD (Organization, SoftwareApplication + Offers, FAQPage, HowTo, Breadcrumb)', 'accessiq-demo' ) ),
			array( 'key' => 'llms', 'type' => 'toggle', 'label' => __( 'Serve /llms.txt and /llms-full.txt', 'accessiq-demo' ) ),
			array( 'key' => 'llms_intro', 'type' => 'textarea', 'label' => __( 'llms.txt introduction', 'accessiq-demo' ) ),
			array( 'key' => 'ai_bots', 'type' => 'toggle', 'label' => __( 'Add AI crawler allow-rules to robots.txt', 'accessiq-demo' ) ),
			array( 'key' => 'org_name', 'type' => 'text', 'label' => __( 'Organization name', 'accessiq-demo' ) ),
			array( 'key' => 'org_url', 'type' => 'text', 'label' => __( 'Organization URL', 'accessiq-demo' ) ),
			array( 'key' => 'same_as', 'type' => 'lines', 'label' => __( 'Official profiles (sameAs, one URL per line)', 'accessiq-demo' ) ),
			array( 'key' => 'app_category', 'type' => 'text', 'label' => __( 'Software category (schema.org)', 'accessiq-demo' ) ),
			array( 'key' => 'os', 'type' => 'text', 'label' => __( 'Operating system / requirements', 'accessiq-demo' ) ),
		);
	}

	public function plans_schema() {
		return array(
			array(
				'key'        => 'plans',
				'type'       => 'repeater',
				'label'      => __( 'Plans', 'accessiq-demo' ),
				'item_label' => 'name',
				'fields'     => array(
					array( 'key' => 'id', 'type' => 'text', 'label' => __( 'ID (slug, unique)', 'accessiq-demo' ) ),
					array( 'key' => 'name', 'type' => 'text', 'label' => __( 'Plan name', 'accessiq-demo' ) ),
					array( 'key' => 'tagline', 'type' => 'textarea', 'label' => __( 'Short description', 'accessiq-demo' ) ),
					array( 'key' => 'badge', 'type' => 'text', 'label' => __( 'Ribbon text (e.g. Most popular)', 'accessiq-demo' ) ),
					array( 'key' => 'highlight', 'type' => 'toggle', 'label' => __( 'Highlight this plan', 'accessiq-demo' ) ),
					array( 'key' => 'is_free', 'type' => 'toggle', 'label' => __( 'This is the free plan (no price, download button)', 'accessiq-demo' ) ),
					array( 'key' => 'price_annual', 'type' => 'number', 'label' => __( 'Annual price (per year)', 'accessiq-demo' ) ),
					array( 'key' => 'price_lifetime', 'type' => 'number', 'label' => __( 'Lifetime price (one-time)', 'accessiq-demo' ) ),
					array( 'key' => 'sites', 'type' => 'text', 'label' => __( 'Sites line (e.g. 5 sites)', 'accessiq-demo' ) ),
					array( 'key' => 'plan_id', 'type' => 'text', 'label' => __( 'Freemius plan ID', 'accessiq-demo' ), 'help' => __( 'Opens the Freemius overlay checkout (needs the public key in Settings). Also builds the no-JS fallback link.', 'accessiq-demo' ) ),
					array( 'key' => 'pricing_id', 'type' => 'text', 'label' => __( 'Freemius pricing ID', 'accessiq-demo' ) ),
					array( 'key' => 'licenses', 'type' => 'number', 'label' => __( 'Licenses (0 = unlimited)', 'accessiq-demo' ) ),
					array( 'key' => 'cta_label', 'type' => 'text', 'label' => __( 'Button label', 'accessiq-demo' ) ),
					array( 'key' => 'cta_link', 'type' => 'link', 'label' => __( 'Button link override', 'accessiq-demo' ), 'help' => __( 'Leave empty to use the Freemius checkout link. For the free plan use @download_free.', 'accessiq-demo' ) ),
					array( 'key' => 'note', 'type' => 'text', 'label' => __( 'Small note under button', 'accessiq-demo' ) ),
					array( 'key' => 'lead', 'type' => 'text', 'label' => __( 'Line above the feature list (e.g. Everything in Free, plus:)', 'accessiq-demo' ) ),
					array( 'key' => 'features', 'type' => 'textarea', 'rows' => 12, 'label' => __( 'Feature list (one per line)', 'accessiq-demo' ), 'help' => __( 'Plain line = included. "-" prefix = not included. "!" prefix = highlighted. "annual text || lifetime text" shows a different line per billing cycle.', 'accessiq-demo' ) ),
				),
			),
		);
	}

	public function links_schema() {
		return array(
			array( 'key' => 'key', 'type' => 'text', 'label' => __( 'Key', 'accessiq-demo' ), 'help' => __( 'Use it anywhere as @key', 'accessiq-demo' ) ),
			array( 'key' => 'label', 'type' => 'text', 'label' => __( 'Name (for you)', 'accessiq-demo' ) ),
			array( 'key' => 'url', 'type' => 'text', 'label' => __( 'URL', 'accessiq-demo' ) ),
			array( 'key' => 'new', 'type' => 'toggle', 'label' => __( 'Open in new tab', 'accessiq-demo' ) ),
		);
	}

	/* ───────────── sanitising ───────────── */

	/**
	 * Sanitise a value by schema field.
	 */
	public function clean_field( $f, $v ) {
		switch ( $f['type'] ) {
			case 'text':
				return sanitize_text_field( is_scalar( $v ) ? (string) $v : '' );
			case 'textarea':
			case 'lines':
				return sanitize_textarea_field( is_scalar( $v ) ? (string) $v : '' );
			case 'richtext':
				return wp_kses_post( is_scalar( $v ) ? (string) $v : '' );
			case 'code':
				$v = is_scalar( $v ) ? (string) $v : '';
				return current_user_can( 'unfiltered_html' ) ? $v : wp_kses_post( $v );
			case 'css':
				return wp_strip_all_tags( is_scalar( $v ) ? (string) $v : '' );
			case 'link':
				$v = trim( is_scalar( $v ) ? (string) $v : '' );
				if ( '' === $v ) {
					return '';
				}
				if ( '@' === $v[0] ) {
					return '@' . preg_replace( '/[^a-z0-9_\-]/i', '', substr( $v, 1 ) );
				}
				if ( '#' === $v[0] ) {
					return '#' . preg_replace( '/[^A-Za-z0-9_\-]/', '', substr( $v, 1 ) );
				}
				return esc_url_raw( $v, array( 'http', 'https', 'mailto', 'tel' ) );
			case 'image':
				return esc_url_raw( is_scalar( $v ) ? (string) $v : '' );
			case 'toggle':
				return ! empty( $v ) && 'false' !== $v && '0' !== $v ? 1 : 0;
			case 'number':
				return ( is_numeric( $v ) ? $v + 0 : 0 );
			case 'color':
				$c = sanitize_hex_color( is_scalar( $v ) ? (string) $v : '' );
				return $c ? $c : '';
			case 'icon':
				$set = aiqd_icon_set();
				return ( is_scalar( $v ) && isset( $set[ $v ] ) ) ? (string) $v : '';
			case 'select':
				$opts = isset( $f['options'] ) ? array_map( 'strval', array_keys( $f['options'] ) ) : array();
				$v    = is_scalar( $v ) ? (string) $v : '';
				if ( in_array( $v, $opts, true ) ) {
					return $v;
				}
				return $opts ? $opts[0] : '';
			case 'repeater':
				$out = array();
				if ( is_array( $v ) ) {
					foreach ( $v as $item ) {
						if ( is_array( $item ) ) {
							$out[] = $this->clean_schema( $f['fields'], $item );
						}
					}
				}
				return $out;
		}
		return '';
	}

	public function clean_schema( $schema, $data ) {
		$out = array();
		foreach ( $schema as $f ) {
			if ( 'notice' === $f['type'] ) {
				continue;
			}
			$k         = $f['key'];
			$out[ $k ] = $this->clean_field( $f, isset( $data[ $k ] ) ? $data[ $k ] : '' );
		}
		return $out;
	}

	private function clean_layout( $rows ) {
		$reg  = AIQD_Registry::instance();
		$out  = array();
		$uids = array();
		if ( ! is_array( $rows ) ) {
			return $out;
		}
		foreach ( $rows as $row ) {
			if ( ! is_array( $row ) || empty( $row['type'] ) ) {
				continue;
			}
			$type = sanitize_key( $row['type'] );
			$cfg  = $reg->get_type( $type );
			if ( ! $cfg || 'body' !== $cfg['zone'] ) {
				continue;
			}
			$uid = isset( $row['uid'] ) ? sanitize_key( $row['uid'] ) : '';
			if ( ! $uid || isset( $uids[ $uid ] ) ) {
				$uid = 's-' . substr( md5( uniqid( $type, true ) ), 0, 8 );
			}
			$uids[ $uid ] = 1;
			$style        = $this->clean_schema( AIQD_Registry::style_fields(), isset( $row['style'] ) && is_array( $row['style'] ) ? $row['style'] : array() );
			$data         = $this->clean_schema( $cfg['schema'], isset( $row['data'] ) && is_array( $row['data'] ) ? $row['data'] : array() );
			// Only keep keys the user actually changed from defaults to keep the option small.
			foreach ( $data as $k => $v ) {
				if ( array_key_exists( $k, $cfg['defaults'] ) && $this->same( $cfg['defaults'][ $k ], $v ) ) {
					unset( $data[ $k ] );
				}
			}
			$out[] = array(
				'uid'     => $uid,
				'type'    => $type,
				'enabled' => ! empty( $row['enabled'] ) ? 1 : 0,
				'anchor'  => isset( $row['anchor'] ) ? sanitize_title( $row['anchor'] ) : '',
				'style'   => $style,
				'data'    => $data,
			);
		}
		return $out;
	}

	/**
	 * Loose equality for nested values (numbers and numeric strings compare equal).
	 */
	private function same( $a, $b ) {
		$norm = function ( $v ) use ( &$norm ) {
			if ( is_array( $v ) ) {
				return array_map( $norm, $v );
			}
			return (string) $v;
		};
		return wp_json_encode( $norm( $a ) ) === wp_json_encode( $norm( $b ) );
	}

	private function clean_links( $rows ) {
		$out = array();
		if ( ! is_array( $rows ) ) {
			return $out;
		}
		foreach ( $rows as $r ) {
			if ( ! is_array( $r ) ) {
				continue;
			}
			$key = isset( $r['key'] ) ? preg_replace( '/[^a-z0-9_\-]/', '', strtolower( (string) $r['key'] ) ) : '';
			if ( '' === $key ) {
				continue;
			}
			$url = isset( $r['url'] ) ? trim( (string) $r['url'] ) : '';
			if ( '' !== $url && '#' !== $url[0] ) {
				$url = esc_url_raw( $url, array( 'http', 'https', 'mailto', 'tel' ) );
			} else {
				$url = '#' . preg_replace( '/[^A-Za-z0-9_\-]/', '', ltrim( $url, '#' ) );
			}
			$out[ $key ] = array(
				'label' => isset( $r['label'] ) ? sanitize_text_field( $r['label'] ) : $key,
				'url'   => $url,
				'new'   => ! empty( $r['new'] ) ? 1 : 0,
			);
		}
		return $out;
	}

	/**
	 * Sanitise + store one group.
	 */
	private function save_group( $group, $value ) {
		$reg = AIQD_Registry::instance();
		switch ( $group ) {
			case 'layout':
				AIQD_Store::set( 'layout', $this->clean_layout( $value ) );
				break;
			case 'plans':
				$schema = $this->plans_schema();
				$clean  = $this->clean_field( $schema[0], $value );
				foreach ( $clean as $i => $p ) {
					$clean[ $i ]['id'] = $p['id'] ? sanitize_key( $p['id'] ) : 'plan-' . ( $i + 1 );
				}
				AIQD_Store::set( 'plans', $clean );
				break;
			case 'matrix':
				AIQD_Store::set( 'matrix', sanitize_textarea_field( is_scalar( $value ) ? (string) $value : '' ) );
				break;
			case 'links':
				AIQD_Store::set( 'links', $this->clean_links( $value ) );
				break;
			case 'header':
			case 'footer':
			case 'thanks':
				$cfg = $reg->get_type( $group );
				AIQD_Store::set( $group, $this->clean_schema( $cfg['schema'], is_array( $value ) ? $value : array() ) );
				break;
			case 'design':
				AIQD_Store::set( 'design', $this->clean_schema( $this->design_schema(), is_array( $value ) ? $value : array() ) );
				break;
			case 'seo':
				AIQD_Store::set( 'seo', $this->clean_schema( $this->seo_schema(), is_array( $value ) ? $value : array() ) );
				break;
			case 'settings':
				$old   = AIQD_Store::settings();
				$clean = $this->clean_schema( $this->settings_schema(), is_array( $value ) ? $value : array() );
				$clean['page_id'] = (int) $clean['page_id'];
				AIQD_Store::set( 'settings', array_replace( $old, $clean ) );
				break;
		}
	}

	private function check_request() {
		if ( ! current_user_can( self::CAP ) ) {
			wp_send_json_error( array( 'message' => 'forbidden' ), 403 );
		}
		check_ajax_referer( 'aiqd_admin', 'nonce' );
	}

	public function ajax_save() {
		$this->check_request();
		$payload = isset( $_POST['payload'] ) ? json_decode( wp_unslash( $_POST['payload'] ), true ) : null; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( ! is_array( $payload ) ) {
			wp_send_json_error( array( 'message' => 'bad payload' ), 400 );
		}
		$allowed = array( 'layout', 'plans', 'matrix', 'links', 'header', 'footer', 'thanks', 'design', 'seo', 'settings' );
		foreach ( $payload as $group => $value ) {
			if ( in_array( $group, $allowed, true ) ) {
				$this->save_group( $group, $value );
			}
		}
		wp_send_json_success(
			array(
				'layout' => AIQD_Store::layout(),
				'url'    => $this->landing_url(),
			)
		);
	}

	public function ajax_reset() {
		$this->check_request();
		$group = isset( $_POST['group'] ) ? sanitize_key( wp_unslash( $_POST['group'] ) ) : '';
		$all   = array( 'layout', 'plans', 'matrix', 'links', 'header', 'footer', 'thanks', 'design', 'seo', 'settings' );
		if ( 'all' === $group ) {
			foreach ( $all as $g ) {
				if ( 'settings' === $g ) {
					continue; // Keep the assigned page.
				}
				AIQD_Store::reset( $g );
			}
		} elseif ( in_array( $group, $all, true ) ) {
			AIQD_Store::reset( $group );
		}
		wp_send_json_success();
	}

	public function ajax_import() {
		$this->check_request();
		$json = isset( $_POST['json'] ) ? json_decode( wp_unslash( $_POST['json'] ), true ) : null; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( ! is_array( $json ) || empty( $json['aiqd'] ) || ! is_array( $json['groups'] ) ) {
			wp_send_json_error( array( 'message' => __( 'This is not an AccessIQ Landing export file.', 'accessiq-demo' ) ), 400 );
		}
		$allowed = array( 'layout', 'plans', 'matrix', 'links', 'header', 'footer', 'thanks', 'design', 'seo' );
		$count   = 0;
		foreach ( $json['groups'] as $group => $value ) {
			if ( in_array( $group, $allowed, true ) ) {
				if ( 'links' === $group && is_array( $value ) && ! isset( $value[0] ) ) {
					// Assoc form (as stored) → rows.
					$rows = array();
					foreach ( $value as $k => $l ) {
						$rows[] = array( 'key' => $k, 'label' => $l['label'], 'url' => $l['url'], 'new' => $l['new'] );
					}
					$value = $rows;
				}
				$this->save_group( $group, $value );
				$count++;
			}
		}
		wp_send_json_success( array( 'imported' => $count ) );
	}

	public function export() {
		if ( ! current_user_can( self::CAP ) ) {
			wp_die( esc_html__( 'Not allowed.', 'accessiq-demo' ) );
		}
		check_admin_referer( 'aiqd_admin' );
		$out = array(
			'aiqd'     => AIQD_VERSION,
			'exported' => gmdate( 'c' ),
			'groups'   => array(
				'layout' => AIQD_Store::layout(),
				'plans'  => AIQD_Store::plans(),
				'matrix' => AIQD_Store::matrix(),
				'links'  => AIQD_Store::links(),
				'header' => AIQD_Store::header(),
				'footer' => AIQD_Store::footer(),
				'thanks' => AIQD_Store::thanks(),
				'design' => AIQD_Store::design(),
				'seo'    => AIQD_Store::seo(),
			),
		);
		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="accessiq-demo-' . gmdate( 'Ymd-His' ) . '.json"' );
		echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); // phpcs:ignore WordPress.Security.EscapeOutput
		exit;
	}
}
