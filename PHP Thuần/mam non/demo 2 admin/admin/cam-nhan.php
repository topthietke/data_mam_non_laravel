<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/admin-auth.php';

$tieu_de_admin = 'Cảm nhận phụ huynh';
$khoa = 'cam_nhan';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_kiem_tra()) {
        dat_thong_bao('loi', 'Phiên làm việc đã hết hạn, vui lòng thử lại.');
        header('Location: cam-nhan.php'); exit;
    }
    $hanh_dong = $_POST['hanh_dong'] ?? '';

    if ($hanh_dong === 'xoa') {
        xoa_muc($khoa, $_POST['id'] ?? '');
        dat_thong_bao('thanh-cong', 'Đã xoá cảm nhận.');
    } else {
        $item = [
            'ten'      => trim($_POST['ten'] ?? ''),
            'vai_tro'  => trim($_POST['vai_tro'] ?? ''),
            'noi_dung' => trim($_POST['noi_dung'] ?? ''),
        ];
        if ($item['ten'] === '' || $item['noi_dung'] === '') {
            dat_thong_bao('loi', 'Vui lòng nhập đầy đủ Họ tên và Nội dung cảm nhận.');
        } else {
            if ($hanh_dong === 'sua' && !empty($_POST['id'])) {
                cap_nhat_muc($khoa, $_POST['id'], $item);
                dat_thong_bao('thanh-cong', 'Đã cập nhật.');
            } else {
                them_muc($khoa, $item);
                dat_thong_bao('thanh-cong', 'Đã thêm cảm nhận mới.');
            }
        }
    }
    header('Location: cam-nhan.php');
    exit;
}

$danh_sach = lay_danh_sach($khoa);
require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h2>Cảm nhận đang hiển thị (<?= count($danh_sach) ?>)</h2>
    <button class="btn btn-cta btn-sm" data-bs-toggle="modal" data-bs-target="#modalThem"><i class="bi bi-plus-lg"></i> Thêm cảm nhận</button>
  </div>
  <p class="admin-hint">Hiển thị dạng slider ở mục "Phụ huynh nói gì" trên trang chủ.</p>

  <?php if (empty($danh_sach)): ?>
    <p class="admin-empty">Chưa có cảm nhận nào. Bấm "Thêm cảm nhận" để bắt đầu.</p>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($danh_sach as $cn): ?>
        <div class="col-md-6 col-xl-4">
          <div class="content-card">
            <p class="fst-italic">"<?= htmlspecialchars($cn['noi_dung']) ?>"</p>
            <h3 class="fs-6 mb-0"><?= htmlspecialchars($cn['ten']) ?></h3>
            <div class="content-card-tag"><?= htmlspecialchars($cn['vai_tro']) ?></div>
            <div class="content-card-actions">
              <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalSua<?= htmlspecialchars($cn['id']) ?>" aria-label="Sửa"><i class="bi bi-pencil-fill"></i></button>
              <button class="btn-icon btn-icon-danger" data-bs-toggle="modal" data-bs-target="#modalXoa<?= htmlspecialchars($cn['id']) ?>" aria-label="Xoá"><i class="bi bi-trash-fill"></i></button>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalSua<?= htmlspecialchars($cn['id']) ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="hanh_dong" value="sua">
                <input type="hidden" name="id" value="<?= htmlspecialchars($cn['id']) ?>">
                <div class="modal-header"><h5 class="modal-title">Sửa cảm nhận</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                  <div class="mb-3"><label class="form-label">Họ tên phụ huynh</label><input type="text" name="ten" class="form-control" value="<?= htmlspecialchars($cn['ten']) ?>" required></div>
                  <div class="mb-3"><label class="form-label">Vai trò / con học lớp nào</label><input type="text" name="vai_tro" class="form-control" value="<?= htmlspecialchars($cn['vai_tro']) ?>" placeholder="VD: Phụ huynh bé Bo - Lớp Chồi"></div>
                  <div class="mb-3"><label class="form-label">Nội dung cảm nhận</label><textarea name="noi_dung" class="form-control" rows="4" required><?= htmlspecialchars($cn['noi_dung']) ?></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Lưu thay đổi</button></div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalXoa<?= htmlspecialchars($cn['id']) ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="hanh_dong" value="xoa">
                <input type="hidden" name="id" value="<?= htmlspecialchars($cn['id']) ?>">
                <div class="modal-header"><h5 class="modal-title">Xoá cảm nhận?</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">Bạn có chắc muốn xoá cảm nhận của "<strong><?= htmlspecialchars($cn['ten']) ?></strong>"?</div>
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
        <div class="modal-header"><h5 class="modal-title">Thêm cảm nhận mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Họ tên phụ huynh</label><input type="text" name="ten" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Vai trò / con học lớp nào</label><input type="text" name="vai_tro" class="form-control" placeholder="VD: Phụ huynh bé Bo - Lớp Chồi"></div>
          <div class="mb-3"><label class="form-label">Nội dung cảm nhận</label><textarea name="noi_dung" class="form-control" rows="4" required></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Thêm</button></div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
