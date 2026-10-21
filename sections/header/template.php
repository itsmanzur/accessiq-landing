<?php
/**
 * Header zone. Vars: $d (data), $s (instance).
 */
defined( 'ABSPATH' ) || exit;

$settings = AIQD_Store::settings();
$cls      = 'aiqd-header' . ( ! empty( $d['sticky'] ) ? ' is-sticky' : '' ) . ( ! empty( $d['transparent_top'] ) ? ' is-transparent' : '' );
?>
<?php if ( ! empty( $d['topbar'] ) && ( ! empty( $d['topbar_text'] ) || ! empty( $d['topbar_links'] ) ) ) : ?>
	<div class="aiqd-topbar">
		<div class="aiqd-container aiqd-topbar__in">
			<span class="aiqd-topbar__txt"><?php echo esc_html( $d['topbar_text'] ); ?></span>
			<div class="aiqd-topbar__menu">
				<button type="button" class="aiqd-topbar__btn" aria-expanded="false" aria-controls="aiqd-company-menu">
					<?php aiqd_e_icon( 'grid', 16 ); ?><span><?php echo esc_html( $d['topbar_button'] ); ?></span><?php aiqd_e_icon( 'chevron-down', 14, 'aiqd-topbar__chev' ); ?>
				</button>
				<div class="aiqd-topbar__panel" id="aiqd-company-menu" hidden>
					<ul>
						<?php foreach ( (array) $d['topbar_links'] as $tl ) : ?>
							<li>
								<a <?php echo aiqd_href_attrs( $tl['link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
									<span class="aiqd-topbar__ico"><?php aiqd_e_icon( ! empty( $tl['icon'] ) ? $tl['icon'] : 'link', 18 ); ?></span>
									<span class="aiqd-topbar__lbl"><strong><?php echo esc_html( $tl['label'] ); ?></strong><?php if ( ! empty( $tl['desc'] ) ) : ?><small><?php echo esc_html( $tl['desc'] ); ?></small><?php endif; ?></span>
									<?php aiqd_e_icon( 'external', 14, 'aiqd-topbar__ext' ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
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
