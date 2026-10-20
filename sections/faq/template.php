<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-faq" data-aiqd-faq>
	<?php if ( ! empty( $d['show_search'] ) ) : ?>
		<label class="aiqd-search aiqd-search--wide">
			<?php aiqd_e_icon( 'search', 16 ); ?>
			<span class="aiqd-sr"><?php esc_html_e( 'Search questions', 'accessiq-demo' ); ?></span>
			<input type="search" placeholder="<?php esc_attr_e( 'Search questions…', 'accessiq-demo' ); ?>" data-faq-search>
		</label>
	<?php endif; ?>
	<div class="aiqd-faq__list">
		<?php foreach ( (array) $d['items'] as $i => $it ) : ?>
			<details class="aiqd-qa aiqd-reveal" style="--d:<?php echo (int) min( $i, 8 ) * 40; ?>ms" <?php echo 0 === $i ? 'open' : ''; ?>>
				<summary><h3><?php echo esc_html( $it['q'] ); ?></h3><?php aiqd_e_icon( 'plus', 20, 'aiqd-qa__plus' ); ?></summary>
				<div class="aiqd-qa__a"><p><?php echo aiqd_hl( $it['a'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p></div>
			</details>
		<?php endforeach; ?>
		<p class="aiqd-faq__empty" hidden><?php esc_html_e( 'No questions match your search.', 'accessiq-demo' ); ?></p>
	</div>
</div>
