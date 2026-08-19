/**
 * admin.js — Khu vực Quản trị Sao Nhỏ
 * Xử lý mở/đóng sidebar trên màn hình nhỏ.
 */
document.addEventListener('DOMContentLoaded', function () {
  var toggleBtn = document.getElementById('adminMenuToggle');
  var sidebar = document.querySelector('.admin-sidebar');

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', function () {
      sidebar.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
      if (sidebar.classList.contains('show') && !sidebar.contains(e.target) && e.target !== toggleBtn && !toggleBtn.contains(e.target)) {
        sidebar.classList.remove('show');
      }
    });
  }
});
