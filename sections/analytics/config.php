<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Analytics dashboard demo', 'accessiq-demo' ),
	'icon'     => 'chart',
	'desc'     => __( 'Animated sessions chart, device donut and top-pages table with 7 / 30 / 90 day switch.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'Behavior Analytics',
		'title'    => 'Know your visitors — [[without cookies]]',
		'subtitle' => 'Sessions, time on page, bounce rate and device split in a dashboard that never leaves WordPress. Switch the range to see the data move.',
		'pages'    => "/ | 4,210 | 1:48 | 31 | Desktop\n/pricing | 2,380 | 2:21 | 24 | Desktop\n/blog/wcag-checklist | 1,940 | 3:05 | 42 | Mobile\n/checkout | 1,120 | 1:12 | 58 | Mobile\n/contact | 640 | 0:44 | 66 | Mobile",
		'points'   => "Cookie-free session tracking\nNo IP addresses stored\nBounce-rate alerts: red, amber, green\nJourney tracker for real session paths",
		'cta_label' => 'Start tracking free',
		'cta_link'  => '@download_free',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'pages', 'type' => 'textarea', 'rows' => 6, 'label' => __( 'Top pages table (one per line)', 'accessiq-demo' ), 'help' => __( 'Format: path | sessions | avg time | bounce % | top device', 'accessiq-demo' ) ),
			array( 'key' => 'points', 'type' => 'lines', 'label' => __( 'Bullet points (one per line)', 'accessiq-demo' ) ),
			array( 'key' => 'cta_label', 'type' => 'text', 'label' => __( 'Button label', 'accessiq-demo' ) ),
			array( 'key' => 'cta_link', 'type' => 'link', 'label' => __( 'Button link', 'accessiq-demo' ) ),
		)
	),
);
