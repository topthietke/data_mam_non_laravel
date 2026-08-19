<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/admin-auth.php';

$tieu_de_admin = 'Đăng ký tham quan';
$nhan_trang_thai = ['moi' => 'Mới', 'da_lien_he' => 'Đã liên hệ', 'hoan_tat' => 'Hoàn tất'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_kiem_tra()) {
        dat_thong_bao('loi', 'Phiên làm việc đã hết hạn, vui lòng thử lại.');
        header('Location: dang-ky.php'); exit;
    }
    $hanh_dong = $_POST['hanh_dong'] ?? '';
    $id = $_POST['id'] ?? '';

    if ($hanh_dong === 'xoa') {
        xoa_dang_ky($id);
        dat_thong_bao('thanh-cong', 'Đã xoá lượt đăng ký.');
    } elseif ($hanh_dong === 'doi_trang_thai') {
        $trang_thai_moi = $_POST['trang_thai'] ?? 'moi';
        if (array_key_exists($trang_thai_moi, $nhan_trang_thai)) {
            cap_nhat_trang_thai_dang_ky($id, $trang_thai_moi);
            dat_thong_bao('thanh-cong', 'Đã cập nhật trạng thái.');
        }
    }
    header('Location: dang-ky.php');
    exit;
}

$loc = $_GET['loc'] ?? 'tat-ca';
$tat_ca = array_reverse(doc_dang_ky());
$danh_sach = $loc === 'tat-ca' ? $tat_ca : array_values(array_filter($tat_ca, fn($d) => ($d['trang_thai'] ?? 'moi') === $loc));

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h2>Danh sách đăng ký (<?= count($tat_ca) ?>)</h2>
    <div class="btn-group btn-group-sm" role="group">
      <a href="?loc=tat-ca" class="btn <?= $loc === 'tat-ca' ? 'btn-cta' : 'btn-outline-cta' ?>">Tất cả</a>
      <a href="?loc=moi" class="btn <?= $loc === 'moi' ? 'btn-cta' : 'btn-outline-cta' ?>">Mới</a>
      <a href="?loc=da_lien_he" class="btn <?= $loc === 'da_lien_he' ? 'btn-cta' : 'btn-outline-cta' ?>">Đã liên hệ</a>
      <a href="?loc=hoan_tat" class="btn <?= $loc === 'hoan_tat' ? 'btn-cta' : 'btn-outline-cta' ?>">Hoàn tất</a>
    </div>
  </div>

  <?php if (empty($danh_sach)): ?>
    <p class="admin-empty">Không có lượt đăng ký nào trong bộ lọc này.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr><th>Phụ huynh</th><th>Liên hệ</th><th>Bé</th><th>Lời nhắn</th><th>Thời gian gửi</th><th style="width:170px">Trạng thái</th><th style="width:60px"></th></tr>
        </thead>
        <tbody>
          <?php foreach ($danh_sach as $dk): ?>
            <tr>
              <td><strong><?= htmlspecialchars($dk['ho_ten']) ?></strong></td>
              <td>
                <div><i class="bi bi-telephone-fill me-1 text-muted"></i><?= htmlspecialchars($dk['sdt']) ?></div>
                <?php if (!empty($dk['email'])): ?><div class="small text-muted"><i class="bi bi-envelope-fill me-1"></i><?= htmlspecialchars($dk['email']) ?></div><?php endif; ?>
              </td>
              <td><?= htmlspecialchars($dk['do_tuoi']) ?></td>
              <td class="small text-muted" style="max-width:220px"><?= htmlspecialchars($dk['loi_nhan'] ?: '—') ?></td>
              <td class="small text-muted text-nowrap"><?= htmlspecialchars($dk['ngay_gui'] ?? '') ?></td>
              <td>
                <form method="POST" class="d-flex gap-1">
                  <?= csrf_field() ?>
                  <input type="hidden" name="hanh_dong" value="doi_trang_thai">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($dk['id']) ?>">
                  <select name="trang_thai" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php foreach ($nhan_trang_thai as $gia_tri => $nhan): ?>
                      <option value="<?= $gia_tri ?>" <?= ($dk['trang_thai'] ?? 'moi') === $gia_tri ? 'selected' : '' ?>><?= $nhan ?></option>
                    <?php endforeach; ?>
                  </select>
                </form>
              </td>
              <td>
                <button class="btn-icon btn-icon-danger" data-bs-toggle="modal" data-bs-target="#modalXoa<?= htmlspecialchars($dk['id']) ?>" aria-label="Xoá"><i class="bi bi-trash-fill"></i></button>
              </td>
            </tr>

            <div class="modal fade" id="modalXoa<?= htmlspecialchars($dk['id']) ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="hanh_dong" value="xoa">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($dk['id']) ?>">
                    <div class="modal-header"><h5 class="modal-title">Xoá lượt đăng ký?</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">Xoá thông tin đăng ký của "<strong><?= htmlspecialchars($dk['ho_ten']) ?></strong>"? Hành động này không thể hoàn tác.</div>
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

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
