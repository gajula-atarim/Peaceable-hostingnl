/* vtHullenaar front-end behaviour: marquee loops, animated waves, tab switchers. */
(function () {
	'use strict';

	function ready(fn) {
		if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); }
	}

	var WAVE = '<svg viewBox="0 0 1440 320" preserveAspectRatio="none"><path fill="FILL" d="M0,192 C240,96 480,288 720,192 C960,96 1200,288 1440,192 L1440,320 L0,320 Z"></path></svg>';
	var WAVE_FILLS = ['rgba(63,169,245,0.10)', 'rgba(31,127,196,0.16)', 'rgba(4,11,26,0.85)'];

	function pad(n) { return (n < 10 ? '0' : '') + n; }

	function cloneChildren(parent, selector) {
		Array.prototype.slice.call(parent.querySelectorAll(selector)).forEach(function (el) {
			var c = el.cloneNode(true);
			c.setAttribute('aria-hidden', 'true');
			c.removeAttribute('data-id');
			parent.appendChild(c);
		});
	}

	function decorate() {
		document.querySelectorAll('.vt-marquee .elementor-icon-list-items').forEach(function (ul) {
			cloneChildren(ul, ':scope > li');
		});
		document.querySelectorAll('.vt-wall > .vt-col').forEach(function (col) {
			cloneChildren(col, ':scope > .elementor-widget');
		});
		document.querySelectorAll('.vt-waves').forEach(function (sec) {
			var layers = sec.classList.contains('vt-page-header') ? 2 : 3;
			for (var i = layers; i >= 1; i--) {
				var d = document.createElement('div');
				d.className = 'vt-wave vt-wave--' + i;
				d.setAttribute('aria-hidden', 'true');
				d.innerHTML = WAVE.replace('FILL', WAVE_FILLS[i - 1]) + WAVE.replace('FILL', WAVE_FILLS[i - 1]);
				sec.insertBefore(d, sec.firstChild);
			}
		});
		document.querySelectorAll('.vt-blob').forEach(function (sec) {
			var b = document.createElement('div');
			b.className = 'vt-blob-shape';
			b.setAttribute('aria-hidden', 'true');
			sec.insertBefore(b, sec.firstChild);
		});
	}

	function switcher(sw) {
		var panes = Array.prototype.slice.call(sw.querySelectorAll('.vt-pane'));
		var tabs = Array.prototype.slice.call(sw.querySelectorAll('.vt-tab'));
		var n = panes.length;
		if (!n) { return; }
		var interval = sw.closest('.vt-services') ? 4000 : (sw.classList.contains('vt-switch--cards') ? 7000 : 5000);
		sw.style.setProperty('--vt-interval', interval + 'ms');
		var counter = sw.querySelector('.vt-counter .elementor-heading-title');
		var bars = [];
		var stage = sw.querySelector('.vt-stage--svc');
		if (stage) {
			var prog = document.createElement('div');
			prog.className = 'vt-progress';
			for (var b = 0; b < n; b++) { var s = document.createElement('span'); s.appendChild(document.createElement('i')); prog.appendChild(s); bars.push(s); }
			stage.appendChild(prog);
		}
		var cur = 0, timer;

		function restartAnim(el) { el.classList.remove('is-active'); void el.offsetWidth; el.classList.add('is-active'); }

		function show(i) {
			cur = (i + n) % n;
			panes.forEach(function (p, k) { p.classList.toggle('is-active', k === cur); });
			tabs.forEach(function (t, k) { if (k === cur) { restartAnim(t); } else { t.classList.remove('is-active'); } });
			bars.forEach(function (s, k) { s.classList.toggle('is-past', k < cur); if (k === cur) { restartAnim(s); } else { s.classList.remove('is-active'); } });
			if (counter) { counter.textContent = pad(cur + 1) + ' / ' + pad(n); }
		}
		function restart() { clearInterval(timer); timer = setInterval(function () { show(cur + 1); }, interval); }
		function go(i) { show(i); restart(); }

		tabs.forEach(function (t, k) {
			t.addEventListener('mouseenter', function () { if (k !== cur) { go(k); } });
			t.addEventListener('click', function () { go(k); });
		});
		var prev = sw.querySelector('.vt-prev a, .vt-prev .elementor-button');
		var next = sw.querySelector('.vt-next a, .vt-next .elementor-button');
		if (prev) { prev.addEventListener('click', function (e) { e.preventDefault(); go(cur - 1); }); }
		if (next) { next.addEventListener('click', function (e) { e.preventDefault(); go(cur + 1); }); }
		if (sw.classList.contains('vt-switch--cards')) {
			panes.forEach(function (p) { p.addEventListener('click', function () { go(cur + 1); }); });
		}
		show(0);
		restart();
	}

	ready(function () {
		if (document.body.classList.contains('elementor-editor-active')) { return; }
		decorate();
		document.querySelectorAll('.vt-switch').forEach(switcher);
	});
})();

