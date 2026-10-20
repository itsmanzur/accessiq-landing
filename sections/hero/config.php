<?php
defined( 'ABSPATH' ) || exit;

$icons_help = __( 'Icon name from the icon list.', 'accessiq-demo' );

return array(
	'label'    => __( 'Hero + live scanner', 'accessiq-demo' ),
	'icon'     => 'rocket',
	'desc'     => __( 'H1 headline, buttons, trust badges and an interactive WCAG scanner simulator with floating chips.', 'accessiq-demo' ),
	'group'    => 'hero',
	'wide'     => true,
	'defaults' => array(
		'eyebrow'    => 'WordPress accessibility, heatmaps & analytics',
		'title'      => 'One plugin. Three superpowers. [[Zero excuses.]]',
		'subtitle'   => 'AccessIQ combines a **WCAG 2.1 & 2.2 scanner**, **self-hosted click heatmaps** and **behavior analytics** in one dashboard — running on your own server. No API keys, no subscriptions, no data leaving your site.',
		'cta1_label' => 'Download free',
		'cta1_link'  => '@download_free',
		'cta2_label' => 'View Pro plans',
		'cta2_link'  => '@pricing',
		'cta3_label' => 'Live demo',
		'cta3_link'  => '@live_demo',
		'badges'     => array(
			array( 'icon' => 'check', 'text' => '100% free core' ),
			array( 'icon' => 'server', 'text' => 'Self-hosted data' ),
			array( 'icon' => 'lock', 'text' => 'No API keys needed' ),
			array( 'icon' => 'shield', 'text' => 'GDPR friendly' ),
			array( 'icon' => 'globe', 'text' => 'WordPress 6.0+' ),
		),
		'demo_title' => 'Try the scanner',
		'demo_hint'  => 'Pick a sample page and press Scan — this is a simulation of the real in-dashboard report.',
		'samples'    => array(
			array(
				'name'  => 'Homepage', 'url' => 'yoursite.com/', 'score' => '96', 'level' => 'WCAG 2.1 AA',
				'issues' => "moderate|Contrast|Low contrast footer link|<a class=\"muted\">Terms</a>|Raise the text colour to at least 4.5:1 against its background.\nmoderate|Images|Decorative image without empty alt|<img src=\"divider.svg\">|Add alt=\"\" so screen readers skip decorative images.\ncritical|ARIA|Icon button has no accessible name|<button class=\"menu-btn\">|Add aria-label=\"Open menu\" to describe the control.",
			),
			array(
				'name'  => 'Checkout', 'url' => 'yoursite.com/checkout', 'score' => '74', 'level' => 'WCAG 2.1 AA',
				'issues' => "critical|Forms|Input has no label|<input name=\"card_zip\">|Associate a visible <label> or add aria-label.\ncritical|Images|Image missing alt text|<img src=\"badge-secure.png\">|Describe the image in the alt attribute (Pro can generate it with AI).\ncritical|ARIA|Button has no accessible name|<button class=\"qty-plus\">|Add aria-label=\"Increase quantity\".\nserious|Contrast|Placeholder text too light|<input placeholder=\"Coupon\">|Use a darker placeholder colour (4.5:1).\nserious|Headings|Heading level skipped (h2 → h4)|<h4>Payment</h4>|Use h3 or restructure the heading outline.\nserious|Forms|Error message not announced|<div class=\"error\">|Add role=\"alert\" so it is announced.\nmoderate|Contrast|Disabled button hard to read|<button disabled>|Keep text readable even in disabled state.\nmoderate|Headings|Empty heading|<h3></h3>|Remove it or add text.",
			),
			array(
				'name'  => 'About page', 'url' => 'yoursite.com/about', 'score' => '100', 'level' => 'WCAG 2.1 AAA',
				'issues' => '',
			),
			array(
				'name'  => 'Contact', 'url' => 'yoursite.com/contact', 'score' => '41', 'level' => 'WCAG 2.1 A',
				'issues' => "critical|Forms|Form field has no label|<input type=\"email\">|Add a <label for> that matches the input id.\ncritical|Forms|Form field has no label|<textarea name=\"msg\">|Add a visible label.\ncritical|Images|Map image missing alt|<img src=\"map.png\">|Describe the map location in alt text.\ncritical|ARIA|Link has no discernible text|<a href=\"/\"><svg/></a>|Add aria-label or visually hidden text.\ncritical|Headings|Page has no h1|<body>|Add one descriptive h1.\ncritical|Contrast|White text on pale background|<p class=\"lead\">|Increase contrast to 4.5:1.\ncritical|ARIA|Duplicate id breaks aria-labelledby|<div id=\"menu\">|Make ids unique.\ncritical|Forms|Required field not marked|<input required>|Mark required fields in text, not colour only.",
			),
		),
		'floaters'   => array(
			array( 'icon' => 'flame', 'text' => '142 clicks', 'sub' => 'on “Add to cart”' ),
			array( 'icon' => 'sparkles', 'text' => 'Alt text added', 'sub' => 'AI · 38 images' ),
			array( 'icon' => 'trending', 'text' => 'Score +12', 'sub' => 'since last scan' ),
			array( 'icon' => 'shield', 'text' => 'WCAG 2.2 AA', 'sub' => 'target level' ),
		),
	),
	'schema'   => array(
		array( 'key' => 'eyebrow', 'type' => 'text', 'label' => __( 'Pill text above headline', 'accessiq-demo' ) ),
		array( 'key' => 'title', 'type' => 'text', 'label' => __( 'Headline (H1)', 'accessiq-demo' ), 'help' => __( 'Only one H1 per page. [[Brackets]] = gradient highlight.', 'accessiq-demo' ) ),
		array( 'key' => 'subtitle', 'type' => 'textarea', 'label' => __( 'Intro paragraph', 'accessiq-demo' ), 'help' => __( '**bold** supported.', 'accessiq-demo' ) ),
		array( 'key' => 'cta1_label', 'type' => 'text', 'label' => __( 'Primary button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta1_link', 'type' => 'link', 'label' => __( 'Primary button link', 'accessiq-demo' ) ),
		array( 'key' => 'cta2_label', 'type' => 'text', 'label' => __( 'Secondary button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta2_link', 'type' => 'link', 'label' => __( 'Secondary button link', 'accessiq-demo' ) ),
		array( 'key' => 'cta3_label', 'type' => 'text', 'label' => __( 'Ghost button label', 'accessiq-demo' ) ),
		array( 'key' => 'cta3_link', 'type' => 'link', 'label' => __( 'Ghost button link', 'accessiq-demo' ) ),
		array(
			'key'        => 'badges',
			'type'       => 'repeater',
			'label'      => __( 'Trust badges', 'accessiq-demo' ),
			'item_label' => 'text',
			'fields'     => array(
				array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
				array( 'key' => 'text', 'type' => 'text', 'label' => __( 'Text', 'accessiq-demo' ) ),
			),
		),
		array( 'key' => 'demo_title', 'type' => 'text', 'label' => __( 'Scanner card title', 'accessiq-demo' ) ),
		array( 'key' => 'demo_hint', 'type' => 'text', 'label' => __( 'Scanner card hint', 'accessiq-demo' ) ),
		array(
			'key'        => 'samples',
			'type'       => 'repeater',
			'label'      => __( 'Scanner sample pages', 'accessiq-demo' ),
			'item_label' => 'name',
			'fields'     => array(
				array( 'key' => 'name', 'type' => 'text', 'label' => __( 'Tab name', 'accessiq-demo' ) ),
				array( 'key' => 'url', 'type' => 'text', 'label' => __( 'Fake URL', 'accessiq-demo' ) ),
				array( 'key' => 'score', 'type' => 'number', 'label' => __( 'Score (0-100)', 'accessiq-demo' ) ),
				array( 'key' => 'level', 'type' => 'text', 'label' => __( 'Level label', 'accessiq-demo' ) ),
				array( 'key' => 'issues', 'type' => 'textarea', 'label' => __( 'Issues (one per line)', 'accessiq-demo' ), 'help' => __( 'Format: severity|category|rule|element|fix   (severity: critical, serious, moderate)', 'accessiq-demo' ) ),
			),
		),
		array(
			'key'        => 'floaters',
			'type'       => 'repeater',
			'label'      => __( 'Floating chips around the scanner (max 4 shown)', 'accessiq-demo' ),
			'item_label' => 'text',
			'fields'     => array(
				array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
				array( 'key' => 'text', 'type' => 'text', 'label' => __( 'Text', 'accessiq-demo' ) ),
				array( 'key' => 'sub', 'type' => 'text', 'label' => __( 'Small text', 'accessiq-demo' ) ),
			),
		),
	),
);
