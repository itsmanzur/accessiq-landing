<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-grid aiqd-grid--4">
	<?php foreach ( (array) $d['cards'] as $i => $c ) : ?>
		<article class="aiqd-card aiqd-card--tilt aiqd-reveal" data-tilt style="--d:<?php echo (int) $i * 80; ?>ms">
			<span class="aiqd-card__ico"><?php aiqd_e_icon( $c['icon'], 26 ); ?></span>
			<h3 class="aiqd-h3"><?php echo esc_html( $c['title'] ); ?> <?php echo aiqd_badge( $c['tier'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h3>
			<p><?php echo esc_html( $c['text'] ); ?></p>
			<?php if ( ! empty( $c['link'] ) ) : ?>
				<a class="aiqd-more" <?php echo aiqd_href_attrs( $c['link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php esc_html_e( 'Explore', 'accessiq-demo' ); ?> <?php aiqd_e_icon( 'arrow-right', 16 ); ?></a>
			<?php endif; ?>
		</article>
	<?php endforeach; ?>
</div>

<div class="aiqd-callout aiqd-reveal">
	<p class="aiqd-callout__stmt"><?php aiqd_e_icon( 'sparkles', 22 ); ?><span><?php echo aiqd_hl( $d['statement'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></p>
	<ul class="aiqd-ticks">
		<?php foreach ( aiqd_lines( $d['points'] ) as $p ) : ?>
			<li><?php aiqd_e_icon( 'check', 16 ); ?><?php echo esc_html( $p ); ?></li>
		<?php endforeach; ?>
	</ul>
	<div class="aiqd-actions">
		<?php aiqd_btn( $d['cta1_label'], $d['cta1_link'], 'aiqd-btn--primary', 'download' ); ?>
		<?php aiqd_btn( $d['cta2_label'], $d['cta2_link'], 'aiqd-btn--ghost', 'arrow-right' ); ?>
	</div>
</div>
