<?php
/**
 * Landing page shell. Supports plugin / theme / no header and footer in any combination
 * (classic themes via get_header()/get_footer(), block themes via block_template_part()).
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

$aiqd      = AIQD_Render::instance();
$aiqd_set  = AIQD_Store::settings();
$aiqd_blk  = function_exists( 'wp_is_block_theme' ) && wp_is_block_theme();
$aiqd_hsrc = $aiqd_set['header_source'];
$aiqd_fsrc = $aiqd_set['footer_source'];

if ( 'theme' === $aiqd_hsrc && ! $aiqd_blk ) {
	get_header();
} else {
	?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<?php
	if ( 'theme' === $aiqd_hsrc && $aiqd_blk && function_exists( 'block_template_part' ) ) {
		block_template_part( 'header' );
	}
}
?>
<a class="aiqd-skip" href="#aiqd-main"><?php esc_html_e( 'Skip to main content', 'accessiq-demo' ); ?></a>
<?php
$aiqd->open_root();
if ( 'plugin' === $aiqd_hsrc ) {
	$aiqd->render_zone( 'header' );
}
?>
<main id="aiqd-main" class="aiqd-main" tabindex="-1">
	<?php
	if ( $aiqd->is_thankyou() ) {
		$aiqd->render_thankyou();
	} else {
		$aiqd->render_body();
	}
	?>
</main>
<?php
if ( 'plugin' === $aiqd_fsrc ) {
	$aiqd->render_zone( 'footer' );
}
$aiqd->render_floaters();
$aiqd->close_root();

if ( 'theme' === $aiqd_fsrc && ! $aiqd_blk ) {
	get_footer();
} else {
	if ( 'theme' === $aiqd_fsrc && $aiqd_blk && function_exists( 'block_template_part' ) ) {
		block_template_part( 'footer' );
	}
	wp_footer();
	echo '</body></html>';
}
