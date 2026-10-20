<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<dl class="aiqd-stats">
	<?php foreach ( (array) $d['items'] as $i => $it ) : ?>
		<div class="aiqd-stat aiqd-reveal" style="--d:<?php echo (int) $i * 80; ?>ms">
			<dt><?php echo esc_html( $it['label'] ); ?></dt>
			<dd>
				<span class="aiqd-stat__num"><?php echo esc_html( $it['prefix'] ); ?><b data-count-to="<?php echo esc_attr( (float) $it['value'] ); ?>"><?php echo esc_html( $it['value'] ); ?></b><?php echo esc_html( $it['suffix'] ); ?></span>
				<?php if ( $it['sub'] ) : ?><small><?php echo esc_html( $it['sub'] ); ?></small><?php endif; ?>
			</dd>
		</div>
	<?php endforeach; ?>
</dl>
