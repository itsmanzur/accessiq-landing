<?php
/**
 * Shared helpers: icons, text formatting, link resolving, buttons.
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Inline SVG icon library (24x24, stroke based).
 *
 * @return array name => inner svg markup
 */
function aiqd_icon_set() {
	static $icons = null;
	if ( null !== $icons ) {
		return $icons;
	}
	$icons = array(
		'check'         => '<path d="M20 6 9 17l-5-5"/>',
		'x'             => '<path d="M18 6 6 18M6 6l12 12"/>',
		'arrow-right'   => '<path d="M5 12h14M12 5l7 7-7 7"/>',
		'arrow-up'      => '<path d="M12 19V5M5 12l7-7 7 7"/>',
		'search'        => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
		'shield'        => '<path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3z"/><path d="m9 12 2 2 4-4"/>',
		'flame'         => '<path d="M12 3c1 3 5 5 5 10a5 5 0 0 1-10 0c0-2 1-3 2-4 0 2 1 3 2 3 0-3-1-6 1-9z"/>',
		'chart'         => '<path d="M3 3v18h18"/><path d="M7 15v-4M12 15V7M17 15v-6"/>',
		'trending'      => '<path d="m3 17 6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
		'activity'      => '<path d="M3 12h4l3-8 4 16 3-8h4"/>',
		'user'          => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>',
		'users'         => '<circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3-6 7-6s7 2.5 7 6"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M22 20c0-3-2-5-5-5.7"/>',
		'type'          => '<path d="M4 7V5h16v2M9 19h6M12 5v14"/>',
		'eye'           => '<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
		'contrast'      => '<circle cx="12" cy="12" r="9"/><path d="M12 3v18a9 9 0 0 0 0-18z" fill="currentColor"/>',
		'zap'           => '<path d="M13 2 4 14h7l-1 8 9-12h-7l1-8z"/>',
		'wrench'        => '<path d="M15 6a4 4 0 0 0 5 5l-9 9a2.1 2.1 0 0 1-3-3l9-9"/><path d="M15 6a4 4 0 0 1 5-3l-3 3 1 2 2 1 3-3a4 4 0 0 1-3 5"/>',
		'tag'           => '<path d="M3 12V3h9l9 9-9 9-9-9z"/><circle cx="7.5" cy="7.5" r="1.5"/>',
		'file'          => '<path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6z"/><path d="M14 3v6h6M8 13h8M8 17h6"/>',
		'mail'          => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'globe'         => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/>',
		'building'      => '<rect x="5" y="3" width="14" height="18" rx="1"/><path d="M9 7h2M13 7h2M9 11h2M13 11h2M10 21v-4h4v4"/>',
		'sparkles'      => '<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3z"/><path d="M19 15l.8 2.2L22 18l-2.2.8L19 21l-.8-2.2L16 18l2.2-.8L19 15z"/>',
		'network'       => '<circle cx="12" cy="5" r="2.5"/><circle cx="5" cy="19" r="2.5"/><circle cx="19" cy="19" r="2.5"/><path d="M12 7.5v4M12 11.5 6 17M12 11.5l6 5.5"/>',
		'layers'        => '<path d="m12 3 9 5-9 5-9-5 9-5z"/><path d="m3 12.5 9 5 9-5"/>',
		'lock'          => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>',
		'download'      => '<path d="M12 3v12m0 0-4-4m4 4 4-4M4 21h16"/>',
		'star'          => '<path d="m12 3 2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9L12 3z"/>',
		'clock'         => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'code'          => '<path d="m8 8-5 4 5 4M16 8l5 4-5 4M14 5l-4 14"/>',
		'pointer'       => '<path d="m5 3 14 7-6 2-2 6L5 3z"/>',
		'palette'       => '<path d="M12 3a9 9 0 1 0 0 18c1.5 0 2-1 1.5-2-.6-1.3.2-2.5 1.7-2.5H17a4 4 0 0 0 4-4C21 6.5 17 3 12 3z"/><circle cx="8" cy="11" r="1"/><circle cx="12" cy="7.5" r="1"/><circle cx="16" cy="11" r="1"/>',
		'sliders'       => '<path d="M4 6h10M18 6h2M4 12h4M12 12h8M4 18h12M20 18h0"/><circle cx="16" cy="6" r="2"/><circle cx="10" cy="12" r="2"/><circle cx="18" cy="18" r="2"/>',
		'heart'         => '<path d="M12 20s-8-5-8-11a4.5 4.5 0 0 1 8-2.6A4.5 4.5 0 0 1 20 9c0 6-8 11-8 11z"/>',
		'calendar'      => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
		'image'         => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.6"/><path d="m21 16-5-5-9 9"/>',
		'link'          => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
		'book'          => '<path d="M4 4h6a3 3 0 0 1 3 3v13a2 2 0 0 0-2-2H4V4z"/><path d="M20 4h-6a3 3 0 0 0-3 3v13a2 2 0 0 1 2-2h7V4z"/>',
		'scale'         => '<path d="M12 3v18M6 21h12M4 7h16"/><path d="m4 7-2 7a3 3 0 0 0 4 0L4 7zm16 0-2 7a3 3 0 0 0 4 0l-2-7z"/>',
		'graduation'    => '<path d="m2 9 10-5 10 5-10 5L2 9z"/><path d="M6 11v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/>',
		'pen'           => '<path d="M4 20h4L19 9l-4-4L4 16v4z"/><path d="m13.5 6.5 4 4"/>',
		'server'        => '<rect x="3" y="4" width="18" height="7" rx="2"/><rect x="3" y="13" width="18" height="7" rx="2"/><path d="M7 7.5h.01M7 16.5h.01"/>',
		'keyboard'      => '<rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10h.01M10 10h.01M14 10h.01M18 10h.01M7 14h10"/>',
		'sun'           => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.5 1.5M17.5 17.5 19 19M5 19l1.5-1.5M17.5 6.5 19 5"/>',
		'moon'          => '<path d="M20 14.5A8.5 8.5 0 0 1 9.5 4a8.5 8.5 0 1 0 10.5 10.5z"/>',
		'menu'          => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'play'          => '<path d="M7 4v16l13-8L7 4z"/>',
		'pause'         => '<path d="M8 4v16M16 4v16"/>',
		'help'          => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9.5a2.5 2.5 0 1 1 3.5 2.3c-.7.4-1 .9-1 1.7M12 17h.01"/>',
		'crown'         => '<path d="m3 8 4 4 5-7 5 7 4-4-2 11H5L3 8z"/>',
		'rocket'        => '<path d="M5 15c-1 1-2 4-2 6 2 0 5-1 6-2M14 4c4 0 6 2 6 6-2 4-5 7-9 8l-5-5c1-4 4-7 8-9z"/><circle cx="15" cy="9" r="1.5"/>',
		'refresh'       => '<path d="M20 12a8 8 0 0 1-14 5.3M4 12a8 8 0 0 1 14-5.3"/><path d="M18 3v4h-4M6 21v-4h4"/>',
		'filter'        => '<path d="M3 5h18l-7 8v6l-4-2v-4L3 5z"/>',
		'grid'          => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
		'bell'          => '<path d="M6 9a6 6 0 0 1 12 0c0 6 2 7 2 8H4c0-1 2-2 2-8z"/><path d="M10 21h4"/>',
		'map'           => '<path d="M9 4 3 6v14l6-2 6 2 6-2V4l-6 2-6-2zM9 4v14M15 6v14"/>',
		'languages'     => '<path d="M4 5h9M8.5 3v2M6 5c0 4 3 7 6 8M11 5c0 3-3 7-7 9M13 20l4-10 4 10M14.5 17h5"/>',
		'accessibility' => '<circle cx="12" cy="4.5" r="1.8"/><path d="M5 8.5c4 1.2 10 1.2 14 0M12 8v6m0 0-3 7m3-7 3 7"/>',
		'cart'          => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.5 12h11l2-8H6"/>',
		'route'         => '<circle cx="6" cy="19" r="2.5"/><circle cx="18" cy="5" r="2.5"/><path d="M8.5 19H16a3.5 3.5 0 0 0 0-7H8a3.5 3.5 0 0 1 0-7h7.5"/>',
		'dollar'        => '<path d="M12 2v20M17 6.5C16 5 14.5 4.5 12 4.5c-3 0-5 1.3-5 3.5 0 5 10 2.5 10 8 0 2.2-2 3.5-5 3.5-2.5 0-4.2-.8-5.2-2.5"/>',
		'bug'           => '<rect x="7" y="8" width="10" height="12" rx="5"/><path d="M12 8V4M9 4l1.5 2M15 4l-1.5 2M3 12h4M17 12h4M4 19l3-2M20 19l-3-2M4 6l3 2M20 6l-3 2"/>',
		'plug'          => '<path d="M9 2v6M15 2v6M6 8h12v4a6 6 0 0 1-12 0V8zM12 18v4"/>',
		'monitor'       => '<rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/>',
		'smartphone'    => '<rect x="6" y="2" width="12" height="20" rx="3"/><path d="M11 18h2"/>',
		'bar-chart'     => '<path d="M5 20V10M12 20V4M19 20v-7"/>',
		'external'      => '<path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/>',
		'minus'         => '<path d="M5 12h14"/>',
		'plus'          => '<path d="M12 5v14M5 12h14"/>',
		'chevron-down'  => '<path d="m6 9 6 6 6-6"/>',
		'chevron-right' => '<path d="m9 6 6 6-6 6"/>',
		'sparkle'       => '<path d="M12 3l2 7 7 2-7 2-2 7-2-7-7-2 7-2 2-7z"/>',
		'target'        => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/>',
		'timer'         => '<circle cx="12" cy="13" r="8"/><path d="M12 9v4l2 2M9 2h6"/>',
		'badge'         => '<circle cx="12" cy="9" r="6"/><path d="m8.5 14-1.5 7 5-3 5 3-1.5-7"/>',
		'cursor-text'   => '<path d="M9 4h-1a2 2 0 0 0-2 2M15 4h1a2 2 0 0 1 2 2M9 20h-1a2 2 0 0 1-2-2M15 20h1a2 2 0 0 0 2-2M12 4v16"/>',
		'send'          => '<path d="m22 2-11 11M22 2l-7 20-4-9-9-4 20-7z"/>',
	);
	return $icons;
}

