// Auto-dismiss flash messages.
(function () {
  var f = document.querySelector('.flash');
  if (f) setTimeout(function () { f.style.transition = 'opacity .4s'; f.style.opacity = '0';
    setTimeout(function () { f.remove(); }, 400); }, 4000);
})();
