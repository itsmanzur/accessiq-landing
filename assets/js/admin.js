/**
 * AccessIQ Landing — admin app.
 * A tiny schema-driven form engine + the Page Builder. No build step.
 * Data/ schemas come from PHP (window.AIQDA); PHP re-sanitises on save.
 */
(function ($) {
	'use strict';

	var A = window.AIQDA;
	var app = document.getElementById('aiqda-app');
	if (!A || !app) { return; }
	var T = A.i18n;
	var uidn = 0;

	/* ───────────── helpers ───────────── */
	function h(tag, attrs, kids) {
		var el = document.createElement(tag);
		if (attrs) {
			Object.keys(attrs).forEach(function (k) {
				var v = attrs[k];
				if (v === null || v === undefined || v === false) { return; }
				if (k === 'class') { el.className = v; }
				else if (k === 'text') { el.textContent = v; }
				else if (k.slice(0, 2) === 'on' && typeof v === 'function') { el.addEventListener(k.slice(2), v); }
				else { el.setAttribute(k, v === true ? '' : v); }
			});
		}
		(kids || []).forEach(function (c) { if (c) { el.appendChild(typeof c === 'string' ? document.createTextNode(c) : c); } });
		return el;
	}
	function clone(o) { return JSON.parse(JSON.stringify(o === undefined ? null : o)); }
	function nid(p) { uidn++; return (p || 'aiqda') + '-' + uidn; }
	function rid() { return 's-' + Math.random().toString(36).slice(2, 10); }
	function plain(s) { return String(s || '').replace(/\[\[(.+?)\]\]/g, '$1').replace(/\*\*(.+?)\*\*/g, '$1'); }
	function svg(name, size) {
		var inner = A.icons[name];
		var s = size || 18;
		var span = document.createElement('span');
		span.className = 'aiqda-ico';
		span.innerHTML = inner ? '<svg width="' + s + '" height="' + s + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' + inner + '</svg>' : '';
		return span;
	}
	function ajax(action, data) {
		var fd = new FormData();
		fd.append('action', action); fd.append('nonce', A.nonce);
		Object.keys(data || {}).forEach(function (k) { fd.append(k, data[k]); });
		return fetch(A.ajax, { method: 'POST', body: fd, credentials: 'same-origin' }).then(function (r) { return r.json(); });
	}

	var dirty = false;
	var statusEl = null;
	function markDirty(v) {
		dirty = v;
		if (statusEl) { statusEl.textContent = v ? T.unsaved : ''; statusEl.className = 'aiqda-status' + (v ? ' is-dirty' : ''); }
	}
	window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });

	/* ───────────── form engine ───────────── */
	function fieldWrap(f, input, id, extra) {
		var wrap = h('div', { 'class': 'aiqda-field aiqda-field--' + f.type });
		if (f.type !== 'toggle') {
			wrap.appendChild(h('label', { 'for': id, text: f.label || f.key }));
		}
		wrap.appendChild(input);
		if (extra) { wrap.appendChild(extra); }
		if (f.help) { wrap.appendChild(h('p', { 'class': 'aiqda-help', text: f.help })); }
		return wrap;
	}

	function buildForm(schema, obj, onChange) {
		var form = h('div', { 'class': 'aiqda-form' });
		schema.forEach(function (f) { form.appendChild(buildField(f, obj, onChange)); });
		return form;
	}

	function buildField(f, obj, onChange) {
		var id = nid('f');
		var key = f.key;
		var val = obj[key];
		function set(v) { obj[key] = v; onChange && onChange(); }

		switch (f.type) {
			case 'notice':
				return h('p', { 'class': 'aiqda-notice', text: f.label });

			case 'text':
			case 'number': {
				var inp = h('input', { type: f.type === 'number' ? 'number' : 'text', id: id, 'class': 'aiqda-input', value: val === undefined || val === null ? '' : val, step: f.type === 'number' ? 'any' : null });
				inp.addEventListener('input', function () { set(f.type === 'number' ? (inp.value === '' ? '' : Number(inp.value)) : inp.value); });
				return fieldWrap(f, inp, id);
			}

			case 'textarea':
			case 'lines':
			case 'richtext':
			case 'code':
			case 'css': {
				var ta = h('textarea', { id: id, 'class': 'aiqda-input' + (f.type === 'code' || f.type === 'css' ? ' is-mono' : ''), rows: f.rows || (f.type === 'lines' ? 4 : 3) });
				ta.value = val === undefined || val === null ? '' : val;
				ta.addEventListener('input', function () { set(ta.value); });
				var hint = null;
				if (f.type === 'code' && !A.canHtml) { hint = h('p', { 'class': 'aiqda-help', text: 'Your role cannot save raw HTML/scripts; unsafe tags will be removed.' }); }
				return fieldWrap(f, ta, id, hint);
			}

			case 'link': {
				var dl = h('datalist', { id: id + '-dl' });
				Object.keys(A.linkKeys).forEach(function (k) { var o = h('option', { value: '@' + k }); o.textContent = A.linkKeys[k]; dl.appendChild(o); });
				var li = h('input', { type: 'text', id: id, 'class': 'aiqda-input', list: id + '-dl', value: val || '', placeholder: '@download_free  or  #pricing  or  https://…' });
				li.addEventListener('input', function () { set(li.value); });
				var wrap = fieldWrap(f, li, id, dl);
				if (!f.help) { wrap.appendChild(h('p', { 'class': 'aiqda-help', text: T.linkHelp })); }
				return wrap;
			}

			case 'select': {
				var sel = h('select', { id: id, 'class': 'aiqda-input' });
				Object.keys(f.options).forEach(function (k) {
					var o = h('option', { value: k }); o.textContent = f.options[k];
					if (String(val) === String(k)) { o.selected = true; }
					sel.appendChild(o);
				});
				if (val === undefined || val === null || val === '') { if (f.options && sel.options[0]) { obj[key] = sel.options[0].value; } }
				sel.addEventListener('change', function () { set(sel.value); });
				return fieldWrap(f, sel, id);
			}

			case 'toggle': {
				var cb = h('input', { type: 'checkbox', id: id });
				cb.checked = !!Number(val) || val === true;
				cb.addEventListener('change', function () { set(cb.checked ? 1 : 0); });
				var w = h('div', { 'class': 'aiqda-field aiqda-field--toggle' }, [
					h('label', { 'class': 'aiqda-switch', 'for': id }, [cb, h('span', { 'class': 'aiqda-switch__ui' }), h('span', { 'class': 'aiqda-switch__txt', text: f.label })])
				]);
				if (f.help) { w.appendChild(h('p', { 'class': 'aiqda-help', text: f.help })); }
				return w;
			}

			case 'color': {
				var col = h('input', { type: 'color', id: id, value: /^#[0-9a-f]{6}$/i.test(val || '') ? val : '#14b8a6', 'class': 'aiqda-color' });
				var hex = h('input', { type: 'text', 'class': 'aiqda-input aiqda-hex', value: val || '', 'aria-label': (f.label || '') + ' (hex)' });
				col.addEventListener('input', function () { hex.value = col.value; set(col.value); });
				hex.addEventListener('input', function () { if (/^#[0-9a-f]{6}$/i.test(hex.value)) { col.value = hex.value; } set(hex.value); });
				return fieldWrap(f, h('div', { 'class': 'aiqda-colorrow' }, [col, hex]), id);
			}

			case 'icon': {
				var isel = h('select', { id: id, 'class': 'aiqda-input' });
				isel.appendChild(h('option', { value: '', text: '— none —' }));
				Object.keys(A.icons).sort().forEach(function (k) { var o = h('option', { value: k, text: k }); if (val === k) { o.selected = true; } isel.appendChild(o); });
				var prev = h('span', { 'class': 'aiqda-iconprev' }, [svg(val, 22)]);
				isel.addEventListener('change', function () { set(isel.value); prev.innerHTML = ''; prev.appendChild(svg(isel.value, 22)); });
				return fieldWrap(f, h('div', { 'class': 'aiqda-iconrow' }, [prev, isel]), id);
			}

			case 'image': {
				var url = h('input', { type: 'url', id: id, 'class': 'aiqda-input', value: val || '', placeholder: 'https://…' });
				var img = h('img', { 'class': 'aiqda-thumb', alt: '', src: val || '' });
				if (!val) { img.style.display = 'none'; }
				function show(u) { url.value = u; img.src = u; img.style.display = u ? '' : 'none'; set(u); }
				url.addEventListener('input', function () { show(url.value); });
				var pick = h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--sm', text: T.choose, onclick: function () {
					if (!window.wp || !wp.media) { return; }
					var frame = wp.media({ title: T.choose, multiple: false, library: { type: 'image' } });
					frame.on('select', function () { var a = frame.state().get('selection').first().toJSON(); show(a.url); });
					frame.open();
				} });
				var rm = h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--sm aiqda-btn--ghost', text: T.remove, onclick: function () { show(''); } });
				return fieldWrap(f, h('div', { 'class': 'aiqda-imgrow' }, [img, url, pick, rm]), id);
			}

			case 'repeater':
				return buildRepeater(f, obj, onChange);
		}
		return h('div');
	}

	function buildRepeater(f, obj, onChange) {
		var key = f.key;
		if (!Array.isArray(obj[key])) { obj[key] = []; }
		var items = obj[key];
		var wrap = h('div', { 'class': 'aiqda-field aiqda-field--repeater' }, [h('div', { 'class': 'aiqda-label', text: f.label || key })]);
		var list = h('div', { 'class': 'aiqda-rep' });
		wrap.appendChild(list);
		if (f.help) { wrap.appendChild(h('p', { 'class': 'aiqda-help', text: f.help })); }

		function emptyItem() {
			var o = {};
			(f.fields || []).forEach(function (sf) { o[sf.key] = sf.type === 'repeater' ? [] : (sf.type === 'toggle' || sf.type === 'number' ? 0 : ''); });
			return o;
		}
		function title(it, i) {
			var t = plain(it[f.item_label || (f.fields[0] && f.fields[0].key)] || '');
			return (i + 1) + '. ' + (t || '(untitled)');
		}
		function draw(openIdx) {
			list.innerHTML = '';
			items.forEach(function (it, i) {
				var sum = h('summary', {}, [h('span', { 'class': 'aiqda-rep__t', text: title(it, i) })]);
				var ctl = h('span', { 'class': 'aiqda-rep__ctl' });
				function btn(label, txt, fn) {
					var b = h('button', { type: 'button', 'class': 'aiqda-mini', 'aria-label': label, title: label, text: txt });
					b.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); fn(); });
					return b;
				}
				ctl.appendChild(btn(T.moveUp, '↑', function () { if (i > 0) { items.splice(i - 1, 0, items.splice(i, 1)[0]); onChange && onChange(); draw(i - 1); } }));
				ctl.appendChild(btn(T.moveDown, '↓', function () { if (i < items.length - 1) { items.splice(i + 1, 0, items.splice(i, 1)[0]); onChange && onChange(); draw(i + 1); } }));
				ctl.appendChild(btn(T.duplicate, '⧉', function () { items.splice(i + 1, 0, clone(it)); onChange && onChange(); draw(i + 1); }));
				ctl.appendChild(btn(T.delete, '✕', function () { if (window.confirm(T.confirmDel)) { items.splice(i, 1); onChange && onChange(); draw(); } }));
				sum.appendChild(ctl);
				var body = buildForm(f.fields, it, function () {
					sum.querySelector('.aiqda-rep__t').textContent = title(it, i);
					onChange && onChange();
				});
				var d = h('details', { 'class': 'aiqda-rep__item' }, [sum, h('div', { 'class': 'aiqda-rep__body' }, [body])]);
				if (openIdx === i) { d.open = true; }
				list.appendChild(d);
			});
			var add = h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--sm', text: '+ ' + T.addItem });
			add.addEventListener('click', function () { items.push(emptyItem()); onChange && onChange(); draw(items.length - 1); });
			list.appendChild(add);
		}
		draw();
		return wrap;
	}

	/* ───────────── save bar ───────────── */
	function saveBar(onSave) {
		statusEl = h('span', { 'class': 'aiqda-status', 'aria-live': 'polite' });
		var btn = h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--primary', text: T.save });
		btn.addEventListener('click', function () {
			btn.disabled = true; statusEl.textContent = T.saving; statusEl.className = 'aiqda-status';
			onSave().then(function (ok) {
				btn.disabled = false;
				if (ok) { markDirty(false); statusEl.textContent = '✓ ' + T.saved; statusEl.className = 'aiqda-status is-ok'; setTimeout(function () { if (!dirty) { statusEl.textContent = ''; } }, 2500); }
				else { statusEl.textContent = T.error; statusEl.className = 'aiqda-status is-bad'; }
			}).catch(function () { btn.disabled = false; statusEl.textContent = T.error; statusEl.className = 'aiqda-status is-bad'; });
		});
		return h('div', { 'class': 'aiqda-savebar' }, [statusEl, btn]);
	}
	function saveGroups(payload) {
		return ajax('aiqd_save', { payload: JSON.stringify(payload) }).then(function (r) { return r && r.success ? r.data : null; });
	}
	function pageHead(title, desc) {
		return h('div', { 'class': 'aiqda-pagehead' }, [h('h2', { text: title }), desc ? h('p', { text: desc }) : null]);
	}

	/* ───────────── simple form pages ───────────── */
	function simplePage(title, desc, groupName, schema) {
		var obj = clone(A.data[groupName]);
		var form = buildForm(schema, obj, function () { markDirty(true); });
		app.innerHTML = '';
		app.appendChild(pageHead(title, desc));
		app.appendChild(h('div', { 'class': 'aiqda-card' }, [form]));
		app.appendChild(saveBar(function () {
			var p = {}; p[groupName] = obj; return saveGroups(p).then(function (r) { return !!r; });
		}));
	}

	function headerFooterPage() {
		var hdr = clone(A.data.header); var ftr = clone(A.data.footer); var thx = clone(A.data.thanks);
		app.innerHTML = '';
		app.appendChild(pageHead('Header, Footer & Thank-you', 'Designed header and footer sections (switch the source to the theme or nothing in Settings), plus the page visitors see after a purchase.'));
		var tabs = h('div', { 'class': 'aiqda-tabs', role: 'tablist' });
		var pane = h('div', { 'class': 'aiqda-card' });
		var forms = {
			header: buildForm(A.types.header.schema, hdr, function () { markDirty(true); }),
			footer: buildForm(A.types.footer.schema, ftr, function () { markDirty(true); }),
			thanks: buildForm(A.types.thanks.schema, thx, function () { markDirty(true); })
		};
		function show(k) {
			pane.innerHTML = ''; pane.appendChild(forms[k]);
			Array.prototype.forEach.call(tabs.children, function (b) { b.setAttribute('aria-selected', b.getAttribute('data-k') === k ? 'true' : 'false'); });
		}
		['header', 'footer', 'thanks'].forEach(function (k) {
			var b = h('button', { type: 'button', role: 'tab', 'data-k': k, text: k === 'header' ? 'Header' : (k === 'footer' ? 'Footer' : 'Thank-you page') });
			b.addEventListener('click', function () { show(k); });
			tabs.appendChild(b);
		});
		app.appendChild(tabs); app.appendChild(pane); show('header');
		app.appendChild(saveBar(function () { return saveGroups({ header: hdr, footer: ftr, thanks: thx }).then(function (r) { return !!r; }); }));
	}

	function plansPage() {
		var obj = { plans: clone(A.data.plans), matrix: A.data.matrix };
		app.innerHTML = '';
		app.appendChild(pageHead('Pricing Plans', 'Add, remove and reorder plans. Prices, features and Freemius plan IDs are all editable. The Pricing section on the page displays exactly this.'));
		var tabs = h('div', { 'class': 'aiqda-tabs', role: 'tablist' });
		var pane = h('div', { 'class': 'aiqda-card' });
		var f1 = buildForm(A.schemas.plans, obj, function () { markDirty(true); });
		var f2 = buildForm([
			{ key: 'matrix', type: 'textarea', rows: 26, label: 'Comparison matrix (one row per line)', help: 'Format: Feature | plan 1 | plan 2 | plan 3 | plan 4  — same order as the plans. Values: yes, no, Pro, Agency, or any text. "# Title" starts a group.' }
		], obj, function () { markDirty(true); });
		f2.querySelector('textarea').classList.add('is-mono');
		var forms = { plans: f1, matrix: f2 };
		function show(k) {
			pane.innerHTML = ''; pane.appendChild(forms[k]);
			Array.prototype.forEach.call(tabs.children, function (b) { b.setAttribute('aria-selected', b.getAttribute('data-k') === k ? 'true' : 'false'); });
		}
		[['plans', 'Plans'], ['matrix', 'Comparison matrix']].forEach(function (p) {
			var b = h('button', { type: 'button', role: 'tab', 'data-k': p[0], text: p[1] });
			b.addEventListener('click', function () { show(p[0]); }); tabs.appendChild(b);
		});
		app.appendChild(tabs); app.appendChild(pane); show('plans');
		app.appendChild(saveBar(function () { return saveGroups({ plans: obj.plans, matrix: obj.matrix }).then(function (r) { return !!r; }); }));
	}

	function linksPage() {
		var obj = { links: clone(A.data.links) };
		app.innerHTML = '';
		app.appendChild(pageHead('Links & Buttons', 'Give a destination a key once, then type @key in any button or menu link. Change the URL here and every button that uses it updates.'));
		var schema = [{ key: 'links', type: 'repeater', label: 'Saved links', item_label: 'key', fields: A.schemas.links }];
		app.appendChild(h('div', { 'class': 'aiqda-card' }, [buildForm(schema, obj, function () { markDirty(true); })]));
		app.appendChild(h('p', { 'class': 'aiqda-hint', text: 'Tip: a link field also accepts #anchors (like #pricing) and full URLs. Deleting a key that is still used makes those buttons render as disabled.' }));
		app.appendChild(saveBar(function () { return saveGroups({ links: obj.links }).then(function (r) { return !!r; }); }));
	}

	/* ───────────── import / export ───────────── */
	function ioPage() {
		app.innerHTML = '';
		app.appendChild(pageHead('Import / Export', 'Back up all content, move it to another site, or start over.'));
		var msg = h('p', { 'class': 'aiqda-hint', 'aria-live': 'polite' });
		var file = h('input', { type: 'file', accept: 'application/json,.json', id: 'aiqda-file' });
		var imp = h('button', { type: 'button', 'class': 'aiqda-btn', text: 'Import file' });
		imp.addEventListener('click', function () {
			if (!file.files[0]) { msg.textContent = 'Choose a .json file first.'; return; }
			var rd = new FileReader();
			rd.onload = function () {
				ajax('aiqd_import', { json: rd.result }).then(function (r) {
					if (r.success) { msg.textContent = 'Imported ' + r.data.imported + ' groups. Reloading…'; setTimeout(function () { location.reload(); }, 800); }
					else { msg.textContent = (r.data && r.data.message) || T.error; }
				});
			};
			rd.readAsText(file.files[0]);
		});
		var reset = h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--danger', text: 'Reset everything to sample content' });
		reset.addEventListener('click', function () {
			if (!window.confirm('This restores ALL sections, plans, links, header, footer, design and SEO to the original sample content. Continue?')) { return; }
			ajax('aiqd_reset', { group: 'all' }).then(function () { msg.textContent = 'Reset. Reloading…'; setTimeout(function () { location.reload(); }, 600); });
		});
		app.appendChild(h('div', { 'class': 'aiqda-card' }, [
			h('h3', { text: 'Export' }), h('p', { text: 'Downloads one JSON file with sections, plans, matrix, links, header, footer, design and SEO.' }),
			h('a', { 'class': 'aiqda-btn aiqda-btn--primary', href: A.exportUrl, text: 'Download export (.json)' })
		]));
		app.appendChild(h('div', { 'class': 'aiqda-card' }, [
			h('h3', { text: 'Import' }), h('p', { text: 'Replaces the current content with the file’s content. Settings (assigned page, header/footer source) are not touched.' }),
			h('label', { 'for': 'aiqda-file', 'class': 'screen-reader-text', text: 'Export file' }), file, imp
		]));
		app.appendChild(h('div', { 'class': 'aiqda-card' }, [h('h3', { text: 'Start over' }), h('p', { text: 'Bring back the original demo content.' }), reset, msg]));
	}

	/* ───────────── PAGE BUILDER ───────────── */
	function builderPage() {
		var layout = clone(A.data.layout);
		var sel = layout.length ? layout[0].uid : null;
		var previewOn = false;
		var device = 'desktop';

		app.innerHTML = '';
		app.appendChild(pageHead('Page Builder', 'Drag sections to reorder, use + to insert between, the eye to hide, and click a row to edit.'));

		var cols = h('div', { 'class': 'aiqda-bcols' });
		var listBox = h('div', { 'class': 'aiqda-list' });
		var editBox = h('div', { 'class': 'aiqda-editor' });
		cols.appendChild(listBox); cols.appendChild(editBox);
		app.appendChild(cols);

		var prevBox = h('div', { 'class': 'aiqda-preview', hidden: true });
		app.appendChild(prevBox);

		function find(uid) { for (var i = 0; i < layout.length; i++) { if (layout[i].uid === uid) { return i; } } return -1; }
		function typeOf(inst) { return A.types[inst.type] || { label: inst.type, icon: 'layers', schema: [], defaults: {} }; }
		function rowTitle(inst) {
			var d = inst.data || {}; var def = typeOf(inst).defaults || {};
			var t = d.title !== undefined ? d.title : def.title;
			return plain(t || '');
		}
		function uniqueAnchor(base) {
			var a = base; var n = 2;
			while (layout.some(function (x) { return x.anchor === a; })) { a = base + '-' + n; n++; }
			return a;
		}
		function change() { markDirty(true); }

		/* list */
		function drawList() {
			listBox.innerHTML = '';
			var head = h('div', { 'class': 'aiqda-list__head' }, [
				h('strong', { text: layout.length + ' sections' }),
				h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--sm aiqda-btn--primary', text: '+ ' + T.addSection, onclick: function () { openPicker(layout.length); } })
			]);
			listBox.appendChild(head);
			if (!layout.length) { listBox.appendChild(h('p', { 'class': 'aiqda-empty', text: T.noSections })); return; }
			var ul = h('ul', { 'class': 'aiqda-rows' });
			var first = h('li', { 'class': 'aiqda-ins aiqda-ins--first' }, [insBtn(0)]);
			ul.appendChild(first);
			layout.forEach(function (inst, i) {
				var ty = typeOf(inst);
				var li = h('li', { 'class': 'aiqda-row' + (inst.uid === sel ? ' is-sel' : '') + (!inst.enabled ? ' is-off' : ''), 'data-uid': inst.uid });
				var handle = h('span', { 'class': 'aiqda-handle', 'aria-hidden': 'true', title: 'Drag' }, [svg('menu', 16)]);
				var main = h('button', { type: 'button', 'class': 'aiqda-row__main', 'aria-current': inst.uid === sel ? 'true' : null }, [
					svg(ty.icon, 18),
					h('span', { 'class': 'aiqda-row__txt' }, [h('b', { text: ty.label }), h('small', { text: rowTitle(inst) || '#' + (inst.anchor || inst.uid) })])
				]);
				main.addEventListener('click', function () { sel = inst.uid; drawList(); drawEditor(); scrollPreview(); });
				var ctl = h('span', { 'class': 'aiqda-row__ctl' });
				var eye = h('button', { type: 'button', 'class': 'aiqda-mini' + (inst.enabled ? '' : ' is-off'), 'aria-pressed': inst.enabled ? 'true' : 'false', 'aria-label': inst.enabled ? T.enabled : T.hidden, title: inst.enabled ? T.enabled : T.hidden, text: inst.enabled ? '👁' : '⊘' });
				eye.addEventListener('click', function () { inst.enabled = inst.enabled ? 0 : 1; change(); drawList(); if (sel === inst.uid) { drawEditor(); } });
				var up = h('button', { type: 'button', 'class': 'aiqda-mini', 'aria-label': T.moveUp, title: T.moveUp, text: '↑' });
				up.addEventListener('click', function () { move(i, i - 1); });
				var dn = h('button', { type: 'button', 'class': 'aiqda-mini', 'aria-label': T.moveDown, title: T.moveDown, text: '↓' });
				dn.addEventListener('click', function () { move(i, i + 1); });
				ctl.appendChild(eye); ctl.appendChild(up); ctl.appendChild(dn);
				li.appendChild(handle); li.appendChild(main); li.appendChild(ctl);
				ul.appendChild(li);
				ul.appendChild(h('li', { 'class': 'aiqda-ins' }, [insBtn(i + 1)]));
			});
			listBox.appendChild(ul);
			$(ul).sortable({
				items: '> li.aiqda-row', handle: '.aiqda-handle', axis: 'y', tolerance: 'pointer', placeholder: 'aiqda-ph',
				update: function () {
					var order = Array.prototype.map.call(ul.querySelectorAll('li.aiqda-row'), function (li) { return li.getAttribute('data-uid'); });
					layout.sort(function (a, b) { return order.indexOf(a.uid) - order.indexOf(b.uid); });
					change(); drawList();
				}
			});
		}
		function insBtn(at) {
			return h('button', { type: 'button', 'class': 'aiqda-insbtn', 'aria-label': T.insertHere, title: T.insertHere, onclick: function () { openPicker(at); } }, [h('span', { text: '+' })]);
		}
		function move(from, to) {
			if (to < 0 || to >= layout.length) { return; }
			layout.splice(to, 0, layout.splice(from, 1)[0]); change(); drawList();
		}

		/* editor */
		function drawEditor() {
			editBox.innerHTML = '';
			var i = find(sel);
			if (i < 0) { editBox.appendChild(h('p', { 'class': 'aiqda-empty', text: 'Select a section to edit.' })); return; }
			var inst = layout[i]; var ty = typeOf(inst);
			inst.data = Object.assign({}, clone(ty.defaults), inst.data || {});
			inst.style = Object.assign({ bg: 'default', space: 'md', hide: '', nav: '', 'class': '' }, inst.style || {});

			var tools = h('div', { 'class': 'aiqda-editor__tools' });
			[[T.duplicate, '⧉ ' + T.duplicate, function () {
				var c = clone(inst); c.uid = rid(); c.anchor = uniqueAnchor((inst.anchor || inst.type) + '-copy'); layout.splice(i + 1, 0, c); sel = c.uid; change(); drawList(); drawEditor();
			}], [T.resetSec, '↺ ' + T.resetSec, function () {
				if (window.confirm(T.confirmReset)) { inst.data = {}; change(); drawEditor(); drawList(); }
			}], [T.delete, '✕ ' + T.delete, function () {
				if (window.confirm(T.confirmDel)) { layout.splice(i, 1); sel = layout.length ? layout[Math.min(i, layout.length - 1)].uid : null; change(); drawList(); drawEditor(); }
			}]].forEach(function (b) {
				tools.appendChild(h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--sm' + (b[0] === T.delete ? ' aiqda-btn--danger' : ' aiqda-btn--ghost'), text: b[1], onclick: b[2] }));
			});

			var head = h('div', { 'class': 'aiqda-editor__head' }, [
				svg(ty.icon, 22),
				h('div', {}, [h('h3', { text: ty.label }), h('p', { text: ty.desc })]),
			]);

			var anchorId = nid('f');
			var anchorIn = h('input', { type: 'text', id: anchorId, 'class': 'aiqda-input', value: inst.anchor || '' });
			anchorIn.addEventListener('input', function () { inst.anchor = anchorIn.value.toLowerCase().replace(/[^a-z0-9\-_]/g, ''); change(); });
			var visId = nid('f');
			var vis = h('input', { type: 'checkbox', id: visId }); vis.checked = !!inst.enabled;
			vis.addEventListener('change', function () { inst.enabled = vis.checked ? 1 : 0; change(); drawList(); });

			var top = h('div', { 'class': 'aiqda-editor__meta' }, [
				h('div', { 'class': 'aiqda-field' }, [h('label', { 'for': anchorId, text: T.anchor }), anchorIn, h('p', { 'class': 'aiqda-help', text: 'Link to it with  #' + (inst.anchor || 'your-id') })]),
				h('div', { 'class': 'aiqda-field aiqda-field--toggle' }, [h('label', { 'class': 'aiqda-switch', 'for': visId }, [vis, h('span', { 'class': 'aiqda-switch__ui' }), h('span', { 'class': 'aiqda-switch__txt', text: T.enabled })])])
			]);

			var tabs = h('div', { 'class': 'aiqda-tabs', role: 'tablist' });
			var pane = h('div', { 'class': 'aiqda-editor__pane' });
			var contentForm = buildForm(ty.schema, inst.data, function () { change(); refreshRowLabel(inst); });
			var styleForm = buildForm(A.styleFields, inst.style, change);
			function show(k) {
				pane.innerHTML = ''; pane.appendChild(k === 'content' ? contentForm : styleForm);
				Array.prototype.forEach.call(tabs.children, function (b) { b.setAttribute('aria-selected', b.getAttribute('data-k') === k ? 'true' : 'false'); });
			}
			[['content', T.content], ['style', T.style]].forEach(function (p) {
				var b = h('button', { type: 'button', role: 'tab', 'data-k': p[0], text: p[1] }); b.addEventListener('click', function () { show(p[0]); }); tabs.appendChild(b);
			});
			editBox.appendChild(head); editBox.appendChild(tools); editBox.appendChild(top); editBox.appendChild(tabs); editBox.appendChild(pane);
			show('content');
		}
		var labelTimer = null;
		function refreshRowLabel(inst) {
			clearTimeout(labelTimer);
			labelTimer = setTimeout(function () {
				var row = listBox.querySelector('[data-uid="' + inst.uid + '"] small');
				if (row) { row.textContent = rowTitle(inst) || '#' + (inst.anchor || inst.uid); }
			}, 150);
		}

		/* picker modal */
		function openPicker(at) {
			var ov = h('div', { 'class': 'aiqda-modal', role: 'dialog', 'aria-modal': 'true', 'aria-label': T.addSection });
			var box = h('div', { 'class': 'aiqda-modal__box' });
			var q = h('input', { type: 'search', 'class': 'aiqda-input', placeholder: 'Search section types…', 'aria-label': 'Search section types' });
			var grid = h('div', { 'class': 'aiqda-picker' });
			function close() { document.removeEventListener('keydown', esc); ov.parentNode && ov.parentNode.removeChild(ov); }
			function esc(e) { if (e.key === 'Escape') { close(); } }
			document.addEventListener('keydown', esc);
			function fill() {
				grid.innerHTML = '';
				var term = q.value.trim().toLowerCase();
				Object.keys(A.types).filter(function (k) { return A.types[k].zone === 'body'; }).sort(function (a, b) { return A.types[a].label.localeCompare(A.types[b].label); }).forEach(function (k) {
					var ty = A.types[k];
					if (term && (ty.label + ' ' + ty.desc + ' ' + k).toLowerCase().indexOf(term) === -1) { return; }
					var b = h('button', { type: 'button', 'class': 'aiqda-pick' }, [svg(ty.icon, 26), h('b', { text: ty.label }), h('small', { text: ty.desc })]);
					b.addEventListener('click', function () {
						var inst = { uid: rid(), type: k, enabled: 1, anchor: uniqueAnchor(k), style: {}, data: clone(ty.defaults) };
						layout.splice(at, 0, inst); sel = inst.uid; change(); close(); drawList(); drawEditor();
						var row = listBox.querySelector('[data-uid="' + inst.uid + '"]'); if (row && row.scrollIntoView) { row.scrollIntoView({ block: 'nearest' }); }
					});
					grid.appendChild(b);
				});
			}
			q.addEventListener('input', fill); fill();
			box.appendChild(h('div', { 'class': 'aiqda-modal__head' }, [h('h3', { text: T.addSection }), h('button', { type: 'button', 'class': 'aiqda-mini', 'aria-label': 'Close', text: '✕', onclick: close })]));
			box.appendChild(q); box.appendChild(grid); ov.appendChild(box);
			ov.addEventListener('click', function (e) { if (e.target === ov) { close(); } });
			document.body.appendChild(ov); q.focus();
		}

		/* preview */
		function previewUrl() {
			if (!A.siteUrl) { return ''; }
			var i = find(sel); var anchor = i >= 0 ? (layout[i].anchor || layout[i].uid) : '';
			return A.siteUrl + (A.siteUrl.indexOf('?') > -1 ? '&' : '?') + 'aiqd_prev=' + Date.now() + (anchor ? '#' + anchor : '');
		}
		var frame = null;
		function drawPreview() {
			prevBox.innerHTML = '';
			var bar = h('div', { 'class': 'aiqda-preview__bar' }, [h('strong', { text: T.preview })]);
			[['desktop', 'Desktop', '100%'], ['tablet', 'Tablet', '820px'], ['mobile', 'Mobile', '390px']].forEach(function (d) {
				var b = h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--sm ' + (device === d[0] ? 'aiqda-btn--primary' : 'aiqda-btn--ghost'), text: d[1] });
				b.addEventListener('click', function () { device = d[0]; frame.style.width = d[2]; drawPreviewBtns(); });
				b.setAttribute('data-d', d[0]); bar.appendChild(b);
			});
			bar.appendChild(h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--sm aiqda-btn--ghost', text: '↻ Reload', onclick: reloadPreview }));
			prevBox.appendChild(bar);
			if (!A.siteUrl) { prevBox.appendChild(h('p', { 'class': 'aiqda-empty', text: 'Assign and publish a landing page in Settings to see the preview.' })); return; }
			frame = h('iframe', { 'class': 'aiqda-frame', title: T.preview, src: previewUrl(), loading: 'lazy' });
			frame.style.width = device === 'desktop' ? '100%' : (device === 'tablet' ? '820px' : '390px');
			prevBox.appendChild(h('div', { 'class': 'aiqda-frame__wrap' }, [frame]));
		}
		function drawPreviewBtns() {
			Array.prototype.forEach.call(prevBox.querySelectorAll('[data-d]'), function (b) {
				var on = b.getAttribute('data-d') === device; b.className = 'aiqda-btn aiqda-btn--sm ' + (on ? 'aiqda-btn--primary' : 'aiqda-btn--ghost');
			});
		}
		function reloadPreview() { if (frame) { frame.src = previewUrl(); } }
		function scrollPreview() {
			if (!previewOn || !frame || !frame.contentWindow) { return; }
			var i = find(sel); if (i < 0) { return; }
			try { var el = frame.contentWindow.document.getElementById(layout[i].anchor || layout[i].uid); if (el) { el.scrollIntoView({ behavior: 'smooth' }); } } catch (e) { /* cross-origin */ }
		}

		var pvBtn = h('button', { type: 'button', 'class': 'aiqda-btn aiqda-btn--ghost', text: '▭ ' + T.preview });
		pvBtn.addEventListener('click', function () {
			previewOn = !previewOn; prevBox.hidden = !previewOn;
			pvBtn.setAttribute('aria-pressed', previewOn ? 'true' : 'false');
			if (previewOn) { drawPreview(); prevBox.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
		});

		var bar = saveBar(function () {
			return saveGroups({ layout: layout }).then(function (r) {
				if (!r) { return false; }
				layout = r.layout;
				if (find(sel) < 0) { sel = layout.length ? layout[0].uid : null; }
				drawList(); drawEditor();
				if (previewOn) { reloadPreview(); }
				return true;
			});
		});
		bar.insertBefore(pvBtn, bar.firstChild);
		app.appendChild(bar);

		drawList(); drawEditor();
	}

	/* ───────────── router ───────────── */
	switch (A.page) {
		case 'builder': builderPage(); break;
		case 'plans': plansPage(); break;
		case 'links': linksPage(); break;
		case 'hf': headerFooterPage(); break;
		case 'design': simplePage('Design', 'Colours, shape, typography and motion for the whole landing page.', 'design', A.schemas.design); break;
		case 'seo': simplePage('SEO & LLM', 'Search snippets, social cards, structured data, llms.txt and AI-crawler rules.', 'seo', A.schemas.seo); break;
		case 'settings': simplePage('Settings', 'Which page is the landing page, where header and footer come from, and the floating elements.', 'settings', A.schemas.settings); break;
		case 'io': ioPage(); break;
	}
})(jQuery);
