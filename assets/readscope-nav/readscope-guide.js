/* Readscope page guide. Shared by the product demo sites. Source: nav/guide/guide.js, built by build.js, do not edit copies.
 *
 * RSGuide.init({
 *   sections: '.main > [data-section]',          // selector or array of elements
 *   label:    function (el, i) { return 'Name'; }, // optional, default: data-label / data-nav / first heading
 *   mount:    '.my-root',                          // element that carries the theme variables (default: body)
 *   progress: true,                                // thin reading-progress line at the top
 *   skip:     1,                                   // hide the guide until this many sections are passed
 *   text:     { sections: 'Sections', of: 'of', close: 'Close' }
 * });
 */
( function ( W, D ) {
	'use strict';

	var reduce = W.matchMedia && W.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	function $$( s, r ) { return Array.prototype.slice.call( ( r || D ).querySelectorAll( s ) ); }
	function el( tag, cls, html ) {
		var n = D.createElement( tag );
		if ( cls ) { n.className = cls; }
		if ( html ) { n.innerHTML = html; }
		return n;
	}
	function esc( s ) { return String( s ).replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ).replace( /"/g, '&quot;' ); }

	function defaultLabel( s ) {
		var t = s.getAttribute( 'data-label' ) || s.getAttribute( 'data-nav' );
		if ( ! t ) {
			var h = s.querySelector( 'h1, h2, h3, .eyebrow, [class*="eyebrow"]' );
			t = h ? h.textContent : s.id;
		}
		return String( t || '' ).replace( /\s+/g, ' ' ).replace( /·.*$/, '' ).trim();
	}

	function init( o ) {
		o = o || {};
		var txt = Object.assign( { sections: 'Sections', of: 'of', close: 'Close' }, o.text || {} );
		var list = Array.isArray( o.sections ) ? o.sections : $$( o.sections || 'main > section[id]' );
		var secs = list.filter( function ( s ) { return s && s.id; } );
		if ( secs.length < 3 ) { return null; }
		var labelFn = o.label || defaultLabel;
		var labels = secs.map( function ( s, i ) { return labelFn( s, i ) || defaultLabel( s ) || String( i + 1 ); } );
		var mount = ( o.mount && ( typeof o.mount === 'string' ? D.querySelector( o.mount ) : o.mount ) ) || D.body;
		var skip = o.skip == null ? 1 : o.skip;
		var n = secs.length;

		var root = el( 'aside', 'rsg' );
		root.setAttribute( 'aria-label', txt.sections );
		root.style.setProperty( '--rsg-n', n );
		var dots = labels.map( function ( l, i ) {
			return '<li><a href="#' + esc( secs[ i ].id ) + '" data-i="' + i + '"><span class="rsg__tip">' + esc( l ) + '</span><span class="rsg__sr">' + esc( l ) + '</span></a></li>';
		} ).join( '' );
		var items = labels.map( function ( l, i ) {
			return '<li><a href="#' + esc( secs[ i ].id ) + '" data-i="' + i + '"><i>' + ( i + 1 ) + '</i><span>' + esc( l ) + '</span></a></li>';
		} ).join( '' );
		root.innerHTML =
			( o.progress === false ? '' : '<div class="rsg__bar" aria-hidden="true"><span></span></div>' ) +
			'<div class="rsg__rail">' +
				'<button type="button" class="rsg__btn" aria-expanded="false" aria-controls="rsg-panel">' +
					'<svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true" focusable="false"><path d="M3 5h14M3 10h14M3 15h9" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>' +
					'<span class="rsg__cnt"><b>1</b>/' + n + '</span><span class="rsg__sr">' + esc( txt.sections ) + '</span>' +
				'</button>' +
				'<ol class="rsg__dots">' + dots + '</ol>' +
				'<span class="rsg__now" aria-hidden="true"></span>' +
			'</div>' +
			'<div class="rsg__panel" id="rsg-panel" role="dialog" aria-label="' + esc( txt.sections ) + '" hidden>' +
				'<div class="rsg__head"><b>' + esc( txt.sections ) + '</b><button type="button" class="rsg__x" aria-label="' + esc( txt.close ) + '">&times;</button></div>' +
				'<ol class="rsg__list">' + items + '</ol>' +
			'</div>';
		mount.appendChild( root );

		var btn = root.querySelector( '.rsg__btn' );
		var panel = root.querySelector( '.rsg__panel' );
		var cnt = root.querySelector( '.rsg__cnt b' );
		var now = root.querySelector( '.rsg__now' );
		var bar = root.querySelector( '.rsg__bar span' );
		var dotA = $$( '.rsg__dots a', root );
		var listA = $$( '.rsg__list a', root );
		var cur = -1;

		function setCurrent( i ) {
			if ( i === cur ) { return; }
			cur = i;
			cnt.textContent = i + 1;
			dotA.forEach( function ( a, k ) {
				a.classList.toggle( 'is-on', k === i );
				if ( k === i ) { a.setAttribute( 'aria-current', 'true' ); } else { a.removeAttribute( 'aria-current' ); }
			} );
			listA.forEach( function ( a, k ) {
				a.classList.toggle( 'is-on', k === i );
			} );
			now.textContent = labels[ i ];
			var a = dotA[ i ];
			if ( a ) { now.style.top = ( a.parentNode.offsetTop + a.offsetHeight / 2 ) + 'px'; }
			if ( ! panel.hidden ) {
				var on = listA[ i ];
				if ( on && on.scrollIntoView ) { on.scrollIntoView( { block: 'nearest' } ); }
			}
		}

		function open( v ) {
			panel.hidden = ! v;
			btn.setAttribute( 'aria-expanded', v ? 'true' : 'false' );
			root.classList.toggle( 'is-open', v );
			if ( v ) {
				var on = listA[ Math.max( cur, 0 ) ];
				if ( on ) { on.scrollIntoView( { block: 'center' } ); on.focus( { preventScroll: true } ); }
			}
		}

		function go( e ) {
			var a = e.target.closest( 'a[data-i]' );
			if ( ! a ) { return; }
			var s = secs[ +a.getAttribute( 'data-i' ) ];
			if ( ! s ) { return; }
			e.preventDefault();
			open( false );
			s.scrollIntoView( { behavior: reduce ? 'auto' : 'smooth', block: 'start' } );
			if ( W.history && W.history.replaceState ) { W.history.replaceState( null, '', '#' + s.id ); }
		}

		btn.addEventListener( 'click', function () { open( panel.hidden ); } );
		root.querySelector( '.rsg__x' ).addEventListener( 'click', function () { open( false ); btn.focus(); } );
		root.addEventListener( 'click', go );
		D.addEventListener( 'click', function ( e ) { if ( ! panel.hidden && ! root.contains( e.target ) ) { open( false ); } } );
		D.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && ! panel.hidden ) { open( false ); btn.focus(); }
		} );

		// Current section: the one crossing the middle of the viewport.
		function measure() {
			var mid = W.innerHeight * 0.45;
			var best = 0;
			for ( var i = 0; i < n; i++ ) {
				if ( secs[ i ].getBoundingClientRect().top <= mid ) { best = i; } else { break; }
			}
			setCurrent( best );
			var de = D.documentElement;
			var max = de.scrollHeight - W.innerHeight;
			var y = W.pageYOffset || de.scrollTop;
			if ( bar ) { bar.style.transform = 'scaleX(' + ( max > 0 ? Math.min( 1, y / max ) : 0 ) + ')'; }
			root.classList.toggle( 'is-on', best >= skip );
		}
		var tick = false;
		function onScroll() {
			if ( tick ) { return; }
			tick = true;
			W.requestAnimationFrame( function () { tick = false; measure(); } );
		}
		W.addEventListener( 'scroll', onScroll, { passive: true } );
		W.addEventListener( 'resize', function () { cur = -1; onScroll(); } );
		measure();
		return { root: root, open: open };
	}

	W.RSGuide = { init: init };
}( window, document ) );
