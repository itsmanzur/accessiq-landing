<?php
/**
 * Widget playground. JS: data-aiqd-widget toggles classes on .aiqd-mock.
 */
defined( 'ABSPATH' ) || exit;

$profiles = array(
	'vision'   => array( 'eye', __( 'Vision Impaired', 'accessiq-demo' ) ),
	'adhd'     => array( 'zap', __( 'ADHD Friendly', 'accessiq-demo' ) ),
	'seizure'  => array( 'shield', __( 'Seizure Safe', 'accessiq-demo' ) ),
	'dyslexia' => array( 'type', __( 'Dyslexia', 'accessiq-demo' ) ),
	'keyboard' => array( 'keyboard', __( 'Keyboard Only', 'accessiq-demo' ) ),
);
$toggles = array(
	'contrast'   => array( 'contrast', __( 'High contrast', 'accessiq-demo' ) ),
	'mono'       => array( 'palette', __( 'Monochrome', 'accessiq-demo' ) ),
	'dyslexic'   => array( 'type', __( 'Dyslexia font', 'accessiq-demo' ) ),
	'links'      => array( 'link', __( 'Highlight links', 'accessiq-demo' ) ),
	'titles'     => array( 'cursor-text', __( 'Highlight titles', 'accessiq-demo' ) ),
	'noanim'     => array( 'pause', __( 'Stop animations', 'accessiq-demo' ) ),
	'bigcursor'  => array( 'pointer', __( 'Big cursor', 'accessiq-demo' ) ),
	'readline'   => array( 'minus', __( 'Reading line', 'accessiq-demo' ) ),
	'readmask'   => array( 'eye', __( 'Reading mask', 'accessiq-demo' ) ),
	'keyboard'   => array( 'keyboard', __( 'Keyboard focus', 'accessiq-demo' ) ),
);
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-wdemo" data-aiqd-widget>
	<div class="aiqd-wdemo__side aiqd-reveal">
		<ul class="aiqd-ticks">
			<?php foreach ( aiqd_lines( $d['points'] ) as $p ) : ?>
				<li><?php aiqd_e_icon( 'check', 16 ); ?><?php echo esc_html( $p ); ?></li>
			<?php endforeach; ?>
		</ul>
		<p class="aiqd-note"><?php echo esc_html( $d['note'] ); ?></p>
		<?php aiqd_btn( $d['cta_label'], $d['cta_link'], 'aiqd-btn--primary', 'download' ); ?>
	</div>

	<div class="aiqd-wdemo__stage aiqd-reveal">
		<div class="aiqd-mock" data-mock>
			<div class="aiqd-mock__line" aria-hidden="true"></div>
			<div class="aiqd-mock__mask" aria-hidden="true"><i></i><i></i></div>
			<div class="aiqd-mock__bar" aria-hidden="true"><i></i><i></i><i></i><span>cozy-coffee.example</span></div>
			<div class="aiqd-mock__page">
				<nav class="aiqd-mock__nav"><b>Cozy Coffee</b><a href="#" tabindex="-1">Menu</a><a href="#" tabindex="-1">Story</a><a href="#" tabindex="-1">Visit</a></nav>
				<h3 class="aiqd-mock__h">Fresh roasted, slowly poured</h3>
				<p class="aiqd-mock__p">Our beans are roasted in small batches every morning. Stop by for a cup, pick up a bag for home, or join our Saturday tasting where we walk through three single-origin coffees.</p>
				<p class="aiqd-mock__p">Opening hours are <a href="#" tabindex="-1">7am to 6pm</a> every day. Read more on our <a href="#" tabindex="-1">sourcing page</a>.</p>
				<div class="aiqd-mock__cards">
					<div><i></i><b>Ethiopia</b><small>Floral · bright</small></div>
					<div><i></i><b>Colombia</b><small>Sweet · nutty</small></div>
					<div><i></i><b>Sumatra</b><small>Earthy · bold</small></div>
				</div>
				<span class="aiqd-mock__spin" aria-hidden="true"></span>
			</div>
		</div>

		<div class="aiqd-wpanel" role="group" aria-label="<?php esc_attr_e( 'Accessibility widget demo', 'accessiq-demo' ); ?>">
			<div class="aiqd-wpanel__head"><?php aiqd_e_icon( 'accessibility', 18 ); ?><strong><?php esc_html_e( 'Accessibility', 'accessiq-demo' ); ?></strong><button type="button" data-w-reset><?php esc_html_e( 'Reset', 'accessiq-demo' ); ?></button></div>

			<p class="aiqd-wpanel__label"><?php esc_html_e( 'Profiles', 'accessiq-demo' ); ?></p>
			<div class="aiqd-wprofiles">
				<?php foreach ( $profiles as $k => $p ) : ?>
					<button type="button" data-profile="<?php echo esc_attr( $k ); ?>" aria-pressed="false"><?php aiqd_e_icon( $p[0], 16 ); ?><span><?php echo esc_html( $p[1] ); ?></span></button>
				<?php endforeach; ?>
			</div>

			<p class="aiqd-wpanel__label"><?php esc_html_e( 'Text size', 'accessiq-demo' ); ?></p>
			<div class="aiqd-wrange">
				<button type="button" data-w-font="-10" aria-label="<?php esc_attr_e( 'Decrease font size', 'accessiq-demo' ); ?>">A−</button>
				<output data-w-fontval>100%</output>
				<button type="button" data-w-font="10" aria-label="<?php esc_attr_e( 'Increase font size', 'accessiq-demo' ); ?>">A+</button>
			</div>
			<label class="aiqd-wslider"><span><?php esc_html_e( 'Letter spacing', 'accessiq-demo' ); ?></span><input type="range" min="0" max="5" step="1" value="0" data-w-spacing></label>
			<label class="aiqd-wslider"><span><?php esc_html_e( 'Line height', 'accessiq-demo' ); ?></span><input type="range" min="0" max="2" step="1" value="0" data-w-lh></label>

			<p class="aiqd-wpanel__label"><?php esc_html_e( 'Tools', 'accessiq-demo' ); ?></p>
			<div class="aiqd-wtools">
				<?php foreach ( $toggles as $k => $t ) : ?>
					<button type="button" data-tool="<?php echo esc_attr( $k ); ?>" aria-pressed="false"><?php aiqd_e_icon( $t[0], 16 ); ?><span><?php echo esc_html( $t[1] ); ?></span></button>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
