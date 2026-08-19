<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/admin-auth.php';

$tieu_de_admin = 'Chương trình học';
$khoa = 'giai_doan';
$icon_lua_chon = ['seedling' => 'Mầm non nhỏ', 'sprout' => 'Chồi non', 'sapling' => 'Cây con', 'tree' => 'Cây trưởng thành'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_kiem_tra()) {
        dat_thong_bao('loi', 'Phiên làm việc đã hết hạn, vui lòng thử lại.');
        header('Location: chuong-trinh.php'); exit;
    }
    $hanh_dong = $_POST['hanh_dong'] ?? '';

    if ($hanh_dong === 'xoa') {
        xoa_muc($khoa, $_POST['id'] ?? '');
        dat_thong_bao('thanh-cong', 'Đã xoá khối lớp.');
    } elseif ($hanh_dong === 'thu_tu') {
        doi_thu_tu_muc($khoa, $_POST['id'] ?? '', $_POST['huong'] ?? '');
    } else {
        $item = [
            'ten'     => trim($_POST['ten'] ?? ''),
            'do_tuoi' => trim($_POST['do_tuoi'] ?? ''),
            'mo_ta'   => trim($_POST['mo_ta'] ?? ''),
            'icon'    => $_POST['icon'] ?? 'seedling',
            'size'    => max(1, min(4, (int)($_POST['size'] ?? 1))),
        ];
        if ($item['ten'] === '' || $item['do_tuoi'] === '') {
            dat_thong_bao('loi', 'Vui lòng nhập đầy đủ Tên khối lớp và Độ tuổi.');
        } else {
            if ($hanh_dong === 'sua' && !empty($_POST['id'])) {
                cap_nhat_muc($khoa, $_POST['id'], $item);
                dat_thong_bao('thanh-cong', 'Đã cập nhật khối lớp.');
            } else {
                them_muc($khoa, $item);
                dat_thong_bao('thanh-cong', 'Đã thêm khối lớp mới.');
            }
        }
    }
    header('Location: chuong-trinh.php');
    exit;
}

