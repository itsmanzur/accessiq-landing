<?php
/**
 * Footer zone. Vars: $d, $s.
 */
defined( 'ABSPATH' ) || exit;

$brand = AIQD_Store::setting( 'brand_name', 'AccessIQ' );
$hdr   = AIQD_Store::header();
?>
<footer class="aiqd-footer" id="aiqd-footer">
	<div class="aiqd-container">
		<?php if ( ! empty( $d['cta_title'] ) ) : ?>
			<div class="aiqd-footer__cta aiqd-reveal">
				<p><?php echo aiqd_hl( $d['cta_title'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
				<?php aiqd_btn( $d['cta_label'], $d['cta_link'], 'aiqd-btn--primary', 'arrow-right' ); ?>
			</div>
		<?php endif; ?>

		<div class="aiqd-footer__grid">
			<div class="aiqd-footer__brand">
				<a class="aiqd-logo" <?php echo aiqd_href_attrs( $hdr['logo_link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<span class="aiqd-logo__mark"><?php aiqd_e_icon( 'accessibility', 20 ); ?></span>
					<span class="aiqd-logo__text"><?php echo esc_html( $brand ); ?></span>
				</a>
				<p><?php echo esc_html( $d['about'] ); ?></p>
			</div>
			<?php foreach ( (array) $d['columns'] as $col ) : ?>
				<nav class="aiqd-footer__col" aria-label="<?php echo esc_attr( $col['title'] ); ?>">
					<h2 class="aiqd-footer__h"><?php echo esc_html( $col['title'] ); ?></h2>
					<ul>
						<?php foreach ( (array) $col['links'] as $lnk ) : ?>
							<li><a <?php echo aiqd_href_attrs( $lnk['link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $lnk['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endforeach; ?>
		</div>

		<div class="aiqd-footer__bottom">
			<p><?php echo esc_html( str_replace( '{year}', gmdate( 'Y' ), $d['copyright'] ) ); ?></p>
			<p class="aiqd-footer__disclaimer"><?php echo esc_html( $d['disclaimer'] ); ?></p>
		</div>
	</div>
</footer>
