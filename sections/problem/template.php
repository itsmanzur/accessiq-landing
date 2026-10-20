<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-split">
	<div class="aiqd-panel aiqd-panel--bad aiqd-reveal">
		<h3 class="aiqd-h3"><?php aiqd_e_icon( 'x', 20 ); ?> <?php echo esc_html( $d['bad_title'] ); ?></h3>
		<ul class="aiqd-xlist">
			<?php foreach ( aiqd_lines( $d['bad'] ) as $t ) : ?>
				<li><?php aiqd_e_icon( 'x', 16 ); ?><span><?php echo esc_html( $t ); ?></span></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="aiqd-panel aiqd-panel--good aiqd-reveal" style="--d:120ms">
		<h3 class="aiqd-h3"><?php aiqd_e_icon( 'check', 20 ); ?> <?php echo esc_html( $d['good_title'] ); ?></h3>
		<ul class="aiqd-xlist">
			<?php foreach ( aiqd_lines( $d['good'] ) as $t ) : ?>
				<li><?php aiqd_e_icon( 'check', 16 ); ?><span><?php echo esc_html( $t ); ?></span></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
