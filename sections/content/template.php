<?php
defined( 'ABSPATH' ) || exit;
$has_img = ! empty( $d['image'] );
?>
<div class="aiqd-content <?php echo $has_img ? 'has-img' : ''; ?> aiqd-content--<?php echo esc_attr( $d['image_side'] ); ?>">
	<div class="aiqd-content__text">
		<?php aiqd_head( $d, $s ); ?>
		<?php if ( ! empty( $d['body'] ) ) : ?>
			<div class="aiqd-prose aiqd-reveal"><?php echo wp_kses_post( $d['body'] ); ?></div>
		<?php endif; ?>
		<?php if ( aiqd_lines( $d['bullets'] ) ) : ?>
			<ul class="aiqd-ticks aiqd-reveal">
				<?php foreach ( aiqd_lines( $d['bullets'] ) as $b ) : ?>
					<li><?php aiqd_e_icon( 'check', 16 ); ?><?php echo esc_html( $b ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ( ! empty( $d['cta_label'] ) ) : ?>
			<div class="aiqd-actions aiqd-reveal"><?php aiqd_btn( $d['cta_label'], $d['cta_link'], 'aiqd-btn--primary', 'arrow-right' ); ?></div>
		<?php endif; ?>
	</div>
	<?php if ( $has_img ) : ?>
		<figure class="aiqd-content__img aiqd-reveal">
			<img src="<?php echo esc_url( $d['image'] ); ?>" alt="<?php echo esc_attr( $d['image_alt'] ); ?>" loading="lazy" decoding="async">
		</figure>
	<?php endif; ?>
</div>
