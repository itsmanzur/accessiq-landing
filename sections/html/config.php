<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Custom HTML / shortcode', 'accessiq-demo' ),
	'icon'     => 'code',
	'desc'     => __( 'Paste raw HTML or any shortcode (forms, embeds, videos). Only users who can edit unfiltered HTML can save it.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => '',
		'title'    => '',
		'subtitle' => '',
		'code'     => '',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'code', 'type' => 'code', 'rows' => 10, 'label' => __( 'HTML or shortcode', 'accessiq-demo' ) ),
		)
	),
);
