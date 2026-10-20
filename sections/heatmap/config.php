<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Interactive heatmap demo', 'accessiq-demo' ),
	'icon'     => 'flame',
	'desc'     => __( 'Visitors click a mock page and watch heat build up, with device filters and a live top-clicked table.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'Heatmap Engine',
		'title'    => 'Click anywhere — [[watch the heat build]]',
		'subtitle' => 'This is the same view you get inside WP Admin: a live page in a browser frame, a hot/cold overlay and a ranked list of the most-clicked elements.',
		'points'   => "Self-hosted: clicks never leave your database\nDesktop / mobile / tablet filter\n7, 30 and 90 day ranges\nTop elements with gold, silver, bronze ranks\nTracker is ~9 KB and loads async",
		'cta_label' => 'See heatmaps in action',
		'cta_link'  => '@live_demo',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'points', 'type' => 'lines', 'label' => __( 'Bullet points (one per line)', 'accessiq-demo' ) ),
			array( 'key' => 'cta_label', 'type' => 'text', 'label' => __( 'Button label', 'accessiq-demo' ) ),
			array( 'key' => 'cta_link', 'type' => 'link', 'label' => __( 'Button link', 'accessiq-demo' ) ),
		)
	),
);
