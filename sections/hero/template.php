<?php
/**
 * Hero + scanner simulator. Vars: $d, $s.
 */
defined( 'ABSPATH' ) || exit;

$samples = array_values( (array) $d['samples'] );
$sev_lbl = array(
	'critical' => __( 'Critical', 'accessiq-demo' ),
	'serious'  => __( 'Serious', 'accessiq-demo' ),
	'moderate' => __( 'Moderate', 'accessiq-demo' ),
);
$cats = array(
	'Images'   => 'image',
	'Contrast' => 'contrast',
	'Headings' => 'type',
	'ARIA'     => 'tag',
	'Forms'    => 'pen',
);
?>
<div class="aiqd-hero">
	<div class="aiqd-hero__bg" aria-hidden="true"><i></i><i></i><i></i></div>
	<div class="aiqd-container aiqd-hero__grid">
		<div class="aiqd-hero__copy">
			<?php if ( $d['eyebrow'] ) : ?>
				<p class="aiqd-pill aiqd-reveal"><span class="aiqd-pill__dot"></span><?php echo aiqd_hl( $d['eyebrow'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
			<?php endif; ?>
			<h1 class="aiqd-h1 aiqd-reveal" id="<?php echo esc_attr( $s['uid'] ); ?>-title"><?php echo aiqd_hl( $d['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
			<p class="aiqd-lead aiqd-reveal"><?php echo aiqd_hl( $d['subtitle'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
			<div class="aiqd-actions aiqd-reveal">
				<?php aiqd_btn( $d['cta1_label'], $d['cta1_link'], 'aiqd-btn--primary aiqd-btn--lg', 'download' ); ?>
				<?php aiqd_btn( $d['cta2_label'], $d['cta2_link'], 'aiqd-btn--outline aiqd-btn--lg', 'crown' ); ?>
				<?php aiqd_btn( $d['cta3_label'], $d['cta3_link'], 'aiqd-btn--ghost aiqd-btn--lg', 'play' ); ?>
			</div>
			<ul class="aiqd-trust aiqd-reveal">
				<?php foreach ( (array) $d['badges'] as $b ) : ?>
					<li><?php aiqd_e_icon( $b['icon'], 16 ); ?><span><?php echo esc_html( $b['text'] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="aiqd-hero__visual aiqd-reveal">
			<?php foreach ( array_slice( (array) $d['floaters'], 0, 4 ) as $i => $f ) : ?>
				<div class="aiqd-chip aiqd-chip--<?php echo (int) $i + 1; ?>" data-float="<?php echo (int) ( 14 + $i * 8 ); ?>" aria-hidden="true">
					<span class="aiqd-chip__ico"><?php aiqd_e_icon( $f['icon'], 18 ); ?></span>
					<span><b><?php echo esc_html( $f['text'] ); ?></b><small><?php echo esc_html( $f['sub'] ); ?></small></span>
				</div>
			<?php endforeach; ?>

			<div class="aiqd-scan" data-aiqd-scanner>
				<div class="aiqd-scan__top">
					<span class="aiqd-dots3" aria-hidden="true"><i></i><i></i><i></i></span>
					<strong class="aiqd-scan__title"><?php echo esc_html( $d['demo_title'] ); ?></strong>
					<span class="aiqd-live"><span class="aiqd-live__dot"></span>DEMO</span>
				</div>

				<div class="aiqd-tabs-pills" role="tablist" aria-label="<?php esc_attr_e( 'Sample pages', 'accessiq-demo' ); ?>">
					<?php foreach ( $samples as $i => $smp ) : ?>
						<button type="button" role="tab" id="<?php echo esc_attr( $s['uid'] . '-tab-' . $i ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $s['uid'] . '-res-' . $i ); ?>" data-sample="<?php echo (int) $i; ?>" tabindex="<?php echo 0 === $i ? '0' : '-1'; ?>"><?php echo esc_html( $smp['name'] ); ?></button>
					<?php endforeach; ?>
				</div>

				<div class="aiqd-scan__bar">
					<span class="aiqd-scan__url"><?php aiqd_e_icon( 'lock', 14 ); ?><span data-scan-url><?php echo esc_html( $samples ? $samples[0]['url'] : '' ); ?></span></span>
					<button type="button" class="aiqd-btn aiqd-btn--primary aiqd-btn--sm" data-scan-run><span><?php esc_html_e( 'Scan', 'accessiq-demo' ); ?></span><?php aiqd_e_icon( 'search', 16 ); ?></button>
				</div>
				<div class="aiqd-scan__progress" aria-hidden="true"><span></span></div>

				<?php foreach ( $samples as $i => $smp ) :
					$score  = (int) $smp['score'];
					$issues = array();
					foreach ( aiqd_lines( $smp['issues'] ) as $ln ) {
						$p = array_pad( array_map( 'trim', explode( '|', $ln ) ), 5, '' );
						$issues[] = array(
							'sev'  => $p[0],
							'cat'  => $p[1],
							'rule' => $p[2],
							'el'   => $p[3],
							'fix'  => $p[4],
						);
					}
					$counts = array( 'critical' => 0, 'serious' => 0, 'moderate' => 0 );
					$bycat  = array_fill_keys( array_keys( $cats ), 0 );
					foreach ( $issues as $is ) {
						if ( isset( $counts[ $is['sev'] ] ) ) {
							$counts[ $is['sev'] ]++;
						}
						if ( isset( $bycat[ $is['cat'] ] ) ) {
							$bycat[ $is['cat'] ]++;
						}
					}
					$maxcat = max( 1, max( $bycat ) );
					?>
					<div class="aiqd-scan__result" role="tabpanel" id="<?php echo esc_attr( $s['uid'] . '-res-' . $i ); ?>" aria-labelledby="<?php echo esc_attr( $s['uid'] . '-tab-' . $i ); ?>" data-url="<?php echo esc_attr( $smp['url'] ); ?>" <?php echo 0 === $i ? '' : 'hidden'; ?>>
						<div class="aiqd-scan__summary">
							<?php echo aiqd_ring( $score, 124 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							<div class="aiqd-scan__meta">
								<p class="aiqd-grade"><?php echo esc_html( aiqd_grade( $score ) ); ?><?php echo 100 === $score ? ' 🎉' : ''; ?></p>
								<p class="aiqd-level"><?php echo esc_html( $smp['level'] ); ?></p>
								<p class="aiqd-sevs">
									<?php foreach ( $counts as $k => $n ) : if ( ! $n ) { continue; } ?>
										<span class="aiqd-sev aiqd-sev--<?php echo esc_attr( $k ); ?>"><?php echo (int) $n; ?> <?php echo esc_html( strtolower( $sev_lbl[ $k ] ) ); ?></span>
									<?php endforeach; ?>
									<?php if ( ! $issues ) : ?>
										<span class="aiqd-sev aiqd-sev--ok"><?php esc_html_e( 'No issues found', 'accessiq-demo' ); ?></span>
									<?php endif; ?>
								</p>
							</div>
						</div>

						<ul class="aiqd-cats" aria-label="<?php esc_attr_e( 'Violations by category', 'accessiq-demo' ); ?>">
							<?php foreach ( $bycat as $cname => $n ) : ?>
								<li>
									<span><?php aiqd_e_icon( $cats[ $cname ], 14 ); ?><?php echo esc_html( $cname ); ?></span>
									<span class="aiqd-cats__bar"><i style="--w:<?php echo (int) round( $n / $maxcat * 100 ); ?>%"></i></span>
									<b><?php echo (int) $n; ?></b>
								</li>
							<?php endforeach; ?>
						</ul>

						<?php if ( $issues ) : ?>
							<div class="aiqd-issues">
								<?php foreach ( $issues as $is ) : ?>
									<details class="aiqd-issue">
										<summary>
											<span class="aiqd-sev aiqd-sev--<?php echo esc_attr( $is['sev'] ); ?>"><?php echo esc_html( isset( $sev_lbl[ $is['sev'] ] ) ? $sev_lbl[ $is['sev'] ] : $is['sev'] ); ?></span>
											<span class="aiqd-issue__rule"><?php echo esc_html( $is['rule'] ); ?></span>
											<?php aiqd_e_icon( 'chevron-down', 16, 'aiqd-issue__chev' ); ?>
										</summary>
										<div class="aiqd-issue__body">
											<code><?php echo esc_html( $is['el'] ); ?></code>
											<p><?php aiqd_e_icon( 'wrench', 14 ); ?> <?php echo esc_html( $is['fix'] ); ?></p>
										</div>
									</details>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<p class="aiqd-perfect"><?php aiqd_e_icon( 'badge', 18 ); ?> <?php esc_html_e( 'Perfect score! Every automated check passed.', 'accessiq-demo' ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
				<p class="aiqd-scan__hint"><?php echo esc_html( $d['demo_hint'] ); ?></p>
			</div>
		</div>
	</div>
</div>
