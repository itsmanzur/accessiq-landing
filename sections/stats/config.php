<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Animated stats', 'accessiq-demo' ),
	'icon'     => 'trending',
	'desc'     => __( 'Big counters that count up when scrolled into view.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'By the numbers',
		'title'    => 'Small footprint. [[Big coverage.]]',
		'subtitle' => '',
		'items'    => array(
			array( 'value' => '9', 'prefix' => '~', 'suffix' => ' KB', 'label' => 'Tracker size', 'sub' => 'Two async scripts' ),
			array( 'value' => '15', 'prefix' => '', 'suffix' => '', 'label' => 'Widget tools', 'sub' => 'Plus 5 one-click profiles' ),
			array( 'value' => '0', 'prefix' => '', 'suffix' => '', 'label' => 'Third-party requests', 'sub' => 'For all core features' ),
			array( 'value' => '31', 'prefix' => '', 'suffix' => '', 'label' => 'Modules', 'sub' => 'Free, Pro and Agency' ),
		),
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array(
				'key'        => 'items',
				'type'       => 'repeater',
				'label'      => __( 'Counters', 'accessiq-demo' ),
				'item_label' => 'label',
				'fields'     => array(
					array( 'key' => 'prefix', 'type' => 'text', 'label' => __( 'Prefix (e.g. ~ or $)', 'accessiq-demo' ) ),
					array( 'key' => 'value', 'type' => 'number', 'label' => __( 'Number', 'accessiq-demo' ) ),
					array( 'key' => 'suffix', 'type' => 'text', 'label' => __( 'Suffix (e.g. % or +)', 'accessiq-demo' ) ),
					array( 'key' => 'label', 'type' => 'text', 'label' => __( 'Label', 'accessiq-demo' ) ),
					array( 'key' => 'sub', 'type' => 'text', 'label' => __( 'Small text', 'accessiq-demo' ) ),
				),
			),
		)
	),
);
