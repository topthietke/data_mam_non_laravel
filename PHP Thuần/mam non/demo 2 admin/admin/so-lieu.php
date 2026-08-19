<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/admin-auth.php';

$tieu_de_admin = 'Số liệu nổi bật';
$khoa = 'so_lieu';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_kiem_tra()) {
        dat_thong_bao('loi', 'Phiên làm việc đã hết hạn, vui lòng thử lại.');
        header('Location: so-lieu.php'); exit;
    }
    $hanh_dong = $_POST['hanh_dong'] ?? '';

    if ($hanh_dong === 'xoa') {
        xoa_muc($khoa, $_POST['id'] ?? '');
        dat_thong_bao('thanh-cong', 'Đã xoá số liệu.');
    } else {
        $item = [
            'so'      => preg_replace('/[^0-9]/', '', $_POST['so'] ?? '0'),
            'don_vi'  => trim($_POST['don_vi'] ?? ''),
            'nhan'    => trim($_POST['nhan'] ?? ''),
        ];
        if ($item['nhan'] === '' || $item['so'] === '') {
            dat_thong_bao('loi', 'Vui lòng nhập đầy đủ Số liệu (chỉ số) và Nhãn mô tả.');
        } else {
            if ($hanh_dong === 'sua' && !empty($_POST['id'])) {
                cap_nhat_muc($khoa, $_POST['id'], $item);
                dat_thong_bao('thanh-cong', 'Đã cập nhật.');
            } else {
                them_muc($khoa, $item);
                dat_thong_bao('thanh-cong', 'Đã thêm số liệu mới.');
            }
        }
    }
    header('Location: so-lieu.php');
    exit;
}

$danh_sach = lay_danh_sach($khoa);
require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h2>Số liệu đang hiển thị (<?= count($danh_sach) ?>)</h2>
    <button class="btn btn-cta btn-sm" data-bs-toggle="modal" data-bs-target="#modalThem"><i class="bi bi-plus-lg"></i> Thêm số liệu</button>
  </div>
  <p class="admin-hint">Hiển thị ở dải số liệu ngay dưới phần Hero trang chủ, có hiệu ứng đếm chạy.</p>

  <?php if (empty($danh_sach)): ?>
    <p class="admin-empty">Chưa có số liệu nào. Bấm "Thêm số liệu" để bắt đầu.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="admin-table">
        <thead><tr><th>Số hiển thị</th><th>Nhãn mô tả</th><th style="width:110px">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($danh_sach as $sl): ?>
            <tr>
              <td><strong class="text-coral fs-5"><?= htmlspecialchars($sl['so']) ?><?= htmlspecialchars($sl['don_vi']) ?></strong></td>
              <td><?= htmlspecialchars($sl['nhan']) ?></td>
              <td>
                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalSua<?= htmlspecialchars($sl['id']) ?>" aria-label="Sửa"><i class="bi bi-pencil-fill"></i></button>
                <button class="btn-icon btn-icon-danger" data-bs-toggle="modal" data-bs-target="#modalXoa<?= htmlspecialchars($sl['id']) ?>" aria-label="Xoá"><i class="bi bi-trash-fill"></i></button>
              </td>
            </tr>

            <div class="modal fade" id="modalSua<?= htmlspecialchars($sl['id']) ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="hanh_dong" value="sua">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($sl['id']) ?>">
                    <div class="modal-header"><h5 class="modal-title">Sửa số liệu</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body row g-3">
                      <div class="col-7"><label class="form-label">Số</label><input type="text" inputmode="numeric" name="so" class="form-control" value="<?= htmlspecialchars($sl['so']) ?>" required></div>
                      <div class="col-5"><label class="form-label">Đơn vị (nếu có)</label><input type="text" name="don_vi" class="form-control" value="<?= htmlspecialchars($sl['don_vi']) ?>" placeholder="+, %"></div>
                      <div class="col-12"><label class="form-label">Nhãn mô tả</label><input type="text" name="nhan" class="form-control" value="<?= htmlspecialchars($sl['nhan']) ?>" required></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Lưu thay đổi</button></div>
                  </form>
                </div>
              </div>
            </div>

            <div class="modal fade" id="modalXoa<?= htmlspecialchars($sl['id']) ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="hanh_dong" value="xoa">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($sl['id']) ?>">
                    <div class="modal-header"><h5 class="modal-title">Xoá số liệu?</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">Bạn có chắc muốn xoá "<strong><?= htmlspecialchars($sl['nhan']) ?></strong>"?</div>
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
        <div class="modal-header"><h5 class="modal-title">Thêm số liệu mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-7"><label class="form-label">Số</label><input type="text" inputmode="numeric" name="so" class="form-control" required></div>
          <div class="col-5"><label class="form-label">Đơn vị (nếu có)</label><input type="text" name="don_vi" class="form-control" placeholder="+, %"></div>
          <div class="col-12"><label class="form-label">Nhãn mô tả</label><input type="text" name="nhan" class="form-control" required></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Thêm</button></div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
