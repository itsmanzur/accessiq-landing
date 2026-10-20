<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Comparison table', 'accessiq-demo' ),
	'icon'     => 'scale',
	'desc'     => __( 'Feature comparison table. Edit columns and rows as plain text.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'Why AccessIQ',
		'title'    => 'Overlays hide problems. [[AccessIQ finds and fixes them.]]',
		'subtitle' => 'How AccessIQ compares with accessibility overlays and third-party heatmap tools.',
		'cols'     => "AccessIQ\nAccessibility overlays\nHotjar-style tools",
		'rows'     => "Detects real WCAG violations | yes | no | no\nShows the exact failing element | yes | no | no\nFix guidance for each issue | yes | ~Cosmetic only | no\nAuto-fixes real HTML | yes | no | no\nSelf-hosted data | yes | no | no\nClick heatmaps | yes | no | yes\nBehavior analytics | yes | no | yes\nCookie-free tracking | yes | no | no\nUnlimited scans | yes | ~Varies | ~Page caps\nNo external subscription for core | yes | no | no\nAI alt text & fixes | Pro | no | no\nPDF reports for clients | Pro | ~Varies | no",
		'footnote' => 'Comparison reflects typical product categories, not any single vendor. Verify current features before you buy.',
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'cols', 'type' => 'lines', 'label' => __( 'Columns (first = your product)', 'accessiq-demo' ) ),
			array( 'key' => 'rows', 'type' => 'textarea', 'rows' => 12, 'label' => __( 'Rows', 'accessiq-demo' ), 'help' => __( 'One per line: Feature | value | value | value. Values: yes, no, Pro, or text (prefix ~ for a partial/orange cell). "# Title" starts a group.', 'accessiq-demo' ) ),
			array( 'key' => 'footnote', 'type' => 'text', 'label' => __( 'Footnote', 'accessiq-demo' ) ),
		)
	),
);
