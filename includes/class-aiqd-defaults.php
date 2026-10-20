<?php
/**
 * Default data for every global store (links, plans, header, footer, design, seo, layout).
 * All values are editable from the dashboard; nothing here is hard-wired into templates.
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

class AIQD_Defaults {

	/**
	 * General settings.
	 */
	public static function settings() {
		return array(
			'page_id'             => 0,
			'thankyou_page_id'    => 0,
			'header_source'       => 'plugin', // plugin | theme | none.
			'footer_source'       => 'plugin',
			'brand_name'          => 'AccessIQ',
			'brand_logo'          => '',
			'freemius_plugin_id'  => '28875',
			'freemius_checkout'   => 'https://checkout.freemius.com',
			'freemius_public_key' => 'pk_71c98e72e08a3d09f9d883cf36bbe', // Freemius → Settings → Keys (public key).
			'checkout_name'       => 'AccessIQ Pro',
			'success_url'         => '/thank-you/',
			'currency'            => '$',
			'show_progress'       => 1,
			'show_dots_nav'       => 1,
			'show_back_to_top'    => 1,
			'show_float_cta'      => 1,
			'float_cta_label'     => 'Get AccessIQ Free',
			'float_cta_link'      => '@download_free',
			'show_theme_toggle'   => 1,
		);
	}

	/**
	 * Global link registry. Buttons reference these as "@key".
	 */
	public static function links() {
		return array(
			'download_free' => array( 'label' => 'Download free (WordPress.org)', 'url' => 'https://wordpress.org/plugins/accessiq/', 'new' => 1 ),
			'pricing'       => array( 'label' => 'Pricing section', 'url' => '#pricing', 'new' => 0 ),
			'features'      => array( 'label' => 'Features section', 'url' => '#modules', 'new' => 0 ),
			'live_demo'     => array( 'label' => 'Live demo', 'url' => 'https://accessiq.thereadscope.com/', 'new' => 1 ),
			'docs'          => array( 'label' => 'Documentation', 'url' => 'https://accessiq.thereadscope.com/', 'new' => 1 ),
			'support'       => array( 'label' => 'Support forum', 'url' => 'https://wordpress.org/support/plugin/accessiq/', 'new' => 1 ),
			'changelog'     => array( 'label' => 'Changelog', 'url' => 'https://wordpress.org/plugins/accessiq/#developers', 'new' => 1 ),
			'account'       => array( 'label' => 'Customer account (Freemius)', 'url' => 'https://users.freemius.com/', 'new' => 1 ),
			'contact'       => array( 'label' => 'Contact', 'url' => 'mailto:hello@thereadscope.com', 'new' => 0 ),
			'privacy'       => array( 'label' => 'Privacy policy', 'url' => '/privacy-policy/', 'new' => 0 ),
			'terms'         => array( 'label' => 'Terms of service', 'url' => '/terms/', 'new' => 0 ),
			'refund'        => array( 'label' => 'Refund policy', 'url' => '/refund-policy/', 'new' => 0 ),
			'author'        => array( 'label' => 'Author (readscope)', 'url' => 'https://profiles.wordpress.org/readscope', 'new' => 1 ),
		);
	}

	/**
	 * Pricing plans (Freemius). Prices: annual = per year, lifetime = one-time.
	 * Feature lines: plain = included, "-" prefix = not included, "!" prefix = highlighted,
	 * "annual text || lifetime text" shows a different line per billing cycle.
	 */
	public static function plans() {
		return array(
			array(
				'id'             => 'free',
				'name'           => 'Free',
				'tagline'        => 'Forever free. No credit card.',
				'badge'          => '',
				'highlight'      => 0,
				'is_free'        => 1,
				'price_annual'   => '0',
				'price_lifetime' => '0',
				'sites'          => 'Unlimited sites',
				'plan_id'        => '',
				'pricing_id'     => '',
				'licenses'       => '1',
				'cta_label'      => 'Download Free',
				'cta_link'       => '@download_free',
				'note'           => '',
				'lead'           => '',
				'features'       => "Unlimited WCAG 2.1 scans (A / AA / AAA)\nCompliance score, history & trend chart\nSelf-hosted click heatmaps\nBehavior analytics (sessions, bounce, devices)\nFrontend accessibility widget\nScheduled scans with email alerts\nPrint reports",
			),
			array(
				'id'             => 'starter',
				'name'           => 'Starter',
				'tagline'        => 'Top pick for individual site owners',
				'badge'          => '',
				'highlight'      => 0,
				'is_free'        => 0,
				'price_annual'   => '59',
				'price_lifetime' => '179',
				'sites'          => '1 site',
				'plan_id'        => '47504',
				'pricing_id'     => '61847',
				'licenses'       => '1',
				'cta_label'      => 'Get Starter',
				'cta_link'       => '',
				'note'           => '',
				'lead'           => 'Everything in Free, plus:',
				'features'       => "PDF compliance reports\nAI alt text generator\nHeading Hierarchy Fixer (one-click)\nARIA Label Auto-Writer\nAdvanced analytics\nEmail report delivery after scans\n1 year updates & support || Lifetime updates & support",
			),
			array(
				'id'             => 'pro',
				'name'           => 'Pro',
				'tagline'        => 'Best for freelancers managing client sites',
				'badge'          => 'Most Popular',
				'highlight'      => 1,
				'is_free'        => 0,
				'price_annual'   => '129',
				'price_lifetime' => '389',
				'sites'          => '5 sites',
				'plan_id'        => '73426',
				'pricing_id'     => '106766',
				'licenses'       => '5',
				'cta_label'      => 'Get Pro',
				'cta_link'       => '',
				'note'           => '',
				'lead'           => 'Everything in Starter, plus:',
				'features'       => "White-label PDF reports (your logo & brand colour)\nMulti-Site Hub — up to 25 sites\nRemote Hub API",
			),
			array(
				'id'             => 'agency',
				'name'           => 'Agency',
				'tagline'        => 'For agencies with unlimited client sites',
				'badge'          => '',
				'highlight'      => 0,
				'is_free'        => 0,
				'price_annual'   => '249',
				'price_lifetime' => '749',
				'sites'          => 'Unlimited sites',
				'plan_id'        => '73427',
				'pricing_id'     => '106767',
				'licenses'       => '0',
				'cta_label'      => 'Get Agency',
				'cta_link'       => '',
				'note'           => '',
				'lead'           => 'Everything in Pro, plus:',
				'features'       => "Multi-Site Hub — unlimited sites\nPriority support\nEarly access to new features",
			),
		);
	}

	/**
	 * Plan comparison matrix. One row per line: Label | free | starter | pro | agency.
	 * "# Text" starts a group. yes / no / any text allowed as cell value.
	 */
	public static function matrix() {
		return "# Core\n"
			. "Unlimited WCAG 2.1 scans (A / AA / AAA) | yes | yes | yes | yes\n"
			. "Compliance score, history & trend chart | yes | yes | yes | yes\n"
			. "Self-hosted click heatmaps | yes | yes | yes | yes\n"
			. "Behavior analytics | yes | yes | yes | yes\n"
			. "Frontend accessibility widget | yes | yes | yes | yes\n"
			. "Scheduled scans with email alerts | yes | yes | yes | yes\n"
			. "Print reports | yes | yes | yes | yes\n"
			. "# Reports & AI tools\n"
			. "PDF compliance reports | no | yes | yes | yes\n"
			. "White-label PDF reports | no | no | yes | yes\n"
			. "AI alt text generator | no | yes | yes | yes\n"
			. "Heading Hierarchy Fixer | no | yes | yes | yes\n"
			. "ARIA Label Auto-Writer | no | yes | yes | yes\n"
			. "Advanced analytics | no | yes | yes | yes\n"
			. "Email report delivery after scans | no | yes | yes | yes\n"
			. "# Multi-site\n"
			. "Multi-Site Hub | no | no | Up to 25 sites | Unlimited sites\n"
			. "Remote Hub API | no | no | yes | yes\n"
			. "# License & support\n"
			. "Sites | Unlimited | 1 | 5 | Unlimited\n"
			. "Updates & support | Forum | 1 year / Lifetime | 1 year / Lifetime | 1 year / Lifetime\n"
			. "Priority support | no | no | no | yes\n"
			. "Early access to new features | no | no | no | yes";
	}

	/**
	 * Thank-you page (after Freemius checkout).
	 */
	public static function thanks() {
		return array(
			'title'      => 'Thank you — [[you’re all set!]]',
			'subtitle'   => 'Your payment went through. A receipt and your license details are on their way to your inbox.',
			'steps_title' => 'What to do next',
			'steps'      => array(
				array( 'icon' => 'download', 'title' => 'Download AccessIQ Pro', 'text' => 'Log in to your Freemius customer account and download the plugin ZIP.' ),
				array( 'icon' => 'plug', 'title' => 'Install & activate', 'text' => 'Plugins → Add New → Upload Plugin. Keep the free AccessIQ plugin active — Pro extends it.' ),
				array( 'icon' => 'lock', 'title' => 'Enter your license key', 'text' => 'Open AccessIQ → Account and paste the key from your email to unlock every Pro tool.' ),
			),
			'cta1_label' => 'Open my account',
			'cta1_link'  => '@account',
			'cta2_label' => 'Read the docs',
			'cta2_link'  => '@docs',
			'cta3_label' => 'Back to home',
			'cta3_link'  => '/',
			'help'       => 'Need a hand getting started? Reply to your receipt email or visit the support forum.',
			'help_link_label' => 'Get support',
			'help_link'  => '@support',
		);
	}

	/**
	 * Header (zone). Menu items link to anchors or global links.
	 */
	public static function header() {
		return array(
			'sticky'     => 1,
			'transparent_top' => 1,
			'logo_text'  => 'AccessIQ',
			'logo_link'  => '#top',
			'logo_image' => '',
			'badge'      => 'v2.1',
			'menu'       => array(
				array( 'label' => 'Modules', 'link' => '#modules' ),
				array( 'label' => 'Features', 'link' => '#features' ),
				array( 'label' => 'Live demos', 'link' => '#widget' ),
				array( 'label' => 'Compare', 'link' => '#compare' ),
				array( 'label' => 'Pricing', 'link' => '#pricing' ),
				array( 'label' => 'FAQ', 'link' => '#faq' ),
			),
			'cta1_label' => 'View plans',
			'cta1_link'  => '@pricing',
			'cta2_label' => 'Get free',
			'cta2_link'  => '@download_free',
		);
	}

	/**
	 * Footer (zone).
	 */
	public static function footer() {
		return array(
			'about'     => 'AccessIQ is a WordPress accessibility plugin: an automated WCAG 2.1 & 2.2 checker, self-hosted heatmaps and behavior analytics in one dashboard. Your data stays on your server.',
			'newsletter' => 0,
			'columns'   => array(
				array(
					'title' => 'Product',
					'links' => array(
						array( 'label' => 'Modules', 'link' => '#modules' ),
						array( 'label' => 'Features', 'link' => '#features' ),
						array( 'label' => 'Pricing', 'link' => '#pricing' ),
						array( 'label' => 'Changelog', 'link' => '@changelog' ),
					),
				),
				array(
					'title' => 'Resources',
					'links' => array(
						array( 'label' => 'Documentation', 'link' => '@docs' ),
						array( 'label' => 'Live demo', 'link' => '@live_demo' ),
						array( 'label' => 'Support forum', 'link' => '@support' ),
						array( 'label' => 'FAQ', 'link' => '#faq' ),
					),
				),
				array(
					'title' => 'Company',
					'links' => array(
						array( 'label' => 'About the author', 'link' => '@author' ),
						array( 'label' => 'Contact', 'link' => '@contact' ),
						array( 'label' => 'Customer account', 'link' => '@account' ),
					),
				),
				array(
					'title' => 'Legal',
					'links' => array(
						array( 'label' => 'Privacy policy', 'link' => '@privacy' ),
						array( 'label' => 'Terms of service', 'link' => '@terms' ),
						array( 'label' => 'Refund policy', 'link' => '@refund' ),
					),
				),
			),
			'copyright' => '© {year} AccessIQ by readscope. All rights reserved.',
			'disclaimer' => 'Automated checks find many common problems but cannot prove WCAG conformance. Combine AccessIQ with manual and assistive-technology testing. Not legal advice.',
			'cta_title' => '',
			'cta_label' => '',
			'cta_link'  => '',
		);
	}

	/**
	 * Visual design tokens.
	 */
	public static function design() {
		return array(
			'default_theme' => 'dark', // dark | light | system.
			'primary'       => '#14b8a6',
			'accent'        => '#8b5cf6',
			'warm'          => '#f59e0b',
			'danger'        => '#f43f5e',
			'dark_bg'       => '#070b12',
			'light_bg'      => '#f6f8fb',
			'radius'        => 20,
			'max_width'     => 1200,
			'font'          => 'brand',  // brand (Space Grotesk + Inter) | system | rounded | serif.
			'motion'        => 'on',     // on | off. (Also respects prefers-reduced-motion.)
			'grain'         => 1,
			'custom_css'    => '',
		);
	}

	/**
	 * SEO + LLM settings.
	 */
	public static function seo() {
		return array(
			'title'        => 'AccessIQ — WordPress WCAG Accessibility Scanner & Heatmaps',
			'description'  => 'Free WordPress accessibility plugin: WCAG 2.1 & 2.2 scanner, self-hosted heatmaps and behavior analytics in one dashboard. Pro adds PDF reports and AI tools.',
			'keywords'     => 'wordpress accessibility plugin, wcag scanner, ada compliance, eaa, heatmap plugin, accessibility checker, ai alt text',
			'og_image'     => '',
			'twitter'      => 'thereadscope',
			'noindex'      => 0,
			'schema'       => 1,
			'llms'         => 1,
			'llms_intro'   => 'AccessIQ is a WordPress plugin that combines an automated WCAG 2.1 & 2.2 accessibility checker, a self-hosted click heatmap engine and privacy-first behavior analytics. The free plugin is fully featured; AccessIQ Pro adds PDF reports, AI alt text, scheduled scans, AI fix tools and agency multi-site management.',
			'ai_bots'      => 1,
			'org_name'     => 'readscope',
			'org_url'      => 'https://profiles.wordpress.org/readscope',
			'same_as'      => "https://wordpress.org/plugins/accessiq/\nhttps://x.com/thereadscope",
			'app_category' => 'BusinessApplication',
			'os'           => 'WordPress 6.0+',
		);
	}

	/**
	 * Default body layout: ordered section instances.
	 */
	public static function layout() {
		$rows = array(
			array( 'hero', 'top' ),
			array( 'ticker', 'ticker' ),
			array( 'overview', 'about' ),
			array( 'problem', 'why' ),
			array( 'modules', 'modules' ),
			array( 'features', 'features' ),
			array( 'widget', 'widget' ),
			array( 'heatmap', 'heatmap' ),
			array( 'analytics', 'analytics' ),
			array( 'how', 'how' ),
			array( 'audience', 'who' ),
			array( 'compare', 'compare' ),
			array( 'stats', 'stats' ),
			array( 'savings', 'savings' ),
			array( 'pricing', 'pricing' ),
			array( 'changelog', 'changelog' ),
			array( 'faq', 'faq' ),
			array( 'cta', 'get' ),
		);
		$out  = array();
		foreach ( $rows as $r ) {
			$out[] = array(
				'uid'     => 's-' . $r[0],
				'type'    => $r[0],
				'enabled' => 1,
				'anchor'  => $r[1],
				'style'   => array(),
				'data'    => array(),
			);
		}
		return $out;
	}
}
