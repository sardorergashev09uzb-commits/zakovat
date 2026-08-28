/* =========================================================================
   ZAKOVAT — main.js
   Barcha sahifalarda umumiy bo'lgan interaktivlik: mobil navbar menyusi
   va footer'dagi joriy yilni ko'rsatish. Sahifaga xos skriptlar
   (quiz.html, admin-questions.html va h.k.) har bir HTML faylning
   oxirida alohida <script> blokida yoziladi.
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
});
