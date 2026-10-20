<?php
defined( 'ABSPATH' ) || exit;

/**
 * Module catalogue — EVERY AccessIQ (free) and AccessIQ Pro module lives here.
 * Edit text freely in the builder; add a module by adding a row.
 */
$aiqd_mods = array();
$aiqd_add  = function ( $id, $name, $tier, $cat, $icon, $visual, $tagline, $desc, $bullets, $where ) use ( &$aiqd_mods ) {
	$aiqd_mods[] = array(
		'id'      => $id,
		'name'    => $name,
		'tier'    => $tier,
		'cat'     => $cat,
		'icon'    => $icon,
		'visual'  => $visual,
		'tagline' => $tagline,
		'desc'    => $desc,
		'bullets' => implode( "\n", $bullets ),
		'where'   => $where,
		'link'    => '',
	);
};

/* ───────────── FREE ───────────── */
$aiqd_add( 'scanner', 'WCAG Scanner', 'free', 'Scan', 'search', 'scanner',
	'Score any page 0–100 against WCAG 2.1 & 2.2.',
	'Run unlimited scans on any page or post URL. Every violation shows the exact element, its severity and a concrete fix suggestion. Choose Level A, AA or AAA as the target per scan.',
	array( 'Animated 0–100 score ring with grade label', 'Levels A, AA and AAA per scan', 'Critical / Serious / Moderate severity labels', 'Exact element selector + HTML snippet', 'Fix suggestion for every violation type', 'WCAG 2.2 checks: Focus Not Obscured, Dragging Movements, Target Size', 'Perfect-score celebration screen at 100/100' ),
	'AccessIQ → WCAG Scanner' );
$aiqd_add( 'reports', 'Scan Reports & History', 'free', 'Scan', 'file', 'report',
	'Every scan saved with a score trend per URL.',
	'A full history of scans with date, score, issue count and WCAG level. Watch the line chart climb as you fix things, re-run any scan in one click and print a clean report.',
	array( 'Score history line chart per URL', 'One-click rescan', 'Single report view with violation breakdown and bar chart by category', 'Print / save as PDF from the browser', '365-day retention with automatic cleanup' ),
	'AccessIQ → Scan Reports' );
$aiqd_add( 'issues', 'All Issues', 'free', 'Scan', 'bug', 'issues',
	'Every violation across every scanned page, in one list.',
	'Stop opening reports one at a time. The All Issues view centralises violations across all scanned URLs so you can filter by severity and fix the worst first.',
	array( 'Cross-page violation list', 'Filter by severity (errors / warnings)', 'Jump from an issue to its source report', 'Plain element + fix guidance on every row' ),
	'AccessIQ → All Issues' );
$aiqd_add( 'heatmap', 'Heatmap Engine', 'free', 'Insight', 'flame', 'heatmap',
	'See where visitors click — on your own server.',
	'Click heatmaps are drawn over your live page inside a macOS-style browser frame in WP Admin. Nothing is sent to Hotjar or any third party; every click lives in your own database.',
	array( 'Live intensity overlay: hot and cold spots', 'In-dashboard preview with LIVE badge', 'Top clicked elements table with gold / silver / bronze ranks', 'Filter by device (desktop / mobile / tablet) and 7 / 30 / 90 days', 'Peak activity hour', 'Tracker is two async scripts, ~9 KB combined' ),
	'AccessIQ → Heatmap' );
$aiqd_add( 'behavior', 'Behavior Analytics', 'free', 'Insight', 'chart', 'chart',
	'Sessions, bounce rate and device split — cookie-free.',
	'Animated Chart.js dashboards for sessions, average time on page, bounce rate and device mix. No cookies and no Google Analytics dependency.',
	array( 'Daily sessions chart with gradient fill and tooltips', 'Animated device donut: desktop / mobile / tablet', 'Top pages with sessions, time, bounce rate and top device', 'Colour-coded bounce-rate alerts', '7 / 30 / 90 day ranges', 'Random per-tab session id in sessionStorage — no IP stored' ),
	'AccessIQ → Behavior' );
