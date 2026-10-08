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

/* vtHullenaar: project gallery as one lightbox slideshow + "Open gallery" button. */
(function () {
	'use strict';
	function ready(fn) { if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
	ready(function () {
		var links = document.querySelectorAll('.vt-mtile a');
		links.forEach(function (a) { a.setAttribute('data-elementor-lightbox-slideshow', 'vt-projects'); });
		document.querySelectorAll('.vt-open-gallery a, .vt-open-gallery .elementor-button').forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				if (!links.length) { return; }
				e.preventDefault();
				links[0].click();
			});
		});
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
		if (m[1] === '1') {
			var card = form.closest('.vt-form-card') || form.parentNode;
			card.innerHTML = '<div class="vt-form-thanks"><b>✓</b><strong>Thank you</strong></div>';
		} else {
			var p = document.createElement('p');
			p.className = 'vt-form-error';
			p.textContent = 'Sorry, your message could not be sent. Please email info@vthullenaar.nl.';
			form.insertBefore(p, form.firstChild);
		}
	});
})();
