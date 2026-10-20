<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-hdemo" data-aiqd-heat>
	<div class="aiqd-hdemo__browser aiqd-reveal">
		<div class="aiqd-browser">
			<div class="aiqd-browser__bar">
				<span class="aiqd-dots3" aria-hidden="true"><i></i><i></i><i></i></span>
				<span class="aiqd-browser__url"><?php aiqd_e_icon( 'lock', 12 ); ?> yourshop.example/product/lamp</span>
				<span class="aiqd-live"><span class="aiqd-live__dot"></span><?php esc_html_e( 'LIVE PREVIEW', 'accessiq-demo' ); ?></span>
			</div>
			<div class="aiqd-hdemo__viewport" data-heat-view data-device="desktop">
				<div class="aiqd-hpage" aria-hidden="true">
					<div class="aiqd-hpage__nav"><b></b><i></i><i></i><i></i><span></span></div>
					<div class="aiqd-hpage__hero"><div class="img"></div><div class="info"><span class="ttl"></span><p></p><p class="s"></p><div class="price"></div><button type="button" tabindex="-1" data-el="Add to cart">Add to cart</button><button type="button" tabindex="-1" class="ghost" data-el="Wishlist">♡</button></div></div>
					<div class="aiqd-hpage__row"><div data-el="Reviews tab"></div><div data-el="Specs tab"></div><div data-el="Shipping tab"></div></div>
				</div>
				<canvas class="aiqd-hdemo__canvas" data-heat-canvas role="img" aria-label="<?php esc_attr_e( 'Click heatmap overlay. Click anywhere to add heat.', 'accessiq-demo' ); ?>"></canvas>
				<span class="aiqd-hdemo__hint"><?php aiqd_e_icon( 'pointer', 14 ); ?> <?php esc_html_e( 'Click anywhere!', 'accessiq-demo' ); ?></span>
			</div>
		</div>
		<div class="aiqd-hdemo__ctrl">
			<div class="aiqd-seg" role="group" aria-label="<?php esc_attr_e( 'Device', 'accessiq-demo' ); ?>">
				<button type="button" class="is-on" data-device="desktop" aria-pressed="true"><?php aiqd_e_icon( 'monitor', 16 ); ?> <?php esc_html_e( 'Desktop', 'accessiq-demo' ); ?></button>
				<button type="button" data-device="mobile" aria-pressed="false"><?php aiqd_e_icon( 'smartphone', 16 ); ?> <?php esc_html_e( 'Mobile', 'accessiq-demo' ); ?></button>
			</div>
			<button type="button" class="aiqd-btn aiqd-btn--ghost aiqd-btn--sm" data-heat-clear><?php aiqd_e_icon( 'refresh', 16 ); ?><span><?php esc_html_e( 'Reset', 'accessiq-demo' ); ?></span></button>
			<button type="button" class="aiqd-btn aiqd-btn--outline aiqd-btn--sm" data-heat-sim><?php aiqd_e_icon( 'sparkles', 16 ); ?><span><?php esc_html_e( 'Simulate 30 days', 'accessiq-demo' ); ?></span></button>
		</div>
	</div>

	<aside class="aiqd-hdemo__side aiqd-reveal">
		<ul class="aiqd-ticks">
			<?php foreach ( aiqd_lines( $d['points'] ) as $p ) : ?>
				<li><?php aiqd_e_icon( 'check', 16 ); ?><?php echo esc_html( $p ); ?></li>
			<?php endforeach; ?>
		</ul>
		<h3 class="aiqd-h4"><?php esc_html_e( 'Top clicked elements', 'accessiq-demo' ); ?> <small data-heat-total>0 <?php esc_html_e( 'clicks', 'accessiq-demo' ); ?></small></h3>
		<ol class="aiqd-top" data-heat-top aria-live="polite">
			<li class="is-empty"><?php esc_html_e( 'Click the page to start collecting.', 'accessiq-demo' ); ?></li>
		</ol>
		<?php aiqd_btn( $d['cta_label'], $d['cta_link'], 'aiqd-btn--primary', 'arrow-right' ); ?>
	</aside>
</div>
