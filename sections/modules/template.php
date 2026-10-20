<?php
/**
 * Module explorer. Vars: $d, $s.
 */
defined( 'ABSPATH' ) || exit;

require_once AIQD_DIR . 'sections/modules/visuals.php';

$mods   = array_values( (array) $d['modules'] );
$counts = array( 'all' => count( $mods ), 'free' => 0, 'pro' => 0, 'agency' => 0 );
foreach ( $mods as $m ) {
	if ( isset( $counts[ $m['tier'] ] ) ) {
		$counts[ $m['tier'] ]++;
	}
}
$tier_label = array(
	'free'   => __( 'Free', 'accessiq-demo' ),
	'pro'    => __( 'Pro', 'accessiq-demo' ),
	'agency' => __( 'Agency', 'accessiq-demo' ),
);
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-mods" data-aiqd-modules>
	<div class="aiqd-mods__tools aiqd-reveal">
		<div class="aiqd-filters" role="group" aria-label="<?php esc_attr_e( 'Filter modules by plan', 'accessiq-demo' ); ?>">
			<button type="button" class="is-on" data-filter="all" aria-pressed="true"><?php esc_html_e( 'All', 'accessiq-demo' ); ?> <b><?php echo (int) $counts['all']; ?></b></button>
			<button type="button" data-filter="free" aria-pressed="false"><?php esc_html_e( 'Free', 'accessiq-demo' ); ?> <b><?php echo (int) $counts['free']; ?></b></button>
			<button type="button" data-filter="pro" aria-pressed="false"><?php esc_html_e( 'Pro', 'accessiq-demo' ); ?> <b><?php echo (int) $counts['pro']; ?></b></button>
			<button type="button" data-filter="agency" aria-pressed="false"><?php esc_html_e( 'Agency', 'accessiq-demo' ); ?> <b><?php echo (int) $counts['agency']; ?></b></button>
		</div>
		<?php if ( ! empty( $d['show_search'] ) ) : ?>
			<label class="aiqd-search">
				<?php aiqd_e_icon( 'search', 16 ); ?>
				<span class="screen-reader-text aiqd-sr"><?php esc_html_e( 'Search modules', 'accessiq-demo' ); ?></span>
				<input type="search" placeholder="<?php esc_attr_e( 'Search modules…', 'accessiq-demo' ); ?>" data-mod-search>
			</label>
		<?php endif; ?>
	</div>

	<div class="aiqd-mods__layout">
		<div class="aiqd-mods__list" role="tablist" aria-orientation="vertical" aria-label="<?php esc_attr_e( 'Modules', 'accessiq-demo' ); ?>">
			<?php foreach ( $mods as $i => $m ) : ?>
				<button type="button" role="tab" class="aiqd-mod-tab" id="<?php echo esc_attr( $s['uid'] . '-t-' . $m['id'] ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $s['uid'] . '-p-' . $m['id'] ); ?>" tabindex="<?php echo 0 === $i ? '0' : '-1'; ?>" data-tier="<?php echo esc_attr( $m['tier'] ); ?>" data-search="<?php echo esc_attr( strtolower( $m['name'] . ' ' . $m['tagline'] . ' ' . $m['cat'] ) ); ?>">
					<?php aiqd_e_icon( $m['icon'], 20 ); ?>
					<span class="aiqd-mod-tab__name"><?php echo esc_html( $m['name'] ); ?></span>
					<?php echo aiqd_badge( $m['tier'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</button>
			<?php endforeach; ?>
			<p class="aiqd-mods__empty" hidden><?php esc_html_e( 'No modules match your search.', 'accessiq-demo' ); ?></p>
		</div>

		<div class="aiqd-mods__stage">
			<?php foreach ( $mods as $i => $m ) : ?>
				<article class="aiqd-mod-panel" role="tabpanel" id="<?php echo esc_attr( $s['uid'] . '-p-' . $m['id'] ); ?>" aria-labelledby="<?php echo esc_attr( $s['uid'] . '-t-' . $m['id'] ); ?>" <?php echo 0 === $i ? '' : 'hidden'; ?>>
					<div class="aiqd-mod-panel__text">
						<p class="aiqd-mod-panel__meta"><?php echo aiqd_badge( $m['tier'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <span><?php echo esc_html( $m['cat'] ); ?></span></p>
						<h3 class="aiqd-h3 aiqd-h3--xl"><?php echo esc_html( $m['name'] ); ?></h3>
						<p class="aiqd-mod-panel__tag"><?php echo esc_html( $m['tagline'] ); ?></p>
						<p><?php echo esc_html( $m['desc'] ); ?></p>
						<ul class="aiqd-ticks">
							<?php foreach ( aiqd_lines( $m['bullets'] ) as $b ) : ?>
								<li><?php aiqd_e_icon( 'check', 16 ); ?><?php echo esc_html( $b ); ?></li>
							<?php endforeach; ?>
						</ul>
						<?php if ( ! empty( $m['where'] ) ) : ?>
							<p class="aiqd-where"><?php aiqd_e_icon( 'map', 16 ); ?> <span><?php esc_html_e( 'Find it in:', 'accessiq-demo' ); ?></span> <code><?php echo esc_html( $m['where'] ); ?></code></p>
						<?php endif; ?>
						<?php if ( ! empty( $m['link'] ) ) : ?>
							<a class="aiqd-more" <?php echo aiqd_href_attrs( $m['link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php esc_html_e( 'Learn more', 'accessiq-demo' ); ?> <?php aiqd_e_icon( 'arrow-right', 16 ); ?></a>
						<?php endif; ?>
					</div>
					<div class="aiqd-mod-panel__visual" aria-hidden="true">
						<?php echo aiqd_module_visual( $m['visual'], $m ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</div>
