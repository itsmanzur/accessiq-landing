<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-grid aiqd-grid--3">
	<?php foreach ( (array) $d['cards'] as $i => $c ) : ?>
		<article class="aiqd-card aiqd-card--tilt aiqd-reveal" data-tilt style="--d:<?php echo (int) ( $i % 3 ) * 90; ?>ms">
			<span class="aiqd-card__ico"><?php aiqd_e_icon( $c['icon'], 26 ); ?></span>
			<h3 class="aiqd-h3"><?php echo esc_html( $c['title'] ); ?></h3>
			<p><?php echo esc_html( $c['text'] ); ?></p>
			<ul class="aiqd-tags">
				<?php foreach ( aiqd_lines( $c['tags'] ) as $t ) : ?>
					<li><?php echo esc_html( $t ); ?></li>
				<?php endforeach; ?>
			</ul>
		</article>
	<?php endforeach; ?>
</div>
