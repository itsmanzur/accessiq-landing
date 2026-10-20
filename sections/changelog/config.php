<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Changelog timeline', 'accessiq-demo' ),
	'icon'     => 'clock',
	'desc'     => __( 'Recent releases as a timeline — shows the product is actively maintained.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'Actively maintained',
		'title'    => 'Recent [[releases]]',
		'subtitle' => 'Security, accuracy and new tools — shipped continuously.',
		'link_label' => 'Full changelog',
		'link'       => '@changelog',
		'releases' => array(
			array( 'version' => '2.1.0', 'product' => 'AccessIQ Free', 'date' => '2026-07-19', 'items' => "Security: stored XSS, SSRF and tracking-throttle hardening\nAccuracy: alt=\"\" false positives, heading order, language level, one score formula\nWidget: profile fixes, missing feature keys, listener leak\nStatement: Publish button now works\nPerformance: admin CSS loads only on plugin pages, no Google Fonts" ),
			array( 'version' => '3.1.0', 'product' => 'AccessIQ Pro', 'date' => '2026-07-19', 'items' => "Security: per-post permission checks, encrypted AI & hub keys, safer PDF storage\nFix: Risk Correlation now matches real elements; PDF layout and wording\nNew default models for Groq and Gemini; bulk alt text no longer blocks\nAccessibility: every Pro admin control labelled\nBengali (bn_BD) translation and RTL admin screens" ),
			array( 'version' => '3.0.0', 'product' => 'AccessIQ Pro', 'date' => '2026-06', 'items' => "New: Agency Dashboard with 10-site hub and client groups\nNew: per-client PDF branding and Full-Site Crawler\nNew: AI Contrast Fixer, AI ARIA Labeler and Plain-English Fixes" ),
			array( 'version' => '2.0.0', 'product' => 'AccessIQ Pro', 'date' => '2026-05', 'items' => "New: Heatmap + Accessibility Risk Correlation\nNew: in-editor WCAG scan, white-label widget, CSV export and network dashboard" ),
		),
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'link_label', 'type' => 'text', 'label' => __( 'Link label', 'accessiq-demo' ) ),
			array( 'key' => 'link', 'type' => 'link', 'label' => __( 'Link', 'accessiq-demo' ) ),
			array(
				'key'        => 'releases',
				'type'       => 'repeater',
				'label'      => __( 'Releases', 'accessiq-demo' ),
				'item_label' => 'version',
				'fields'     => array(
					array( 'key' => 'version', 'type' => 'text', 'label' => __( 'Version', 'accessiq-demo' ) ),
					array( 'key' => 'product', 'type' => 'text', 'label' => __( 'Product', 'accessiq-demo' ) ),
					array( 'key' => 'date', 'type' => 'text', 'label' => __( 'Date', 'accessiq-demo' ) ),
					array( 'key' => 'items', 'type' => 'lines', 'label' => __( 'Highlights (one per line)', 'accessiq-demo' ) ),
				),
			),
		)
	),
);
