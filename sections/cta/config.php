<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Call to action banner', 'accessiq-demo' ),
	'icon'     => 'rocket',
	'desc'     => __( 'Big closing banner with two buttons. Reusable anywhere in the page.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'    => '',
		'title'      => 'Your site deserves to [[work for everyone]]',
		'subtitle'   => 'Install AccessIQ, run your first scan in minutes and see exactly what to fix.',
		'cta1_label' => 'Download free',
		'cta1_link'  => '@download_free',
		'cta2_label' => 'View Pro plans',
		'cta2_link'  => '@pricing',
		'fine'       => 'Free forever · No credit card · Activates in 60 seconds',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'cta1_label', 'type' => 'text', 'label' => __( 'Primary button label', 'accessiq-demo' ) ),
			array( 'key' => 'cta1_link', 'type' => 'link', 'label' => __( 'Primary button link', 'accessiq-demo' ) ),
			array( 'key' => 'cta2_label', 'type' => 'text', 'label' => __( 'Secondary button label', 'accessiq-demo' ) ),
			array( 'key' => 'cta2_link', 'type' => 'link', 'label' => __( 'Secondary button link', 'accessiq-demo' ) ),
			array( 'key' => 'fine', 'type' => 'text', 'label' => __( 'Fine print', 'accessiq-demo' ) ),
		)
	),
);
