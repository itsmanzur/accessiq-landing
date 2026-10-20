<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Live widget playground', 'accessiq-demo' ),
	'icon'     => 'accessibility',
	'desc'     => __( 'Visitors try the accessibility widget on a mock page: font size, contrast, dyslexia font, reading mask, profiles and more actually change the preview.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'Try it live',
		'title'    => 'The accessibility widget — [[play with it]]',
		'subtitle' => 'These controls really change the mock page next to them. Pick a profile, or toggle tools one by one.',
		'points'   => "15 tools in a floating toolbar\n5 one-click profiles\nDark / light / system themes\nMobile bottom sheet\nNo external fonts or scripts",
		'note'     => 'The widget helps visitors adjust their experience. It does not fix code-level violations — that is what the scanner and Auto-Fix engine are for.',
		'cta_label' => 'Get the widget free',
		'cta_link'  => '@download_free',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'points', 'type' => 'lines', 'label' => __( 'Bullet points (one per line)', 'accessiq-demo' ) ),
			array( 'key' => 'note', 'type' => 'textarea', 'label' => __( 'Honesty note under the demo', 'accessiq-demo' ) ),
			array( 'key' => 'cta_label', 'type' => 'text', 'label' => __( 'Button label', 'accessiq-demo' ) ),
			array( 'key' => 'cta_link', 'type' => 'link', 'label' => __( 'Button link', 'accessiq-demo' ) ),
		)
	),
);
