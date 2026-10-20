<?php
/**
 * Header zone. Vars: $d (data), $s (instance).
 */
defined( 'ABSPATH' ) || exit;

$settings = AIQD_Store::settings();
$cls      = 'aiqd-header' . ( ! empty( $d['sticky'] ) ? ' is-sticky' : '' ) . ( ! empty( $d['transparent_top'] ) ? ' is-transparent' : '' );
?>
<header class="<?php echo esc_attr( $cls ); ?>" id="aiqd-header">
	<div class="aiqd-container aiqd-header__bar">
		<a class="aiqd-logo" <?php echo aiqd_href_attrs( $d['logo_link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?> aria-label="<?php echo esc_attr( $d['logo_text'] ); ?>">
			<?php if ( ! empty( $d['logo_image'] ) ) : ?>
				<img src="<?php echo esc_url( $d['logo_image'] ); ?>" alt="" width="32" height="32">
			<?php else : ?>
				<span class="aiqd-logo__mark"><?php aiqd_e_icon( 'accessibility', 20 ); ?></span>
			<?php endif; ?>
			<span class="aiqd-logo__text"><?php echo esc_html( $d['logo_text'] ); ?></span>
			<?php if ( ! empty( $d['badge'] ) ) : ?>
				<span class="aiqd-logo__badge"><?php echo esc_html( $d['badge'] ); ?></span>
			<?php endif; ?>
		</a>

		<nav class="aiqd-nav" aria-label="<?php esc_attr_e( 'Primary', 'accessiq-demo' ); ?>">
			<ul>
				<?php foreach ( (array) $d['menu'] as $item ) : ?>
					<li><a <?php echo aiqd_href_attrs( $item['link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $item['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<div class="aiqd-header__actions">
			<?php if ( $settings['show_theme_toggle'] ) : ?>
				<button type="button" class="aiqd-iconbtn aiqd-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle light / dark theme', 'accessiq-demo' ); ?>">
					<span class="aiqd-theme-toggle__sun"><?php aiqd_e_icon( 'sun', 18 ); ?></span>
					<span class="aiqd-theme-toggle__moon"><?php aiqd_e_icon( 'moon', 18 ); ?></span>
				</button>
			<?php endif; ?>
			<?php aiqd_btn( $d['cta1_label'], $d['cta1_link'], 'aiqd-btn--ghost aiqd-btn--sm aiqd-hide-sm' ); ?>
			<?php aiqd_btn( $d['cta2_label'], $d['cta2_link'], 'aiqd-btn--primary aiqd-btn--sm', 'download' ); ?>
			<button type="button" class="aiqd-iconbtn aiqd-burger" aria-expanded="false" aria-controls="aiqd-mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'accessiq-demo' ); ?>">
				<?php aiqd_e_icon( 'menu', 22 ); ?>
			</button>
		</div>
	</div>

	<div class="aiqd-mobile-nav" id="aiqd-mobile-nav" hidden>
		<ul>
			<?php foreach ( (array) $d['menu'] as $item ) : ?>
				<li><a <?php echo aiqd_href_attrs( $item['link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $item['label'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
		<div class="aiqd-mobile-nav__cta">
			<?php aiqd_btn( $d['cta1_label'], $d['cta1_link'], 'aiqd-btn--ghost' ); ?>
			<?php aiqd_btn( $d['cta2_label'], $d['cta2_link'], 'aiqd-btn--primary', 'download' ); ?>
		</div>
	</div>
</header>
