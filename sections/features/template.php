<?php
defined( 'ABSPATH' ) || exit;
$tabs = array_values( (array) $d['tabs'] );
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-tabs" data-aiqd-tabs>
	<div class="aiqd-tabs__list aiqd-reveal" role="tablist" aria-label="<?php esc_attr_e( 'Feature categories', 'accessiq-demo' ); ?>">
		<?php foreach ( $tabs as $i => $t ) : ?>
			<button type="button" role="tab" id="<?php echo esc_attr( $s['uid'] . '-ft-' . $t['id'] ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $s['uid'] . '-fp-' . $t['id'] ); ?>" tabindex="<?php echo 0 === $i ? '0' : '-1'; ?>">
				<?php aiqd_e_icon( $t['icon'], 18 ); ?><span><?php echo esc_html( $t['label'] ); ?></span>
			</button>
		<?php endforeach; ?>
	</div>
	<?php foreach ( $tabs as $i => $t ) : ?>
		<div class="aiqd-tabs__panel" role="tabpanel" id="<?php echo esc_attr( $s['uid'] . '-fp-' . $t['id'] ); ?>" aria-labelledby="<?php echo esc_attr( $s['uid'] . '-ft-' . $t['id'] ); ?>" <?php echo 0 === $i ? '' : 'hidden'; ?> tabindex="0">
			<ul class="aiqd-grid aiqd-grid--3 aiqd-fgrid">
				<?php foreach ( aiqd_lines( $t['cards'] ) as $ci => $line ) :
					$p = array_pad( array_map( 'trim', explode( '|', $line, 3 ) ), 3, '' );
					?>
					<li class="aiqd-fcard" style="--d:<?php echo (int) min( $ci, 12 ) * 35; ?>ms">
						<span class="aiqd-fcard__ico"><?php aiqd_e_icon( $t['icon'], 18 ); ?></span>
						<div>
							<h3 class="aiqd-h4"><?php echo esc_html( $p[1] ); ?> <?php echo aiqd_badge( strtolower( $p[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h3>
							<p><?php echo esc_html( $p[2] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endforeach; ?>
</div>