$aiqd_add( 'journey', 'Journey Tracker', 'free', 'Insight', 'route', 'journey',
	'Follow a visitor from first page to last.',
	'See the last sessions as ordered page paths with time spent, so you can understand how people move through your site and where they drop off.',
	array( 'Session list with page count and total time', 'Entry page and path per session', 'Built on the same privacy-first page-view data', 'No personal data stored' ),
	'AccessIQ → Journey' );
$aiqd_add( 'widget', 'Accessibility Widget', 'free', 'Widget', 'accessibility', 'widget',
	'15 tools for your visitors in a floating toolbar.',
	'A redesigned floating toolbar with grouped accordions, Lucide SVG icons, dark / light / system theme and a mobile bottom sheet. Visitors adjust the site to their needs — and nothing external loads.',
	array( 'Text: font size 80–150%, letter spacing, line height, dyslexia-friendly font, reading line, reading mask', 'Colour: high contrast, monochrome, saturation, highlight links, highlight titles', 'Motion & navigation: stop animations, big cursor (4 colours), keyboard focus, screen-reader optimise', 'Brand colour: 9 swatches + picker + hex', 'Position, panel width and height, mobile bottom sheet < 480px' ),
	'AccessIQ → Settings → Widget' );
$aiqd_add( 'profiles', 'Accessibility Profiles', 'free', 'Widget', 'users', 'profiles',
	'Five one-click presets that apply many settings at once.',
	'Profiles are the fastest way for a visitor to get the right experience. Pick the ones to show from Settings.',
	array( 'Vision Impaired: 130% font + high contrast + big black cursor', 'ADHD Friendly: stop animations + reading line + mask + line height', 'Seizure Safe: stop animations + low saturation', 'Dyslexia: dyslexia font + letter spacing + line height + 110% font', 'Keyboard Only: keyboard navigation + highlighted links' ),
	'AccessIQ → Settings → Widget' );
$aiqd_add( 'autofix', 'Auto-Fix Engine', 'free', 'Automation', 'wrench', 'autofix',
	'Apply common fixes with no code.',
	'Real HTML fixes, not an overlay. Toggle the fixes you want and AccessIQ applies them on the front end.',
	array( 'Skip link as the first focusable element', 'Visible focus outline on every focusable element', 'html lang attribute auto-added', 'Missing alt filled from the Media Library; alt="" for spacers and tracking pixels' ),
	'AccessIQ → Auto-Fix' );
$aiqd_add( 'statement', 'Accessibility Statement', 'free', 'Automation', 'badge', 'statement',
	'Generate and publish a statement in one click.',
	'Auto-fills organisation name, last scan date and top violations. Live preview, one-click publish to a WordPress page and an embeddable badge — worded as an aim to conform, never a false claim.',
	array( 'Statement generator with live preview', 'One-click create / update page', '[accessiq_badge] shortcode, dark or light', '[accessiq_statement] shortcode', 'Footer link inside the widget' ),
	'AccessIQ → Statement' );
$aiqd_add( 'schedule', 'Scheduled Scans', 'free', 'Automation', 'calendar', 'schedule',
	'Re-scan on autopilot — daily, weekly or monthly.',
	'Keep a compliance history without remembering to click. Scheduled scans run in the background and old data is cleaned up automatically.',
	array( 'Daily, weekly and monthly schedules', 'Background WP-Cron execution', 'Automatic cleanup of old data', 'Pro adds email delivery and score-drop alerts' ),
	'AccessIQ → Settings → Scanner' );
$aiqd_add( 'remote', 'Remote Connector API', 'free', 'Automation', 'plug', 'api',
	'A secure REST API so a hub can read your site.',
	'Each site exposes a key-protected REST endpoint so AccessIQ Pro’s hub can pull score, issues and last scan date — and trigger scans — from one place.',
	array( 'Key-protected REST routes', 'Brute-force limiting on the key', 'Remote-triggered scans', 'Used by the Pro Multi-Site Hub' ),
	'AccessIQ → Settings → Remote' );
