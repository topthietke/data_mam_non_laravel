/**
 * main.js — Mầm Non Sao Nhỏ
 * - Hiệu ứng xuất hiện khi cuộn (scroll reveal)
 * - Đếm số chạy trong dải số liệu nổi bật
 * - Slider cảm nhận phụ huynh (không phụ thuộc thư viện ngoài)
 * - Nút "lên đầu trang"
 * - Validate form đăng ký phía trình duyệt (kèm với validate PHP phía server)
 */
document.addEventListener('DOMContentLoaded', function () {

  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- 1. Scroll reveal ---------- */
  var revealEls = document.querySelectorAll('[data-reveal]');
  if ('IntersectionObserver' in window && !prefersReducedMotion) {
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var delay = entry.target.getAttribute('data-reveal-delay') || 0;
          setTimeout(function () {
            entry.target.classList.add('is-visible');
          }, parseInt(delay, 10));
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });
    revealEls.forEach(function (el) { revealObserver.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* ---------- 2. Đếm số chạy (stats) ---------- */
  var statEls = document.querySelectorAll('.stat-so');
  function chayDemSo(el) {
    var target = parseInt(el.getAttribute('data-count'), 10) || 0;
    var suffix = el.textContent.replace(/[0-9]/g, ''); // giữ lại % hoặc +
    var start = 0;
    var duration = 1200;
    var startTime = null;

    function buoc(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      var value = Math.floor(progress * (target - start) + start);
      el.textContent = value + suffix;
      if (progress < 1) requestAnimationFrame(buoc);
      else el.textContent = target + suffix;
    }
    requestAnimationFrame(buoc);
  }
  if (statEls.length) {
    if ('IntersectionObserver' in window && !prefersReducedMotion) {
      var statObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            chayDemSo(entry.target);
            statObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.5 });
      statEls.forEach(function (el) { statObserver.observe(el); });
    }
  }

  /* ---------- 3. Slider cảm nhận phụ huynh ---------- */
  var track = document.getElementById('testimonialTrack');
  var dotsWrap = document.getElementById('testimonialDots');
  if (track && dotsWrap) {
    var cards = track.children;
    var soLuong = cards.length;
    var chiSoHienTai = 0;
    var timer = null;

    for (var i = 0; i < soLuong; i++) {
      var dot = document.createElement('button');
      dot.type = 'button';
      dot.setAttribute('aria-label', 'Xem cảm nhận số ' + (i + 1));
      if (i === 0) dot.classList.add('active');
      (function (idx) {
        dot.addEventListener('click', function () { diToi(idx); resetTimer(); });
      })(i);
      dotsWrap.appendChild(dot);
    }

    function diToi(idx) {
      chiSoHienTai = (idx + soLuong) % soLuong;
      track.style.transform = 'translateX(-' + (chiSoHienTai * 100) + '%)';
      var dots = dotsWrap.children;
      for (var d = 0; d < dots.length; d++) {
        dots[d].classList.toggle('active', d === chiSoHienTai);
      }
    }

    function resetTimer() {
      if (timer) clearInterval(timer);
      if (!prefersReducedMotion) {
        timer = setInterval(function () { diToi(chiSoHienTai + 1); }, 6000);
      }
    }

    if (soLuong > 1) resetTimer();
  }

  /* ---------- 4. Nút lên đầu trang ---------- */
  var backToTop = document.querySelector('.back-to-top');
  if (backToTop) {
    window.addEventListener('scroll', function () {
      backToTop.classList.toggle('show', window.scrollY > 480);
    });
    backToTop.addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
    });
  }

  /* ---------- 5. Validate form đăng ký phía trình duyệt ---------- */
  var form = document.getElementById('formDangKy');
  if (form) {
    form.addEventListener('submit', function (e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  }

  /* ---------- 6. Đóng menu di động sau khi chọn mục ---------- */
  var navLinks = document.querySelectorAll('#menuChinh .nav-link');
  var menuChinh = document.getElementById('menuChinh');
  if (menuChinh) {
    navLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        if (menuChinh.classList.contains('show')) {
          var collapseInstance = bootstrap.Collapse.getOrCreateInstance(menuChinh);
          collapseInstance.hide();
        }
      });
    });
  }
});
