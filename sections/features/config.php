<?php
defined( 'ABSPATH' ) || exit;

return array(
	'label'    => __( 'Feature grid (tabs)', 'accessiq-demo' ),
	'icon'     => 'grid',
	'desc'     => __( 'Tabbed grid of every single feature as short cards with Free / Pro badges. Nothing gets left out.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'  => 'Every feature',
		'title'    => 'The complete checklist — [[free and Pro]]',
		'subtitle' => 'Every capability in one scannable grid. Free features are marked Free; Pro features carry a Pro or Agency badge.',
		'tabs'     => array(
			array(
				'id' => 'scanner', 'label' => 'WCAG Scanner', 'icon' => 'search',
				'cards' => "free|Accessibility score 0–100|Animated score ring with an Excellent / Good / Fair / Poor grade.\nfree|WCAG 2.1 & 2.2 · A / AA / AAA|Choose the target level on every scan.\nfree|Violations by category|Visual bars for Images, Contrast, Headings, ARIA and Forms.\nfree|Severity labels|Critical, Serious and Moderate classification.\nfree|Exact element selector|See the HTML element that caused each violation.\nfree|Fix suggestions|Actionable guidance for every violation type.\nfree|Scan history|Date, score, issue count and level for every URL.\nfree|Score history chart|Line chart of your score over time.\nfree|One-click rescan|Re-run any scan from the reports page.\nfree|Print reports|Print or save a clean report from the browser.\nfree|Unlimited scans|No credits, no paywalls, no limits.\nfree|WCAG 2.2 checks|Focus Not Obscured, Dragging Movements, Target Size (Minimum).\nfree|Perfect-score celebration|A special screen at 100 / 100.\nfree|All Issues view|Every violation across every page in one list.",
			),
			array(
				'id' => 'heatmap', 'label' => 'Heatmaps', 'icon' => 'flame',
				'cards' => "free|Live click heatmap|Hot and cold spots drawn over your real page.\nfree|In-dashboard preview|View heatmaps inside WP Admin — no external app.\nfree|macOS-style browser frame|URL bar and LIVE PREVIEW badge.\nfree|Top clicked elements|Ranked table with selector, clicks and % of total.\nfree|Gold / silver / bronze ranks|Instantly see your top three elements.\nfree|Date range filter|7, 30 or 90 days.\nfree|Device filter|All, desktop, mobile or tablet.\nfree|Page dropdown|Pick any tracked page.\nfree|Peak activity hour|Learn when visitors are most active.\nfree|100% self-hosted|Every click stays in your WordPress database.\nfree|Lightweight tracker|Two async scripts, about 9 KB combined.",
			),
			array(
				'id' => 'analytics', 'label' => 'Analytics', 'icon' => 'chart',
				'cards' => "free|Session tracking|Total sessions, average time on page and bounce rate.\nfree|Daily sessions chart|Chart.js line with gradient fill and tooltips.\nfree|Device breakdown|Animated donut: desktop, mobile, tablet.\nfree|Top pages|Sessions, time, bounce rate and top device per page.\nfree|7 / 30 / 90 day ranges|Switch periods instantly.\nfree|Bounce-rate alerts|Colour-coded red, amber and green.\nfree|Journey tracker|Follow real sessions page by page.\nfree|Privacy first|No cookies, no third-party scripts, no GA dependency.\npro|Advanced analytics|Deeper trend and category reporting.\npro|Heatmap + Risk Correlation|Find high-traffic elements that fail WCAG.\npro|CSV export|Violations, summaries and correlation reports.",
			),
			array(
				'id' => 'widget', 'label' => 'Widget', 'icon' => 'accessibility',
				'cards' => "free|Font size 80–150%|A− / A+ controls for every visitor.\nfree|Letter spacing & line height|Slider 0–5 px and three line-height levels.\nfree|Dyslexia-friendly font|Lexend / OpenDyslexic stack, no external requests.\nfree|Reading line & mask|A guide line and a spotlight window for focus.\nfree|High contrast & monochrome|One-click colour schemes and grayscale.\nfree|Saturation control|Low, normal or high.\nfree|Highlight links & titles|Outlines and heading accents.\nfree|Stop animations|Disables CSS animations, transitions and smooth scroll.\nfree|Big cursor|Four colours: white, black, teal, red.\nfree|Keyboard navigation|Strong focus indicators sitewide.\nfree|Screen-reader optimise|Improves page structure for assistive tech.\nfree|5 accessibility profiles|Vision, ADHD, Seizure Safe, Dyslexia, Keyboard Only.\nfree|Brand colour|9 swatches, picker and hex input.\nfree|Position, width & height|Four corners, three widths, four heights.\nfree|Dark / Light / System|Matches the visitor’s preference.\nfree|Mobile bottom sheet|Slides up on screens under 480 px.\npro|White-label widget|Your agency logo and colours.",
			),
			array(
				'id' => 'automation', 'label' => 'Fix & automate', 'icon' => 'wrench',
				'cards' => "free|Skip link|Adds “Skip to content” as the first focusable element.\nfree|Focus outline|Injects a visible focus ring everywhere.\nfree|HTML lang attribute|Adds lang to the html tag automatically.\nfree|Image alt fill|Uses Media Library alt text; alt=\"\" for decorative images.\nfree|Statement generator|Auto-filled, live preview, one-click publish.\nfree|[accessiq_badge] shortcode|Dark or light badge, “Committed to WCAG 2.2 AA”.\nfree|Scheduled scans|Daily, weekly or monthly in the background.\npro|Heading Fixer|Repairs skipped and empty heading levels.\npro|ARIA Writer|AI labels with character count and regenerate.\npro|AI Contrast Fixer|Colour suggestions that reach 4.5:1.\npro|Plain-English fixes|Explain any violation in simple words.\npro|In-editor scan|Gutenberg sidebar scan, even for drafts.",
			),
			array(
				'id' => 'pro', 'label' => 'Pro & Agency', 'icon' => 'crown',
				'cards' => "pro|Branded PDF reports|Logo, company name and accent colour.\npro|Email delivery|PDF emailed after every scheduled scan.\npro|Regression alerts|Get warned when the score drops.\npro|AI alt text|Gemini, Groq, Claude, OpenAI or a custom endpoint.\npro|Bulk alt text|Fix the whole media library in one run.\npro|Media Library column|See and regenerate alt text in the list table.\npro|Multi-site hub|Monitor up to 25 sites on Pro, unlimited on Agency.\npro|CSV export|Spreadsheet-safe exports.\nagency|Agency dashboard|Client groups, bulk scan and summary cards.\nagency|Per-client PDF branding|A different logo and colour per client.\nagency|Full-site crawler|Sitemap queue, up to 50 pages.\nagency|Network dashboard|All sub-sites of a multisite network.\nagency|Priority support|Priority email support on the Agency plan.",
			),
			array(
				'id' => 'privacy', 'label' => 'Privacy & speed', 'icon' => 'shield',
				'cards' => "free|No cookies|A random per-tab session id lives in sessionStorage only.\nfree|No IP addresses stored|No usernames, emails or other personal data.\nfree|No external requests|No third-party fonts, scripts or APIs for core features.\nfree|Self-hosted data|Scans, clicks and sessions stay in your database.\nfree|Tiny tracker|About 9 KB, loaded asynchronously.\nfree|Throttled tracking|Hashed one-minute counters stop abusive bursts.\nfree|Page-builder friendly|Scans the final rendered HTML — Elementor, Divi and more.\nfree|Hardened|Nonce + capability checks, SSRF protection, encrypted keys in Pro.",
			),
		),
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array(
				'key'        => 'tabs',
				'type'       => 'repeater',
				'label'      => __( 'Tabs', 'accessiq-demo' ),
				'item_label' => 'label',
				'fields'     => array(
					array( 'key' => 'id', 'type' => 'text', 'label' => __( 'ID (slug)', 'accessiq-demo' ) ),
					array( 'key' => 'label', 'type' => 'text', 'label' => __( 'Tab label', 'accessiq-demo' ) ),
					array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
					array( 'key' => 'cards', 'type' => 'textarea', 'rows' => 12, 'label' => __( 'Cards (one per line)', 'accessiq-demo' ), 'help' => __( 'Format: tier|Title|Description   — tier is free, pro, agency, new or soon.', 'accessiq-demo' ) ),
				),
			),
		)
	),
);