$aiqd_add( 'i18n', 'Translation & RTL ready', 'free', 'Automation', 'languages', 'i18n',
	'Fully translatable, with Bengali included.',
	'Every string is translatable, a bn_BD translation ships in the box and Pro admin screens mirror on right-to-left sites.',
	array( 'POT file + Bengali (bn_BD) translation', 'RTL-safe logical spacing in admin', 'No external fonts or scripts' ),
	'Languages' );

/* ───────────── PRO ───────────── */
$aiqd_add( 'pdf', 'PDF Reports', 'pro', 'Reports', 'file', 'pdf',
	'Branded multi-page reports for clients.',
	'Generate professional accessibility reports with your logo, company name and accent colour. Wording is careful: no false “meets WCAG” claims.',
	array( 'Multi-page PDF with category bars', 'White-label logo, name and accent colour', 'Saved in an unguessable folder, removed after emailing', 'Per-client branding on the Agency plan' ),
	'AccessIQ → Reports' );
$aiqd_add( 'email', 'Email Reports & Alerts', 'pro', 'Reports', 'mail', 'mail',
	'PDF reports in your inbox, plus score-drop alerts.',
	'After each scheduled scan AccessIQ Pro can email the PDF report and warn you the moment a score regresses.',
	array( 'Email delivery after scheduled scans', 'Regression alerts when the score drops', 'Scheduled scans capped at 25 URLs / 240 s per run for reliability' ),
	'AccessIQ → Scheduled Scans' );
$aiqd_add( 'alttext', 'AI Alt Text', 'pro', 'AI', 'sparkles', 'alt',
	'Descriptive alt text from the AI you choose.',
	'Bring your own key and generate alt text with Gemini, Groq, Claude, OpenAI or any OpenAI-compatible endpoint. Data is sent only when you click Generate. Keys are stored encrypted.',
	array( 'Providers: Gemini, Groq, Claude, OpenAI, custom endpoint', 'One-click generate per image', 'Keys encrypted with libsodium; Gemini key sent in a header', 'Skips decorative alt="" images' ),
	'AccessIQ → AI Alt Text / AI Settings' );
$aiqd_add( 'bulk', 'Bulk Alt Text & Media Column', 'pro', 'AI', 'image', 'bulk',
	'Fix a whole media library in one run.',
	'Batch-process every image missing alt text, and see or regenerate alt text right inside the Media list table.',
	array( 'Bulk run with lock and failure guard', 'Media Library column to view / regenerate', 'Never blocks the request' ),
	'Media Library · AccessIQ → AI Alt Text' );
$aiqd_add( 'plain', 'Plain-English Fixes', 'pro', 'AI', 'book', 'explain',
	'Understand any violation without reading the spec.',
	'Click a violation and get a short explanation in simple language, cached so it is instant next time. Perfect for clients and content editors.',
	array( 'AI explanation per violation', 'Result cached per issue', 'Works inside scan reports' ),
	'AccessIQ → Scan Reports' );
$aiqd_add( 'contrast', 'AI Contrast Fixer', 'pro', 'AI', 'contrast', 'contrast',
	'Colour suggestions that pass 4.5:1.',
	'For contrast violations the Contrast Fixer proposes accessible colour pairs that stay close to your brand.',
	array( 'Suggested foreground / background pairs', 'Shows the new ratio', 'One-click copy of the colour' ),
	'AccessIQ → Scan Reports' );
$aiqd_add( 'aria', 'ARIA Writer & Labeler', 'pro', 'AI', 'tag', 'aria',
	'Generate aria-labels right from the report.',
	'“Fix with AI” sits next to missing-label violations. Generate All, character count (80) and per-element regenerate keep labels short and useful.',
	array( 'Fix with AI button in reports', 'Generate All + per-element regenerate', '80-character guidance', 'Ignores decorative alt="" images' ),
	'AccessIQ → ARIA Writer' );
$aiqd_add( 'heading', 'Heading Fixer', 'pro', 'AI', 'type', 'heading',
	'Repair broken heading hierarchies.',
	'Finds posts and pages with skipped or empty heading levels, previews the corrected outline and applies it — classic editor and Gutenberg.',
	array( 'Detects skipped / multiple / empty headings', 'Before / after outline preview', 'Per-post permission checks' ),
	'AccessIQ → Heading Fixer' );
