/* =========================================================================
   ZAKOVAT — main.js
   Barcha sahifalarda umumiy bo'lgan interaktivlik: mobil navbar menyusi,
   footer joriy yili va kategoriya filtrlari.
   ========================================================================= */

document.addEventListener('DOMContentLoaded', function () {
  /* Mobil navbar menyusini ochish/yopish */
  var navToggle = document.getElementById('navToggle');
  var navLinks = document.getElementById('navLinks');

  if (navToggle && navLinks) {
    navToggle.addEventListener('click', function () {
      var isOpen = navLinks.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  /* Footer'dagi joriy yilni avtomatik yozish */
  var yearEl = document.getElementById('currentYear');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }

  /* Kategoriyalar sahifasida qiyinlik bo'yicha filter */
  var filterBar = document.getElementById('filterBar');
  var categoryGrid = document.getElementById('categoryGrid');
  if (filterBar && categoryGrid) {
    var filterChips = filterBar.querySelectorAll('.filter-chip');
    var cards = categoryGrid.querySelectorAll('.quiz-card');

    filterChips.forEach(function (chip) {
      chip.addEventListener('click', function () {
        filterChips.forEach(function (c) { c.classList.remove('is-active'); });
        chip.classList.add('is-active');

        var filter = chip.getAttribute('data-filter');
        cards.forEach(function (card) {
          if (filter === 'all' || card.getAttribute('data-difficulty') === filter) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  }
});
