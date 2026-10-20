<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<ol class="aiqd-timeline">
	<?php foreach ( (array) $d['releases'] as $i => $r ) : ?>
		<li class="aiqd-tl aiqd-reveal" style="--d:<?php echo (int) $i * 70; ?>ms">
			<span class="aiqd-tl__dot" aria-hidden="true"></span>
			<div class="aiqd-tl__card">
				<header>
					<h3 class="aiqd-h4"><?php echo esc_html( $r['product'] ); ?> <span class="aiqd-ver">v<?php echo esc_html( $r['version'] ); ?></span></h3>
					<time><?php echo esc_html( $r['date'] ); ?></time>
				</header>
				<ul>
					<?php foreach ( aiqd_lines( $r['items'] ) as $it ) : ?>
						<li><?php aiqd_e_icon( 'check', 14 ); ?><?php echo esc_html( $it ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</li>
	<?php endforeach; ?>
</ol>
<?php if ( ! empty( $d['link_label'] ) ) : ?>
	<p class="aiqd-center"><?php aiqd_btn( $d['link_label'], $d['link'], 'aiqd-btn--ghost', 'external' ); ?></p>
<?php endif; ?>