$aiqd_add( 'analytics', 'Advanced Analytics', 'pro', 'Insight', 'trending', 'advanced',
	'Deeper reporting on scans and traffic.',
	'A Pro analytics page that goes beyond the free overview: trends across scans, issue categories and engagement.',
	array( 'Trend analysis across scans', 'Issue-category insights', 'Scheduled scans counted once (no double count)' ),
	'AccessIQ → Analytics' );
$aiqd_add( 'correlation', 'Heatmap + Risk Correlation', 'pro', 'Insight', 'target', 'correlation',
	'Find the high-traffic elements that also fail WCAG.',
	'Joins click heatmaps with scan violations so you fix the issues real visitors actually touch first.',
	array( 'Matches clicked elements to violations', 'Prioritised risk list', 'Timezone-aware date ranges' ),
	'AccessIQ → Risk Correlation' );
$aiqd_add( 'editor', 'In-editor WCAG Scan', 'pro', 'Insight', 'pen', 'editor',
	'Scan from the Gutenberg sidebar.',
	'Check a page while you write it — including drafts, by rendering the unsaved editor content. No arbitrary URLs are accepted.',
	array( 'Gutenberg sidebar panel', 'Works for drafts', 'SSRF-safe: only your own content' ),
	'Block editor sidebar' );
$aiqd_add( 'whitelabel', 'White-label Widget', 'pro', 'Agency', 'palette', 'whitelabel',
	'Ship the widget under your agency brand.',
	'Replace the AccessIQ identity with your logo and colours on the visitor-facing toolbar.',
	array( 'Your logo and colours', 'Live preview', 'Works across the widget themes' ),
	'AccessIQ → White-label' );
$aiqd_add( 'csv', 'CSV Export', 'pro', 'Reports', 'download', 'csv',
	'Export violations, summaries and correlations.',
	'Spreadsheet-safe CSV exports (formula-injection neutralised) for violations, summaries and correlation reports.',
	array( 'Violations, summaries and correlation reports', 'Formula injection neutralised', 'Opens cleanly in Excel / Sheets' ),
	'Reports screens' );
$aiqd_add( 'hub', 'Multi-Site Hub', 'pro', 'Agency', 'globe', 'hub',
	'Monitor up to 25 sites on Pro, unlimited on Agency.',
	'Connect client sites and see score, issues and last scan date side by side. Test connections and trigger scans remotely.',
	array( 'Monitor up to 25 sites on Pro, unlimited on Agency', 'Score, issues and last scan per site', 'Connection test + remote trigger', 'API keys stored encrypted', 'Auto-refresh scheduled on init' ),
	'AccessIQ → Hub Dashboard' );

/* ───────────── AGENCY ───────────── */
$aiqd_add( 'agency', 'Agency Dashboard', 'agency', 'Agency', 'building', 'agency',
	'Unlimited-site hub with client groups and bulk scan.',
	'Group sites by client, run bulk scans and see summary cards for the whole portfolio.',
	array( 'Client groups', 'Bulk scan', 'Summary cards for the portfolio', 'Unlimited connected sites' ),
	'AccessIQ → Agency Dashboard' );
$aiqd_add( 'brand', 'Per-client PDF Branding', 'agency', 'Agency', 'badge', 'brand',
	'A different logo and colour for each client report.',
	'Edit the brand for each connected site and every PDF is generated in that client’s identity.',
	array( 'Logo and colour per client', 'Edit Brand panel', 'Applied automatically to PDFs' ),
	'AccessIQ → Agency Dashboard' );
$aiqd_add( 'crawler', 'Full-Site Crawler', 'agency', 'Agency', 'network', 'crawler',
	'Scan every page from the sitemap.',
	'Reads your sitemap, queues up to 50 pages and scans them in cron batches of five — in-process on the crawled host only.',
	array( 'Sitemap-driven queue (max 50 pages)', 'Batches of 5 via WP-Cron', 'Progress view' ),
	'AccessIQ → Full-Site Crawler' );