$danh_sach = lay_danh_sach($khoa);
require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h2>Các khối lớp đang hiển thị (<?= count($danh_sach) ?>)</h2>
    <button class="btn btn-cta btn-sm" data-bs-toggle="modal" data-bs-target="#modalThem"><i class="bi bi-plus-lg"></i> Thêm khối lớp</button>
  </div>
  <p class="admin-hint">Thứ tự bên dưới chính là thứ tự hiển thị trong "Hành trình khôn lớn" ở trang chủ — dùng nút mũi tên để sắp xếp lại.</p>

  <?php if (empty($danh_sach)): ?>
    <p class="admin-empty">Chưa có khối lớp nào. Bấm "Thêm khối lớp" để bắt đầu.</p>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($danh_sach as $i => $gd): ?>
        <div class="col-md-6 col-xl-3">
          <div class="content-card">
            <div class="content-card-order">
              <form method="POST" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="hanh_dong" value="thu_tu">
                <input type="hidden" name="id" value="<?= htmlspecialchars($gd['id']) ?>">
                <button type="submit" name="huong" value="len" class="order-btn" <?= $i === 0 ? 'disabled' : '' ?> aria-label="Chuyển lên"><i class="bi bi-caret-left-fill"></i></button>
              </form>
              <span>#<?= $i + 1 ?></span>
              <form method="POST" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="hanh_dong" value="thu_tu">
                <input type="hidden" name="id" value="<?= htmlspecialchars($gd['id']) ?>">
                <button type="submit" name="huong" value="xuong" class="order-btn" <?= $i === count($danh_sach) - 1 ? 'disabled' : '' ?> aria-label="Chuyển xuống"><i class="bi bi-caret-right-fill"></i></button>
              </form>
            </div>
            <div class="content-card-icon"><i class="bi bi-<?= $gd['icon'] === 'seedling' ? 'flower1' : ($gd['icon'] === 'sprout' ? 'flower2' : ($gd['icon'] === 'sapling' ? 'tree' : 'tree-fill')) ?>"></i></div>
            <h3><?= htmlspecialchars($gd['ten']) ?></h3>
            <div class="content-card-tag"><?= htmlspecialchars($gd['do_tuoi']) ?></div>
            <p><?= htmlspecialchars($gd['mo_ta']) ?></p>
            <div class="content-card-actions">
              <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalSua<?= htmlspecialchars($gd['id']) ?>" aria-label="Sửa"><i class="bi bi-pencil-fill"></i></button>
              <button class="btn-icon btn-icon-danger" data-bs-toggle="modal" data-bs-target="#modalXoa<?= htmlspecialchars($gd['id']) ?>" aria-label="Xoá"><i class="bi bi-trash-fill"></i></button>
            </div>
          </div>
        </div>

        <!-- Modal sửa -->
        <div class="modal fade" id="modalSua<?= htmlspecialchars($gd['id']) ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="hanh_dong" value="sua">
                <input type="hidden" name="id" value="<?= htmlspecialchars($gd['id']) ?>">
                <div class="modal-header"><h5 class="modal-title">Sửa: <?= htmlspecialchars($gd['ten']) ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                  <div class="mb-3"><label class="form-label">Tên khối lớp</label><input type="text" name="ten" class="form-control" value="<?= htmlspecialchars($gd['ten']) ?>" required></div>
                  <div class="mb-3"><label class="form-label">Độ tuổi</label><input type="text" name="do_tuoi" class="form-control" value="<?= htmlspecialchars($gd['do_tuoi']) ?>" required></div>
                  <div class="mb-3"><label class="form-label">Mô tả</label><textarea name="mo_ta" class="form-control" rows="3"><?= htmlspecialchars($gd['mo_ta']) ?></textarea></div>
                  <div class="mb-3"><label class="form-label">Biểu tượng</label>
                    <select name="icon" class="form-select">
                      <?php foreach ($icon_lua_chon as $gia_tri => $nhan): ?>
                        <option value="<?= $gia_tri ?>" <?= $gd['icon'] === $gia_tri ? 'selected' : '' ?>><?= $nhan ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Lưu thay đổi</button></div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal xoá -->
        <div class="modal fade" id="modalXoa<?= htmlspecialchars($gd['id']) ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="hanh_dong" value="xoa">
                <input type="hidden" name="id" value="<?= htmlspecialchars($gd['id']) ?>">
                <div class="modal-header"><h5 class="modal-title">Xoá khối lớp?</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">Bạn có chắc muốn xoá "<strong><?= htmlspecialchars($gd['ten']) ?></strong>"? Hành động này không thể hoàn tác.</div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-danger">Xoá</button></div>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<!-- Modal thêm mới -->
<div class="modal fade" id="modalThem" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="hanh_dong" value="them">
        <div class="modal-header"><h5 class="modal-title">Thêm khối lớp mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Tên khối lớp</label><input type="text" name="ten" class="form-control" placeholder="VD: Lớp Chồi" required></div>
          <div class="mb-3"><label class="form-label">Độ tuổi</label><input type="text" name="do_tuoi" class="form-control" placeholder="VD: 4 - 5 tuổi" required></div>
          <div class="mb-3"><label class="form-label">Mô tả</label><textarea name="mo_ta" class="form-control" rows="3" placeholder="Mô tả ngắn về giai đoạn phát triển của bé"></textarea></div>
          <div class="mb-3"><label class="form-label">Biểu tượng</label>
            <select name="icon" class="form-select">
              <?php foreach ($icon_lua_chon as $gia_tri => $nhan): ?>
                <option value="<?= $gia_tri ?>"><?= $nhan ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-cta" data-bs-dismiss="modal">Huỷ</button><button type="submit" class="btn btn-cta">Thêm khối lớp</button></div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
