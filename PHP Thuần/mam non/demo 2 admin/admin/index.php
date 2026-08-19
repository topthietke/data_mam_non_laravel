<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/admin-auth.php';

$tieu_de_admin = 'Tổng quan';

$ds_dang_ky = doc_dang_ky();
$so_dang_ky_moi = count(array_filter($ds_dang_ky, fn($d) => ($d['trang_thai'] ?? '') === 'moi'));

$the_thong_ke = [
    ['icon' => 'inbox-fill',           'so' => count($ds_dang_ky),        'nhan' => 'Lượt đăng ký tham quan', 'link' => 'dang-ky.php',      'mau' => 'coral'],
    ['icon' => 'bell-fill',            'so' => $so_dang_ky_moi,           'nhan' => 'Đăng ký chưa xử lý',      'link' => 'dang-ky.php',      'mau' => 'sun'],
    ['icon' => 'signpost-split-fill',  'so' => count($giai_doan),         'nhan' => 'Khối lớp đang hiển thị',  'link' => 'chuong-trinh.php', 'mau' => 'leaf'],
    ['icon' => 'chat-quote-fill',      'so' => count($cam_nhan),          'nhan' => 'Cảm nhận phụ huynh',      'link' => 'cam-nhan.php',     'mau' => 'sky'],
];

require __DIR__ . '/includes/admin-header.php';
?>

<div class="row g-3 mb-4">
  <?php foreach ($the_thong_ke as $tk): ?>
    <div class="col-sm-6 col-xl-3">
      <a href="<?= htmlspecialchars($tk['link']) ?>" class="stat-card stat-card-<?= htmlspecialchars($tk['mau']) ?>">
        <div class="stat-card-icon"><i class="bi bi-<?= htmlspecialchars($tk['icon']) ?>"></i></div>
        <div class="stat-card-so"><?= (int)$tk['so'] ?></div>
        <div class="stat-card-nhan"><?= htmlspecialchars($tk['nhan']) ?></div>
      </a>
    </div>
  <?php endforeach; ?>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="admin-card">
      <div class="admin-card-header">
        <h2>Đăng ký tham quan gần đây</h2>
        <a href="dang-ky.php" class="admin-link-more">Xem tất cả <i class="bi bi-arrow-right"></i></a>
      </div>
      <?php if (empty($ds_dang_ky)): ?>
        <p class="admin-empty">Chưa có lượt đăng ký nào. Khi phụ huynh gửi form ở trang Liên hệ, thông tin sẽ hiện tại đây.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="admin-table">
            <thead><tr><th>Phụ huynh</th><th>Số điện thoại</th><th>Bé</th><th>Trạng thái</th><th>Thời gian</th></tr></thead>
            <tbody>
              <?php foreach (array_slice(array_reverse($ds_dang_ky), 0, 5) as $dk): ?>
                <tr>
                  <td><?= htmlspecialchars($dk['ho_ten']) ?></td>
                  <td><?= htmlspecialchars($dk['sdt']) ?></td>
                  <td><?= htmlspecialchars($dk['do_tuoi']) ?></td>
                  <td><span class="badge-trangthai badge-<?= htmlspecialchars($dk['trang_thai'] ?? 'moi') ?>"><?= htmlspecialchars(['moi' => 'Mới', 'da_lien_he' => 'Đã liên hệ', 'hoan_tat' => 'Hoàn tất'][$dk['trang_thai'] ?? 'moi'] ?? 'Mới') ?></span></td>
                  <td><?= htmlspecialchars($dk['ngay_gui'] ?? '') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="admin-card">
      <div class="admin-card-header"><h2>Lối tắt quản lý nội dung</h2></div>
      <div class="quick-links">
        <a href="gioi-thieu.php" class="quick-link"><i class="bi bi-shield-heart"></i><span>Điểm mạnh nổi bật</span><i class="bi bi-chevron-right ms-auto"></i></a>
        <a href="chuong-trinh.php" class="quick-link"><i class="bi bi-signpost-split-fill"></i><span>Chương trình học các khối lớp</span><i class="bi bi-chevron-right ms-auto"></i></a>
        <a href="hoat-dong.php" class="quick-link"><i class="bi bi-stars"></i><span>Hoạt động hằng ngày</span><i class="bi bi-chevron-right ms-auto"></i></a>
        <a href="cam-nhan.php" class="quick-link"><i class="bi bi-chat-quote-fill"></i><span>Cảm nhận phụ huynh</span><i class="bi bi-chevron-right ms-auto"></i></a>
        <a href="so-lieu.php" class="quick-link"><i class="bi bi-graph-up-arrow"></i><span>Số liệu nổi bật</span><i class="bi bi-chevron-right ms-auto"></i></a>
        <a href="cai-dat.php" class="quick-link"><i class="bi bi-gear-fill"></i><span>Thông tin liên hệ của trường</span><i class="bi bi-chevron-right ms-auto"></i></a>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
