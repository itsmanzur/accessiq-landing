/* AccessIQ Landing — tiny helpers for the dashboard and docs screens (copy buttons, docs search / TOC). */
(function () {
	'use strict';
	var D = document;

	D.addEventListener('click', function (e) {
		var b = e.target.closest('.aiqda-copy');
		if (!b) { return; }
		var txt = b.getAttribute('data-copy') || '';
		var done = function () { var old = b.textContent; b.textContent = '✓'; setTimeout(function () { b.textContent = old; }, 1200); };
		if (navigator.clipboard && navigator.clipboard.writeText) {
			navigator.clipboard.writeText(txt).then(done);
		} else {
			var ta = D.createElement('textarea'); ta.value = txt; D.body.appendChild(ta); ta.select();
			try { D.execCommand('copy'); done(); } catch (err) { /* ignore */ }
			D.body.removeChild(ta);
		}
	});

	var search = D.getElementById('aiqda-doc-search');
	if (search) {
		var secs = Array.prototype.slice.call(D.querySelectorAll('.aiqda-doc section'));
		var links = Array.prototype.slice.call(D.querySelectorAll('.aiqda-toc a'));
		search.addEventListener('input', function () {
			var q = search.value.trim().toLowerCase();
			secs.forEach(function (s, i) {
				var ok = !q || s.textContent.toLowerCase().indexOf(q) !== -1;
				s.hidden = !ok;
				if (links[i]) { links[i].parentNode.hidden = !ok; }
			});
		});
		var io = ('IntersectionObserver' in window) ? new IntersectionObserver(function (es) {
			es.forEach(function (e) {
				if (e.isIntersecting) {
					links.forEach(function (a) { a.classList.toggle('is-active', a.getAttribute('href') === '#' + e.target.id); });
				}
			});
		}, { rootMargin: '-20% 0px -70% 0px' }) : null;
		if (io) { secs.forEach(function (s) { io.observe(s); }); }
	}
})();
