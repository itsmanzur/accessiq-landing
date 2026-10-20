<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Thank-you page', 'accessiq-demo' ),
	'icon'     => 'heart',
	'desc'     => __( 'Shown after a successful Freemius checkout. Edited under Header, Footer & Thank-you.', 'accessiq-demo' ),
	'zone'     => 'page',
	'defaults' => array(),
	'schema'   => array(
		array( 'key' => 'title', 'type' => 'text', 'label' => __( 'Heading (H1)', 'accessiq-demo' ), 'help' => __( '[[Brackets]] = gradient highlight.', 'accessiq-demo' ) ),
		array( 'key' => 'subtitle', 'type' => 'textarea', 'label' => __( 'Message', 'accessiq-demo' ) ),
		array( 'key' => 'steps_title', 'type' => 'text', 'label' => __( 'Steps heading', 'accessiq-demo' ) ),
		array(
			'key'        => 'steps',
			'type'       => 'repeater',
			'label'      => __( 'Next steps', 'accessiq-demo' ),
			'item_label' => 'title',
			'fields'     => array(
				array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
				array( 'key' => 'title', 'type' => 'text', 'label' => __( 'Title', 'accessiq-demo' ) ),
				array( 'key' => 'text', 'type' => 'textarea', 'label' => __( 'Text', 'accessiq-demo' ) ),
			),
		),
		array( 'key' => 'cta1_label', 'type' => 'text', 'label' => __( 'Primary button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta1_link', 'type' => 'link', 'label' => __( 'Primary button link', 'accessiq-demo' ) ),
		array( 'key' => 'cta2_label', 'type' => 'text', 'label' => __( 'Secondary button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta2_link', 'type' => 'link', 'label' => __( 'Secondary button link', 'accessiq-demo' ) ),
		array( 'key' => 'cta3_label', 'type' => 'text', 'label' => __( 'Ghost button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta3_link', 'type' => 'link', 'label' => __( 'Ghost button link', 'accessiq-demo' ) ),
		array( 'key' => 'help', 'type' => 'text', 'label' => __( 'Help line', 'accessiq-demo' ) ),
		array( 'key' => 'help_link_label', 'type' => 'text', 'label' => __( 'Help link label', 'accessiq-demo' ) ),
		array( 'key' => 'help_link', 'type' => 'link', 'label' => __( 'Help link', 'accessiq-demo' ) ),
	),
);
