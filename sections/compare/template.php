<?php
defined( 'ABSPATH' ) || exit;

$cols = aiqd_lines( $d['cols'] );
$rows = AIQD_Render::parse_matrix( $d['rows'] );
aiqd_head( $d, $s, 'is-center' );

/**
 * Print one comparison cell.
 */
$aiqd_cell = function ( $v ) {
	$t = strtolower( trim( $v ) );
	if ( 'yes' === $t || 'true' === $t || '✓' === $t ) {
		echo '<span class="aiqd-yes" role="img" aria-label="' . esc_attr__( 'Yes', 'accessiq-demo' ) . '">' . aiqd_icon( 'check', 18 ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput
	} elseif ( 'no' === $t || 'false' === $t || '✗' === $t || '' === $t ) {
		echo '<span class="aiqd-no" role="img" aria-label="' . esc_attr__( 'No', 'accessiq-demo' ) . '">' . aiqd_icon( 'x', 18 ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput
	} elseif ( '~' === $v[0] ) {
		echo '<span class="aiqd-part">' . esc_html( ltrim( substr( $v, 1 ) ) ) . '</span>';
	} elseif ( 'pro' === $t ) {
		echo aiqd_badge( 'pro' ); // phpcs:ignore WordPress.Security.EscapeOutput
	} elseif ( 'agency' === $t ) {
		echo aiqd_badge( 'agency' ); // phpcs:ignore WordPress.Security.EscapeOutput
	} else {
		echo '<span class="aiqd-txt">' . esc_html( $v ) . '</span>';
	}
};
?>
<div class="aiqd-tablewrap aiqd-reveal" tabindex="0" role="region" aria-label="<?php esc_attr_e( 'Comparison table, scrollable', 'accessiq-demo' ); ?>">
	<table class="aiqd-table aiqd-cmp">
		<thead>
			<tr>
				<th scope="col"><span class="aiqd-sr"><?php esc_html_e( 'Feature', 'accessiq-demo' ); ?></span></th>
				<?php foreach ( $cols as $i => $c ) : ?>
					<th scope="col" class="<?php echo 0 === $i ? 'is-us' : ''; ?>"><?php echo esc_html( $c ); ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $rows as $r ) : ?>
				<?php if ( 'group' === $r['type'] ) : ?>
					<tr class="aiqd-cmp__group"><th scope="colgroup" colspan="<?php echo (int) count( $cols ) + 1; ?>"><?php echo esc_html( $r['label'] ); ?></th></tr>
				<?php else : ?>
					<tr>
						<th scope="row"><?php echo esc_html( $r['label'] ); ?></th>
						<?php foreach ( $cols as $i => $c ) : ?>
							<td class="<?php echo 0 === $i ? 'is-us' : ''; ?>"><?php $aiqd_cell( isset( $r['cells'][ $i ] ) ? $r['cells'][ $i ] : '' ); ?></td>
						<?php endforeach; ?>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php if ( ! empty( $d['footnote'] ) ) : ?>
	<p class="aiqd-footnote"><?php echo esc_html( $d['footnote'] ); ?></p>
<?php endif; ?>
