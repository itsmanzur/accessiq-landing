<?php
defined( 'ABSPATH' ) || exit;

$cur   = AIQD_Store::setting( 'currency', '$' );
$tools = array();
foreach ( aiqd_lines( $d['tools'] ) as $line ) {
	$p       = array_pad( array_map( 'trim', explode( '|', $line ) ), 2, '0' );
	$tools[] = array( $p[0], (float) $p[1] );
}
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-calc aiqd-reveal" data-aiqd-calc data-ours="<?php echo esc_attr( (float) $d['ours_year'] ); ?>" data-persite="<?php echo ! empty( $d['per_site'] ) ? '1' : '0'; ?>" data-cur="<?php echo esc_attr( $cur ); ?>">
	<fieldset class="aiqd-calc__tools">
		<legend><?php esc_html_e( 'Tools you pay for today', 'accessiq-demo' ); ?></legend>
		<?php foreach ( $tools as $i => $t ) : ?>
			<label class="aiqd-check">
				<input type="checkbox" value="<?php echo esc_attr( $t[1] ); ?>" <?php checked( $i < 3 ); ?>>
				<span class="aiqd-check__box"><?php aiqd_e_icon( 'check', 14 ); ?></span>
				<span class="aiqd-check__txt"><?php echo esc_html( $t[0] ); ?></span>
				<em><?php echo esc_html( aiqd_money( $t[1], $cur ) ); ?>/<?php esc_html_e( 'mo', 'accessiq-demo' ); ?></em>
			</label>
		<?php endforeach; ?>
		<?php if ( ! empty( $d['per_site'] ) ) : ?>
			<label class="aiqd-calc__sites"><span><?php esc_html_e( 'Number of sites', 'accessiq-demo' ); ?>: <b data-sites-val>3</b></span>
				<input type="range" min="1" max="<?php echo (int) $d['max_sites']; ?>" value="3" data-sites></label>
		<?php endif; ?>
	</fieldset>
	<div class="aiqd-calc__out" aria-live="polite">
		<p class="aiqd-calc__lbl"><?php esc_html_e( 'Today you spend', 'accessiq-demo' ); ?></p>
		<p class="aiqd-calc__old"><span data-old>$0</span><small>/<?php esc_html_e( 'year', 'accessiq-demo' ); ?></small></p>
		<p class="aiqd-calc__lbl"><?php echo esc_html( sprintf( /* translators: %s product name */ __( 'With %s', 'accessiq-demo' ), $d['ours_label'] ) ); ?></p>
		<p class="aiqd-calc__new"><span data-new>$0</span><small>/<?php esc_html_e( 'year', 'accessiq-demo' ); ?></small></p>
		<div class="aiqd-calc__save"><?php esc_html_e( 'You could save', 'accessiq-demo' ); ?> <b data-save>$0</b> <?php esc_html_e( 'a year', 'accessiq-demo' ); ?></div>
		<?php aiqd_btn( $d['cta_label'], $d['cta_link'], 'aiqd-btn--primary', 'arrow-right' ); ?>
	</div>
</div>
<?php if ( ! empty( $d['footnote'] ) ) : ?>
	<p class="aiqd-footnote"><?php echo esc_html( $d['footnote'] ); ?></p>
<?php endif; ?>
