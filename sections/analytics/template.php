<?php
defined( 'ABSPATH' ) || exit;
aiqd_head( $d, $s, 'is-center' );
?>
<div class="aiqd-adash aiqd-reveal" data-aiqd-chart>
	<div class="aiqd-adash__top">
		<h3 class="aiqd-h4"><?php aiqd_e_icon( 'chart', 18 ); ?> <?php esc_html_e( 'Behavior overview', 'accessiq-demo' ); ?></h3>
		<div class="aiqd-seg" role="group" aria-label="<?php esc_attr_e( 'Date range', 'accessiq-demo' ); ?>">
			<button type="button" class="is-on" data-range="7" aria-pressed="true">7 <?php esc_html_e( 'days', 'accessiq-demo' ); ?></button>
			<button type="button" data-range="30" aria-pressed="false">30 <?php esc_html_e( 'days', 'accessiq-demo' ); ?></button>
			<button type="button" data-range="90" aria-pressed="false">90 <?php esc_html_e( 'days', 'accessiq-demo' ); ?></button>
		</div>
	</div>
	<div class="aiqd-kpis">
		<div class="aiqd-kpi"><small><?php esc_html_e( 'Sessions', 'accessiq-demo' ); ?></small><b data-kpi="sessions">0</b></div>
		<div class="aiqd-kpi"><small><?php esc_html_e( 'Avg. time on page', 'accessiq-demo' ); ?></small><b data-kpi="time">0:00</b></div>
		<div class="aiqd-kpi"><small><?php esc_html_e( 'Bounce rate', 'accessiq-demo' ); ?></small><b data-kpi="bounce">0%</b></div>
		<div class="aiqd-kpi"><small><?php esc_html_e( 'Peak hour', 'accessiq-demo' ); ?></small><b data-kpi="peak">—</b></div>
	</div>
	<div class="aiqd-adash__charts">
		<div class="aiqd-adash__line">
			<canvas data-chart-line role="img" aria-label="<?php esc_attr_e( 'Daily sessions line chart', 'accessiq-demo' ); ?>"></canvas>
			<div class="aiqd-tip" data-chart-tip hidden></div>
		</div>
		<div class="aiqd-adash__donut">
			<canvas data-chart-donut width="180" height="180" role="img" aria-label="<?php esc_attr_e( 'Device split donut chart', 'accessiq-demo' ); ?>"></canvas>
			<ul class="aiqd-legend" data-chart-legend></ul>
		</div>
	</div>
	<div class="aiqd-tablewrap">
		<table class="aiqd-table">
			<caption class="aiqd-sr"><?php esc_html_e( 'Top pages performance', 'accessiq-demo' ); ?></caption>
			<thead><tr><th scope="col"><?php esc_html_e( 'Page', 'accessiq-demo' ); ?></th><th scope="col"><?php esc_html_e( 'Sessions', 'accessiq-demo' ); ?></th><th scope="col"><?php esc_html_e( 'Avg. time', 'accessiq-demo' ); ?></th><th scope="col"><?php esc_html_e( 'Bounce', 'accessiq-demo' ); ?></th><th scope="col"><?php esc_html_e( 'Top device', 'accessiq-demo' ); ?></th></tr></thead>
			<tbody>
				<?php foreach ( aiqd_lines( $d['pages'] ) as $line ) :
					$c      = array_pad( array_map( 'trim', explode( '|', $line ) ), 5, '' );
					$bounce = (int) $c[3];
					$tone   = $bounce >= 55 ? 'bad' : ( $bounce >= 35 ? 'warn' : 'good' );
					?>
					<tr data-base="<?php echo esc_attr( (int) str_replace( ',', '', $c[1] ) ); ?>">
						<th scope="row"><?php echo esc_html( $c[0] ); ?></th>
						<td data-sess><?php echo esc_html( $c[1] ); ?></td>
						<td><?php echo esc_html( $c[2] ); ?></td>
						<td><span class="aiqd-pillx aiqd-pillx--<?php echo esc_attr( $tone ); ?>"><?php echo (int) $bounce; ?>%</span></td>
						<td><?php echo esc_html( $c[4] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="aiqd-adash__foot">
		<ul class="aiqd-ticks aiqd-ticks--row">
			<?php foreach ( aiqd_lines( $d['points'] ) as $p ) : ?>
				<li><?php aiqd_e_icon( 'check', 16 ); ?><?php echo esc_html( $p ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php aiqd_btn( $d['cta_label'], $d['cta_link'], 'aiqd-btn--primary', 'download' ); ?>
	</div>
</div>
