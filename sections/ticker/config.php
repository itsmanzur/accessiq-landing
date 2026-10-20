<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Scrolling ticker', 'accessiq-demo' ),
	'icon'     => 'zap',
	'desc'     => __( 'Auto-scrolling strip of short claims / facts. Has a pause button for accessibility.', 'accessiq-demo' ),
	'group'    => 'hero',
	'wide'     => true,
	'defaults' => array(
		'speed' => 45,
		'items' => array(
			array( 'icon' => 'scale', 'text' => 'ADA & EAA lawsuits are rising every year' ),
			array( 'icon' => 'users', 'text' => '1 in 4 adults lives with a disability' ),
			array( 'icon' => 'bug', 'text' => '95%+ of home pages fail basic WCAG checks' ),
			array( 'icon' => 'layers', 'text' => 'Scanner + heatmaps + analytics in one plugin' ),
			array( 'icon' => 'server', 'text' => '100% self-hosted — your data stays yours' ),
			array( 'icon' => 'refresh', 'text' => 'Unlimited scans, no credits' ),
			array( 'icon' => 'zap', 'text' => 'Tracker is only ~9 KB' ),
			array( 'icon' => 'plug', 'text' => 'Works with Elementor, Divi, Gutenberg & more' ),
		),
	),
	'schema'   => array(
		array( 'key' => 'speed', 'type' => 'number', 'label' => __( 'Loop duration in seconds (higher = slower)', 'accessiq-demo' ) ),
		array(
			'key'        => 'items',
			'type'       => 'repeater',
			'label'      => __( 'Items', 'accessiq-demo' ),
			'item_label' => 'text',
			'fields'     => array(
				array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
				array( 'key' => 'text', 'type' => 'text', 'label' => __( 'Text', 'accessiq-demo' ) ),
			),
		),
	),
);
