<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'FAQ accordion', 'accessiq-demo' ),
	'icon'     => 'help',
	'desc'     => __( 'Searchable FAQ. Also outputs FAQPage structured data and feeds llms.txt automatically.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'FAQ',
		'title'    => 'Questions, [[answered]]',
		'subtitle' => 'Everything people ask before installing.',
		'show_search' => 1,
		'items'    => array(
			array( 'q' => 'Is AccessIQ completely free?', 'a' => 'Yes. The WordPress.org release includes unlimited automated scans, the full heatmap engine, behavior analytics, the accessibility widget, profiles, the Auto-Fix engine and the statement generator. No scan credits, no paywall, no expiry. AccessIQ Pro is an optional upgrade for reports, AI tools and agency features.' ),
			array( 'q' => 'Does AccessIQ fix accessibility problems or only detect them?', 'a' => 'Both. The scanner shows the exact element and a fix suggestion, and the Auto-Fix engine applies real HTML fixes for a skip link, focus outline, the lang attribute and image alt text. Pro adds AI helpers for alt text, ARIA labels, contrast and heading structure.' ),
			array( 'q' => 'How is it different from accessibility overlays?', 'a' => 'Overlays add a toolbar but do not change your underlying code, and many are criticised by the accessibility community. AccessIQ finds actual violations in your HTML so you can fix them. Its widget is a complement for visitors, not a substitute for remediation.' ),
			array( 'q' => 'Will it slow down my site?', 'a' => 'No. The tracking scripts are about 9 KB combined, load asynchronously after the page has rendered and are throttled per visitor, so the impact on Core Web Vitals is minimal.' ),
			array( 'q' => 'Is AccessIQ GDPR friendly?', 'a' => 'It stores click coordinates, page URLs, session duration and device type in your own database. No IP addresses, usernames or emails are stored and no cookies are used for tracking. We still recommend disclosing heatmap and analytics collection in your privacy policy.' ),
			array( 'q' => 'Does it work with Elementor, Divi and other page builders?', 'a' => 'Yes. The scanner analyses the final rendered HTML, whatever theme or page builder produced it.' ),
			array( 'q' => 'Which WCAG versions and levels are supported?', 'a' => 'WCAG 2.1 and 2.2 at levels A, AA and AAA, chosen per scan. Automated checks cover a subset of success criteria, so manual testing is still needed to claim conformance.' ),
			array( 'q' => 'Can I use it on client sites?', 'a' => 'Yes, on any number of sites with the free plugin. Paid plans add PDF reports and AI tools. Pro adds white-label reports and a multi-site hub for up to 25 sites; Agency adds unlimited sites, priority support and early access.' ),
			array( 'q' => 'Does AccessIQ make my site legally compliant?', 'a' => 'No tool can certify compliance. AccessIQ helps you find and track issues and document remediation, but it is not a certification service and does not provide legal advice.' ),
			array( 'q' => 'Which AI providers does Pro support?', 'a' => 'Google Gemini, Groq, Anthropic Claude, OpenAI and any OpenAI-compatible custom endpoint (bring your own key). Data is sent only when you click Generate, and keys are stored encrypted.' ),
			array( 'q' => 'Is there a refund policy?', 'a' => 'Paid plans come with a 30-day money-back guarantee. Payments are handled securely by Freemius.' ),
			array( 'q' => 'Where do I get support?', 'a' => 'Free users: the WordPress.org support forum. Paid plans: direct email support, with priority support on the Agency plan.' ),
		),
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'show_search', 'type' => 'toggle', 'label' => __( 'Show search box', 'accessiq-demo' ) ),
			array(
				'key'        => 'items',
				'type'       => 'repeater',
				'label'      => __( 'Questions', 'accessiq-demo' ),
				'item_label' => 'q',
				'fields'     => array(
					array( 'key' => 'q', 'type' => 'text', 'label' => __( 'Question', 'accessiq-demo' ) ),
					array( 'key' => 'a', 'type' => 'textarea', 'label' => __( 'Answer (plain text)', 'accessiq-demo' ) ),
				),
			),
		)
	),
);
