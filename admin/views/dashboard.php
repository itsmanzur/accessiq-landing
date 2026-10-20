<?php
/**
 * Admin dashboard.
 */
defined( 'ABSPATH' ) || exit;

$layout   = AIQD_Store::layout();
$active   = 0;
foreach ( $layout as $inst ) {
	if ( ! empty( $inst['enabled'] ) ) {
		$active++;
	}
}
$plans    = AIQD_Store::plans();
$links    = AIQD_Store::links();
$audit    = AIQD_SEO::audit();
$ok       = 0;
foreach ( $audit as $a ) {
	if ( 'ok' === $a[0] ) {
		$ok++;
	}
}
$score    = $audit ? (int) round( $ok / count( $audit ) * 100 ) : 0;
$page_id  = (int) AIQD_Store::setting( 'page_id', 0 );
$page_url = ( $page_id && 'publish' === get_post_status( $page_id ) ) ? get_permalink( $page_id ) : '';
$reg      = AIQD_Registry::instance();
$modules  = AIQD_SEO::section( 'modules' );
$mod_n    = $modules ? count( (array) $modules['modules'] ) : 0;
$seo      = AIQD_Store::seo();
$admin    = function ( $slug ) {
	return esc_url( admin_url( 'admin.php?page=' . $slug ) );
};
$actions  = array(
	array( 'aiqd-builder', 'layout', __( 'Page Builder', 'accessiq-demo' ), __( 'Reorder, add, hide and edit every section.', 'accessiq-demo' ) ),
	array( 'aiqd-pricing', 'money-alt', __( 'Pricing Plans', 'accessiq-demo' ), __( 'Four plans, prices, features, Freemius IDs.', 'accessiq-demo' ) ),
	array( 'aiqd-links', 'admin-links', __( 'Links & Buttons', 'accessiq-demo' ), __( 'Change one link, update every button.', 'accessiq-demo' ) ),
	array( 'aiqd-hf', 'align-center', __( 'Header & Footer', 'accessiq-demo' ), __( 'Menu, CTAs, columns — or use the theme.', 'accessiq-demo' ) ),
	array( 'aiqd-design', 'art', __( 'Design', 'accessiq-demo' ), __( 'Colours, radius, fonts, motion, dark / light.', 'accessiq-demo' ) ),
	array( 'aiqd-seo', 'search', __( 'SEO & LLM', 'accessiq-demo' ), __( 'Meta, JSON-LD, llms.txt, robots rules.', 'accessiq-demo' ) ),
);
?>
<div class="aiqda-dash">
	<section class="aiqda-hero">
		<div>
			<p class="aiqda-eyebrow"><?php esc_html_e( 'AccessIQ Landing', 'accessiq-demo' ); ?></p>
			<h2><?php esc_html_e( 'Your product landing page, built from sections.', 'accessiq-demo' ); ?></h2>
			<p><?php esc_html_e( 'Every block of the page — hero, 31-module explorer, live demos, pricing, FAQ — is a section you can reorder, hide, duplicate or add between. Content, links and prices are plain data you edit from here.', 'accessiq-demo' ); ?></p>
			<p class="aiqda-hero__btns">
				<a class="aiqda-btn aiqda-btn--primary" href="<?php echo $admin( 'aiqd-builder' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>"><?php esc_html_e( 'Open Page Builder', 'accessiq-demo' ); ?></a>
				<?php if ( $page_url ) : ?>
					<a class="aiqda-btn" target="_blank" rel="noopener" href="<?php echo esc_url( $page_url ); ?>"><?php esc_html_e( 'View landing page ↗', 'accessiq-demo' ); ?></a>
				<?php endif; ?>
				<a class="aiqda-btn" href="<?php echo $admin( 'aiqd-docs' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>"><?php esc_html_e( 'Read the docs', 'accessiq-demo' ); ?></a>
			</p>
		</div>
		<div class="aiqda-hero__score" role="img" aria-label="<?php echo esc_attr( sprintf( /* translators: %d percent */ __( 'SEO readiness %d percent', 'accessiq-demo' ), $score ) ); ?>">
			<svg viewBox="0 0 120 120" aria-hidden="true"><circle cx="60" cy="60" r="52" class="bg"/><circle cx="60" cy="60" r="52" class="fg" stroke-dasharray="326.73" stroke-dashoffset="<?php echo esc_attr( round( 326.73 - 326.73 * $score / 100, 1 ) ); ?>"/></svg>
			<div><b><?php echo (int) $score; ?></b><small><?php esc_html_e( 'SEO ready', 'accessiq-demo' ); ?></small></div>
		</div>
	</section>

	<?php if ( ! $page_url ) : ?>
		<div class="notice notice-warning inline"><p><?php esc_html_e( 'No published landing page is assigned yet.', 'accessiq-demo' ); ?> <a href="<?php echo $admin( 'aiqd-settings' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>"><?php esc_html_e( 'Choose one in Settings', 'accessiq-demo' ); ?></a></p></div>
	<?php endif; ?>
	<?php if ( ! empty( $seo['noindex'] ) ) : ?>
		<div class="notice notice-info inline"><p><?php esc_html_e( 'The page is set to noindex (good for local testing). Turn it off in SEO & LLM before launch.', 'accessiq-demo' ); ?></p></div>
	<?php endif; ?>

	<div class="aiqda-stats">
		<div class="aiqda-stat"><b><?php echo (int) $active; ?><small>/<?php echo (int) count( $layout ); ?></small></b><span><?php esc_html_e( 'Sections visible', 'accessiq-demo' ); ?></span></div>
		<div class="aiqda-stat"><b><?php echo (int) $mod_n; ?></b><span><?php esc_html_e( 'Modules documented', 'accessiq-demo' ); ?></span></div>
		<div class="aiqda-stat"><b><?php echo (int) count( $plans ); ?></b><span><?php esc_html_e( 'Pricing plans', 'accessiq-demo' ); ?></span></div>
		<div class="aiqda-stat"><b><?php echo (int) count( $links ); ?></b><span><?php esc_html_e( 'Global links', 'accessiq-demo' ); ?></span></div>
		<div class="aiqda-stat"><b><?php echo (int) count( $reg->body_types() ); ?></b><span><?php esc_html_e( 'Section types', 'accessiq-demo' ); ?></span></div>
	</div>

	<h3 class="aiqda-h"><?php esc_html_e( 'Quick actions', 'accessiq-demo' ); ?></h3>
	<div class="aiqda-actions">
		<?php foreach ( $actions as $a ) : ?>
			<a class="aiqda-action" href="<?php echo $admin( $a[0] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">
				<span class="dashicons dashicons-<?php echo esc_attr( $a[1] ); ?>"></span>
				<strong><?php echo esc_html( $a[2] ); ?></strong>
				<small><?php echo esc_html( $a[3] ); ?></small>
			</a>
		<?php endforeach; ?>
	</div>

	<div class="aiqda-cols">
		<section class="aiqda-card">
			<h3 class="aiqda-h"><?php esc_html_e( 'Section order', 'accessiq-demo' ); ?></h3>
			<ol class="aiqda-map">
				<?php foreach ( $layout as $inst ) :
					$t = $reg->get_type( $inst['type'] );
					?>
					<li class="<?php echo empty( $inst['enabled'] ) ? 'is-off' : ''; ?>"><span class="dashicons dashicons-<?php echo 'hero' === $inst['type'] ? 'star-filled' : 'minus'; ?>"></span><?php echo esc_html( $t ? $t['label'] : $inst['type'] ); ?><?php echo empty( $inst['enabled'] ) ? ' <em>(' . esc_html__( 'hidden', 'accessiq-demo' ) . ')</em>' : ''; ?></li>
				<?php endforeach; ?>
			</ol>
			<a class="aiqda-btn" href="<?php echo $admin( 'aiqd-builder' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>"><?php esc_html_e( 'Reorder sections', 'accessiq-demo' ); ?></a>
		</section>

		<section class="aiqda-card">
			<h3 class="aiqda-h"><?php esc_html_e( 'SEO & LLM checklist', 'accessiq-demo' ); ?></h3>
			<ul class="aiqda-audit">
				<?php foreach ( $audit as $a ) : ?>
					<li class="is-<?php echo esc_attr( $a[0] ); ?>">
						<span class="dashicons dashicons-<?php echo 'ok' === $a[0] ? 'yes-alt' : ( 'warn' === $a[0] ? 'warning' : 'dismiss' ); ?>"></span>
						<span><strong><?php echo esc_html( $a[1] ); ?></strong><small><?php echo esc_html( $a[2] ); ?></small></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<p class="aiqda-links">
				<a href="<?php echo esc_url( home_url( '/llms.txt' ) ); ?>" target="_blank" rel="noopener">/llms.txt ↗</a>
				<a href="<?php echo esc_url( home_url( '/llms-full.txt' ) ); ?>" target="_blank" rel="noopener">/llms-full.txt ↗</a>
				<a href="<?php echo esc_url( home_url( '/robots.txt' ) ); ?>" target="_blank" rel="noopener">/robots.txt ↗</a>
			</p>
		</section>

		<section class="aiqda-card">
			<h3 class="aiqda-h"><?php esc_html_e( 'Shortcodes', 'accessiq-demo' ); ?></h3>
			<p class="aiqda-muted"><?php esc_html_e( 'Use these inside any page or page builder:', 'accessiq-demo' ); ?></p>
			<div class="aiqda-code"><code>[accessiq_demo]</code><button type="button" class="aiqda-copy" data-copy="[accessiq_demo]"><?php esc_html_e( 'Copy', 'accessiq-demo' ); ?></button></div>
			<p class="aiqda-muted"><?php esc_html_e( 'Whole landing page body (no header / footer).', 'accessiq-demo' ); ?></p>
			<div class="aiqda-code"><code>[accessiq_section type="pricing"]</code><button type="button" class="aiqda-copy" data-copy='[accessiq_section type="pricing"]'><?php esc_html_e( 'Copy', 'accessiq-demo' ); ?></button></div>
			<p class="aiqda-muted"><?php esc_html_e( 'Embed a single section (pricing, faq, modules, widget…) on any other page.', 'accessiq-demo' ); ?></p>
			<h3 class="aiqda-h"><?php esc_html_e( 'This plugin is a demo', 'accessiq-demo' ); ?></h3>
			<p class="aiqda-muted"><?php esc_html_e( 'It never reads or changes the AccessIQ / AccessIQ Pro plugins. Every text, price and link on the page is data you control from this plugin.', 'accessiq-demo' ); ?></p>
		</section>
	</div>
</div>
