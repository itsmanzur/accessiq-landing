<?php
/**
 * In-admin documentation.
 */
defined( 'ABSPATH' ) || exit;

$admin = function ( $slug ) {
	return esc_url( admin_url( 'admin.php?page=' . $slug ) );
};
$toc   = array(
	'start'    => __( 'Quick start', 'accessiq-demo' ),
	'sections' => __( 'Sections: add, reorder, edit', 'accessiq-demo' ),
	'types'    => __( 'Section types', 'accessiq-demo' ),
	'text'     => __( 'Text formats & shortcuts', 'accessiq-demo' ),
	'links'    => __( 'Links & buttons', 'accessiq-demo' ),
	'pricing'  => __( 'Pricing plans & Freemius', 'accessiq-demo' ),
	'hf'       => __( 'Header & footer (plugin or theme)', 'accessiq-demo' ),
	'design'   => __( 'Design & dark mode', 'accessiq-demo' ),
	'seo'      => __( 'SEO & LLM', 'accessiq-demo' ),
	'a11y'     => __( 'Accessibility of the page', 'accessiq-demo' ),
	'dev'      => __( 'Developer guide: new section types', 'accessiq-demo' ),
	'hooks'    => __( 'Hooks & template overrides', 'accessiq-demo' ),
	'trouble'  => __( 'Troubleshooting', 'accessiq-demo' ),
);
?>
<div class="aiqda-docwrap">
	<aside class="aiqda-toc">
		<label class="screen-reader-text" for="aiqda-doc-search"><?php esc_html_e( 'Search the docs', 'accessiq-demo' ); ?></label>
		<input type="search" id="aiqda-doc-search" placeholder="<?php esc_attr_e( 'Search docs…', 'accessiq-demo' ); ?>">
		<ul>
			<?php foreach ( $toc as $id => $label ) : ?>
				<li><a href="#<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</aside>

	<article class="aiqda-doc">
		<section id="start">
			<h2><?php echo esc_html( $toc['start'] ); ?></h2>
			<ol>
				<li><?php esc_html_e( 'Activate the plugin. It creates a page called “AccessIQ” and assigns it as the landing page automatically.', 'accessiq-demo' ); ?></li>
				<li><?php printf( /* translators: %s link */ esc_html__( 'Open %s to see the order of sections. Drag a row (or use the arrows) to reorder; use the eye switch to hide a section.', 'accessiq-demo' ), '<a href="' . $admin( 'aiqd-builder' ) . '">' . esc_html__( 'Page Builder', 'accessiq-demo' ) . '</a>' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></li>
				<li><?php esc_html_e( 'Click a section to edit its text. Everything on the page — headings, cards, tables, FAQ — is data in a form.', 'accessiq-demo' ); ?></li>
				<li><?php printf( /* translators: %s: link to Pricing Plans */ esc_html__( 'Set prices and Freemius plan IDs in %s.', 'accessiq-demo' ), '<a href="' . $admin( 'aiqd-pricing' ) . '">' . esc_html__( 'Pricing Plans', 'accessiq-demo' ) . '</a>' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></li>
				<li><?php printf( /* translators: %s: link to Links & Buttons */ esc_html__( 'Change any button destination in %s — it updates every button that uses that link.', 'accessiq-demo' ), '<a href="' . $admin( 'aiqd-links' ) . '">' . esc_html__( 'Links & Buttons', 'accessiq-demo' ) . '</a>' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></li>
				<li><?php esc_html_e( 'Before going live turn off “noindex” in SEO & LLM and set a social image.', 'accessiq-demo' ); ?></li>
			</ol>
		</section>

		<section id="sections">
			<h2><?php echo esc_html( $toc['sections'] ); ?></h2>
			<p><?php esc_html_e( 'The body of the page is an ordered list of independent sections. Each has a type (hero, pricing, FAQ…), its own data, and style options.', 'accessiq-demo' ); ?></p>
			<ul>
				<li><strong><?php esc_html_e( 'Reorder', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'drag the handle, or use the up / down buttons (keyboard friendly).', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Add between', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'press the “+” between two rows to insert a new section exactly there. You can add the same type many times (two CTA banners, three content blocks…).', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Hide', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'the eye switch removes a section from the page (and from SEO data) without deleting it.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Duplicate / delete / reset', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'available in the row menu and the editor. Reset restores a section’s original sample content.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Anchor ID', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'the #id of a section (e.g. pricing). Menu items and buttons can link to #pricing. Changing an anchor? Update the links that point to it.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Style', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'background (soft panel, gradient glow, dotted grid, always dark), vertical spacing, hide on mobile/desktop, extra CSS class, side-navigation label.', 'accessiq-demo' ); ?></li>
			</ul>
			<p><?php esc_html_e( 'Changes are saved with the Save button; the live preview below the editor reloads after saving.', 'accessiq-demo' ); ?></p>
		</section>

		<section id="types">
			<h2><?php echo esc_html( $toc['types'] ); ?></h2>
			<table class="widefat striped">
				<thead><tr><th><?php esc_html_e( 'Section', 'accessiq-demo' ); ?></th><th><?php esc_html_e( 'What it is', 'accessiq-demo' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( AIQD_Registry::instance()->body_types() as $slug => $t ) : ?>
					<tr><td><strong><?php echo esc_html( $t['label'] ); ?></strong><br><code><?php echo esc_html( $slug ); ?></code></td><td><?php echo esc_html( $t['desc'] ); ?></td></tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</section>

		<section id="text">
			<h2><?php echo esc_html( $toc['text'] ); ?></h2>
			<table class="widefat striped">
				<tbody>
					<tr><td><code>[[words]]</code></td><td><?php esc_html_e( 'Gradient-highlighted words in headings and intro text.', 'accessiq-demo' ); ?></td></tr>
					<tr><td><code>**bold**</code></td><td><?php esc_html_e( 'Bold text.', 'accessiq-demo' ); ?></td></tr>
					<tr><td><code>`code`</code></td><td><?php esc_html_e( 'Inline code.', 'accessiq-demo' ); ?></td></tr>
					<tr><td><?php esc_html_e( 'One per line', 'accessiq-demo' ); ?></td><td><?php esc_html_e( 'Fields labelled “one per line” (bullets, tags, promises) turn each line into a list item.', 'accessiq-demo' ); ?></td></tr>
					<tr><td><code>tier|Title|Description</code></td><td><?php esc_html_e( 'Feature grid cards. tier = free, pro, agency, new or soon (becomes the badge).', 'accessiq-demo' ); ?></td></tr>
					<tr><td><code>Feature | yes | no | Pro | ~Partial</code></td><td><?php esc_html_e( 'Comparison tables. yes = ✓, no = ✕, Pro / Agency = badge, ~text = orange partial cell, anything else = text. A line starting with # is a group heading.', 'accessiq-demo' ); ?></td></tr>
					<tr><td><code>severity|category|rule|element|fix</code></td><td><?php esc_html_e( 'Hero scanner issues. severity: critical, serious, moderate. category: Images, Contrast, Headings, ARIA or Forms.', 'accessiq-demo' ); ?></td></tr>
					<tr><td><code>/path | sessions | time | bounce | device</code></td><td><?php esc_html_e( 'Analytics demo table rows.', 'accessiq-demo' ); ?></td></tr>
				</tbody>
			</table>
		</section>

		<section id="links">
			<h2><?php echo esc_html( $toc['links'] ); ?></h2>
			<p><?php esc_html_e( 'Every link field accepts three things:', 'accessiq-demo' ); ?></p>
			<ul>
				<li><code>@download_free</code> — <?php esc_html_e( 'a saved link from Links & Buttons. Edit it once and every button using it changes.', 'accessiq-demo' ); ?></li>
				<li><code>#pricing</code> — <?php esc_html_e( 'a section anchor on the same page.', 'accessiq-demo' ); ?></li>
				<li><code>https://example.com/…</code>, <code>/relative</code>, <code>mailto:</code>, <code>tel:</code> — <?php esc_html_e( 'any URL. External links open in a new tab with rel=noopener automatically.', 'accessiq-demo' ); ?></li>
			</ul>
			<p><?php esc_html_e( 'Add your own keys (e.g. @webinar) on the Links screen, then type @webinar in any link field — the field offers autocomplete.', 'accessiq-demo' ); ?></p>
		</section>

		<section id="pricing">
			<h2><?php echo esc_html( $toc['pricing'] ); ?></h2>
			<p><?php esc_html_e( 'Plans live in one place and the Pricing section simply displays them. Four plans are preconfigured: Free, Starter, Pro (featured) and Agency, with the Freemius plan and pricing IDs.', 'accessiq-demo' ); ?></p>
			<ul>
				<li><strong><?php esc_html_e( 'Add / remove / reorder plans', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'the grid adapts to the number of plans.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Prices', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'annual price (per year) and lifetime price (one-time). The Annual / Lifetime toggle switches every price, the label and the checkout billing cycle.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Freemius plan ID', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'paste the real ID when you have it. The button opens the Freemius overlay checkout (needs the public key in Settings; with no key it falls back to the hosted checkout link)', 'accessiq-demo' ); ?> <code>https://checkout.freemius.com/plugin/{product id}/plan/{plan id}/?billing_cycle=annual&amp;licenses=N</code> (fallback) <?php esc_html_e( 'The product ID and public key are in Settings; the pricing ID is per plan. The toggle passes billing_cycle annual or lifetime. After purchase the visitor is sent to the success URL (Settings).', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Custom button link', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'if filled, it overrides the Freemius link (use @download_free for the free plan).', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Feature lines', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'plain = included; “-” prefix = not included; “!” prefix = highlighted.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Comparison matrix', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'one row per line: Label | cell for plan 1 | cell for plan 2 … in the same order as the plans. Use # for groups.', 'accessiq-demo' ); ?></li>
			</ul>
			<p><?php esc_html_e( 'Prices also feed the JSON-LD offers and llms.txt, so search engines and AI assistants always see the same numbers.', 'accessiq-demo' ); ?></p>
		</section>

		<section id="hf">
			<h2><?php echo esc_html( $toc['hf'] ); ?></h2>
			<p><?php printf( /* translators: %s: link to Settings */ esc_html__( 'In %s choose where the header and footer come from:', 'accessiq-demo' ), '<a href="' . $admin( 'aiqd-settings' ) . '">' . esc_html__( 'Settings', 'accessiq-demo' ) . '</a>' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
			<ul>
				<li><strong><?php esc_html_e( 'This plugin', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'the designed Header and Footer (edit in Header & Footer).', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Active theme', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'classic themes via get_header()/get_footer(); block themes via their header and footer template parts.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Nothing', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'a clean canvas. You can mix: plugin header + theme footer, and so on.', 'accessiq-demo' ); ?></li>
			</ul>
		</section>

		<section id="design">
			<h2><?php echo esc_html( $toc['design'] ); ?></h2>
			<p><?php esc_html_e( 'The Design screen controls the CSS variables used everywhere: primary / accent colours, radius, width, font style and motion. Visitors get a light / dark toggle (remembered in their browser). Pick a default theme or let it follow their operating system.', 'accessiq-demo' ); ?></p>
			<p><?php esc_html_e( 'Buttons use dark text on the primary colour, so choose a mid/light primary to keep contrast above 4.5:1. Custom CSS is loaded last — scope it with .aiqd-root.', 'accessiq-demo' ); ?></p>
		</section>

		<section id="seo">
			<h2><?php echo esc_html( $toc['seo'] ); ?></h2>
			<ul>
				<li><?php esc_html_e( 'Semantic HTML: one H1 (hero), H2 per section, landmarks (header, main, footer, nav), sections labelled by their headings, real tables and details/summary — all rendered on the server, no JavaScript needed to read the content.', 'accessiq-demo' ); ?></li>
				<li><?php esc_html_e( 'Meta title / description, canonical, Open Graph and Twitter cards (skipped automatically when Yoast, Rank Math, AIOSEO or SEOPress is active).', 'accessiq-demo' ); ?></li>
				<li><?php esc_html_e( 'JSON-LD @graph: Organization, WebSite, WebPage, SoftwareApplication (with featureList from the modules and one Offer per plan), FAQPage from the FAQ section, HowTo from the steps section, BreadcrumbList.', 'accessiq-demo' ); ?></li>
				<li><code>/llms.txt</code> <?php esc_html_e( 'and', 'accessiq-demo' ); ?> <code>/llms-full.txt</code> — <?php esc_html_e( 'generated from the same data (modules, plans, FAQ, links) for AI assistants. If you get a 404, save Settings → Permalinks once and clear your cache.', 'accessiq-demo' ); ?></li>
				<li><?php esc_html_e( 'robots.txt: optional allow-rules for GPTBot, ClaudeBot, PerplexityBot, Google-Extended and others, plus a pointer to llms.txt.', 'accessiq-demo' ); ?></li>
				<li><?php esc_html_e( 'Because everything is generated from your section data, editing a FAQ or a price updates the page, the schema and llms.txt at once.', 'accessiq-demo' ); ?></li>
			</ul>
		</section>

		<section id="a11y">
			<h2><?php echo esc_html( $toc['a11y'] ); ?></h2>
			<p><?php esc_html_e( 'A landing page for an accessibility product has to practise what it sells. Included: skip link, visible focus rings, keyboard-operable tabs / accordions / explorers with arrow keys, ARIA states (aria-selected, aria-pressed, aria-expanded), labelled controls, reduced-motion support, a pause button for the ticker, AA-contrast colours, tables with headers and captions, and decorative visuals hidden from screen readers while the same facts exist as text.', 'accessiq-demo' ); ?></p>
			<p><?php esc_html_e( 'When you add images in the Text + image block always fill the alt text.', 'accessiq-demo' ); ?></p>
		</section>

		<section id="dev">
			<h2><?php echo esc_html( $toc['dev'] ); ?></h2>
			<p><?php esc_html_e( 'A section type is a folder. Create sections/my-type/ with two files and it appears in “Add section” — no other registration.', 'accessiq-demo' ); ?></p>
<pre class="aiqda-pre">accessiq-demo/sections/my-type/config.php
accessiq-demo/sections/my-type/template.php</pre>
<pre class="aiqda-pre">&lt;?php // config.php
return array(
  'label'    =&gt; 'My block',
  'icon'     =&gt; 'sparkles',          // any name from the icon list
  'desc'     =&gt; 'What it does',
  'wide'     =&gt; false,                // true = full-bleed (no container)
  'defaults' =&gt; array( 'title' =&gt; 'Hello', 'items' =&gt; array() ),
  'schema'   =&gt; array_merge(
    AIQD_Registry::head_fields(),       // eyebrow, title, subtitle
    array(
      array( 'key' =&gt; 'items', 'type' =&gt; 'repeater', 'item_label' =&gt; 'name',
             'fields' =&gt; array(
               array( 'key' =&gt; 'name', 'type' =&gt; 'text', 'label' =&gt; 'Name' ),
             ) ),
    )
  ),
);</pre>
<pre class="aiqda-pre">&lt;?php // template.php  — variables: $d (data), $s (uid, anchor, style)
aiqd_head( $d, $s, 'is-center' );
foreach ( $d['items'] as $it ) {
  echo '&lt;p&gt;' . esc_html( $it['name'] ) . '&lt;/p&gt;';
}</pre>
			<h3><?php esc_html_e( 'Field types', 'accessiq-demo' ); ?></h3>
			<p><code>text</code> <code>textarea</code> <code>richtext</code> <code>lines</code> <code>link</code> <code>select</code> <code>toggle</code> <code>number</code> <code>color</code> <code>icon</code> <code>image</code> <code>repeater</code> <code>code</code> <code>css</code> <code>notice</code></p>
			<p><?php esc_html_e( 'Helpers: aiqd_head(), aiqd_btn( label, link, classes, icon ), aiqd_icon( name ), aiqd_hl( text ), aiqd_link( value ), aiqd_lines( text ), aiqd_badge( tier ), aiqd_ring( score ).', 'accessiq-demo' ); ?></p>
		</section>

		<section id="hooks">
			<h2><?php echo esc_html( $toc['hooks'] ); ?></h2>
			<table class="widefat striped"><tbody>
				<tr><td><code>aiqd_section_types</code></td><td><?php esc_html_e( 'Filter: add or change section types programmatically.', 'accessiq-demo' ); ?></td></tr>
				<tr><td><code>yourtheme/accessiq-demo/sections/{type}.php</code></td><td><?php esc_html_e( 'Copy a section template here to override its HTML from your theme.', 'accessiq-demo' ); ?></td></tr>
				<tr><td><code>[accessiq_demo]</code>, <code>[accessiq_section type=""]</code></td><td><?php esc_html_e( 'Shortcodes to embed the whole body or a single section.', 'accessiq-demo' ); ?></td></tr>
			</tbody></table>
		</section>

		<section id="trouble">
			<h2><?php echo esc_html( $toc['trouble'] ); ?></h2>
			<ul>
				<li><strong><?php esc_html_e( 'Page looks unstyled / sections invisible', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'clear any caching or minify plugin; make sure the page is the assigned landing page or contains the shortcode.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'llms.txt shows a 404', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'save Settings → Permalinks and confirm “Serve llms.txt” is on.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Theme header appears twice', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'set Header comes from → Active theme (or Nothing) so only one header renders.', 'accessiq-demo' ); ?></li>
				<li><strong><?php esc_html_e( 'Start over', 'accessiq-demo' ); ?></strong> — <?php esc_html_e( 'Import / Export → Reset everything restores all sample content.', 'accessiq-demo' ); ?></li>
			</ul>
		</section>
	</article>
</div>
