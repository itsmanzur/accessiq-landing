<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'How it works (steps)', 'accessiq-demo' ),
	'icon'     => 'route',
	'desc'     => __( 'Numbered timeline of steps with a progress line that fills as you scroll.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'How it works',
		'title'    => 'From install to insight in [[four steps]]',
		'subtitle' => 'No accounts, no API keys, no configuration marathon.',
		'steps'    => array(
			array( 'icon' => 'download', 'title' => 'Install & activate', 'text' => 'Add AccessIQ from Plugins → Add New or upload the ZIP. Activate it — that is the whole setup.', 'time' => '60 seconds' ),
			array( 'icon' => 'search', 'title' => 'Run your first scan', 'text' => 'Open AccessIQ → WCAG Scanner, paste any URL, pick A / AA / AAA and scan. You get a score and every failing element.', 'time' => '10 seconds per page' ),
			array( 'icon' => 'flame', 'title' => 'Heatmaps start automatically', 'text' => 'The lightweight tracker is already collecting clicks and sessions. Open Heatmap or Behavior whenever you like.', 'time' => 'Zero config' ),
			array( 'icon' => 'trending', 'title' => 'Fix, track, improve', 'text' => 'Apply Auto-Fixes, repair what is left, rescan and watch the score history climb. Publish your accessibility statement.', 'time' => 'Ongoing' ),
		),
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array(
				'key'        => 'steps',
				'type'       => 'repeater',
				'label'      => __( 'Steps', 'accessiq-demo' ),
				'item_label' => 'title',
				'fields'     => array(
					array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
					array( 'key' => 'title', 'type' => 'text', 'label' => __( 'Title', 'accessiq-demo' ) ),
					array( 'key' => 'text', 'type' => 'textarea', 'label' => __( 'Text', 'accessiq-demo' ) ),
					array( 'key' => 'time', 'type' => 'text', 'label' => __( 'Time / outcome tag', 'accessiq-demo' ) ),
				),
			),
		)
	),
);
