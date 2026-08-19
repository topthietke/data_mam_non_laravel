<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/admin-auth.php';

$tieu_de_admin = 'Hoạt động hằng ngày';
$khoa = 'hoat_dong';
$mau_goi_y = ['#FFE4B8', '#C9E8DD', '#FFD3C2', '#DCE3F7', '#F6E3C5', '#E4D6EF', '#FFD9DC', '#D6F0D9'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_kiem_tra()) {
        dat_thong_bao('loi', 'Phiên làm việc đã hết hạn, vui lòng thử lại.');
        header('Location: hoat-dong.php'); exit;
    }
    $hanh_dong = $_POST['hanh_dong'] ?? '';

    if ($hanh_dong === 'xoa') {
        xoa_muc($khoa, $_POST['id'] ?? '');
        dat_thong_bao('thanh-cong', 'Đã xoá hoạt động.');
    } else {
        $mau = trim($_POST['mau'] ?? '#FFE4B8');
        if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $mau)) $mau = '#FFE4B8';
        $item = [
            'ten'  => trim($_POST['ten'] ?? ''),
            'icon' => trim($_POST['icon'] ?? 'stars'),
            'mau'  => $mau,
        ];
        if ($item['ten'] === '') {
            dat_thong_bao('loi', 'Vui lòng nhập tên hoạt động.');
        } else {
            if ($hanh_dong === 'sua' && !empty($_POST['id'])) {
                cap_nhat_muc($khoa, $_POST['id'], $item);
                dat_thong_bao('thanh-cong', 'Đã cập nhật.');
            } else {
                them_muc($khoa, $item);
                dat_thong_bao('thanh-cong', 'Đã thêm hoạt động mới.');
            }
        }
    }
    header('Location: hoat-dong.php');
    exit;
}

$danh_sach = lay_danh_sach($khoa);
require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h2>Hoạt động đang hiển thị (<?= count($danh_sach) ?>)</h2>
    <button class="btn btn-cta btn-sm" data-bs-toggle="modal" data-bs-target="#modalThem"><i class="bi bi-plus-lg"></i> Thêm hoạt động</button>
  </div>
  <p class="admin-hint">Hiển thị ở mục "Một ngày ở Sao Nhỏ" trên trang chủ.</p>

  <?php if (empty($danh_sach)): ?>
    <p class="admin-empty">Chưa có hoạt động nào. Bấm "Thêm hoạt động" để bắt đầu.</p>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($danh_sach as $hd): ?>
        <div class="col-md-6 col-xl-4">
          <div class="hoatdong-preview" style="--tile-bg: <?= htmlspecialchars($hd['mau']) ?>">
            <i class="bi bi-<?= htmlspecialchars($hd['icon']) ?>"></i>
            <span><?= htmlspecialchars($hd['ten']) ?></span>
            <div class="content-card-actions">
              <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalSua<?= htmlspecialchars($hd['id']) ?>" aria-label="Sửa"><i class="bi bi-pencil-fill"></i></button>
              <button class="btn-icon btn-icon-danger" data-bs-toggle="modal" data-bs-target="#modalXoa<?= htmlspecialchars($hd['id']) ?>" aria-label="Xoá"><i class="bi bi-trash-fill"></i></button>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalSua<?= htmlspecialchars($hd['id']) ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="hanh_dong" value="sua">
                <input type="hidden" name="id" value="<?= htmlspecialchars($hd['id']) ?>">
                <div class="modal-header"><h5 class="modal-title">Sửa hoạt động</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                  <div class="mb-3"><label class="form-label">Tên hoạt động</label><input type="text" name="ten" class="form-control" value="<?= htmlspecialchars($hd['ten']) ?>" required></div>
                  <div class="mb-3"><label class="form-label">Tên biểu tượng (Bootstrap Icons)</label><input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($hd['icon']) ?>"></div>
                  <div class="mb-3">
                    <label class="form-label">Màu nền thẻ</label>
                    <input type="color" name="mau" class="form-control form-control-color" value="<?= htmlspecialchars($hd['mau']) ?>">
                  </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Lưu thay đổi</button></div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalXoa<?= htmlspecialchars($hd['id']) ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="hanh_dong" value="xoa">
                <input type="hidden" name="id" value="<?= htmlspecialchars($hd['id']) ?>">
                <div class="modal-header"><h5 class="modal-title">Xoá hoạt động?</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">Bạn có chắc muốn xoá "<strong><?= htmlspecialchars($hd['ten']) ?></strong>"?</div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-danger">Xoá</button></div>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<div class="modal fade" id="modalThem" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="hanh_dong" value="them">
        <div class="modal-header"><h5 class="modal-title">Thêm hoạt động mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Tên hoạt động</label><input type="text" name="ten" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Tên biểu tượng (Bootstrap Icons)</label><input type="text" name="icon" class="form-control" value="stars"></div>
          <div class="mb-3">
            <label class="form-label">Màu nền thẻ</label>
            <input type="color" name="mau" class="form-control form-control-color" value="<?= $mau_goi_y[array_rand($mau_goi_y)] ?>">
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Thêm</button></div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
