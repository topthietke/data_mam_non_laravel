<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/admin-auth.php';

$tieu_de_admin = 'Điểm mạnh nổi bật';
$khoa = 'diem_manh';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_kiem_tra()) {
        dat_thong_bao('loi', 'Phiên làm việc đã hết hạn, vui lòng thử lại.');
        header('Location: gioi-thieu.php'); exit;
    }
    $hanh_dong = $_POST['hanh_dong'] ?? '';

    if ($hanh_dong === 'xoa') {
        xoa_muc($khoa, $_POST['id'] ?? '');
        dat_thong_bao('thanh-cong', 'Đã xoá mục điểm mạnh.');
    } else {
        $item = [
            'icon'    => trim($_POST['icon'] ?? 'star-fill'),
            'tieu_de' => trim($_POST['tieu_de'] ?? ''),
            'mo_ta'   => trim($_POST['mo_ta'] ?? ''),
        ];
        if ($item['tieu_de'] === '') {
            dat_thong_bao('loi', 'Vui lòng nhập tiêu đề.');
        } else {
            if ($hanh_dong === 'sua' && !empty($_POST['id'])) {
                cap_nhat_muc($khoa, $_POST['id'], $item);
                dat_thong_bao('thanh-cong', 'Đã cập nhật.');
            } else {
                them_muc($khoa, $item);
                dat_thong_bao('thanh-cong', 'Đã thêm điểm mạnh mới.');
            }
        }
    }
    header('Location: gioi-thieu.php');
    exit;
}

$danh_sach = lay_danh_sach($khoa);
require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h2>Điểm mạnh đang hiển thị (<?= count($danh_sach) ?>)</h2>
    <button class="btn btn-cta btn-sm" data-bs-toggle="modal" data-bs-target="#modalThem"><i class="bi bi-plus-lg"></i> Thêm điểm mạnh</button>
  </div>
  <p class="admin-hint">Hiển thị ở mục "Vì sao chọn Sao Nhỏ" trên trang chủ. Tên biểu tượng lấy từ bộ <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener">Bootstrap Icons</a> (VD: <code>shield-heart</code>, <code>palette</code>).</p>

  <?php if (empty($danh_sach)): ?>
    <p class="admin-empty">Chưa có mục nào. Bấm "Thêm điểm mạnh" để bắt đầu.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="admin-table">
        <thead><tr><th style="width:60px">Icon</th><th>Tiêu đề</th><th>Mô tả</th><th style="width:110px">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($danh_sach as $dm): ?>
            <tr>
              <td><i class="bi bi-<?= htmlspecialchars($dm['icon']) ?> fs-4 text-leaf"></i></td>
              <td><strong><?= htmlspecialchars($dm['tieu_de']) ?></strong></td>
              <td class="text-muted small"><?= htmlspecialchars($dm['mo_ta']) ?></td>
              <td>
                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalSua<?= htmlspecialchars($dm['id']) ?>" aria-label="Sửa"><i class="bi bi-pencil-fill"></i></button>
                <button class="btn-icon btn-icon-danger" data-bs-toggle="modal" data-bs-target="#modalXoa<?= htmlspecialchars($dm['id']) ?>" aria-label="Xoá"><i class="bi bi-trash-fill"></i></button>
              </td>
            </tr>

            <div class="modal fade" id="modalSua<?= htmlspecialchars($dm['id']) ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="hanh_dong" value="sua">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($dm['id']) ?>">
                    <div class="modal-header"><h5 class="modal-title">Sửa điểm mạnh</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                      <div class="mb-3"><label class="form-label">Tên biểu tượng (Bootstrap Icons)</label><input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($dm['icon']) ?>"></div>
                      <div class="mb-3"><label class="form-label">Tiêu đề</label><input type="text" name="tieu_de" class="form-control" value="<?= htmlspecialchars($dm['tieu_de']) ?>" required></div>
                      <div class="mb-3"><label class="form-label">Mô tả</label><textarea name="mo_ta" class="form-control" rows="3"><?= htmlspecialchars($dm['mo_ta']) ?></textarea></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Lưu thay đổi</button></div>
                  </form>
                </div>
              </div>
            </div>

            <div class="modal fade" id="modalXoa<?= htmlspecialchars($dm['id']) ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="hanh_dong" value="xoa">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($dm['id']) ?>">
                    <div class="modal-header"><h5 class="modal-title">Xoá mục này?</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">Bạn có chắc muốn xoá "<strong><?= htmlspecialchars($dm['tieu_de']) ?></strong>"?</div>
                    <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-danger">Xoá</button></div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<div class="modal fade" id="modalThem" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="hanh_dong" value="them">
        <div class="modal-header"><h5 class="modal-title">Thêm điểm mạnh mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Tên biểu tượng (Bootstrap Icons)</label><input type="text" name="icon" class="form-control" placeholder="VD: shield-heart" value="star-fill"></div>
          <div class="mb-3"><label class="form-label">Tiêu đề</label><input type="text" name="tieu_de" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Mô tả</label><textarea name="mo_ta" class="form-control" rows="3"></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Thêm</button></div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
