<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Who it is for', 'accessiq-demo' ),
	'icon'     => 'users',
	'desc'     => __( 'Audience cards with tag chips.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'Who it’s for',
		'title'    => 'Built for everyone who ships [[WordPress sites]]',
		'subtitle' => '',
		'cards'    => array(
			array( 'icon' => 'building', 'title' => 'Agencies & freelancers', 'text' => 'Audit client sites before launch, deliver branded PDF reports and justify ongoing maintenance retainers.', 'tags' => "Client reports\nMulti-site hub\nWhite-label" ),
			array( 'icon' => 'cart', 'title' => 'E-commerce stores', 'text' => 'Heatmaps reveal which product elements get clicked. Fix inaccessible checkout buttons that cost conversions.', 'tags' => "Heatmaps\nCheckout audit\nConversion" ),
			array( 'icon' => 'scale', 'title' => 'Legal & healthcare', 'text' => 'Document remediation efforts and keep a score history. AccessIQ helps you track issues; it does not give legal advice.', 'tags' => "ADA / EAA\nStatement\nHistory" ),
			array( 'icon' => 'pen', 'title' => 'Bloggers & publishers', 'text' => 'See where readers engage without handing data to Google Analytics. Better headings and alt text help SEO too.', 'tags' => "Privacy\nHeading Fixer\nSEO" ),
			array( 'icon' => 'graduation', 'title' => 'Education & nonprofits', 'text' => 'Serve every learner and donor. Free, unlimited scans fit tight budgets.', 'tags' => "Free forever\nWidget\nProfiles" ),
			array( 'icon' => 'code', 'title' => 'Developers & QA', 'text' => 'Catch regressions with scheduled scans, in-editor checks and a REST connector.', 'tags' => "Scheduled scans\nIn-editor scan\nREST API" ),
		),
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array(
				'key'        => 'cards',
				'type'       => 'repeater',
				'label'      => __( 'Audience cards', 'accessiq-demo' ),
				'item_label' => 'title',
				'fields'     => array(
					array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
					array( 'key' => 'title', 'type' => 'text', 'label' => __( 'Title', 'accessiq-demo' ) ),
					array( 'key' => 'text', 'type' => 'textarea', 'label' => __( 'Text', 'accessiq-demo' ) ),
					array( 'key' => 'tags', 'type' => 'lines', 'label' => __( 'Tags (one per line)', 'accessiq-demo' ) ),
				),
			),
		)
	),
);
