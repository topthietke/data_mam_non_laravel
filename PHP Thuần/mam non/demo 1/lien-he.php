<?php
$tieu_de_trang = 'Liên hệ & Đăng ký tham quan - ' . 'Trường Mầm Non Sao Nhỏ';
$mo_ta_trang   = 'Liên hệ Trường Mầm Non Sao Nhỏ để đặt lịch tham quan lớp học và tìm hiểu chương trình tuyển sinh.';
require_once __DIR__ . '/includes/header.php';

// Lấy thông báo / lỗi từ session (được set bởi xu-ly-lien-he.php) rồi xoá đi để không hiện lại khi F5
$thong_bao = $_SESSION['thong_bao_thanh_cong'] ?? null;
$loi       = $_SESSION['loi_form'] ?? [];
$cu        = $_SESSION['du_lieu_cu'] ?? [];
unset($_SESSION['thong_bao_thanh_cong'], $_SESSION['loi_form'], $_SESSION['du_lieu_cu']);

function gia_tri_cu(array $cu, string $khoa): string
{
    return htmlspecialchars($cu[$khoa] ?? '');
}
?>

<section class="page-hero">
  <div class="container text-center" data-reveal>
    <span class="eyebrow"><i class="bi bi-envelope-heart me-1"></i>Liên hệ</span>
    <h1 class="page-hero-title">Rất vui được đồng hành cùng gia đình bạn</h1>
    <p class="section-desc mx-auto" style="max-width:600px">Để lại thông tin, nhà trường sẽ liên hệ tư vấn và sắp xếp lịch tham quan lớp học phù hợp với thời gian của anh/chị.</p>
  </div>
  <div class="wave-divider" aria-hidden="true">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none"><path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,90 L0,90 Z"></path></svg>
  </div>
</section>

<section class="section" id="form-tuyen-sinh">
  <div class="container">
    <div class="row g-5">
      <!-- Thông tin liên hệ -->
      <div class="col-lg-5" data-reveal>
        <h2 class="section-title mb-4">Thông tin liên hệ</h2>
        <ul class="contact-info-list">
          <li>
            <span class="contact-info-icon"><i class="bi bi-geo-alt-fill"></i></span>
            <div><strong>Địa chỉ</strong><br><?= htmlspecialchars($site['dia_chi']) ?></div>
          </li>
          <li>
            <span class="contact-info-icon"><i class="bi bi-telephone-fill"></i></span>
            <div><strong>Hotline</strong><br><?= htmlspecialchars($site['hotline']) ?></div>
          </li>
          <li>
            <span class="contact-info-icon"><i class="bi bi-envelope-fill"></i></span>
            <div><strong>Email</strong><br><?= htmlspecialchars($site['email']) ?></div>
          </li>
          <li>
            <span class="contact-info-icon"><i class="bi bi-clock-fill"></i></span>
            <div><strong>Giờ hoạt động</strong><br><?= htmlspecialchars($site['gio_hoc']) ?></div>
          </li>
        </ul>
        <div class="map-placeholder mt-4" role="img" aria-label="Bản đồ vị trí trường (minh hoạ)">
          <i class="bi bi-map"></i>
          <span>Bản đồ vị trí trường</span>
        </div>
      </div>

      <!-- Form đăng ký -->
      <div class="col-lg-7" data-reveal data-reveal-delay="150">
        <div class="form-card">
          <h2 class="section-title mb-2">Đăng ký tham quan</h2>
          <p class="section-desc mb-4">Điền thông tin bên dưới, nhà trường sẽ gọi lại trong vòng 24 giờ làm việc.</p>

          <?php if ($thong_bao): ?>
            <div class="alert alert-success-custom d-flex align-items-start gap-2" role="alert">
              <i class="bi bi-check-circle-fill mt-1"></i>
              <div><?= htmlspecialchars($thong_bao) ?></div>
            </div>
          <?php endif; ?>

          <?php if (!empty($loi)): ?>
            <div class="alert alert-danger-custom d-flex align-items-start gap-2" role="alert">
              <i class="bi bi-exclamation-triangle-fill mt-1"></i>
              <div>Vui lòng kiểm tra lại thông tin bên dưới.</div>
            </div>
          <?php endif; ?>

          <form action="xu-ly-lien-he.php" method="POST" novalidate id="formDangKy" class="row g-3">
            <div class="col-md-6">
              <label for="ho_ten" class="form-label">Họ tên phụ huynh <span class="text-danger">*</span></label>
              <input type="text" class="form-control <?= isset($loi['ho_ten']) ? 'is-invalid' : '' ?>" id="ho_ten" name="ho_ten" value="<?= gia_tri_cu($cu, 'ho_ten') ?>" required minlength="2">
              <?php if (isset($loi['ho_ten'])): ?><div class="invalid-feedback"><?= htmlspecialchars($loi['ho_ten']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-6">
              <label for="sdt" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
              <input type="tel" class="form-control <?= isset($loi['sdt']) ? 'is-invalid' : '' ?>" id="sdt" name="sdt" value="<?= gia_tri_cu($cu, 'sdt') ?>" placeholder="0909123456" required pattern="0[0-9]{9,10}">
              <?php if (isset($loi['sdt'])): ?><div class="invalid-feedback"><?= htmlspecialchars($loi['sdt']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control <?= isset($loi['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= gia_tri_cu($cu, 'email') ?>" placeholder="ban@email.com">
              <?php if (isset($loi['email'])): ?><div class="invalid-feedback"><?= htmlspecialchars($loi['email']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-6">
              <label for="do_tuoi_be" class="form-label">Độ tuổi của bé <span class="text-danger">*</span></label>
              <select class="form-select <?= isset($loi['do_tuoi']) ? 'is-invalid' : '' ?>" id="do_tuoi_be" name="do_tuoi_be" required>
                <option value="" <?= gia_tri_cu($cu, 'do_tuoi') === '' ? 'selected' : '' ?> disabled>-- Chọn độ tuổi --</option>
                <?php foreach ($giai_doan as $gd): ?>
                  <option value="<?= htmlspecialchars($gd['ten']) ?>" <?= gia_tri_cu($cu, 'do_tuoi') === $gd['ten'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($gd['ten']) ?> (<?= htmlspecialchars($gd['do_tuoi']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
              <?php if (isset($loi['do_tuoi'])): ?><div class="invalid-feedback"><?= htmlspecialchars($loi['do_tuoi']) ?></div><?php endif; ?>
            </div>
            <div class="col-12">
              <label for="loi_nhan" class="form-label">Lời nhắn (nếu có)</label>
              <textarea class="form-control" id="loi_nhan" name="loi_nhan" rows="3" placeholder="Anh/chị muốn tham quan vào buổi nào, có câu hỏi gì thêm..."><?= gia_tri_cu($cu, 'loi_nhan') ?></textarea>
            </div>
            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-cta btn-lg w-100 w-md-auto">Gửi đăng ký</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
