<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Problem vs solution', 'accessiq-demo' ),
	'icon'     => 'scale',
	'desc'     => __( 'Two-column "without / with" comparison list.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'    => 'The problem',
		'title'      => 'Most sites are exposed and [[don’t know it]]',
		'subtitle'   => 'Overlays hide problems. One-time audits go stale. Separate tools cost more and leak data.',
		'bad_title'  => 'Without AccessIQ',
		'bad'        => "Accessibility issues stay undiscovered until a complaint arrives\nYou pay for a scanner, a heatmap tool and an analytics tool\nClick data lives on a third-party server\nNo compliance history to show a client or a regulator\nOne-time audits go stale the day you publish\nOverlay widgets promise fixes but leave the code broken",
		'good_title' => 'With AccessIQ',
		'good'       => "See every violation with the exact element and a fix suggestion\nUnlimited scans — no credits, no per-page fee\nSelf-hosted heatmaps — data never leaves your database\nCookie-free analytics with no personal data stored\nScore history and an accessibility statement you can publish\nScheduled scans with email alerts when the score drops\nReal HTML fixes through the Auto-Fix engine",
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'bad_title', 'type' => 'text', 'label' => __( '"Without" column title', 'accessiq-demo' ) ),
			array( 'key' => 'bad', 'type' => 'lines', 'label' => __( '"Without" items (one per line)', 'accessiq-demo' ) ),
			array( 'key' => 'good_title', 'type' => 'text', 'label' => __( '"With" column title', 'accessiq-demo' ) ),
			array( 'key' => 'good', 'type' => 'lines', 'label' => __( '"With" items (one per line)', 'accessiq-demo' ) ),
		)
	),
);