/**
 * Render an inline SVG icon.
 *
 * @param string $name  Icon name.
 * @param int    $size  Pixel size.
 * @param string $class Extra class.
 * @return string
 */
function aiqd_icon( $name, $size = 24, $class = '' ) {
	$set = aiqd_icon_set();
	if ( ! isset( $set[ $name ] ) ) {
		return '';
	}
	return '<svg class="aiqd-i ' . esc_attr( $class ) . '" width="' . (int) $size . '" height="' . (int) $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $set[ $name ] . '</svg>'; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Echo an icon.
 */
function aiqd_e_icon( $name, $size = 24, $class = '' ) {
	echo aiqd_icon( $name, $size, $class ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Escape text and apply tiny inline markup:
 * [[highlight]] gradient text, **bold**, `code`.
 *
 * @param string $text Raw text.
 * @return string Safe HTML.
 */
function aiqd_hl( $text ) {
	$text = esc_html( (string) $text );
	$text = preg_replace( '/\[\[(.+?)\]\]/s', '<span class="aiqd-hl">$1</span>', $text );
	$text = preg_replace( '/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text );
	$text = preg_replace( '/`(.+?)`/s', '<code>$1</code>', $text );
	return $text;
}

/**
 * Echo aiqd_hl() output.
 */
function aiqd_e_hl( $text ) {
	echo aiqd_hl( $text ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Plain text version of aiqd_hl() input (for meta, schema, llms.txt).
 */
function aiqd_plain( $text ) {
	$text = preg_replace( '/\[\[(.+?)\]\]/s', '$1', (string) $text );
	$text = preg_replace( '/\*\*(.+?)\*\*/s', '$1', $text );
	$text = preg_replace( '/`(.+?)`/s', '$1', $text );
	return trim( wp_strip_all_tags( $text ) );
}

/**
 * Resolve a link value. Accepts "@key" (global link registry), "#anchor", or any URL.
 *
 * @param string $value Raw link value.
 * @return array { url, new, rel }
 */
function aiqd_link( $value ) {
	$value = trim( (string) $value );
	$out   = array(
		'url' => '',
		'new' => false,
		'rel' => '',
	);
	if ( '' === $value ) {
		return $out;
	}
	if ( '@' === $value[0] ) {
		$key   = substr( $value, 1 );
		$links = AIQD_Store::links();
		if ( isset( $links[ $key ] ) ) {
			$out['url'] = (string) $links[ $key ]['url'];
			$out['new'] = ! empty( $links[ $key ]['new'] );
			$out['rel'] = isset( $links[ $key ]['rel'] ) ? (string) $links[ $key ]['rel'] : '';
		}
	} else {
		$out['url'] = $value;
		if ( preg_match( '#^https?://#i', $value ) ) {
			$host = wp_parse_url( $value, PHP_URL_HOST );
			$home = wp_parse_url( home_url(), PHP_URL_HOST );
			$out['new'] = ( $host && $host !== $home );
		}
	}
	if ( $out['new'] && '' === $out['rel'] ) {
		$out['rel'] = 'noopener';
	}
	return $out;
}

/**
 * Anchor attributes string (href, target, rel) for a link value.
 */
function aiqd_href_attrs( $value ) {
	$l = aiqd_link( $value );
	if ( '' === $l['url'] ) {
		return 'href="#" aria-disabled="true"';
	}
	$attrs = 'href="' . esc_url( $l['url'] ) . '"';
	if ( $l['new'] ) {
		$attrs .= ' target="_blank"';
	}
	if ( $l['rel'] ) {
		$attrs .= ' rel="' . esc_attr( $l['rel'] ) . '"';
	}
	return $attrs;
}

/**
 * Render a button/link.
 *
 * @param string $label Text.
 * @param string $link  Link value.
 * @param string $class Variant classes, e.g. "aiqd-btn--primary".
 * @param string $icon  Optional trailing icon name.
 * @param array  $extra Extra html attributes (already safe key => value).
 */
function aiqd_btn( $label, $link, $class = 'aiqd-btn--primary', $icon = '', $extra = array() ) {
	if ( '' === trim( (string) $label ) ) {
		return;
	}
	$attr = '';
	foreach ( $extra as $k => $v ) {
		$attr .= ' ' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
	}
	echo '<a class="aiqd-btn ' . esc_attr( $class ) . '" ' . aiqd_href_attrs( $link ) . $attr . '><span>' . esc_html( $label ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput
	if ( $icon ) {
		aiqd_e_icon( $icon, 18 );
	}
	echo '</a>';
}

/**
 * Split a textarea into trimmed non-empty lines.
 */
function aiqd_lines( $text ) {
	if ( is_array( $text ) ) {
		return $text;
	}
	$lines = preg_split( '/\r\n|\r|\n/', (string) $text );
	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}

/**
 * Format money.
 */
function aiqd_money( $amount, $currency = '$' ) {
	$amount = (float) $amount;
	$n      = ( floor( $amount ) === $amount ) ? number_format( $amount, 0 ) : number_format( $amount, 2 );
	return $currency . $n;
}

/**
 * Output a section heading block (eyebrow / h2 / subtitle).
 *
 * @param array  $d   Section data.
 * @param array  $s   Section instance (needs uid).
 * @param string $cls Alignment class.
 */
function aiqd_head( $d, $s, $cls = '' ) {
	if ( empty( $d['title'] ) && empty( $d['eyebrow'] ) && empty( $d['subtitle'] ) ) {
		return;
	}
	echo '<header class="aiqd-head aiqd-reveal ' . esc_attr( $cls ) . '">';
	if ( ! empty( $d['eyebrow'] ) ) {
		echo '<p class="aiqd-eyebrow">' . aiqd_hl( $d['eyebrow'] ) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
	if ( ! empty( $d['title'] ) ) {
		echo '<h2 class="aiqd-h2" id="' . esc_attr( $s['uid'] ) . '-title">' . aiqd_hl( $d['title'] ) . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
	if ( ! empty( $d['subtitle'] ) ) {
		echo '<p class="aiqd-sub">' . aiqd_hl( $d['subtitle'] ) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
	echo '</header>';
}

/**
 * Animated score ring (SVG). JS animates [data-ring] on reveal; static fallback is fully drawn.
 *
 * @param int $score 0-100.
 * @param int $size  Pixel size.
 * @return string
 */
function aiqd_ring( $score, $size = 140 ) {
	$score = max( 0, min( 100, (int) $score ) );
	$c     = 326.73; // 2 * pi * 52.
	$off   = $c - ( $c * $score / 100 );
	$tone  = $score >= 90 ? 'good' : ( $score >= 75 ? 'ok' : ( $score >= 50 ? 'warn' : 'bad' ) );
	return '<div class="aiqd-ring aiqd-ring--' . $tone . '" style="width:' . (int) $size . 'px;height:' . (int) $size . 'px" data-ring data-score="' . $score . '">'
		. '<svg viewBox="0 0 120 120" aria-hidden="true"><circle class="aiqd-ring__bg" cx="60" cy="60" r="52"/><circle class="aiqd-ring__fg" cx="60" cy="60" r="52" stroke-dasharray="' . $c . '" stroke-dashoffset="' . round( $off, 2 ) . '" data-offset="' . round( $off, 2 ) . '"/></svg>'
		. '<div class="aiqd-ring__num"><b data-count-to="' . $score . '">' . $score . '</b><small>/100</small></div></div>';
}

/**
 * Grade label for a score.
 */
function aiqd_grade( $score ) {
	if ( $score >= 90 ) {
		return __( 'Excellent', 'accessiq-demo' );
	}
	if ( $score >= 75 ) {
		return __( 'Good', 'accessiq-demo' );
	}
	if ( $score >= 50 ) {
		return __( 'Fair', 'accessiq-demo' );
	}
	return __( 'Poor', 'accessiq-demo' );
}

/**
 * Comparison-table cell: yes / no / Pro / Agency / ~partial / free text. Returns HTML.
 */
function aiqd_matrix_cell( $v ) {
	$v = trim( (string) $v );
	$t = strtolower( $v );
	if ( in_array( $t, array( 'yes', 'true', '✓' ), true ) ) {
		return '<span class="aiqd-yes" role="img" aria-label="' . esc_attr__( 'Yes', 'accessiq-demo' ) . '">' . aiqd_icon( 'check', 18 ) . '</span>';
	}
	if ( in_array( $t, array( '', 'no', 'false', '✗' ), true ) ) {
		return '<span class="aiqd-no" role="img" aria-label="' . esc_attr__( 'No', 'accessiq-demo' ) . '">' . aiqd_icon( 'x', 18 ) . '</span>';
	}
	if ( '~' === $v[0] ) {
		return '<span class="aiqd-part">' . esc_html( ltrim( substr( $v, 1 ) ) ) . '</span>';
	}
	if ( 'pro' === $t || 'agency' === $t ) {
		return aiqd_badge( $t );
	}
	return '<span class="aiqd-txt">' . esc_html( $v ) . '</span>';
}

/**
 * Free / Pro badge.
 *
 * @param string $tier free|pro|agency|new|soon
 */
function aiqd_badge( $tier ) {
	$map = array(
		'free'   => __( 'Free', 'accessiq-demo' ),
		'pro'    => __( 'Pro', 'accessiq-demo' ),
		'agency' => __( 'Agency', 'accessiq-demo' ),
		'new'    => __( 'New', 'accessiq-demo' ),
		'soon'   => __( 'Soon', 'accessiq-demo' ),
	);
	if ( ! isset( $map[ $tier ] ) ) {
		return '';
	}
	return '<span class="aiqd-badge aiqd-badge--' . esc_attr( $tier ) . '">' . esc_html( $map[ $tier ] ) . '</span>';
}
