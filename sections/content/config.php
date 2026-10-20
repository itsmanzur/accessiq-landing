<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Text + image block', 'accessiq-demo' ),
	'icon'     => 'pen',
	'desc'     => __( 'Generic block: heading, rich text, bullets, optional image and button. Use it for any extra section.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'    => 'New section',
		'title'      => 'Add your own [[story]]',
		'subtitle'   => '',
		'body'       => '<p>Write anything here. Basic HTML such as <strong>bold</strong>, <em>italic</em> and <a href="#">links</a> is allowed.</p>',
		'bullets'    => "First point\nSecond point\nThird point",
		'image'      => '',
		'image_alt'  => '',
		'image_side' => 'right',
		'cta_label'  => '',
		'cta_link'   => '',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'body', 'type' => 'richtext', 'rows' => 6, 'label' => __( 'Body (basic HTML allowed)', 'accessiq-demo' ) ),
			array( 'key' => 'bullets', 'type' => 'lines', 'label' => __( 'Bullets (one per line)', 'accessiq-demo' ) ),
			array( 'key' => 'image', 'type' => 'image', 'label' => __( 'Image', 'accessiq-demo' ) ),
			array( 'key' => 'image_alt', 'type' => 'text', 'label' => __( 'Image alt text', 'accessiq-demo' ), 'help' => __( 'Required for accessibility. Leave empty only for decorative images.', 'accessiq-demo' ) ),
			array( 'key' => 'image_side', 'type' => 'select', 'label' => __( 'Image position', 'accessiq-demo' ), 'options' => array( 'right' => 'Right', 'left' => 'Left' ) ),
			array( 'key' => 'cta_label', 'type' => 'text', 'label' => __( 'Button label', 'accessiq-demo' ) ),
			array( 'key' => 'cta_link', 'type' => 'link', 'label' => __( 'Button link', 'accessiq-demo' ) ),
		)
	),
);