/* vtHullenaar: project gallery lightbox with previous/next, counter, keyboard and swipe. */
(function () {
	'use strict';
	function ready(fn) { if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
	ready(function () {
		var en = /^en/i.test(document.documentElement.lang || '');
		var t = en ? { prev: 'Previous photo', next: 'Next photo', close: 'Close' } : { prev: 'Vorige foto', next: 'Volgende foto', close: 'Sluiten' };
		var sel = 'a[data-elementor-open-lightbox="yes"]';
		var box, img, cap, count, prevBtn, nextBtn, items = [], index = 0, lastFocus, touchX = null;
		function toArray(list) { return Array.prototype.slice.call(list); }
		function isImage(a) { return /\.(jpe?g|png|webp|gif|avif)(\?|$)/i.test(a.getAttribute('href') || ''); }
		// All lightbox photos in the same top-level section form one slideshow.
		function groupOf(a) {
			var root = a.closest('.e-con.e-parent') || document;
			return toArray(root.querySelectorAll(sel)).filter(isImage);
		}
		function show(i) {
			index = (i + items.length) % items.length;
			var a = items[index], thumb = a.querySelector('img');
			img.src = a.getAttribute('href');
			img.alt = thumb ? thumb.alt : '';
			cap.textContent = a.getAttribute('data-elementor-lightbox-title') || img.alt;
			count.textContent = (index + 1) + ' / ' + items.length;
			prevBtn.hidden = nextBtn.hidden = items.length < 2;
		}
		function close() {
			box.hidden = true;
			document.documentElement.classList.remove('vt-lb-open');
			if (lastFocus && lastFocus.focus) { lastFocus.focus(); }
		}
		function build() {
			box = document.createElement('div');
			box.className = 'vt-lb';
			box.hidden = true;
			box.setAttribute('role', 'dialog');
			box.setAttribute('aria-modal', 'true');
			box.innerHTML = '<div class="vt-lb__count"></div>' +
				'<button type="button" class="vt-lb__close" aria-label="' + t.close + '">&times;</button>' +
				'<button type="button" class="vt-lb__nav vt-lb__prev" aria-label="' + t.prev + '">&#8592;</button>' +
				'<figure class="vt-lb__fig"><img class="vt-lb__img" alt=""><figcaption class="vt-lb__cap"></figcaption></figure>' +
				'<button type="button" class="vt-lb__nav vt-lb__next" aria-label="' + t.next + '">&#8594;</button>';
			document.body.appendChild(box);
			img = box.querySelector('.vt-lb__img');
			cap = box.querySelector('.vt-lb__cap');
			count = box.querySelector('.vt-lb__count');
			prevBtn = box.querySelector('.vt-lb__prev');
			nextBtn = box.querySelector('.vt-lb__next');
			prevBtn.addEventListener('click', function () { show(index - 1); });
			nextBtn.addEventListener('click', function () { show(index + 1); });
			box.querySelector('.vt-lb__close').addEventListener('click', close);
			box.addEventListener('click', function (e) { if (e.target === box || e.target.classList.contains('vt-lb__fig')) { close(); } });
			box.addEventListener('touchstart', function (e) { touchX = e.touches[0].clientX; }, { passive: true });
			box.addEventListener('touchend', function (e) {
				if (touchX === null) { return; }
				var dx = e.changedTouches[0].clientX - touchX;
				touchX = null;
				if (Math.abs(dx) > 40 && items.length > 1) { show(index + (dx < 0 ? 1 : -1)); }
			});
		}
		function open(list, i) {
			if (!list.length) { return; }
			if (!box) { build(); }
			items = list;
			lastFocus = document.activeElement;
			box.hidden = false;
			document.documentElement.classList.add('vt-lb-open');
			show(i);
			(items.length > 1 ? nextBtn : box.querySelector('.vt-lb__close')).focus();
		}
		document.addEventListener('keydown', function (e) {
			if (!box || box.hidden) { return; }
			if (e.key === 'Escape') { close(); } else if (e.key === 'ArrowLeft') { show(index - 1); } else if (e.key === 'ArrowRight') { show(index + 1); }
		});
		// Capture phase: runs before (and replaces) Elementor's single-image lightbox.
		window.addEventListener('click', function (e) {
			if (!e.target.closest) { return; }
			var btn = e.target.closest('.vt-open-gallery');
			if (btn) {
				var tiles = toArray(document.querySelectorAll('.vt-mtile ' + sel)).filter(isImage);
				if (!tiles.length) { return; }
				e.preventDefault();
				e.stopImmediatePropagation();
				open(tiles, 0);
				return;
			}
			var a = e.target.closest(sel);
			if (!a || !isImage(a) || (box && box.contains(a))) { return; }
			e.preventDefault();
			e.stopImmediatePropagation();
			var list = groupOf(a);
			open(list, Math.max(0, list.indexOf(a)));
		}, true);
	});
})();

/* vtHullenaar: contact form result state. */
(function () {
	'use strict';
	function ready(fn) { if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
	ready(function () {
		var m = /[?&]vt_sent=([01])/.exec(window.location.search);
		var form = document.querySelector('.vt-form .vt-form-el');
		if (!m || !form) { return; }
		var en = /^en/i.test(document.documentElement.lang || '');
		if (m[1] === '1') {
			var card = form.closest('.vt-form-card') || form.parentNode;
			card.innerHTML = '<div class="vt-form-thanks"><b>✓</b><strong>' + (en ? 'Thank you for your message' : 'Bedankt voor uw bericht') + '</strong></div>';
		} else {
			var p = document.createElement('p');
			p.className = 'vt-form-error';
			p.textContent = en ? 'Sorry, your message could not be sent. Email us at info@vthullenaar.nl.' : 'Sorry, uw bericht kon niet worden verzonden. Mail ons op info@vthullenaar.nl.';
			form.insertBefore(p, form.firstChild);
		}
	});
})();

/* vtHullenaar: NL | EN switcher links to the translation of the current page (Polylang hreflang alternates). */
(function () {
	'use strict';
	function ready(fn) { if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
	ready(function () {
		document.querySelectorAll('.vt-lang__opt[lang]').forEach(function (a) {
			var alt = document.querySelector('link[rel="alternate"][hreflang^="' + a.getAttribute('lang') + '"]');
			if (alt && alt.href) { a.href = alt.href; }
		});
	});
})();
