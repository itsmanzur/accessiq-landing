<?php
/**
 * Default Privacy Policy, Terms of Service and Refund Policy pages.
 * Created on activation (only when the page does not exist). Edit them in the normal WordPress page editor.
 * These are starting-point texts — have them reviewed by a qualified professional before relying on them.
 *
 * @package AccessIQLanding
 */

defined( 'ABSPATH' ) || exit;

/**
 * Page definitions: slug => [ title, html ].
 */
function aiqd_legal_pages() {
	$mail    = 'hello@thereadscope.com';
	$updated = 'October 20, 2026';
	$mailto  = '<a href="mailto:' . $mail . '">' . $mail . '</a>';

	ob_start();
?>
<p><em>Last updated: <?php echo esc_html( $updated ); ?></em></p>
<p>This policy explains what personal data is handled when you visit the AccessIQ website and buy AccessIQ Pro. "We", "us" and "readscope" mean the publisher of AccessIQ. Contact: <?php echo $mailto; // phpcs:ignore WordPress.Security.EscapeOutput ?>.</p>

<h2>1. This website</h2>
<ul>
<li><strong>No tracking cookies.</strong> The landing page does not set advertising or analytics cookies. Your light/dark theme choice is stored in your browser's local storage and never sent to us.</li>
<li><strong>Server logs.</strong> Like any website, our host records technical data such as IP address, browser type and requested page for security and troubleshooting. These logs are kept for a limited time.</li>
<li><strong>Messages you send.</strong> If you email us, we use your email address and message only to reply and to provide support.</li>
</ul>

<h2>2. Purchases and licences</h2>
<p>Purchases of AccessIQ Pro are handled by our payment and licensing partner, <strong>Freemius</strong>, and its payment processors (for example Stripe and PayPal). When you buy, you give your name, email, billing details and payment data directly to them. We do not see or store your card details. Freemius shares with us the information needed to provide your licence and support (such as your name, email, plan and purchase date). See the Freemius <a href="https://freemius.com/privacy/" rel="noopener">privacy policy</a>.</p>
<p>When you activate a Pro licence, the plugin contacts Freemius for licence validation and updates. This can include your site URL, WordPress and plugin versions and the account email you provide.</p>

<h2>3. The AccessIQ plugin on your own site</h2>
<ul>
<li>AccessIQ stores scan results, click coordinates and session statistics in <strong>your own WordPress database</strong>. We do not receive this data.</li>
<li>Tracking uses a random session identifier kept in the visitor's session storage (no cookies) and does not store IP addresses. If you use the heatmap and analytics features, mention them in your own privacy policy.</li>
<li>AccessIQ Pro's AI tools send data to the AI provider <em>you</em> choose (for example an image for alt text, or a code snippet for a fix suggestion) only when you click Generate. Your API key is stored encrypted on your site. The provider's own terms and privacy policy apply.</li>
</ul>

<h2>4. Why we use data</h2>
<p>To deliver and support the product, process licences and purchases, keep the website secure, and comply with legal obligations. Where the law requires a legal basis, we rely on performing our contract with you, our legitimate interests in running a secure service, and legal obligations.</p>

<h2>5. Sharing and retention</h2>
<p>We share data only with the service providers needed above (hosting, Freemius and its payment processors) and when required by law. We keep purchase and support records for as long as needed to provide the service and meet tax and legal duties.</p>

<h2>6. Your rights</h2>
<p>Depending on where you live, you may have the right to access, correct, delete or export your personal data, or to object to or restrict certain processing. Email <?php echo $mailto; // phpcs:ignore WordPress.Security.EscapeOutput ?> and we will respond. You can also complain to your local data protection authority.</p>

<h2>7. Children</h2>
<p>This website and product are not directed at children under 16.</p>

<h2>8. Changes</h2>
<p>We may update this policy. The date at the top shows the latest version.</p>
<?php
$privacy = ob_get_clean();

	ob_start();
?>
<p><em>Last updated: <?php echo esc_html( $updated ); ?></em></p>
<p>These terms apply to your use of the AccessIQ website and your purchase of AccessIQ Pro. By using the site or buying a licence you agree to them. Contact: <?php echo $mailto; // phpcs:ignore WordPress.Security.EscapeOutput ?>.</p>

<h2>1. The software and licences</h2>
<ul>
<li>The free AccessIQ plugin and the AccessIQ Pro plugin code are released under the <strong>GNU General Public License v2 or later</strong>.</li>
<li>A paid plan gives you a <strong>licence key</strong> for updates and support for the number of sites stated on your plan (Starter: 1 site, Pro: 5 sites, Agency: unlimited sites). Annual plans include one year of updates and support and renew yearly unless cancelled; Lifetime plans include lifetime updates and support for the licensed sites.</li>
<li>Licence keys are for your own use or your clients' sites within your plan. You may not resell or publicly share a licence key.</li>
</ul>

<h2>2. Purchases and payment</h2>
<p>Orders are processed by Freemius, which handles checkout, payment, taxes and licence delivery. Its terms also apply to your purchase. Prices are shown on our pricing page and may change for future purchases.</p>

<h2>3. Refunds</h2>
<p>See our <a href="/refund-policy/">Refund Policy</a>. We offer a 30-day money-back guarantee on purchases.</p>

<h2>4. Accessibility results are guidance, not certification</h2>
<p>AccessIQ runs automated checks that find many common accessibility problems but <strong>cannot prove that a website conforms to WCAG</strong> or any law. Scores, reports, badges and statements generated by the plugin are aids, not legal advice or a guarantee of compliance. You remain responsible for manual testing and for your own site's legal obligations.</p>

<h2>5. Third-party services</h2>
<p>AccessIQ Pro can connect to third-party AI providers using your own API keys. You are responsible for those accounts, their costs and their terms.</p>

<h2>6. Acceptable use</h2>
<p>Do not misuse the website or software, attempt to break or overload our systems, or use the product to break the law or infringe others' rights.</p>

<h2>7. Warranty and liability</h2>
<p>The software is provided "as is" without warranties of any kind, to the fullest extent permitted by law. To the fullest extent permitted by law, our total liability for any claim relating to the product is limited to the amount you paid for it in the 12 months before the claim, and we are not liable for indirect or consequential losses, lost profits or data loss. Nothing in these terms limits liability that cannot be limited by law.</p>

<h2>8. Termination</h2>
<p>We may suspend a licence that is used in breach of these terms. You may stop using the software at any time.</p>

<h2>9. Changes and governing law</h2>
<p>We may update these terms; the date above shows the current version. They are governed by the laws of the country in which readscope is established, without regard to conflict-of-law rules.</p>

<h2>10. Contact</h2>
<p>Questions: <?php echo $mailto; // phpcs:ignore WordPress.Security.EscapeOutput ?>.</p>
<?php
$terms = ob_get_clean();

	ob_start();
?>
<p><em>Last updated: <?php echo esc_html( $updated ); ?></em></p>
<h2>30-day money-back guarantee</h2>
<p>If AccessIQ Pro is not right for you, you can ask for a full refund within <strong>30 days of purchase</strong> — no complicated questions.</p>

<h2>How to request a refund</h2>
<ol>
<li>Email <?php echo $mailto; // phpcs:ignore WordPress.Security.EscapeOutput ?> from the address used for the purchase, or contact support through your Freemius customer account, within 30 days of the purchase date.</li>
<li>Include your order or licence details if you have them, and tell us briefly what did not work so we can improve (optional).</li>
<li>We process approved refunds back to the original payment method. Your bank or payment provider may take a few business days to show it.</li>
</ol>

<h2>What happens after a refund</h2>
<p>The licence is deactivated and you stop receiving Pro updates and support. The free AccessIQ plugin keeps working — you can continue to use it at no cost.</p>

<h2>Good to know</h2>
<ul>
<li>The guarantee applies to AccessIQ Pro plans (annual and lifetime). The free plugin has nothing to refund.</li>
<li>Third-party costs such as AI provider usage billed by those providers are separate and not covered.</li>
<li>If you have a problem, please contact support first — we can often fix it quickly.</li>
</ul>
<p>Questions? Email <?php echo $mailto; // phpcs:ignore WordPress.Security.EscapeOutput ?>.</p>
<?php
$refund = ob_get_clean();

	return array(
		'privacy-policy' => array( 'Privacy Policy', $privacy ),
		'terms'          => array( 'Terms of Service', $terms ),
		'refund-policy'  => array( 'Refund Policy', $refund ),
	);
}

/**
 * Create (or publish the placeholder of) the legal pages. Never overwrites a published page.
 *
 * @return array slug => post ID
 */
function aiqd_create_legal_pages() {
	$out = array();
	foreach ( aiqd_legal_pages() as $slug => $page ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $existing && 'publish' === $existing->post_status ) {
			$out[ $slug ] = (int) $existing->ID;
			continue;
		}
		$args = array(
			'post_title'   => $page[0],
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => wp_kses_post( $page[1] ),
		);
		if ( $existing ) {
			// Draft placeholder (e.g. WordPress's default Privacy Policy draft): fill and publish it.
			$args['ID'] = $existing->ID;
			$id         = wp_update_post( $args );
		} else {
			$id = wp_insert_post( $args );
		}
		if ( $id && ! is_wp_error( $id ) ) {
			$out[ $slug ] = (int) $id;
		}
	}
	return $out;
}
