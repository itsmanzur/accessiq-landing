<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<ol class="aiqd-steps" data-aiqd-steps>
	<span class="aiqd-steps__line" aria-hidden="true"><i></i></span>
	<?php foreach ( (array) $d['steps'] as $i => $st ) : ?>
		<li class="aiqd-step aiqd-reveal" style="--d:<?php echo (int) $i * 90; ?>ms">
			<span class="aiqd-step__num"><?php echo (int) $i + 1; ?></span>
			<div class="aiqd-step__card">
				<span class="aiqd-card__ico"><?php aiqd_e_icon( $st['icon'], 24 ); ?></span>
				<h3 class="aiqd-h3"><?php echo esc_html( $st['title'] ); ?></h3>
				<p><?php echo esc_html( $st['text'] ); ?></p>
				<?php if ( $st['time'] ) : ?>
					<span class="aiqd-tag"><?php aiqd_e_icon( 'clock', 14 ); ?><?php echo esc_html( $st['time'] ); ?></span>
				<?php endif; ?>
			</div>
		</li>
	<?php endforeach; ?>
</ol>
