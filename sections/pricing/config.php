<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Pricing table', 'accessiq-demo' ),
	'icon'     => 'crown',
	'desc'     => __( 'Pricing cards with Annual / Lifetime toggle, Freemius overlay checkout and a full comparison matrix. Plans, prices and Freemius IDs are edited in AccessIQ Landing → Pricing Plans.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'        => 'Pricing',
		'title'          => 'Start free. [[Upgrade when you need more.]]',
		'subtitle'       => 'The free plugin is fully featured for most sites. Paid plans add reports, AI tools and multi-site management.',
		'show_toggle'    => 1,
		'default_cycle'  => 'annual',
		'annual_label'   => 'Annual',
		'lifetime_label' => 'Lifetime',
		'lifetime_badge' => 'Best value',
		'show_matrix'    => 1,
		'matrix_title'   => 'Compare every feature',
		'trust'          => "30-day money-back guarantee\nSecure checkout via Freemius\nStripe & PayPal accepted",
		'footnote'       => '',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'show_toggle', 'type' => 'toggle', 'label' => __( 'Show Annual / Lifetime toggle', 'accessiq-demo' ) ),
			array( 'key' => 'default_cycle', 'type' => 'select', 'label' => __( 'Default billing cycle', 'accessiq-demo' ), 'options' => array( 'annual' => 'Annual', 'lifetime' => 'Lifetime' ) ),
			array( 'key' => 'annual_label', 'type' => 'text', 'label' => __( 'Annual toggle label', 'accessiq-demo' ) ),
			array( 'key' => 'lifetime_label', 'type' => 'text', 'label' => __( 'Lifetime toggle label', 'accessiq-demo' ) ),
			array( 'key' => 'lifetime_badge', 'type' => 'text', 'label' => __( 'Badge on the Lifetime option', 'accessiq-demo' ) ),
			array( 'key' => 'show_matrix', 'type' => 'toggle', 'label' => __( 'Show full comparison matrix', 'accessiq-demo' ) ),
			array( 'key' => 'matrix_title', 'type' => 'text', 'label' => __( 'Matrix heading', 'accessiq-demo' ) ),
			array( 'key' => 'trust', 'type' => 'lines', 'label' => __( 'Trust row items (one per line)', 'accessiq-demo' ) ),
			array( 'key' => 'footnote', 'type' => 'text', 'label' => __( 'Footnote (optional)', 'accessiq-demo' ) ),
			array( 'key' => '_info', 'type' => 'notice', 'label' => __( 'Plans, prices, features, matrix rows and Freemius plan / pricing IDs live in AccessIQ Landing → Pricing Plans. The public key is in Settings.', 'accessiq-demo' ) ),
		)
	),
);
