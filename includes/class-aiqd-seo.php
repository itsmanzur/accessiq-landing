<?php
/**
 * SEO + LLM layer: meta tags, Open Graph, JSON-LD (@graph), llms.txt / llms-full.txt, robots hints.
 * Every value is generated from the same section data the page renders, so the markup,
 * the structured data and llms.txt can never drift apart.
 *
 * @package AccessIQDemo
 */

defined( 'ABSPATH' ) || exit;

class AIQD_SEO {

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_filter( 'pre_get_document_title', array( $this, 'title' ), 20 );
		add_action( 'wp_head', array( $this, 'head' ), 1 );
		add_filter( 'wp_robots', array( $this, 'robots' ) );
		add_filter( 'robots_txt', array( $this, 'robots_txt' ), 20, 2 );
		add_action( 'init', array( $this, 'maybe_serve_llms' ), 0 );
	}

	private function is_landing() {
		return AIQD_Render::instance()->is_landing();
	}

	/**
	 * Does another SEO plugin own the meta tags?
	 */
	private function other_seo_plugin() {
		return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
	}

	public function title( $title ) {
		if ( ! $this->is_landing() || $this->other_seo_plugin() ) {
			return $title;
		}
		$seo = AIQD_Store::seo();
		return $seo['title'] ? $seo['title'] : $title;
	}

	public function robots( $robots ) {
		if ( AIQD_Render::instance()->is_thankyou() ) {
			$robots['noindex']  = true;
			$robots['nofollow'] = true;
		} elseif ( $this->is_landing() && AIQD_Store::seo()['noindex'] ) {
			$robots['noindex']  = true;
			$robots['nofollow'] = true;
			unset( $robots['max-image-preview'] );
		} elseif ( $this->is_landing() ) {
			$robots['max-image-preview'] = 'large';
			$robots['max-snippet']       = '-1';
		}
		return $robots;
	}

	/**
	 * Output meta + JSON-LD.
	 */
	public function head() {
		if ( ! $this->is_landing() ) {
			return;
		}
		$seo = AIQD_Store::seo();
		$url = get_permalink();
		$img = self::og_image();
		echo "\n<!-- AccessIQ Landing SEO -->\n";
		if ( ! $this->other_seo_plugin() ) {
			echo '<meta name="description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";
			if ( $seo['keywords'] ) {
				echo '<meta name="keywords" content="' . esc_attr( $seo['keywords'] ) . '">' . "\n";
			}
			echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
			echo '<meta property="og:type" content="website">' . "\n";
			echo '<meta property="og:site_name" content="' . esc_attr( AIQD_Store::setting( 'brand_name', 'AccessIQ' ) ) . '">' . "\n";
			echo '<meta property="og:title" content="' . esc_attr( $seo['title'] ) . '">' . "\n";
			echo '<meta property="og:description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";
			echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
			if ( $img ) {
				echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
				if ( empty( $seo['og_image'] ) ) {
					echo '<meta property="og:image:width" content="1200">' . "\n" . '<meta property="og:image:height" content="630">' . "\n";
				}
				echo '<meta property="og:image:alt" content="' . esc_attr( $seo['title'] ) . '">' . "\n";
			}
			echo '<meta name="twitter:card" content="' . ( $img ? 'summary_large_image' : 'summary' ) . '">' . "\n";
			echo '<meta name="twitter:title" content="' . esc_attr( $seo['title'] ) . '">' . "\n";
			echo '<meta name="twitter:description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";
			if ( $seo['twitter'] ) {
				echo '<meta name="twitter:site" content="@' . esc_attr( ltrim( $seo['twitter'], '@' ) ) . '">' . "\n";
			}
			if ( $img ) {
				echo '<meta name="twitter:image" content="' . esc_url( $img ) . '">' . "\n";
			}
		}
		if ( $seo['llms'] ) {
			echo '<link rel="alternate" type="text/plain" href="' . esc_url( home_url( '/llms.txt' ) ) . '" title="llms.txt">' . "\n";
		}
		if ( $seo['schema'] ) {
			echo '<script type="application/ld+json">' . wp_json_encode( $this->graph(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo "<!-- /AccessIQ Landing SEO -->\n";
	}

	/**
	 * Social image: the one set in SEO & LLM, otherwise the bundled 1200×630 card.
	 */
	public static function og_image() {
		$img = AIQD_Store::seo()['og_image'];
		return $img ? $img : AIQD_URL . 'assets/img/og-image.png';
	}

	/**
	 * First enabled section data of a type.
	 */
	public static function section( $type ) {
		foreach ( AIQD_Store::layout() as $inst ) {
			if ( $inst['type'] === $type && ! empty( $inst['enabled'] ) ) {
				return AIQD_Store::section_data( $inst );
			}
		}
		return null;
	}

	private function currency_code() {
		$map = array(
			'$' => 'USD',
			'€' => 'EUR',
			'£' => 'GBP',
			'৳' => 'BDT',
			'₹' => 'INR',
		);
		$cur = AIQD_Store::setting( 'currency', '$' );
		return isset( $map[ $cur ] ) ? $map[ $cur ] : ( preg_match( '/^[A-Z]{3}$/', $cur ) ? $cur : 'USD' );
	}

	/**
	 * JSON-LD graph.
	 */
	public function graph() {
		$seo   = AIQD_Store::seo();
		$url   = get_permalink();
		$brand = AIQD_Store::setting( 'brand_name', 'AccessIQ' );
		$logo  = AIQD_Store::setting( 'brand_logo', '' );
		$graph = array();

		$org = array(
			'@type' => 'Organization',
			'@id'   => $url . '#org',
			'name'  => $seo['org_name'],
			'url'   => $seo['org_url'] ? $seo['org_url'] : home_url( '/' ),
		);
		if ( $logo ) {
			$org['logo'] = $logo;
		}
		$same = aiqd_lines( $seo['same_as'] );
		if ( $same ) {
			$org['sameAs'] = $same;
		}
		$graph[] = $org;

		$graph[] = array(
			'@type'     => 'WebSite',
			'@id'       => home_url( '/' ) . '#website',
			'url'       => home_url( '/' ),
			'name'      => get_bloginfo( 'name' ),
			'inLanguage' => get_bloginfo( 'language' ),
		);

		$graph[] = array(
			'@type'           => 'WebPage',
			'@id'             => $url . '#webpage',
			'url'             => $url,
			'name'            => $seo['title'],
			'description'     => $seo['description'],
			'isPartOf'        => array( '@id' => home_url( '/' ) . '#website' ),
			'about'           => array( '@id' => $url . '#software' ),
			'inLanguage'      => get_bloginfo( 'language' ),
			'dateModified'    => get_post_modified_time( 'c', true ),
		);

		// SoftwareApplication with offers + featureList.
		$features = array();
		$modules  = self::section( 'modules' );
		if ( $modules ) {
			foreach ( (array) $modules['modules'] as $m ) {
				$features[] = $m['name'] . ' — ' . $m['tagline'];
			}
		}
		$offers = array();
		foreach ( AIQD_Store::plans() as $p ) {
			$price    = (float) $p['price_annual'];
			$offers[] = array(
				'@type'           => 'Offer',
				'name'            => $p['name'],
				'description'     => $p['tagline'],
				'price'           => number_format( $price, 2, '.', '' ),
				'priceCurrency'   => $this->currency_code(),
				'availability'    => 'https://schema.org/InStock',
				'url'             => ! empty( $p['is_free'] ) ? aiqd_link( '@download_free' )['url'] : AIQD_Store::plan_url( $p, 'annual' ),
				'priceSpecification' => array(
					'@type'         => 'UnitPriceSpecification',
					'price'         => number_format( $price, 2, '.', '' ),
					'priceCurrency' => $this->currency_code(),
					'billingDuration' => 'P1Y',
				),
			);
			if ( empty( $p['is_free'] ) && (float) $p['price_lifetime'] > 0 ) {
				$offers[] = array(
					'@type'         => 'Offer',
					'name'          => $p['name'] . ' (lifetime)',
					'description'   => $p['tagline'],
					'price'         => number_format( (float) $p['price_lifetime'], 2, '.', '' ),
					'priceCurrency' => $this->currency_code(),
					'availability'  => 'https://schema.org/InStock',
					'url'           => AIQD_Store::plan_url( $p, 'lifetime' ),
				);
			}
		}
		$app = array(
			'@type'               => 'SoftwareApplication',
			'@id'                 => $url . '#software',
			'name'                => $brand,
			'applicationCategory' => $seo['app_category'],
			'operatingSystem'     => $seo['os'],
			'description'         => $seo['description'],
			'url'                 => $url,
			'downloadUrl'         => aiqd_link( '@download_free' )['url'],
			'publisher'           => array( '@id' => $url . '#org' ),
			'offers'              => $offers,
		);
		if ( $features ) {
			$app['featureList'] = $features;
		}
		$app['image'] = self::og_image();
		$graph[] = $app;

		// FAQPage.
		$faq = self::section( 'faq' );
		if ( $faq && ! empty( $faq['items'] ) ) {
			$qs = array();
			foreach ( (array) $faq['items'] as $it ) {
				if ( '' === trim( $it['q'] ) ) {
					continue;
				}
				$qs[] = array(
					'@type'          => 'Question',
					'name'           => $it['q'],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => aiqd_plain( $it['a'] ),
					),
				);
			}
			if ( $qs ) {
				$graph[] = array(
					'@type'      => 'FAQPage',
					'@id'        => $url . '#faq',
					'mainEntity' => $qs,
				);
			}
		}

		// HowTo.
		$how = self::section( 'how' );
		if ( $how && ! empty( $how['steps'] ) ) {
			$steps = array();
			foreach ( array_values( (array) $how['steps'] ) as $i => $st ) {
				$steps[] = array(
					'@type'    => 'HowToStep',
					'position' => $i + 1,
					'name'     => $st['title'],
					'text'     => $st['text'],
					'url'      => $url . '#how',
				);
			}
			$graph[] = array(
				'@type' => 'HowTo',
				'@id'   => $url . '#howto',
				'name'  => aiqd_plain( $how['title'] ),
				'step'  => $steps,
			);
		}

		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => array(
				array(
					'@type'    => 'ListItem',
					'position' => 1,
					'name'     => 'Home',
					'item'     => home_url( '/' ),
				),
				array(
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => $brand,
					'item'     => $url,
				),
			),
		);

		return array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		);
	}

	/* ───────────── llms.txt ───────────── */

	public function maybe_serve_llms() {
		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return;
		}
		$path = wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );
		$home = rtrim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
		$path = '/' . ltrim( substr( (string) $path, strlen( $home ) ), '/' );
		if ( '/llms.txt' !== $path && '/llms-full.txt' !== $path ) {
			return;
		}
		if ( ! AIQD_Store::seo()['llms'] ) {
			return;
		}
		$full = '/llms-full.txt' === $path;
		nocache_headers();
		header( 'Content-Type: text/plain; charset=utf-8' );
		header( 'X-Robots-Tag: noindex' );
		echo $this->llms( $full ); // phpcs:ignore WordPress.Security.EscapeOutput -- plain text.
		exit;
	}

	/**
	 * Build llms.txt (summary) or llms-full.txt (everything).
	 */
	public function llms( $full = false ) {
		$seo   = AIQD_Store::seo();
		$brand = AIQD_Store::setting( 'brand_name', 'AccessIQ' );
		$page  = (int) AIQD_Store::setting( 'page_id', 0 );
		$url   = $page ? get_permalink( $page ) : home_url( '/' );
		$cur   = AIQD_Store::setting( 'currency', '$' );
		$o     = array();

		$o[] = '# ' . $brand;
		$o[] = '';
		$o[] = '> ' . $seo['description'];
		$o[] = '';
		$o[] = $seo['llms_intro'];
		$o[] = '';
		$o[] = 'Canonical page: ' . $url;
		$o[] = '';

		$modules = self::section( 'modules' );
		if ( $modules ) {
			$o[] = '## Modules';
			$o[] = '';
			foreach ( (array) $modules['modules'] as $m ) {
				$line = '- **' . $m['name'] . '** (' . strtoupper( $m['tier'] ) . '): ' . $m['tagline'];
				if ( $full ) {
					$line .= ' ' . $m['desc'];
				}
				$o[] = $line;
				if ( $full ) {
					foreach ( aiqd_lines( $m['bullets'] ) as $b ) {
						$o[] = '  - ' . $b;
					}
					if ( $m['where'] ) {
						$o[] = '  - Location: ' . $m['where'];
					}
				}
			}
			$o[] = '';
		}

		if ( $full ) {
			$feat = self::section( 'features' );
			if ( $feat ) {
				$o[] = '## Feature checklist';
				$o[] = '';
				foreach ( (array) $feat['tabs'] as $t ) {
					$o[] = '### ' . $t['label'];
					foreach ( aiqd_lines( $t['cards'] ) as $ln ) {
						$p   = array_pad( array_map( 'trim', explode( '|', $ln, 3 ) ), 3, '' );
						$o[] = '- [' . strtoupper( $p[0] ) . '] ' . $p[1] . ': ' . $p[2];
					}
					$o[] = '';
				}
			}
		}

		$o[] = '## Pricing';
		$o[] = '';
		foreach ( AIQD_Store::plans() as $p ) {
			$line = '- **' . $p['name'] . '**: ';
			if ( ! empty( $p['is_free'] ) ) {
				$line .= 'free';
			} else {
				$line .= aiqd_money( $p['price_annual'], $cur ) . '/year or ' . aiqd_money( $p['price_lifetime'], $cur ) . ' lifetime';
			}
			$line .= ' — ' . $p['sites'] . '. ' . $p['tagline'];
			$o[]   = $line;
			if ( $full ) {
				foreach ( AIQD_Render::parse_features( $p['features'] ) as $f ) {
					$o[] = '  - ' . ( $f['inc'] ? '' : 'Not included: ' ) . $f['text'];
				}
			}
		}
		$o[] = '';

		$faq = self::section( 'faq' );
		if ( $faq ) {
			$o[] = '## FAQ';
			$o[] = '';
			foreach ( (array) $faq['items'] as $it ) {
				$o[] = '### ' . $it['q'];
				$o[] = aiqd_plain( $it['a'] );
				$o[] = '';
			}
		}

		$o[]   = '## Links';
		$o[]   = '';
		$links = AIQD_Store::links();
		foreach ( array( 'download_free', 'docs', 'support', 'changelog', 'live_demo' ) as $k ) {
			if ( isset( $links[ $k ] ) && preg_match( '#^https?://#', $links[ $k ]['url'] ) ) {
				$o[] = '- [' . $links[ $k ]['label'] . '](' . $links[ $k ]['url'] . ')';
			}
		}
		$o[] = '';
		$o[] = '## Notes for AI assistants';
		$o[] = '';
		$o[] = '- Automated accessibility checks cover a subset of WCAG and cannot prove conformance; do not describe the product as guaranteeing legal compliance.';
		$o[] = '- Core features run on the site owner\'s own server; no scan, click or session data is sent to third parties.';
		$o[] = '- Prices on this page may be sample data; confirm on the checkout page.';

		return implode( "\n", $o ) . "\n";
	}

	/**
	 * Allow AI crawlers and advertise llms.txt.
	 */
	public function robots_txt( $output, $public ) {
		$seo = AIQD_Store::seo();
		if ( ! $public ) {
			return $output;
		}
		if ( $seo['ai_bots'] ) {
			$output .= "\n# AccessIQ Landing: allow AI search and assistant crawlers on the public landing page\n";
			foreach ( array( 'GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-User', 'anthropic-ai', 'PerplexityBot', 'Google-Extended', 'Applebot-Extended' ) as $bot ) {
				$output .= 'User-agent: ' . $bot . "\nAllow: /\n";
			}
		}
		if ( $seo['llms'] ) {
			$output .= "\n# LLM-friendly summary: " . home_url( '/llms.txt' ) . "\n";
		}
		return $output;
	}

	/**
	 * Simple SEO health checks used by the dashboard.
	 *
	 * @return array list of [ level(ok|warn|bad), label, hint ]
	 */
	public static function audit() {
		$seo    = AIQD_Store::seo();
		$checks = array();
		$tl     = mb_strlen( $seo['title'] );
		$dl     = mb_strlen( $seo['description'] );
		$checks[] = array( ( $tl >= 30 && $tl <= 65 ) ? 'ok' : 'warn', sprintf( /* translators: %d characters */ __( 'Title length: %d chars', 'accessiq-demo' ), $tl ), __( 'Aim for 30–65 characters.', 'accessiq-demo' ) );
		$checks[] = array( ( $dl >= 80 && $dl <= 170 ) ? 'ok' : 'warn', sprintf( /* translators: %d characters */ __( 'Meta description: %d chars', 'accessiq-demo' ), $dl ), __( 'Aim for 80–170 characters.', 'accessiq-demo' ) );
		$checks[] = array( 'ok', __( 'Social share image (og:image)', 'accessiq-demo' ), __( 'Bundled 1200×630 card is used; upload your own in SEO & LLM to override.', 'accessiq-demo' ) );
		$checks[] = array( $seo['schema'] ? 'ok' : 'bad', __( 'JSON-LD structured data', 'accessiq-demo' ), __( 'Organization, SoftwareApplication + Offers, FAQPage, HowTo, Breadcrumb.', 'accessiq-demo' ) );
		$checks[] = array( $seo['llms'] ? 'ok' : 'warn', __( 'llms.txt / llms-full.txt', 'accessiq-demo' ), __( 'LLM-readable summary served at /llms.txt.', 'accessiq-demo' ) );
		$checks[] = array( $seo['noindex'] ? 'bad' : 'ok', __( 'Search engines allowed to index', 'accessiq-demo' ), __( 'Turn off "noindex" before launch.', 'accessiq-demo' ) );
		$h1 = 0;
		$faq = false;
		foreach ( AIQD_Store::layout() as $inst ) {
			if ( empty( $inst['enabled'] ) ) {
				continue;
			}
			if ( 'hero' === $inst['type'] ) {
				$h1++;
			}
			if ( 'faq' === $inst['type'] ) {
				$faq = true;
			}
		}
		$checks[] = array( 1 === $h1 ? 'ok' : 'bad', sprintf( /* translators: %d count */ __( 'H1 headings (hero sections): %d', 'accessiq-demo' ), $h1 ), __( 'Exactly one hero section should be enabled.', 'accessiq-demo' ) );
		$checks[] = array( $faq ? 'ok' : 'warn', __( 'FAQ section enabled', 'accessiq-demo' ), __( 'Powers FAQPage rich results and AI answers.', 'accessiq-demo' ) );
		$page_id  = (int) AIQD_Store::setting( 'page_id', 0 );
		$checks[] = array( ( $page_id && 'publish' === get_post_status( $page_id ) ) ? 'ok' : 'bad', __( 'Landing page assigned and published', 'accessiq-demo' ), __( 'Choose it in Settings.', 'accessiq-demo' ) );
		return $checks;
	}
}
