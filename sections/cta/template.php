<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="aiqd-cta aiqd-reveal">
	<div class="aiqd-cta__orbs" aria-hidden="true"><i></i><i></i><i></i></div>
	<?php aiqd_head( $d, $s, 'is-center' ); ?>
	<div class="aiqd-actions aiqd-actions--center">
		<?php aiqd_btn( $d['cta1_label'], $d['cta1_link'], 'aiqd-btn--light aiqd-btn--lg', 'download' ); ?>
		<?php aiqd_btn( $d['cta2_label'], $d['cta2_link'], 'aiqd-btn--glass aiqd-btn--lg', 'crown' ); ?>
	</div>
	<?php if ( $d['fine'] ) : ?><p class="aiqd-fine"><?php echo esc_html( $d['fine'] ); ?></p><?php endif; ?>
</div>
