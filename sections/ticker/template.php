<?php
defined( 'ABSPATH' ) || exit;
$items = (array) $d['items'];
?>
<div class="aiqd-ticker" style="--aiqd-ticker:<?php echo (int) $d['speed']; ?>s">
	<button type="button" class="aiqd-ticker__pause" aria-pressed="false" aria-label="<?php esc_attr_e( 'Pause scrolling', 'accessiq-demo' ); ?>"><?php aiqd_e_icon( 'pause', 14 ); ?></button>
	<div class="aiqd-ticker__track">
		<ul class="aiqd-ticker__list">
			<?php foreach ( $items as $it ) : ?>
				<li><?php aiqd_e_icon( $it['icon'], 16 ); ?><span><?php echo esc_html( $it['text'] ); ?></span></li>
			<?php endforeach; ?>
		</ul>
		<ul class="aiqd-ticker__list" aria-hidden="true">
			<?php foreach ( $items as $it ) : ?>
				<li><?php aiqd_e_icon( $it['icon'], 16 ); ?><span><?php echo esc_html( $it['text'] ); ?></span></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
