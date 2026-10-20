<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'What is it (pillars)', 'accessiq-demo' ),
	'icon'     => 'layers',
	'desc'     => __( 'Intro with the core product pillars as tilt cards, key promises and buttons.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'    => 'What is AccessIQ',
		'title'      => 'Three tools you pay for separately. [[One plugin.]]',
		'subtitle'   => 'Scan for WCAG problems, see where visitors click, and understand behavior — without installing three plugins or sending data to three vendors.',
		'cards'      => array(
			array( 'icon' => 'search', 'title' => 'WCAG 2.1 & 2.2 Scanner', 'text' => 'Score every page 0–100, see the exact failing element, severity, and how to fix it. Levels A, AA and AAA.', 'tier' => 'free', 'link' => '#modules' ),
			array( 'icon' => 'flame', 'title' => 'Self-hosted Heatmaps', 'text' => 'Click heatmaps drawn over your live pages inside a browser frame. Filter by device and date. No Hotjar.', 'tier' => 'free', 'link' => '#heatmap' ),
			array( 'icon' => 'chart', 'title' => 'Behavior Analytics', 'text' => 'Sessions, bounce rate, time on page, device split and a full journey tracker — cookie-free.', 'tier' => 'free', 'link' => '#analytics' ),
			array( 'icon' => 'accessibility', 'title' => 'Accessibility Widget', 'text' => '15 visitor tools, 5 one-click profiles, dark / light themes and a mobile bottom sheet.', 'tier' => 'free', 'link' => '#widget' ),
		),
		'statement'  => 'The only WordPress plugin that combines an accessibility checker, heatmaps and behavior analytics.',
		'points'     => "No monthly fees for core features\nNo external accounts or API keys\nA free plan that is not a trial\nSet up in under two minutes",
		'cta1_label' => 'Get it free',
		'cta1_link'  => '@download_free',
		'cta2_label' => 'See all modules',
		'cta2_link'  => '#modules',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array(
				'key'        => 'cards',
				'type'       => 'repeater',
				'label'      => __( 'Pillar cards', 'accessiq-demo' ),
				'item_label' => 'title',
				'fields'     => array(
					array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
					array( 'key' => 'title', 'type' => 'text', 'label' => __( 'Title', 'accessiq-demo' ) ),
					array( 'key' => 'text', 'type' => 'textarea', 'label' => __( 'Text', 'accessiq-demo' ) ),
					array( 'key' => 'tier', 'type' => 'select', 'label' => __( 'Badge', 'accessiq-demo' ), 'options' => array( '' => 'None', 'free' => 'Free', 'pro' => 'Pro', 'agency' => 'Agency', 'new' => 'New' ) ),
					array( 'key' => 'link', 'type' => 'link', 'label' => __( 'Link', 'accessiq-demo' ) ),
				),
			),
			array( 'key' => 'statement', 'type' => 'textarea', 'label' => __( 'Bold statement', 'accessiq-demo' ) ),
			array( 'key' => 'points', 'type' => 'lines', 'label' => __( 'Key promises (one per line)', 'accessiq-demo' ) ),
			array( 'key' => 'cta1_label', 'type' => 'text', 'label' => __( 'Button 1 label', 'accessiq-demo' ) ),
			array( 'key' => 'cta1_link', 'type' => 'link', 'label' => __( 'Button 1 link', 'accessiq-demo' ) ),
			array( 'key' => 'cta2_label', 'type' => 'text', 'label' => __( 'Button 2 label', 'accessiq-demo' ) ),
			array( 'key' => 'cta2_link', 'type' => 'link', 'label' => __( 'Button 2 link', 'accessiq-demo' ) ),
		)
	),
);
