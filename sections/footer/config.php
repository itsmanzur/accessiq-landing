<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Footer', 'accessiq-demo' ),
	'icon'     => 'layers',
	'desc'     => __( 'Footer with brand blurb, link columns, legal text and disclaimer.', 'accessiq-demo' ),
	'zone'     => 'footer',
	'defaults' => array(),
	'schema'   => array(
		array( 'key' => 'about', 'type' => 'textarea', 'label' => __( 'Brand blurb', 'accessiq-demo' ) ),
		array(
			'key'        => 'columns',
			'type'       => 'repeater',
			'label'      => __( 'Link columns', 'accessiq-demo' ),
			'item_label' => 'title',
			'fields'     => array(
				array( 'key' => 'title', 'type' => 'text', 'label' => __( 'Column title', 'accessiq-demo' ) ),
				array(
					'key'        => 'links',
					'type'       => 'repeater',
					'label'      => __( 'Links', 'accessiq-demo' ),
					'item_label' => 'label',
					'fields'     => array(
						array( 'key' => 'label', 'type' => 'text', 'label' => __( 'Label', 'accessiq-demo' ) ),
						array( 'key' => 'link', 'type' => 'link', 'label' => __( 'Link', 'accessiq-demo' ) ),
					),
				),
			),
		),
		array( 'key' => 'cta_title', 'type' => 'text', 'label' => __( 'Mini call-to-action title (optional)', 'accessiq-demo' ) ),
		array( 'key' => 'cta_label', 'type' => 'text', 'label' => __( 'Mini CTA button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta_link', 'type' => 'link', 'label' => __( 'Mini CTA button link', 'accessiq-demo' ) ),
		array( 'key' => 'copyright', 'type' => 'text', 'label' => __( 'Copyright line', 'accessiq-demo' ), 'help' => __( '{year} becomes the current year.', 'accessiq-demo' ) ),
		array( 'key' => 'disclaimer', 'type' => 'textarea', 'label' => __( 'Disclaimer', 'accessiq-demo' ) ),
	),
);
