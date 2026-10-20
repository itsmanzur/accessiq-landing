<?php
/**
 * Pure HTML/CSS visual mock-ups for the module explorer. Decorative (aria-hidden by the caller).
 * Add a new visual by adding a case + an option in config.php.
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'aiqd_v_win' ) ) {

	function aiqd_v_win( $title, $inner, $cls = '' ) {
		return '<div class="v-win ' . esc_attr( $cls ) . '"><div class="v-win__bar"><i></i><i></i><i></i><span>' . esc_html( $title ) . '</span></div><div class="v-win__body">' . $inner . '</div></div>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}

	function aiqd_v_bar( $label, $pct, $val = '', $tone = '' ) {
		return '<div class="v-row"><span class="v-k">' . esc_html( $label ) . '</span><span class="v-bar ' . esc_attr( $tone ) . '"><i style="--w:' . (int) $pct . '%"></i></span><b>' . esc_html( $val ) . '</b></div>';
	}

	function aiqd_v_spark( $pts, $w = 220, $h = 60, $cls = '' ) {
		$n   = count( $pts );
		$max = max( $pts );
		$min = min( $pts );
		$rng = max( 1, $max - $min );
		$d   = '';
		foreach ( $pts as $i => $p ) {
			$x  = round( $i * ( $w / max( 1, $n - 1 ) ), 1 );
			$y  = round( $h - 4 - ( ( $p - $min ) / $rng ) * ( $h - 10 ), 1 );
			$d .= ( 0 === $i ? 'M' : 'L' ) . $x . ' ' . $y . ' ';
		}
		return '<svg class="v-spark ' . esc_attr( $cls ) . '" viewBox="0 0 ' . $w . ' ' . $h . '" preserveAspectRatio="none"><path class="v-spark__area" d="' . $d . 'L' . $w . ' ' . $h . ' L0 ' . $h . ' Z"/><path class="v-spark__line" d="' . trim( $d ) . '" pathLength="1"/></svg>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}

	function aiqd_v_pill( $text, $tone = '' ) {
		return '<span class="v-pill ' . esc_attr( $tone ) . '">' . esc_html( $text ) . '</span>';
	}

	function aiqd_module_visual( $key, $m = array() ) {
		$h = '';
		switch ( $key ) {
			case 'scanner':
				$h  = '<div class="v-split">' . aiqd_ring( 87, 116 ) . '<div class="v-col">';
				$h .= aiqd_v_bar( 'Images', 70, '4' ) . aiqd_v_bar( 'Contrast', 45, '3', 'warn' ) . aiqd_v_bar( 'Headings', 20, '1' ) . aiqd_v_bar( 'ARIA', 55, '3', 'bad' ) . aiqd_v_bar( 'Forms', 30, '2' );
				$h .= '</div></div><div class="v-chips">' . aiqd_v_pill( 'WCAG 2.2 AA' ) . aiqd_v_pill( '2 critical', 'bad' ) . aiqd_v_pill( '5 serious', 'warn' ) . '</div>';
				return aiqd_v_win( 'yoursite.com/checkout', $h );

			case 'report':
				$rows = array( array( '/', 96, '12 Jul' ), array( '/checkout', 74, '12 Jul' ), array( '/about', 100, '10 Jul' ), array( '/contact', 41, '08 Jul' ) );
				$h    = aiqd_v_spark( array( 41, 48, 55, 52, 63, 70, 74, 82, 88, 96 ), 260, 70, 'is-good' );
				$h   .= '<table class="v-table"><tbody>';
				foreach ( $rows as $r ) {
					$h .= '<tr><td>' . esc_html( $r[0] ) . '</td><td>' . esc_html( $r[2] ) . '</td><td><b class="v-score ' . ( $r[1] >= 90 ? 'good' : ( $r[1] >= 60 ? 'warn' : 'bad' ) ) . '">' . (int) $r[1] . '</b></td></tr>';
				}
				$h .= '</tbody></table>';
				return aiqd_v_win( 'Scan history', $h );

			case 'issues':
				$h  = '<div class="v-chips">' . aiqd_v_pill( 'All', 'on' ) . aiqd_v_pill( 'Errors' ) . aiqd_v_pill( 'Warnings' ) . '</div>';
				$h .= '<ul class="v-list">';
				foreach ( array( array( 'bad', 'Image missing alt text', '/checkout' ), array( 'bad', 'Form input has no label', '/contact' ), array( 'warn', 'Heading level skipped', '/blog' ), array( 'warn', 'Low contrast text', '/' ), array( 'warn', 'Link text not descriptive', '/shop' ) ) as $r ) {
					$h .= '<li>' . aiqd_v_pill( 'bad' === $r[0] ? 'Error' : 'Warn', $r[0] ) . '<span>' . esc_html( $r[1] ) . '</span><em>' . esc_html( $r[2] ) . '</em></li>';
				}
				$h .= '</ul>';
				return aiqd_v_win( 'All issues · 38', $h );

			case 'heatmap':
				$h = '<div class="v-heat"><div class="v-heat__page"><b></b><i></i><i class="s"></i><div class="btn"></div><div class="grid"><s></s><s></s><s></s></div></div>'
					. '<span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span><span class="blob b4"></span></div>'
					. '<div class="v-chips">' . aiqd_v_pill( 'Desktop', 'on' ) . aiqd_v_pill( 'Mobile' ) . aiqd_v_pill( '30 days' ) . '</div>';
				return aiqd_v_win( 'yoursite.com · LIVE PREVIEW', $h );

			case 'chart':
				$h  = '<div class="v-kpis"><div><b>12.4k</b><small>Sessions</small></div><div><b>1:42</b><small>Avg time</small></div><div><b>38%</b><small>Bounce</small></div></div>';
				$h .= aiqd_v_spark( array( 12, 18, 14, 22, 30, 26, 38, 34, 44, 52, 48, 60 ), 300, 80 );
				$h .= '<div class="v-donut" style="--a:58;--b:32"><span></span><ul><li><i class="a"></i>Desktop 58%</li><li><i class="b"></i>Mobile 32%</li><li><i class="c"></i>Tablet 10%</li></ul></div>';
				return aiqd_v_win( 'Behavior analytics', $h );

			case 'journey':
				$h = '<ol class="v-path"><li><b>/</b><small>0:24</small></li><li><b>/shop</b><small>1:10</small></li><li><b>/product/lamp</b><small>2:03</small></li><li><b>/cart</b><small>0:41</small></li><li class="end"><b>/checkout</b><small>exit</small></li></ol>';
				return aiqd_v_win( 'Session 4f9c · 5 pages', $h );

			case 'widget':
				$h  = '<div class="v-widget">';
				foreach ( array( 'Font size', 'High contrast', 'Dyslexia font', 'Reading mask', 'Stop animations', 'Big cursor' ) as $i => $t ) {
					$h .= '<div class="v-toggle"><span>' . esc_html( $t ) . '</span><i class="' . ( in_array( $i, array( 1, 2 ), true ) ? 'on' : '' ) . '"></i></div>';
				}
				$h .= '</div>';
				return aiqd_v_win( 'Accessibility', $h, 'v-win--narrow' );

			case 'profiles':
				$h = '<div class="v-profiles">';
				foreach ( array( array( 'eye', 'Vision Impaired' ), array( 'zap', 'ADHD Friendly' ), array( 'shield', 'Seizure Safe' ), array( 'type', 'Dyslexia' ), array( 'keyboard', 'Keyboard Only' ) ) as $i => $p ) {
					$h .= '<div class="v-prof' . ( 1 === $i ? ' on' : '' ) . '">' . aiqd_icon( $p[0], 20 ) . '<span>' . esc_html( $p[1] ) . '</span></div>';
				}
				$h .= '</div>';
				return aiqd_v_win( 'Profiles', $h );

			case 'autofix':
				$h = '<pre class="v-code"><span class="del">- &lt;html&gt;</span>
<span class="add">+ &lt;html lang="en-US"&gt;</span>
<span class="add">+ &lt;a class="skip-link" href="#main"&gt;Skip to content&lt;/a&gt;</span>
<span class="del">- &lt;img src="team.jpg"&gt;</span>
<span class="add">+ &lt;img src="team.jpg" alt="Our team at the 2025 retreat"&gt;</span>
<span class="add">+ a:focus-visible { outline: 3px solid #14b8a6; }</span></pre>';
				return aiqd_v_win( 'Auto-Fix output', $h );

			case 'statement':
				$h = '<div class="v-doc"><h4>Accessibility statement</h4><i></i><i class="s"></i><i></i><p>We aim to conform to WCAG 2.2 AA.</p><i class="s"></i><i></i><div class="v-chips">' . aiqd_v_pill( 'Committed to WCAG 2.2 AA', 'on' ) . '</div></div>';
				return aiqd_v_win( 'Statement preview', $h );

			case 'schedule':
				$h = '<ul class="v-list">';
				foreach ( array( array( 'Daily', '/', 'next 03:00' ), array( 'Weekly', '/checkout', 'next Mon' ), array( 'Monthly', '/blog/*', 'next 1st' ) ) as $r ) {
					$h .= '<li>' . aiqd_v_pill( $r[0], 'on' ) . '<span>' . esc_html( $r[1] ) . '</span><em>' . esc_html( $r[2] ) . '</em></li>';
				}
				$h .= '</ul>';
				return aiqd_v_win( 'Scheduled scans', $h );

			case 'api':
				$h = '<pre class="v-code"><span class="k">GET</span> /wp-json/accessiq/v1/summary
<span class="k">X-AccessIQ-Key:</span> ••••••••••••

{
  "score": 87,
  "issues": 14,
  "last_scan": "2026-07-12",
  "level": "AA"
}</pre>';
				return aiqd_v_win( 'REST connector', $h );

			case 'i18n':
				$h = '<div class="v-chips big">' . aiqd_v_pill( 'English', 'on' ) . aiqd_v_pill( 'বাংলা' ) . aiqd_v_pill( 'العربية · RTL' ) . aiqd_v_pill( 'Deutsch' ) . aiqd_v_pill( 'Español' ) . '</div><div class="v-rtl"><i></i><i class="s"></i><i></i></div>';
				return aiqd_v_win( 'Languages', $h );

			case 'pdf':
				$h = '<div class="v-pdf"><div class="v-pdf__head"><b></b><span>ACME Agency</span></div><h4>Accessibility Report</h4>' . aiqd_ring( 82, 84 ) . aiqd_v_bar( 'Images', 40, '' ) . aiqd_v_bar( 'Contrast', 65, '', 'warn' ) . aiqd_v_bar( 'ARIA', 25, '' ) . '</div>';
				return $h;

			case 'mail':
				$h = '<div class="v-mail"><p><b>From</b> AccessIQ</p><p><b>Subject</b> Weekly report — score dropped 96 → 88 ⚠</p><hr><p>Your scheduled scan found <b>3 new issues</b> on /checkout.</p><div class="v-attach">📎 accessibility-report.pdf</div></div>';
				return aiqd_v_win( 'Inbox', $h );

			case 'alt':
				$h = '<div class="v-split"><div class="v-img"><i></i><b></b></div><div class="v-col"><small>Generated alt text</small><p class="v-type">“A smiling barista handing a takeaway coffee to a customer at a wooden counter.”</p><div class="v-chips">' . aiqd_v_pill( 'Gemini', 'on' ) . aiqd_v_pill( 'Claude' ) . aiqd_v_pill( 'OpenAI' ) . aiqd_v_pill( 'Groq' ) . '</div></div></div>';
				return aiqd_v_win( 'AI Alt Text', $h );

			case 'bulk':
				$h = '<div class="v-progress"><span style="--w:72%"></span></div><p class="v-note">Processing 38 images · 27 done</p><ul class="v-list">';
				foreach ( array( 'team-photo.jpg', 'hero-banner.png', 'product-04.webp', 'logo-dark.svg' ) as $i => $f ) {
					$h .= '<li>' . aiqd_v_pill( $i < 3 ? 'Done' : 'Skipped', $i < 3 ? 'good' : '' ) . '<span>' . esc_html( $f ) . '</span></li>';
				}
				$h .= '</ul>';
				return aiqd_v_win( 'Bulk alt text', $h );

			case 'explain':
				$h = '<div class="v-bubble bad"><small>Violation</small>1.4.3 Contrast (Minimum)</div><div class="v-bubble good"><small>In plain English</small>Light grey text on white is hard to read for many people. Make it darker.</div>';
				return aiqd_v_win( 'Plain English', $h );

			case 'contrast':
				$h = '<div class="v-split"><div class="v-sw" style="background:#fff;color:#9ca3af">Aa<small>2.3 : 1 ✕</small></div><span class="v-arrow">→</span><div class="v-sw" style="background:#fff;color:#4b5563">Aa<small>7.6 : 1 ✓</small></div></div><div class="v-chips">' . aiqd_v_pill( '#4B5563', 'on' ) . aiqd_v_pill( 'Copy colour' ) . '</div>';
				return aiqd_v_win( 'Contrast Fixer', $h );

			case 'aria':
				$h = '<pre class="v-code"><span class="del">- &lt;button class="menu"&gt;</span>
<span class="add">+ &lt;button class="menu" aria-label="Open main menu"&gt;</span></pre><div class="v-chips">' . aiqd_v_pill( 'Fix with AI ✨', 'on' ) . aiqd_v_pill( '17 / 80 chars' ) . '</div>';
				return aiqd_v_win( 'ARIA Writer', $h );

			case 'heading':
				$h = '<div class="v-split"><ul class="v-tree bad"><li>H1 Title</li><li class="l3">H3 Features <em>skipped</em></li><li class="l4">H4 Pricing</li></ul><span class="v-arrow">→</span><ul class="v-tree good"><li>H1 Title</li><li class="l2">H2 Features</li><li class="l3">H3 Pricing</li></ul></div>';
				return aiqd_v_win( 'Heading Fixer', $h );

			case 'advanced':
				$h = '<div class="v-kpis"><div><b>+14</b><small>Score trend</small></div><div><b>62%</b><small>Fixed</small></div><div><b>9</b><small>Open critical</small></div></div>' . aiqd_v_spark( array( 20, 24, 22, 34, 40, 38, 52, 60, 66 ), 300, 70, 'is-good' );
				return aiqd_v_win( 'Advanced analytics', $h );

			case 'correlation':
				$h = '<ul class="v-list">';
				foreach ( array( array( 'bad', '#add-to-cart', '1,204 clicks', 'no label' ), array( 'warn', '.hero-cta', '842 clicks', 'low contrast' ), array( 'good', 'nav a.home', '510 clicks', 'OK' ) ) as $r ) {
					$h .= '<li>' . aiqd_v_pill( $r[3], $r[0] ) . '<span>' . esc_html( $r[1] ) . '</span><em>' . esc_html( $r[2] ) . '</em></li>';
				}
				$h .= '</ul>';
				return aiqd_v_win( 'Risk correlation', $h );

			case 'editor':
				$h = '<div class="v-editor"><div class="v-editor__doc"><i></i><i class="s"></i><i></i><i class="s"></i></div><div class="v-editor__side"><b>AccessIQ</b>' . aiqd_ring( 91, 64 ) . '<small>2 issues</small></div></div>';
				return aiqd_v_win( 'Block editor', $h );

			case 'whitelabel':
				$h = '<div class="v-split"><div class="v-brandbox"><i style="background:#f97316"></i><span>Acme Access</span></div><div class="v-col"><div class="v-swatches"><i style="background:#f97316"></i><i style="background:#6366f1"></i><i style="background:#14b8a6"></i><i style="background:#ec4899"></i></div><small>Brand colour</small></div></div>';
				return aiqd_v_win( 'White-label', $h );

			case 'csv':
				$h = '<table class="v-table"><thead><tr><th>url</th><th>rule</th><th>severity</th></tr></thead><tbody><tr><td>/checkout</td><td>image-alt</td><td>critical</td></tr><tr><td>/</td><td>color-contrast</td><td>serious</td></tr><tr><td>/blog</td><td>heading-order</td><td>moderate</td></tr></tbody></table><div class="v-chips">' . aiqd_v_pill( '⬇ violations.csv', 'on' ) . '</div>';
				return aiqd_v_win( 'Export', $h );

			case 'hub':
				$h = '<div class="v-cards">';
				foreach ( array( array( 'shop.example', 92 ), array( 'blog.example', 78 ), array( 'agency.example', 100 ), array( 'docs.example', 55 ) ) as $c ) {
					$h .= '<div class="v-site"><b class="v-score ' . ( $c[1] >= 90 ? 'good' : ( $c[1] >= 70 ? 'warn' : 'bad' ) ) . '">' . (int) $c[1] . '</b><span>' . esc_html( $c[0] ) . '</span></div>';
				}
				$h .= '</div>';
				return aiqd_v_win( 'Hub · 4 sites', $h );

			case 'agency':
				$h = '<div class="v-groups"><div><strong>Client A</strong><span>3 sites · avg 91</span></div><div><strong>Client B</strong><span>2 sites · avg 74</span></div><div><strong>Client C</strong><span>5 sites · avg 88</span></div></div><div class="v-chips">' . aiqd_v_pill( 'Bulk scan all', 'on' ) . '</div>';
				return aiqd_v_win( 'Agency dashboard', $h );

			case 'brand':
				$h = '<div class="v-split"><div class="v-pdf small"><div class="v-pdf__head"><b style="background:#f97316"></b><span>Client A</span></div><i></i><i class="s"></i></div><div class="v-pdf small"><div class="v-pdf__head"><b style="background:#6366f1"></b><span>Client B</span></div><i></i><i class="s"></i></div></div>';
				return $h;

			case 'crawler':
				$h = '<div class="v-progress"><span style="--w:64%"></span></div><ul class="v-tree flat"><li>/ <em>done</em></li><li class="l2">/about <em>done</em></li><li class="l2">/services <em>done</em></li><li class="l2">/blog <em>scanning…</em></li><li class="l3">/blog/post-1 <em>queued</em></li></ul>';
				return aiqd_v_win( 'Crawling sitemap · 32 / 50', $h );

			case 'network':
				$h = '<table class="v-table"><thead><tr><th>Sub-site</th><th>Score</th><th>Issues</th></tr></thead><tbody><tr><td>/store</td><td><b class="v-score good">94</b></td><td>3</td></tr><tr><td>/news</td><td><b class="v-score warn">71</b></td><td>19</td></tr><tr><td>/docs</td><td><b class="v-score good">98</b></td><td>1</td></tr></tbody></table>';
				return aiqd_v_win( 'Network admin', $h );
		}
		return '<div class="v-win"><div class="v-win__body"><span class="v-pill on">' . esc_html( isset( $m['name'] ) ? $m['name'] : '' ) . '</span></div></div>';
	}
}
