<?php
/**
 * Thank-you page body. Vars: $d, $s.
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="aiqd-thanks">
	<div class="aiqd-thanks__orbs" aria-hidden="true"><i></i><i></i><i></i></div>
	<div class="aiqd-thanks__check aiqd-reveal" aria-hidden="true">
		<svg viewBox="0 0 120 120"><circle cx="60" cy="60" r="52" class="ring"/><path d="M38 62l16 16 30-34" class="tick"/></svg>
	</div>
	<h1 class="aiqd-h1 aiqd-reveal" id="<?php echo esc_attr( $s['uid'] ); ?>-title"><?php echo aiqd_hl( $d['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
	<p class="aiqd-lead aiqd-reveal"><?php echo aiqd_hl( $d['subtitle'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>

	<?php if ( ! empty( $d['steps'] ) ) : ?>
		<h2 class="aiqd-h3 aiqd-thanks__h aiqd-reveal"><?php echo esc_html( $d['steps_title'] ); ?></h2>
		<ol class="aiqd-thanks__steps">
			<?php foreach ( (array) $d['steps'] as $i => $st ) : ?>
				<li class="aiqd-card aiqd-reveal" style="--d:<?php echo (int) $i * 90; ?>ms">
					<span class="aiqd-step__num"><?php echo (int) $i + 1; ?></span>
					<span class="aiqd-card__ico"><?php aiqd_e_icon( $st['icon'], 24 ); ?></span>
					<h3 class="aiqd-h3"><?php echo esc_html( $st['title'] ); ?></h3>
					<p><?php echo esc_html( $st['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	<?php endif; ?>

	<div class="aiqd-actions aiqd-actions--center aiqd-reveal">
		<?php aiqd_btn( $d['cta1_label'], $d['cta1_link'], 'aiqd-btn--primary aiqd-btn--lg', 'external' ); ?>
		<?php aiqd_btn( $d['cta2_label'], $d['cta2_link'], 'aiqd-btn--outline aiqd-btn--lg', 'book' ); ?>
		<?php aiqd_btn( $d['cta3_label'], $d['cta3_link'], 'aiqd-btn--ghost aiqd-btn--lg' ); ?>
	</div>

	<?php if ( ! empty( $d['help'] ) ) : ?>
		<p class="aiqd-thanks__help aiqd-reveal"><?php echo esc_html( $d['help'] ); ?>
			<?php if ( ! empty( $d['help_link_label'] ) ) : ?><a class="aiqd-more" <?php echo aiqd_href_attrs( $d['help_link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $d['help_link_label'] ); ?> <?php aiqd_e_icon( 'arrow-right', 16 ); ?></a><?php endif; ?>
		</p>
	<?php endif; ?>
</div>
