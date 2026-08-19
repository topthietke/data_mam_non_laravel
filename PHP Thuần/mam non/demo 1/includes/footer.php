</main>

<!-- ===== Dải CTA trước footer ===== -->
<section class="cta-band">
  <div class="container text-center">
    <h2>Cho con một khởi đầu đầy yêu thương</h2>
    <p>Đặt lịch tham quan lớp học thực tế - phụ huynh có thể quan sát trực tiếp giờ học của các bé.</p>
    <a href="lien-he.php#form-tuyen-sinh" class="btn btn-cta btn-lg">Đăng ký tham quan miễn phí</a>
  </div>
</section>

<footer class="site-footer">
  <div class="container py-5">
    <div class="row gy-4">
      <div class="col-lg-4">
        <a class="navbar-brand d-flex align-items-center gap-2 mb-3" href="index.php">
          <span class="brand-mark" aria-hidden="true"><i class="bi bi-flower2"></i></span>
          <span class="brand-text">
            <span class="brand-ten">Mầm Non <?= htmlspecialchars($site['ten_truong']) ?></span>
          </span>
        </a>
        <p class="footer-mota"><?= htmlspecialchars($site['ten_day_du']) ?> - nơi ươm mầm những điều tốt đẹp đầu tiên trong hành trình khôn lớn của con.</p>
        <div class="d-flex gap-2 mt-3">
          <a href="<?= htmlspecialchars($site['facebook']) ?>" class="social-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="<?= htmlspecialchars($site['zalo']) ?>" class="social-btn" aria-label="Zalo">Zalo</a>
        </div>
      </div>
      <div class="col-lg-2 col-6">
        <h6 class="footer-tieude">Khám phá</h6>
        <ul class="footer-links">
          <?php foreach ($menu as $muc): ?>
            <li><a href="<?= htmlspecialchars($muc['link']) ?>"><?= htmlspecialchars($muc['ten']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-lg-3 col-6">
        <h6 class="footer-tieude">Các khối lớp</h6>
        <ul class="footer-links">
          <?php foreach ($giai_doan as $gd): ?>
            <li><a href="index.php#chuong-trinh"><?= htmlspecialchars($gd['ten']) ?> (<?= htmlspecialchars($gd['do_tuoi']) ?>)</a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6 class="footer-tieude">Liên hệ</h6>
        <ul class="footer-links">
          <li><i class="bi bi-geo-alt-fill me-2"></i><?= htmlspecialchars($site['dia_chi']) ?></li>
          <li><i class="bi bi-telephone-fill me-2"></i><?= htmlspecialchars($site['hotline']) ?></li>
          <li><i class="bi bi-envelope-fill me-2"></i><?= htmlspecialchars($site['email']) ?></li>
        </ul>
      </div>
    </div>
    <hr class="footer-hr">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small footer-copy">
      <span>&copy; <?= date('Y') ?> <?= htmlspecialchars($site['ten_day_du']) ?>. Bảo lưu mọi quyền.</span>
      <span>Thiết kế với <i class="bi bi-heart-fill text-danger"></i> dành cho các bé</span>
    </div>
  </div>
</footer>

<a href="#top" class="back-to-top" aria-label="Lên đầu trang"><i class="bi bi-arrow-up"></i></a>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