$aiqd_add( 'network', 'Multisite Network Dashboard', 'agency', 'Agency', 'layers', 'network',
	'Every sub-site in a WordPress network.',
	'Super-admin-only dashboard that surfaces scores and issues for all sub-sites in a multisite network.',
	array( 'All sub-sites in one table', 'Super-admin only', 'Network-level summary' ),
	'Network Admin' );

return array(
	'label'    => __( 'Module explorer', 'accessiq-demo' ),
	'icon'     => 'grid',
	'desc'     => __( 'Interactive explorer of EVERY module (free + Pro + Agency) with filters, search and visual previews.', 'accessiq-demo' ),
	'defaults' => array(
		'eyebrow'     => 'Every module',
		'title'       => 'Explore what’s inside — [[nothing is hidden]]',
		'subtitle'    => 'Free and Pro modules side by side. Filter by plan, search, or click any module to see exactly how it works.',
		'show_search' => 1,
		'modules'     => $aiqd_mods,
	),
	'schema'   => array_merge(
		AIQD_Registry::head_fields(),
		array(
			array( 'key' => 'show_search', 'type' => 'toggle', 'label' => __( 'Show search box', 'accessiq-demo' ) ),
			array(
				'key'        => 'modules',
				'type'       => 'repeater',
				'label'      => __( 'Modules', 'accessiq-demo' ),
				'item_label' => 'name',
				'fields'     => array(
					array( 'key' => 'id', 'type' => 'text', 'label' => __( 'ID (slug, unique)', 'accessiq-demo' ) ),
					array( 'key' => 'name', 'type' => 'text', 'label' => __( 'Name', 'accessiq-demo' ) ),
					array( 'key' => 'tier', 'type' => 'select', 'label' => __( 'Plan badge', 'accessiq-demo' ), 'options' => array( 'free' => 'Free', 'pro' => 'Pro', 'agency' => 'Agency' ) ),
					array( 'key' => 'cat', 'type' => 'text', 'label' => __( 'Category label', 'accessiq-demo' ) ),
					array( 'key' => 'icon', 'type' => 'icon', 'label' => __( 'Icon', 'accessiq-demo' ) ),
					array(
						'key'     => 'visual',
						'type'    => 'select',
						'label'   => __( 'Visual preview', 'accessiq-demo' ),
						'options' => array(
							'scanner' => 'Scanner ring', 'report' => 'Report history', 'issues' => 'Issue list', 'heatmap' => 'Heatmap',
							'chart' => 'Line chart', 'journey' => 'Journey path', 'widget' => 'Widget panel', 'profiles' => 'Profile chips',
							'autofix' => 'Code diff', 'statement' => 'Statement doc', 'schedule' => 'Schedule', 'api' => 'REST code',
							'i18n' => 'Languages', 'pdf' => 'PDF page', 'mail' => 'Email', 'alt' => 'Alt text AI', 'bulk' => 'Bulk progress',
							'explain' => 'Plain English', 'contrast' => 'Contrast swatches', 'aria' => 'ARIA label', 'heading' => 'Heading outline',
							'advanced' => 'KPI tiles', 'correlation' => 'Risk correlation', 'editor' => 'Editor sidebar', 'whitelabel' => 'White-label',
							'csv' => 'CSV table', 'hub' => 'Hub cards', 'agency' => 'Client groups', 'brand' => 'Client brands',
							'crawler' => 'Crawler tree', 'network' => 'Network table',
						),
					),
					array( 'key' => 'tagline', 'type' => 'text', 'label' => __( 'Tagline', 'accessiq-demo' ) ),
					array( 'key' => 'desc', 'type' => 'textarea', 'label' => __( 'Description', 'accessiq-demo' ) ),
					array( 'key' => 'bullets', 'type' => 'lines', 'label' => __( 'Feature bullets (one per line)', 'accessiq-demo' ) ),
					array( 'key' => 'where', 'type' => 'text', 'label' => __( 'Where to find it (menu path)', 'accessiq-demo' ) ),
					array( 'key' => 'link', 'type' => 'link', 'label' => __( 'Optional "Learn more" link', 'accessiq-demo' ) ),
				),
			),
		)
	),
);
