<?php
/**
 * Pricing. Plans come from AIQD_Store::plans() (Pricing Plans admin page).
 * Cycles: annual (per year) | lifetime (one-time).
 */
defined( 'ABSPATH' ) || exit;

$plans  = AIQD_Store::plans();
$cur    = AIQD_Store::setting( 'currency', '$' );
$cycle  = 'lifetime' === $d['default_cycle'] ? 'lifetime' : 'annual';
$matrix = AIQD_Render::parse_matrix( AIQD_Store::matrix() );

aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-pricing" data-aiqd-billing data-cycle="<?php echo esc_attr( $cycle ); ?>">
	<?php if ( ! empty( $d['show_toggle'] ) ) : ?>
		<div class="aiqd-bill aiqd-reveal" role="group" aria-label="<?php esc_attr_e( 'Billing cycle', 'accessiq-demo' ); ?>">
			<button type="button" data-cycle="annual" aria-pressed="<?php echo 'annual' === $cycle ? 'true' : 'false'; ?>"><?php echo esc_html( $d['annual_label'] ); ?></button>
			<button type="button" data-cycle="lifetime" aria-pressed="<?php echo 'lifetime' === $cycle ? 'true' : 'false'; ?>"><?php echo esc_html( $d['lifetime_label'] ); ?><?php if ( $d['lifetime_badge'] ) : ?> <em><?php echo esc_html( $d['lifetime_badge'] ); ?></em><?php endif; ?></button>
		</div>
	<?php endif; ?>

	<div class="aiqd-plans" style="--cols:<?php echo (int) count( $plans ); ?>">
		<?php foreach ( $plans as $i => $p ) :
			$free   = ! empty( $p['is_free'] );
			$yr     = (float) $p['price_annual'];
			$life   = (float) $p['price_lifetime'];
			$price  = 'lifetime' === $cycle ? $life : $yr;
			$feats  = AIQD_Render::parse_features( $p['features'] );
			$href_a = AIQD_Store::plan_url( $p, 'annual' );
			$href_l = AIQD_Store::plan_url( $p, 'lifetime' );
			$l      = aiqd_link( $p['cta_link'] );
			$ext    = $l['new'] || ( ! $free && empty( $p['cta_link'] ) && preg_match( '#^https?://#', $href_a ) );
			?>
			<article class="aiqd-plan <?php echo ! empty( $p['highlight'] ) ? 'is-hot' : ''; ?> <?php echo $free ? 'is-free' : ''; ?> aiqd-reveal" style="--d:<?php echo (int) $i * 80; ?>ms" data-plan="<?php echo esc_attr( $p['id'] ); ?>">
				<?php if ( $p['badge'] ) : ?><span class="aiqd-plan__badge"><?php echo esc_html( $p['badge'] ); ?></span><?php endif; ?>
				<h3 class="aiqd-plan__name"><?php echo esc_html( $p['name'] ); ?></h3>
				<p class="aiqd-plan__tag"><?php echo esc_html( $p['tagline'] ); ?></p>

				<div class="aiqd-plan__price" aria-live="polite">
					<span class="aiqd-plan__cur"><?php echo esc_html( $cur ); ?></span>
					<span class="aiqd-plan__amt" data-annual="<?php echo esc_attr( $yr ); ?>" data-lifetime="<?php echo esc_attr( $life ); ?>"><?php echo esc_html( number_format( $price, floor( $price ) === $price ? 0 : 2 ) ); ?></span>
					<?php if ( ! $free ) : ?>
						<span class="aiqd-plan__per" data-per><?php echo 'lifetime' === $cycle ? esc_html__( 'one-time', 'accessiq-demo' ) : esc_html__( '/year', 'accessiq-demo' ); ?></span>
					<?php endif; ?>
				</div>
				<p class="aiqd-plan__bill">
					<?php if ( $free ) : ?>
						<?php esc_html_e( 'Free forever', 'accessiq-demo' ); ?>
					<?php else : ?>
						<span data-bill><?php echo 'lifetime' === $cycle ? esc_html__( 'pay once, use forever', 'accessiq-demo' ) : esc_html__( 'billed yearly', 'accessiq-demo' ); ?></span>
					<?php endif; ?>
				</p>
				<p class="aiqd-plan__sites"><?php aiqd_e_icon( 'globe', 16 ); ?> <span class="aiqd-sr"><?php esc_html_e( 'License:', 'accessiq-demo' ); ?></span> <?php echo esc_html( $p['sites'] ); ?></p>

				<a class="aiqd-btn <?php echo ! empty( $p['highlight'] ) ? 'aiqd-btn--primary' : 'aiqd-btn--outline'; ?> aiqd-btn--block" href="<?php echo esc_url( 'lifetime' === $cycle ? $href_l : $href_a ); ?>" data-href-annual="<?php echo esc_url( $href_a ); ?>" data-href-lifetime="<?php echo esc_url( $href_l ); ?>"<?php echo ( ! $free && empty( $p['cta_link'] ) ) ? ' data-checkout="' . esc_attr( $p['id'] ) . '"' : ''; ?><?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>>
					<span><?php echo esc_html( $p['cta_label'] ); ?></span><?php aiqd_e_icon( $free ? 'download' : 'arrow-right', 18 ); ?>
				</a>
				<?php if ( $p['note'] ) : ?><p class="aiqd-plan__note"><?php echo esc_html( $p['note'] ); ?></p><?php endif; ?>

				<?php if ( ! empty( $p['lead'] ) ) : ?><p class="aiqd-plan__lead"><?php echo esc_html( $p['lead'] ); ?></p><?php endif; ?>
				<ul class="aiqd-plan__list<?php echo empty( $p['lead'] ) ? ' no-lead' : ''; ?>">
					<?php foreach ( $feats as $f ) : ?>
						<li class="<?php echo $f['inc'] ? '' : 'is-off'; ?> <?php echo $f['strong'] ? 'is-strong' : ''; ?>">
							<?php aiqd_e_icon( $f['inc'] ? 'check' : 'x', 16 ); ?>
							<span>
								<?php if ( $f['alt'] ) : ?>
									<span class="aiqd-only-annual"><?php echo esc_html( $f['text'] ); ?></span><span class="aiqd-only-lifetime"><?php echo esc_html( $f['alt'] ); ?></span>
								<?php else : ?>
									<?php echo esc_html( $f['text'] ); ?>
								<?php endif; ?>
								<?php if ( ! $f['inc'] ) : ?><span class="aiqd-sr"> <?php esc_html_e( '(not included)', 'accessiq-demo' ); ?></span><?php endif; ?>
							</span>
						</li>
					<?php endforeach; ?>
				</ul>
			</article>
		<?php endforeach; ?>
	</div>

	<?php if ( aiqd_lines( $d['trust'] ) ) : ?>
		<ul class="aiqd-trustbar aiqd-reveal">
			<?php foreach ( aiqd_lines( $d['trust'] ) as $t ) : ?>
				<li><?php aiqd_e_icon( 'shield', 16 ); ?><?php echo esc_html( $t ); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php if ( ! empty( $d['show_matrix'] ) && $matrix ) : ?>
		<details class="aiqd-matrix aiqd-reveal">
			<summary><span><?php echo esc_html( $d['matrix_title'] ); ?></span><?php aiqd_e_icon( 'chevron-down', 18 ); ?></summary>
			<div class="aiqd-tablewrap" tabindex="0" role="region" aria-label="<?php esc_attr_e( 'Plan comparison, scrollable', 'accessiq-demo' ); ?>">
				<table class="aiqd-table aiqd-cmp">
					<thead>
						<tr>
							<th scope="col"><span class="aiqd-sr"><?php esc_html_e( 'Feature', 'accessiq-demo' ); ?></span></th>
							<?php foreach ( $plans as $p ) : ?>
								<th scope="col" class="<?php echo ! empty( $p['highlight'] ) ? 'is-us' : ''; ?>"><?php echo esc_html( $p['name'] ); ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $matrix as $r ) : ?>
							<?php if ( 'group' === $r['type'] ) : ?>
								<tr class="aiqd-cmp__group"><th scope="colgroup" colspan="<?php echo (int) count( $plans ) + 1; ?>"><?php echo esc_html( $r['label'] ); ?></th></tr>
							<?php else : ?>
								<tr>
									<th scope="row"><?php echo esc_html( $r['label'] ); ?></th>
									<?php foreach ( $plans as $pi => $p ) : ?>
										<td class="<?php echo ! empty( $p['highlight'] ) ? 'is-us' : ''; ?>"><?php echo aiqd_matrix_cell( isset( $r['cells'][ $pi ] ) ? $r['cells'][ $pi ] : '' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
									<?php endforeach; ?>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</details>
	<?php endif; ?>

	<?php if ( ! empty( $d['footnote'] ) ) : ?>
		<p class="aiqd-footnote"><?php echo esc_html( $d['footnote'] ); ?></p>
	<?php endif; ?>
</div>
