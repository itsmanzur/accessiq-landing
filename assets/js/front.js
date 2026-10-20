/**
 * AccessIQ Landing — front-end behaviour (vanilla JS, no dependencies).
 * Every interactive block is progressive enhancement: the HTML is complete without JS.
 */
(function () {
	'use strict';

	var D = document;
	var W = window;
	var cfg = W.AIQD || { motion: 'on', i18n: {} };

	/**
	 * Freemius checkout config — single place for the IDs.
	 * Values are filled from PHP (AccessIQ Landing → Settings for product_id / public_key / success_url,
	 * Pricing Plans for each plan_id / pricing_id). Defaults below mirror the live Freemius setup.
	 */
	var CHECKOUT = Object.assign({
		ready: false,
		product_id: '28875',
		public_key: 'pk_71c98e72e08a3d09f9d883cf36bbe', // overridden from PHP settings
		name: 'AccessIQ Pro',
		success_url: '/thank-you/',
		plans: {
			starter: { plan_id: '47504', pricing_id: '61847' },
			pro: { plan_id: '73426', pricing_id: '106766' },
			agency: { plan_id: '73427', pricing_id: '106767' }
		}
	}, cfg.checkout || {});
	var t = cfg.i18n || {};
	var reduce = (W.matchMedia && W.matchMedia('(prefers-reduced-motion: reduce)').matches) || cfg.motion === 'off';

	function $(s, c) { return (c || D).querySelector(s); }
	function $$(s, c) { return Array.prototype.slice.call((c || D).querySelectorAll(s)); }
	function clamp(n, a, b) { return Math.max(a, Math.min(b, n)); }
	function ease(x) { return 1 - Math.pow(1 - x, 3); }
	function fmt(n) { return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','); }
	function css(root, name) { return getComputedStyle(root).getPropertyValue(name).trim(); }

	function animate(dur, step, done) {
		if (reduce) { step(1); if (done) { done(); } return; }
		var s = null;
		function f(ts) {
			if (s === null) { s = ts; }
			var p = clamp((ts - s) / dur, 0, 1);
			step(ease(p));
			if (p < 1) { requestAnimationFrame(f); } else if (done) { done(); }
		}
		requestAnimationFrame(f);
	}

	function countTo(el, target, dur) {
		var dec = (String(target).split('.')[1] || '').length;
		animate(dur || 1400, function (p) {
			var v = target * p;
			el.textContent = dec ? v.toFixed(dec) : fmt(v);
		});
	}

	function onVisible(el, cb, opts) {
		if (!('IntersectionObserver' in W)) { cb(); return; }
		var io = new IntersectionObserver(function (es) {
			es.forEach(function (e) {
				if (e.isIntersecting) { io.unobserve(e.target); cb(e.target); }
			});
		}, opts || { threshold: 0.2 });
		io.observe(el);
	}

	/* ───────────── per-root init ───────────── */
	$$('.aiqd-root').forEach(init);

	function init(root) {
		root.classList.add('aiqd-js');
		reveal(root);
		counters(root);
		rings(root);
		header(root);
		floaters(root);
		ticker(root);
		cards(root);
		floatParallax(root);
		tabs(root);
		scanner(root);
		modules(root);
		widgetDemo(root);
		heatDemo(root);
		analytics(root);
		billing(root);
		faq(root);
		calc(root);
		steps(root);
		anchors(root);
	}

	/* reveal */
	function reveal(root) {
		var els = $$('.aiqd-reveal', root);
		if (!('IntersectionObserver' in W) || reduce) { els.forEach(function (e) { e.classList.add('is-in'); }); return; }
		var io = new IntersectionObserver(function (es) {
			es.forEach(function (e) {
				if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); }
			});
		}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
		els.forEach(function (e) { io.observe(e); });
		// Safety net (jump-scrolls, throttled tabs): reveal anything already inside or above the viewport.
		var pending = els.slice();
		var sweeping = false;
		function sweep() {
			sweeping = false;
			pending = pending.filter(function (e) {
				if (e.classList.contains('is-in')) { return false; }
				if (e.getBoundingClientRect().top < W.innerHeight - 20) { e.classList.add('is-in'); return false; }
				return true;
			});
		}
		function queue() { if (!sweeping) { sweeping = true; requestAnimationFrame(sweep); } }
		W.addEventListener('scroll', queue, { passive: true });
		W.addEventListener('resize', queue);
		setTimeout(sweep, 1200);
	}

	function counters(root) {
		$$('[data-count-to]', root).forEach(function (el) {
			if (el.closest('.aiqd-ring')) { return; }
			var target = parseFloat(el.getAttribute('data-count-to'));
			if (isNaN(target)) { return; }
			onVisible(el, function () { countTo(el, target, 1500); });
		});
	}

	function ringAnimate(ring) {
		var fg = $('.aiqd-ring__fg', ring);
		var num = $('[data-count-to]', ring);
		if (!fg) { return; }
		var c = parseFloat(fg.getAttribute('stroke-dasharray'));
		var off = fg.getAttribute('data-offset');
		if (reduce) { fg.style.strokeDashoffset = off; return; }
		fg.style.transition = 'none';
		fg.style.strokeDashoffset = c;
		void fg.getBoundingClientRect();
		fg.style.transition = '';
		requestAnimationFrame(function () { fg.style.strokeDashoffset = off; });
		if (num) { countTo(num, parseFloat(num.getAttribute('data-count-to')), 1200); }
	}

	function rings(root) {
		$$('[data-ring]', root).forEach(function (r) {
			if (r.closest('.aiqd-scan__result')) { return; }
			onVisible(r, function () { ringAnimate(r); });
		});
	}

	/* header + theme + burger + scrollspy */
	function header(root) {
		var h = $('.aiqd-header', root);
		var burger = $('.aiqd-burger', root);
		var panel = $('.aiqd-mobile-nav', root);

		function onScroll() { if (h) { h.classList.toggle('is-scrolled', W.scrollY > 12); } }
		onScroll();
		W.addEventListener('scroll', onScroll, { passive: true });

		if (burger && panel) {
			var set = function (open) {
				burger.setAttribute('aria-expanded', open ? 'true' : 'false');
				burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
				panel.hidden = !open;
			};
			burger.addEventListener('click', function () { set(burger.getAttribute('aria-expanded') !== 'true'); });
			panel.addEventListener('click', function (e) { if (e.target.closest('a')) { set(false); } });
			D.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !panel.hidden) { set(false); burger.focus(); } });
		}

		var tg = $('.aiqd-theme-toggle', root);
		if (tg) {
			tg.addEventListener('click', function () {
				var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
				root.setAttribute('data-theme', next);
				try { localStorage.setItem('aiqd-theme', next); } catch (e) { /* ignore */ }
			});
		}

		// Scrollspy + dots.
		var secs = $$('section[data-nav][id]', root);
		var dots = $('.aiqd-dots', root);
		var links = $$('.aiqd-nav a, .aiqd-mobile-nav a', root);
		if (dots) {
			secs.forEach(function (s) {
				var a = D.createElement('a');
				a.href = '#' + s.id;
				a.setAttribute('data-label', s.getAttribute('data-nav'));
				a.setAttribute('aria-label', s.getAttribute('data-nav'));
				dots.appendChild(a);
			});
		}
		if (!('IntersectionObserver' in W) || !secs.length) { return; }
		var dotLinks = dots ? $$('a', dots) : [];
		var spy = new IntersectionObserver(function (es) {
			es.forEach(function (e) {
				if (!e.isIntersecting) { return; }
				var id = e.target.id;
				links.forEach(function (a) { a.classList.toggle('is-active', a.getAttribute('href') === '#' + id); });
				dotLinks.forEach(function (a) { a.classList.toggle('is-active', a.getAttribute('href') === '#' + id); });
			});
		}, { rootMargin: '-45% 0px -50% 0px' });
		secs.forEach(function (s) { spy.observe(s); });
	}

	/* progress, back-to-top, floating CTA */
	function floaters(root) {
		var bar = $('.aiqd-progress span', root);
		var top = $('.aiqd-totop', root);
		var cta = $('.aiqd-float-cta', root);
		var ticking = false;
		function upd() {
			var max = D.documentElement.scrollHeight - W.innerHeight;
			var p = max > 0 ? W.scrollY / max : 0;
			if (bar) { bar.style.transform = 'scaleX(' + p.toFixed(4) + ')'; }
			if (top) { top.classList.toggle('is-visible', W.scrollY > 700); }
			if (cta) {
				var pricing = $('#pricing', root);
				var inPricing = false;
				if (pricing) { var r = pricing.getBoundingClientRect(); inPricing = r.top < W.innerHeight * 0.5 && r.bottom > 0; }
				cta.classList.toggle('is-visible', W.scrollY > 600 && !inPricing);
			}
			ticking = false;
		}
		W.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(upd); } }, { passive: true });
		upd();
		if (top) { top.addEventListener('click', function () { W.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' }); var m = $('#aiqd-main'); if (m) { m.focus({ preventScroll: true }); } }); }
	}

	function ticker(root) {
		$$('.aiqd-ticker', root).forEach(function (tk) {
			var b = $('.aiqd-ticker__pause', tk);
			if (!b) { return; }
			b.addEventListener('click', function () {
				var p = tk.classList.toggle('is-paused');
				b.setAttribute('aria-pressed', p ? 'true' : 'false');
				b.setAttribute('aria-label', p ? 'Resume scrolling' : 'Pause scrolling');
			});
		});
	}

	function cards(root) {
		if (!W.matchMedia || !W.matchMedia('(pointer:fine)').matches) { return; }
		$$('[data-tilt]', root).forEach(function (c) {
			c.addEventListener('pointermove', function (e) {
				var r = c.getBoundingClientRect();
				c.style.setProperty('--mx', ((e.clientX - r.left) / r.width * 100).toFixed(1) + '%');
				c.style.setProperty('--my', ((e.clientY - r.top) / r.height * 100).toFixed(1) + '%');
			});
		});
	}

	function floatParallax(root) {
		if (reduce) { return; }
		var vis = $('.aiqd-hero__visual', root);
		if (!vis) { return; }
		var chips = $$('[data-float]', vis);
		var hero = $('.aiqd-hero', root);
		hero.addEventListener('pointermove', function (e) {
			var r = hero.getBoundingClientRect();
			var nx = (e.clientX - r.left) / r.width - 0.5;
			var ny = (e.clientY - r.top) / r.height - 0.5;
			chips.forEach(function (c) {
				var d = parseFloat(c.getAttribute('data-float')) || 10;
				c.style.setProperty('--px', (nx * d * 2).toFixed(1) + 'px');
				c.style.setProperty('--py', (ny * d * 2).toFixed(1) + 'px');
			});
		});
	}

	/* generic tabs */
	function tabs(root) {
		$$('[data-aiqd-tabs]', root).forEach(function (wrap) {
			var list = $('[role="tablist"]', wrap);
			var btns = $$('[role="tab"]', list);
			function select(b, focus) {
				btns.forEach(function (x) {
					var on = x === b;
					x.setAttribute('aria-selected', on ? 'true' : 'false');
					x.tabIndex = on ? 0 : -1;
					var p = D.getElementById(x.getAttribute('aria-controls'));
					if (p) { p.hidden = !on; }
				});
				if (focus) { b.focus(); }
			}
			btns.forEach(function (b, i) {
				b.addEventListener('click', function () { select(b); });
				b.addEventListener('keydown', function (e) {
					var n = null;
					if (e.key === 'ArrowRight' || e.key === 'ArrowDown') { n = btns[(i + 1) % btns.length]; }
					if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') { n = btns[(i - 1 + btns.length) % btns.length]; }
					if (e.key === 'Home') { n = btns[0]; }
					if (e.key === 'End') { n = btns[btns.length - 1]; }
					if (n) { e.preventDefault(); select(n, true); }
				});
			});
		});
	}

	/* ───────────── hero scanner simulator ───────────── */
	function scanner(root) {
		$$('[data-aiqd-scanner]', root).forEach(function (box) {
			var tabsEl = $$('[role="tab"]', box);
			var panels = $$('.aiqd-scan__result', box);
			var urlEl = $('[data-scan-url]', box);
			var run = $('[data-scan-run]', box);
			var label = run ? $('span', run) : null;
			var busy = false;

			function active() { return panels.filter(function (p) { return !p.hidden; })[0]; }

			function play(panel) {
				if (!panel) { return; }
				var ring = $('[data-ring]', panel);
				if (ring) { ringAnimate(ring); }
				$$('.aiqd-cats__bar i', panel).forEach(function (i) {
					i.style.transition = 'none'; var w = i.style.getPropertyValue('--w'); i.style.width = '0%';
					void i.offsetWidth; i.style.transition = ''; requestAnimationFrame(function () { i.style.width = w; });
				});
				$$('.aiqd-issue', panel).forEach(function (el, n) {
					if (reduce) { return; }
					el.style.opacity = '0'; el.style.transform = 'translateY(8px)';
					setTimeout(function () { el.style.transition = 'all .4s'; el.style.opacity = '1'; el.style.transform = 'none'; }, 250 + n * 90);
				});
			}

			function show(i) {
				tabsEl.forEach(function (b, n) {
					b.setAttribute('aria-selected', n === i ? 'true' : 'false'); b.tabIndex = n === i ? 0 : -1;
				});
				panels.forEach(function (p, n) { p.hidden = n !== i; });
				if (urlEl && panels[i]) { urlEl.textContent = panels[i].getAttribute('data-url'); }
				play(panels[i]);
			}

			function scan() {
				if (busy) { return; }
				busy = true;
				box.classList.add('is-scanning');
				if (label) { label.textContent = t.scanning || 'Scanning…'; }
				setTimeout(function () {
					box.classList.remove('is-scanning');
					if (label) { label.textContent = t.scanAgain || 'Scan again'; }
					play(active());
					busy = false;
				}, reduce ? 0 : 1650);
			}

			tabsEl.forEach(function (b, i) {
				b.addEventListener('click', function () { show(i); });
				b.addEventListener('keydown', function (e) {
					var n = null;
					if (e.key === 'ArrowRight') { n = (i + 1) % tabsEl.length; }
					if (e.key === 'ArrowLeft') { n = (i - 1 + tabsEl.length) % tabsEl.length; }
					if (n !== null) { e.preventDefault(); show(n); tabsEl[n].focus(); }
				});
			});
			if (run) { run.addEventListener('click', scan); }
			onVisible(box, function () { setTimeout(scan, 500); }, { threshold: 0.35 });
		});
	}

	/* ───────────── module explorer ───────────── */
	function modules(root) {
		$$('[data-aiqd-modules]', root).forEach(function (box) {
			var tabsEl = $$('[role="tab"]', box);
			var filterBtns = $$('[data-filter]', box);
			var search = $('[data-mod-search]', box);
			var empty = $('.aiqd-mods__empty', box);
			var tier = 'all';
			var q = '';

			function select(b, focus) {
				tabsEl.forEach(function (x) {
					var on = x === b;
					x.setAttribute('aria-selected', on ? 'true' : 'false');
					x.tabIndex = on ? 0 : -1;
					var p = D.getElementById(x.getAttribute('aria-controls'));
					if (p) { p.hidden = !on; }
				});
				if (focus) { b.focus(); }
			}
			function visibleTabs() { return tabsEl.filter(function (x) { return !x.hidden; }); }
			function apply() {
				var shown = 0;
				tabsEl.forEach(function (b) {
					var ok = (tier === 'all' || b.getAttribute('data-tier') === tier) && (!q || b.getAttribute('data-search').indexOf(q) !== -1);
					b.hidden = !ok;
					if (ok) { shown++; }
				});
				if (empty) { empty.hidden = shown > 0; }
				var cur = tabsEl.filter(function (x) { return x.getAttribute('aria-selected') === 'true' && !x.hidden; })[0];
				if (!cur && visibleTabs()[0]) { select(visibleTabs()[0]); }
			}
			tabsEl.forEach(function (b) {
				b.addEventListener('click', function () { select(b); });
				b.addEventListener('keydown', function (e) {
					var vis = visibleTabs();
					var i = vis.indexOf(b);
					var n = null;
					if (e.key === 'ArrowDown' || e.key === 'ArrowRight') { n = vis[(i + 1) % vis.length]; }
					if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') { n = vis[(i - 1 + vis.length) % vis.length]; }
					if (e.key === 'Home') { n = vis[0]; }
					if (e.key === 'End') { n = vis[vis.length - 1]; }
					if (n) { e.preventDefault(); select(n, true); }
				});
			});
			filterBtns.forEach(function (f) {
				f.addEventListener('click', function () {
					tier = f.getAttribute('data-filter');
					filterBtns.forEach(function (x) { var on = x === f; x.classList.toggle('is-on', on); x.setAttribute('aria-pressed', on ? 'true' : 'false'); });
					apply();
				});
			});
			if (search) { search.addEventListener('input', function () { q = search.value.trim().toLowerCase(); apply(); }); }

			// Deep link: #module-<id>
			var hm = (location.hash || '').match(/^#module-(.+)$/);
			if (hm) {
				var target = tabsEl.filter(function (x) { return x.id.slice(-hm[1].length) === hm[1]; })[0];
				if (target) { select(target); }
			}
		});
	}

	/* ───────────── widget playground ───────────── */
	function widgetDemo(root) {
		$$('[data-aiqd-widget]', root).forEach(function (box) {
			var mock = $('[data-mock]', box);
			var fontVal = $('[data-w-fontval]', box);
			var sp = $('[data-w-spacing]', box);
			var lh = $('[data-w-lh]', box);
			var toolBtns = $$('[data-tool]', box);
			var profBtns = $$('[data-profile]', box);
			var state = { font: 100, tools: {}, spacing: 0, lh: 0 };
			var map = { contrast: 'is-contrast', mono: 'is-mono', dyslexic: 'is-dyslexic', links: 'is-links', titles: 'is-titles', noanim: 'is-noanim', bigcursor: 'is-bigcursor', readline: 'is-readline', readmask: 'is-readmask', keyboard: 'is-keyboard', lowsat: 'is-lowsat' };
			var profiles = {
				vision: { font: 130, tools: ['contrast', 'bigcursor'] },
				adhd: { tools: ['noanim', 'readline', 'readmask'], lh: 2 },
				seizure: { tools: ['noanim', 'lowsat'] },
				dyslexia: { font: 110, tools: ['dyslexic'], spacing: 2, lh: 1 },
				keyboard: { tools: ['keyboard', 'links'] }
			};
			var lhVals = [1.55, 1.85, 2.2];

			function render() {
				mock.style.setProperty('--fs', (state.font / 100).toString());
				mock.style.setProperty('--ls', state.spacing + 'px');
				mock.style.setProperty('--lh', lhVals[state.lh]);
				if (fontVal) { fontVal.textContent = state.font + '%'; }
				Object.keys(map).forEach(function (k) { mock.classList.toggle(map[k], !!state.tools[k]); });
				toolBtns.forEach(function (b) { b.setAttribute('aria-pressed', state.tools[b.getAttribute('data-tool')] ? 'true' : 'false'); });
				if (sp) { sp.value = state.spacing; }
				if (lh) { lh.value = state.lh; }
			}
			function reset() { state = { font: 100, tools: {}, spacing: 0, lh: 0 }; profBtns.forEach(function (p) { p.setAttribute('aria-pressed', 'false'); }); render(); }

			toolBtns.forEach(function (b) {
				b.addEventListener('click', function () { var k = b.getAttribute('data-tool'); state.tools[k] = !state.tools[k]; render(); });
			});
			$$('[data-w-font]', box).forEach(function (b) {
				b.addEventListener('click', function () { state.font = clamp(state.font + parseInt(b.getAttribute('data-w-font'), 10), 80, 150); render(); });
			});
			if (sp) { sp.addEventListener('input', function () { state.spacing = parseInt(sp.value, 10); render(); }); }
			if (lh) { lh.addEventListener('input', function () { state.lh = parseInt(lh.value, 10); render(); }); }
			profBtns.forEach(function (p) {
				p.addEventListener('click', function () {
					var on = p.getAttribute('aria-pressed') !== 'true';
					reset();
					if (!on) { return; }
					var def = profiles[p.getAttribute('data-profile')];
					p.setAttribute('aria-pressed', 'true');
					if (def.font) { state.font = def.font; }
					if (def.spacing) { state.spacing = def.spacing; }
					if (def.lh) { state.lh = def.lh; }
					(def.tools || []).forEach(function (k) { state.tools[k] = true; });
					render();
				});
			});
			var rs = $('[data-w-reset]', box);
			if (rs) { rs.addEventListener('click', reset); }

			// Reading line / mask follow the pointer.
			mock.addEventListener('pointermove', function (e) {
				var r = mock.getBoundingClientRect();
				mock.style.setProperty('--y', clamp(e.clientY - r.top, 0, r.height) + 'px');
			});
			render();
		});
	}

	/* ───────────── heatmap demo ───────────── */
	function heatDemo(root) {
		$$('[data-aiqd-heat]', root).forEach(function (box) {
			var view = $('[data-heat-view]', box);
			var canvas = $('[data-heat-canvas]', box);
			var topEl = $('[data-heat-top]', box);
			var totalEl = $('[data-heat-total]', box);
			var ctx = canvas.getContext('2d');
			var off = D.createElement('canvas');
			var octx = off.getContext('2d');
			var device = 'desktop';
			var data = { desktop: [], mobile: [] };
			var pal = null;

			function palette() {
				if (pal) { return pal; }
				var c = D.createElement('canvas'); c.width = 256; c.height = 1;
				var g = c.getContext('2d'); var gr = g.createLinearGradient(0, 0, 256, 0);
				gr.addColorStop(0.0, 'rgba(0,0,255,0)'); gr.addColorStop(0.18, 'rgba(0,160,255,.85)'); gr.addColorStop(0.4, 'rgba(0,230,120,.9)');
				gr.addColorStop(0.65, 'rgba(255,230,0,.95)'); gr.addColorStop(1.0, 'rgba(255,40,0,1)');
				g.fillStyle = gr; g.fillRect(0, 0, 256, 1);
				pal = g.getImageData(0, 0, 256, 1).data; return pal;
			}
			function size() {
				var r = view.getBoundingClientRect();
				var w = Math.max(1, Math.round(r.width)); var h = Math.max(1, Math.round(r.height));
				if (canvas.width !== w || canvas.height !== h) { canvas.width = w; canvas.height = h; off.width = w; off.height = h; }
				return { w: w, h: h };
			}
			function draw() {
				var s = size();
				octx.clearRect(0, 0, s.w, s.h);
				var rad = device === 'mobile' ? 26 : 36;
				data[device].forEach(function (c) {
					var x = c.x * s.w; var y = c.y * s.h;
					var g = octx.createRadialGradient(x, y, 0, x, y, rad);
					g.addColorStop(0, 'rgba(0,0,0,.24)'); g.addColorStop(1, 'rgba(0,0,0,0)');
					octx.fillStyle = g; octx.beginPath(); octx.arc(x, y, rad, 0, 6.2832); octx.fill();
				});
				var img = octx.getImageData(0, 0, s.w, s.h); var d = img.data; var p = palette();
				for (var i = 0; i < d.length; i += 4) {
					var a = d[i + 3];
					if (a) { var o = Math.min(255, a * 3) * 4; d[i] = p[o]; d[i + 1] = p[o + 1]; d[i + 2] = p[o + 2]; d[i + 3] = Math.min(235, p[o + 3]); }
				}
				ctx.clearRect(0, 0, s.w, s.h); ctx.putImageData(img, 0, 0);
			}
			function label(x, y) {
				var els = $$('[data-el]', view);
				for (var i = 0; i < els.length; i++) {
					var r = els[i].getBoundingClientRect(); var vr = view.getBoundingClientRect();
					if (x >= r.left - vr.left && x <= r.right - vr.left && y >= r.top - vr.top && y <= r.bottom - vr.top) { return els[i].getAttribute('data-el'); }
				}
				var hit = D.elementFromPoint(view.getBoundingClientRect().left + x, view.getBoundingClientRect().top + y);
				if (hit && hit.closest) {
					if (hit.closest('.img')) { return 'Product image'; }
					if (hit.closest('.aiqd-hpage__nav')) { return 'Navigation'; }
					if (hit.closest('.info')) { return 'Product info'; }
				}
				return 'Page background';
			}
			function add(x, y) {
				var s = size();
				data[device].push({ x: x / s.w, y: y / s.h, el: label(x, y) });
				view.classList.add('has-data');
			}
			function list() {
				var tally = {};
				data[device].forEach(function (c) { tally[c.el] = (tally[c.el] || 0) + 1; });
				var rows = Object.keys(tally).map(function (k) { return [k, tally[k]]; }).sort(function (a, b) { return b[1] - a[1]; }).slice(0, 5);
				var total = data[device].length;
				totalEl.textContent = total + ' ' + (total === 1 ? 'click' : 'clicks');
				topEl.innerHTML = '';
				if (!rows.length) { var li = D.createElement('li'); li.className = 'is-empty'; li.textContent = 'Click the page to start collecting.'; topEl.appendChild(li); return; }
				rows.forEach(function (r, i) {
					var li = D.createElement('li');
					var pct = Math.round(r[1] / total * 100);
					li.innerHTML = '<span class="rank">' + (i + 1) + '</span><span></span><em>' + r[1] + ' · ' + pct + '%</em><span class="bar"><i style="width:' + pct + '%"></i></span>';
					li.children[1].textContent = r[0];
					topEl.appendChild(li);
				});
			}
			function refresh() { draw(); list(); }

			canvas.addEventListener('pointerdown', function (e) {
				var r = canvas.getBoundingClientRect();
				add(e.clientX - r.left, e.clientY - r.top); refresh();
			});
			canvas.setAttribute('tabindex', '0');
			canvas.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); var s = size(); add(Math.random() * s.w, Math.random() * s.h); refresh(); }
			});
			$$('[data-device]', box).forEach(function (b) {
				if (b.tagName !== 'BUTTON') { return; }
				b.addEventListener('click', function () {
					device = b.getAttribute('data-device');
					view.setAttribute('data-device', device);
					$$('.aiqd-seg [data-device]', box).forEach(function (x) { var on = x === b; x.classList.toggle('is-on', on); x.setAttribute('aria-pressed', on ? 'true' : 'false'); });
					view.classList.toggle('has-data', data[device].length > 0);
					setTimeout(refresh, 420);
				});
			});
			$('[data-heat-clear]', box).addEventListener('click', function () { data[device] = []; view.classList.remove('has-data'); refresh(); });
			$('[data-heat-sim]', box).addEventListener('click', function () {
				var s = size();
				var spots = [
					{ sel: 'Add to cart', w: 5 }, { sel: 'Wishlist', w: 1.4 }, { sel: 'Reviews tab', w: 2 }, { sel: 'Specs tab', w: 1 }, { sel: 'Shipping tab', w: 0.8 }
				];
				var vr = view.getBoundingClientRect(); var n = 0;
				var total = 160;
				while (n < total) {
					var pick = Math.random() * 10.5; var acc = 0; var sp = spots[0];
					for (var i = 0; i < spots.length; i++) { acc += spots[i].w; if (pick <= acc) { sp = spots[i]; break; } }
					var el = $('[data-el="' + sp.sel + '"]', view);
					var x; var y;
					if (el) {
						var r = el.getBoundingClientRect();
						x = r.left - vr.left + Math.random() * r.width; y = r.top - vr.top + Math.random() * r.height;
					} else { x = Math.random() * s.w; y = Math.random() * s.h; }
					data[device].push({ x: x / s.w, y: y / s.h, el: label(x, y) }); n++;
				}
				for (var j = 0; j < 12; j++) { var rx = Math.random() * s.w; var ry = Math.random() * s.h; data[device].push({ x: rx / s.w, y: ry / s.h, el: label(rx, ry) }); }
				view.classList.add('has-data'); refresh();
			});
			if ('ResizeObserver' in W) { new ResizeObserver(function () { draw(); }).observe(view); }
			refresh();
		});
	}

	/* ───────────── analytics demo ───────────── */
	function analytics(root) {
		$$('[data-aiqd-chart]', root).forEach(function (box) {
			var line = $('[data-chart-line]', box);
			var donut = $('[data-chart-donut]', box);
			var legend = $('[data-chart-legend]', box);
			var tip = $('[data-chart-tip]', box);
			var rows = $$('tbody tr', box);
			var range = 7;
			var series = [];
			var progress = 1;
			var hover = -1;

			function rng(seed) { return function () { seed |= 0; seed = seed + 0x6D2B79F5 | 0; var x = Math.imul(seed ^ seed >>> 15, 1 | seed); x = x + Math.imul(x ^ x >>> 7, 61 | x) ^ x; return ((x ^ x >>> 14) >>> 0) / 4294967296; }; }
			function build(days) {
				var r = rng(days * 97 + 13); var out = []; var base = 0;
				rows.forEach(function (tr) { base += parseInt(tr.getAttribute('data-base'), 10) || 0; });
				var daily = Math.max(120, base / 30 * 1.55);
				for (var i = 0; i < days; i++) {
					var dow = i % 7; var wk = (dow === 5 || dow === 6) ? 0.72 : 1.06;
					var trend = 1 + (i / days) * 0.28;
					out.push(Math.round(daily * wk * trend * (0.85 + r() * 0.3)));
				}
				return out;
			}
			function colors() {
				return { p: css(root, '--primary') || '#14b8a6', a: css(root, '--accent') || '#8b5cf6', w: css(root, '--warm') || '#f59e0b', line: css(root, '--line'), muted: css(root, '--muted') };
			}
			function kpis() {
				var sum = series.reduce(function (a, b) { return a + b; }, 0);
				var peak = series.indexOf(Math.max.apply(null, series));
				var bounce = range === 7 ? 36 : (range === 30 ? 38 : 41);
				var secs = range === 7 ? 108 : (range === 30 ? 112 : 104);
				var set = function (k, v) { var el = $('[data-kpi="' + k + '"]', box); if (el) { el.textContent = v; } };
				set('sessions', fmt(sum)); set('time', Math.floor(secs / 60) + ':' + ('0' + (secs % 60)).slice(-2)); set('bounce', bounce + '%');
				set('peak', ['9 AM', '10 AM', '2 PM', '8 PM'][peak % 4]);
				rows.forEach(function (tr) {
					var cell = $('[data-sess]', tr); if (!cell) { return; }
					cell.textContent = fmt((parseInt(tr.getAttribute('data-base'), 10) || 0) * range / 30);
				});
			}
			function drawLine() {
				var c = colors(); var dpr = Math.min(2, W.devicePixelRatio || 1);
				var cw = line.clientWidth; var ch = line.clientHeight;
				if (!cw || !ch) { return; }
				line.width = cw * dpr; line.height = ch * dpr;
				var g = line.getContext('2d'); g.setTransform(dpr, 0, 0, dpr, 0, 0); g.clearRect(0, 0, cw, ch);
				var pad = { l: 38, r: 10, t: 12, b: 24 };
				var max = Math.max.apply(null, series) * 1.15; var iw = cw - pad.l - pad.r; var ih = ch - pad.t - pad.b;
				g.font = '11px system-ui,sans-serif'; g.fillStyle = c.muted; g.strokeStyle = c.line; g.lineWidth = 1;
				for (var i = 0; i <= 4; i++) {
					var y = pad.t + ih - ih * i / 4;
					g.beginPath(); g.moveTo(pad.l, y); g.lineTo(cw - pad.r, y); g.stroke();
					g.textAlign = 'right'; g.fillText(fmt(max * i / 4), pad.l - 6, y + 4);
				}
				var n = series.length; var pts = series.map(function (v, k) { return [pad.l + iw * k / Math.max(1, n - 1), pad.t + ih - ih * v / max]; });
				var upto = Math.max(1, Math.round((n - 1) * progress));
				g.save(); g.beginPath(); g.rect(0, 0, pad.l + iw * progress + 1, ch); g.clip();
				var grad = g.createLinearGradient(0, pad.t, 0, pad.t + ih); grad.addColorStop(0, c.p + '66'); grad.addColorStop(1, c.p + '00');
				g.beginPath(); pts.forEach(function (p, k) { if (k === 0) { g.moveTo(p[0], p[1]); } else { g.lineTo(p[0], p[1]); } });
				g.lineTo(pts[n - 1][0], pad.t + ih); g.lineTo(pts[0][0], pad.t + ih); g.closePath(); g.fillStyle = grad; g.fill();
				g.beginPath(); pts.forEach(function (p, k) { if (k === 0) { g.moveTo(p[0], p[1]); } else { g.lineTo(p[0], p[1]); } });
				g.strokeStyle = c.p; g.lineWidth = 2.5; g.lineJoin = 'round'; g.stroke(); g.restore();
				if (hover >= 0 && hover < n) {
					var hp = pts[hover]; g.strokeStyle = c.line; g.beginPath(); g.moveTo(hp[0], pad.t); g.lineTo(hp[0], pad.t + ih); g.stroke();
					g.fillStyle = c.p; g.beginPath(); g.arc(hp[0], hp[1], 5, 0, 6.2832); g.fill();
				}
				g.fillStyle = c.muted; g.textAlign = 'center';
				var step = Math.ceil(n / 7);
				for (var k = 0; k < n; k += step) { g.fillText('D' + (k + 1), pts[k][0], ch - 6); }
				line._pts = pts; line._pad = pad;
				void upto;
			}
			function drawDonut(p) {
				var c = colors(); var s = donut.width; var g = donut.getContext('2d'); g.clearRect(0, 0, s, s);
				var parts = [['Desktop', 56, c.p], ['Mobile', 34, c.a], ['Tablet', 10, c.w]];
				var a0 = -Math.PI / 2; var total = Math.PI * 2 * p;
				parts.forEach(function (pt) {
					var a1 = a0 + total * pt[1] / 100;
					g.beginPath(); g.arc(s / 2, s / 2, s / 2 - 14, a0, a1); g.lineWidth = 22; g.strokeStyle = pt[2]; g.lineCap = 'butt'; g.stroke(); a0 = a1;
				});
				g.fillStyle = css(root, '--ink'); g.font = '800 26px system-ui,sans-serif'; g.textAlign = 'center'; g.fillText('56%', s / 2, s / 2 + 4);
				g.fillStyle = c.muted; g.font = '600 11px system-ui,sans-serif'; g.fillText('Desktop', s / 2, s / 2 + 22);
				if (legend && !legend.children.length) {
					legend.innerHTML = parts.map(function (pt) { return '<li><i style="background:' + pt[2] + '"></i>' + pt[0] + ' ' + pt[1] + '%</li>'; }).join('');
				}
			}
			function run(days) {
				range = days; series = build(days); kpis();
				animate(1100, function (p) { progress = p; drawLine(); });
			}
			box.querySelectorAll('[data-range]').forEach(function (b) {
				b.addEventListener('click', function () {
					$$('[data-range]', box).forEach(function (x) { var on = x === b; x.classList.toggle('is-on', on); x.setAttribute('aria-pressed', on ? 'true' : 'false'); });
					run(parseInt(b.getAttribute('data-range'), 10));
				});
			});
			line.addEventListener('pointermove', function (e) {
				if (!line._pts) { return; }
				var r = line.getBoundingClientRect(); var x = e.clientX - r.left; var best = 0; var bd = 1e9;
				line._pts.forEach(function (p, i) { var d = Math.abs(p[0] - x); if (d < bd) { bd = d; best = i; } });
				hover = best; drawLine();
				tip.hidden = false; tip.textContent = 'Day ' + (best + 1) + ': ' + fmt(series[best]) + ' sessions';
				tip.style.left = (line.offsetLeft + line._pts[best][0]) + 'px'; tip.style.top = (line.offsetTop + line._pts[best][1]) + 'px';
			});
			line.addEventListener('pointerleave', function () { hover = -1; tip.hidden = true; drawLine(); });
			W.addEventListener('resize', function () { drawLine(); drawDonut(1); });
			if ('MutationObserver' in W) { new MutationObserver(function () { drawLine(); drawDonut(1); }).observe(root, { attributes: true, attributeFilter: ['data-theme'] }); }
			series = build(7); kpis(); drawLine(); drawDonut(0);
			onVisible(box, function () { animate(1100, function (p) { progress = p; drawLine(); drawDonut(p); }); }, { threshold: 0.25 });
		});
	}

	/* ───────────── pricing: Annual / Lifetime toggle + Freemius checkout ───────────── */
	function billing(root) {
		$$('[data-aiqd-billing]', root).forEach(function (box) {
			var btns = $$('.aiqd-bill [data-cycle]', box);
			function set(cycle) {
				box.setAttribute('data-cycle', cycle);
				btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-cycle') === cycle ? 'true' : 'false'); });
				$$('.aiqd-plan', box).forEach(function (plan) {
					var amt = $('.aiqd-plan__amt', plan); if (!amt) { return; }
					var from = parseFloat(amt.textContent.replace(/,/g, '')) || 0;
					var to = parseFloat(amt.getAttribute('data-' + cycle)) || 0;
					animate(450, function (p) { var v = from + (to - from) * p; amt.textContent = (Math.round(to) === to) ? fmt(v) : v.toFixed(2); });
					var per = $('[data-per]', plan); if (per) { per.textContent = cycle === 'annual' ? (t.perYear || '/year') : (t.perOnce || 'one-time'); }
					var bill = $('[data-bill]', plan); if (bill) { bill.textContent = cycle === 'annual' ? (t.billedYear || 'billed yearly') : (t.billedOnce || 'pay once, use forever'); }
					var a = $('a.aiqd-btn', plan);
					if (a && a.getAttribute('data-href-' + cycle)) { a.href = a.getAttribute('data-href-' + cycle); }
				});
			}
			btns.forEach(function (b) { b.addEventListener('click', function () { set(b.getAttribute('data-cycle')); }); });

			// Freemius overlay checkout. Falls back to the plain link when the key is not configured.
			box.addEventListener('click', function (e) {
				var a = e.target.closest('a[data-checkout]');
				if (!a || !CHECKOUT.ready || !W.FS || !W.FS.Checkout) { return; }
				var ids = CHECKOUT.plans[a.getAttribute('data-checkout')];
				if (!ids) { return; }
				e.preventDefault();
				var cycle = box.getAttribute('data-cycle') === 'lifetime' ? 'lifetime' : 'annual';
				var handler = new W.FS.Checkout({ product_id: CHECKOUT.product_id, plan_id: ids.plan_id, public_key: CHECKOUT.public_key });
				handler.open({
					name: CHECKOUT.name,
					pricing_id: ids.pricing_id,
					billing_cycle: cycle,
					purchaseCompleted: function (data) {
						D.dispatchEvent(new CustomEvent('aiqd:purchase', { detail: data })); // hook for analytics
					},
					success: function () { W.location.href = CHECKOUT.success_url; }
				});
			});
		});
	}

	/* faq search */
	function faq(root) {
		$$('[data-aiqd-faq]', root).forEach(function (box) {
			var inp = $('[data-faq-search]', box);
			var items = $$('.aiqd-qa', box);
			var empty = $('.aiqd-faq__empty', box);
			if (!inp) { return; }
			inp.addEventListener('input', function () {
				var q = inp.value.trim().toLowerCase(); var n = 0;
				items.forEach(function (it) {
					var ok = !q || it.textContent.toLowerCase().indexOf(q) !== -1;
					it.hidden = !ok; if (ok) { n++; }
					if (q && ok) { it.open = true; }
				});
				if (empty) { empty.hidden = n > 0; }
			});
		});
	}

	/* savings calculator */
	function calc(root) {
		$$('[data-aiqd-calc]', root).forEach(function (box) {
			var cur = box.getAttribute('data-cur') || '$';
			var ours = parseFloat(box.getAttribute('data-ours')) || 0;
			var perSite = box.getAttribute('data-persite') === '1';
			var checks = $$('input[type=checkbox]', box);
			var sites = $('[data-sites]', box);
			var sitesVal = $('[data-sites-val]', box);
			var oldEl = $('[data-old]', box); var newEl = $('[data-new]', box); var saveEl = $('[data-save]', box);
			var shown = { o: 0, n: 0, s: 0 };
			function money(v) { return cur + fmt(v); }
			function upd() {
				var n = perSite && sites ? parseInt(sites.value, 10) : 1;
				if (sitesVal) { sitesVal.textContent = n; }
				var monthly = checks.reduce(function (a, c) { return a + (c.checked ? parseFloat(c.value) : 0); }, 0);
				var old = monthly * 12 * n; var neu = ours * n; var save = Math.max(0, old - neu);
				var from = { o: shown.o, n: shown.n, s: shown.s };
				animate(500, function (p) {
					oldEl.textContent = money(from.o + (old - from.o) * p);
					newEl.textContent = money(from.n + (neu - from.n) * p);
					saveEl.textContent = money(from.s + (save - from.s) * p);
				});
				shown = { o: old, n: neu, s: save };
			}
			checks.forEach(function (c) { c.addEventListener('change', upd); });
			if (sites) { sites.addEventListener('input', upd); }
			upd();
		});
	}

	/* steps progress line */
	function steps(root) {
		$$('[data-aiqd-steps]', root).forEach(function (ol) {
			var line = $('.aiqd-steps__line', ol);
			function upd() {
				var r = ol.getBoundingClientRect();
				var p = clamp((W.innerHeight * 0.65 - r.top) / r.height, 0, 1);
				line.style.setProperty('--p', p.toFixed(3));
			}
			W.addEventListener('scroll', upd, { passive: true }); upd();
		});
	}

	/* anchor links: move focus to the target for keyboard / screen-reader users */
	function anchors(root) {
		root.addEventListener('click', function (e) {
			var a = e.target.closest('a[href^="#"]');
			if (!a) { return; }
			var id = a.getAttribute('href').slice(1);
			if (!id) { return; }
			var tgt = D.getElementById(id);
			if (!tgt) { return; }
			setTimeout(function () { if (!tgt.hasAttribute('tabindex')) { tgt.setAttribute('tabindex', '-1'); } tgt.focus({ preventScroll: true }); }, reduce ? 0 : 450);
		});
	}
})();
