<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Header', 'accessiq-demo' ),
	'icon'     => 'menu',
	'desc'     => __( 'Sticky site header with menu, theme toggle and call-to-action buttons.', 'accessiq-demo' ),
	'zone'     => 'header',
	'defaults' => array(),
	'schema'   => array(
		array( 'key' => 'logo_text', 'type' => 'text', 'label' => __( 'Logo text', 'accessiq-demo' ) ),
		array( 'key' => 'logo_image', 'type' => 'image', 'label' => __( 'Logo image (optional, replaces icon)', 'accessiq-demo' ) ),
		array( 'key' => 'logo_link', 'type' => 'link', 'label' => __( 'Logo link', 'accessiq-demo' ) ),
		array( 'key' => 'badge', 'type' => 'text', 'label' => __( 'Version badge next to logo', 'accessiq-demo' ) ),
		array( 'key' => 'sticky', 'type' => 'toggle', 'label' => __( 'Sticky header', 'accessiq-demo' ) ),
		array( 'key' => 'transparent_top', 'type' => 'toggle', 'label' => __( 'Transparent until scrolled', 'accessiq-demo' ) ),
		array(
			'key'        => 'menu',
			'type'       => 'repeater',
			'label'      => __( 'Menu items', 'accessiq-demo' ),
			'item_label' => 'label',
			'fields'     => array(
				array( 'key' => 'label', 'type' => 'text', 'label' => __( 'Label', 'accessiq-demo' ) ),
				array( 'key' => 'link', 'type' => 'link', 'label' => __( 'Link', 'accessiq-demo' ) ),
			),
		),
		array( 'key' => 'cta1_label', 'type' => 'text', 'label' => __( 'Secondary button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta1_link', 'type' => 'link', 'label' => __( 'Secondary button link', 'accessiq-demo' ) ),
		array( 'key' => 'cta2_label', 'type' => 'text', 'label' => __( 'Primary button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta2_link', 'type' => 'link', 'label' => __( 'Primary button link', 'accessiq-demo' ) ),
	),
);
