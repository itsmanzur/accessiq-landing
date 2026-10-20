<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Savings calculator', 'accessiq-demo' ),
	'icon'     => 'dollar',
	'desc'     => __( 'Interactive calculator: tick the tools you pay for today and see the yearly saving.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'    => 'Savings calculator',
		'title'      => 'How much could you [[stop paying]]?',
		'subtitle'   => 'Tick the tools you use today. Prices are illustrative — edit them in the builder to match your own stack.',
		'tools'      => "Accessibility scanner SaaS | 29\nHeatmap / session-recording tool | 39\nPrivacy analytics subscription | 20\nAccessibility overlay widget | 49",
		'ours_label' => 'AccessIQ',
		'ours_year'  => '0',
		'per_site'   => 1,
		'max_sites'  => 20,
		'footnote'   => 'Illustrative numbers only. AccessIQ free covers the scanner, heatmaps, analytics and widget; Pro is optional.',
		'cta_label'  => 'Start free',
		'cta_link'   => '@download_free',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'tools', 'type' => 'textarea', 'rows' => 6, 'label' => __( 'Tools you replace', 'accessiq-demo' ), 'help' => __( 'One per line: Name | price per month (number only).', 'accessiq-demo' ) ),
			array( 'key' => 'ours_label', 'type' => 'text', 'label' => __( 'Your product name', 'accessiq-demo' ) ),
			array( 'key' => 'ours_year', 'type' => 'number', 'label' => __( 'Your yearly price per site', 'accessiq-demo' ) ),
			array( 'key' => 'per_site', 'type' => 'toggle', 'label' => __( 'Multiply by number of sites', 'accessiq-demo' ) ),
			array( 'key' => 'max_sites', 'type' => 'number', 'label' => __( 'Maximum sites on the slider', 'accessiq-demo' ) ),
			array( 'key' => 'footnote', 'type' => 'text', 'label' => __( 'Footnote', 'accessiq-demo' ) ),
			array( 'key' => 'cta_label', 'type' => 'text', 'label' => __( 'Button label', 'accessiq-demo' ) ),
			array( 'key' => 'cta_link', 'type' => 'link', 'label' => __( 'Button link', 'accessiq-demo' ) ),
		)
	),
);
