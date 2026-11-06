// Auto-dismiss the flash toast.
(function () {
  var t = document.getElementById('toast');
  if (t) setTimeout(function () { t.style.transition = 'opacity .4s'; t.style.opacity = '0';
    setTimeout(function () { t.remove(); }, 400); }, 3500);
})();

// Reveal sections on scroll.
(function () {
  if (!('IntersectionObserver' in window)) return;
  var els = document.querySelectorAll('.skill-card, .project, .exp-item, .section-head');
  els.forEach(function (el) { el.style.opacity = '0'; el.style.transform = 'translateY(24px)';
    el.style.transition = 'opacity .6s ease, transform .6s ease'; });
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (en) {
      if (en.isIntersecting) { en.target.style.opacity = '1'; en.target.style.transform = 'none';
        io.unobserve(en.target); }
    });
  }, { threshold: 0.12 });
  els.forEach(function (el) { io.observe(el); });
})();
