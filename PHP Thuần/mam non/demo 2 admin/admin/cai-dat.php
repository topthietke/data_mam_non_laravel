<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/admin-auth.php';

$tieu_de_admin = 'Thông tin trường';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_kiem_tra()) {
        dat_thong_bao('loi', 'Phiên làm việc đã hết hạn, vui lòng thử lại.');
        header('Location: cai-dat.php'); exit;
    }
    $hanh_dong = $_POST['hanh_dong'] ?? '';

    if ($hanh_dong === 'luu_thong_tin') {
        $site_moi = [
            'ten_truong' => trim($_POST['ten_truong'] ?? ''),
            'ten_day_du' => trim($_POST['ten_day_du'] ?? ''),
            'khau_hieu'  => trim($_POST['khau_hieu'] ?? ''),
            'hotline'    => trim($_POST['hotline'] ?? ''),
            'email'      => trim($_POST['email'] ?? ''),
            'dia_chi'    => trim($_POST['dia_chi'] ?? ''),
            'gio_hoc'    => trim($_POST['gio_hoc'] ?? ''),
            'facebook'   => trim($_POST['facebook'] ?? '#'),
            'zalo'       => trim($_POST['zalo'] ?? '#'),
        ];
        if ($site_moi['ten_truong'] === '' || $site_moi['ten_day_du'] === '') {
            dat_thong_bao('loi', 'Vui lòng nhập đầy đủ Tên trường.');
        } else {
            cap_nhat_thong_tin_truong($site_moi);
            dat_thong_bao('thanh-cong', 'Đã cập nhật thông tin trường.');
        }
    } elseif ($hanh_dong === 'doi_mat_khau') {
        $mat_khau_hien_tai = (string) ($_POST['mat_khau_hien_tai'] ?? '');
        $mat_khau_moi       = (string) ($_POST['mat_khau_moi'] ?? '');
        $mat_khau_xac_nhan  = (string) ($_POST['mat_khau_xac_nhan'] ?? '');

        $nguoi_dung = tim_nguoi_dung($_SESSION['admin_ten']);
        die($nguoi_dung);
        if (!$nguoi_dung || !password_verify($mat_khau_hien_tai, $nguoi_dung['mat_khau_hash'])) {
            dat_thong_bao('loi', 'Mật khẩu hiện tại không đúng.');
        } elseif (mb_strlen($mat_khau_moi) < 8) {
            dat_thong_bao('loi', 'Mật khẩu mới phải có ít nhất 8 ký tự.');
        } elseif ($mat_khau_moi !== $mat_khau_xac_nhan) {
            dat_thong_bao('loi', 'Xác nhận mật khẩu không khớp.');
        } else {
            $tat_ca_nguoi_dung = doc_nguoi_dung();
            foreach ($tat_ca_nguoi_dung as &$nd) {
                if ($nd['ten_dang_nhap'] === $_SESSION['admin_ten']) {
                    $nd['mat_khau_hash'] = password_hash($mat_khau_moi, PASSWORD_DEFAULT);
                }
            }
            ghi_json(FILE_NGUOI_DUNG, $tat_ca_nguoi_dung);
            dat_thong_bao('thanh-cong', 'Đã đổi mật khẩu thành công.');
        }
    }
    header('Location: cai-dat.php');
    exit;
}

require __DIR__ . '/includes/admin-header.php';
?>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="admin-card">
      <div class="admin-card-header"><h2>Thông tin liên hệ của trường</h2></div>
      <p class="admin-hint">Thông tin này hiển thị ở thanh trên cùng, chân trang và trang Liên hệ.</p>
      <form method="POST" class="row g-3">
        <?= csrf_field() ?>
        <input type="hidden" name="hanh_dong" value="luu_thong_tin">
        <div class="col-md-6"><label class="form-label">Tên ngắn gọn</label><input type="text" name="ten_truong" class="form-control" value="<?= htmlspecialchars($site['ten_truong']) ?>" required></div>
        <div class="col-md-6"><label class="form-label">Tên đầy đủ</label><input type="text" name="ten_day_du" class="form-control" value="<?= htmlspecialchars($site['ten_day_du']) ?>" required></div>
        <div class="col-12"><label class="form-label">Khẩu hiệu</label><input type="text" name="khau_hieu" class="form-control" value="<?= htmlspecialchars($site['khau_hieu']) ?>"></div>
        <div class="col-md-6"><label class="form-label">Hotline</label><input type="text" name="hotline" class="form-control" value="<?= htmlspecialchars($site['hotline']) ?>"></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($site['email']) ?>"></div>
        <div class="col-12"><label class="form-label">Địa chỉ</label><input type="text" name="dia_chi" class="form-control" value="<?= htmlspecialchars($site['dia_chi']) ?>"></div>
        <div class="col-12"><label class="form-label">Giờ hoạt động</label><input type="text" name="gio_hoc" class="form-control" value="<?= htmlspecialchars($site['gio_hoc']) ?>"></div>
        <div class="col-md-6"><label class="form-label">Link Facebook</label><input type="text" name="facebook" class="form-control" value="<?= htmlspecialchars($site['facebook']) ?>"></div>
        <div class="col-md-6"><label class="form-label">Link Zalo</label><input type="text" name="zalo" class="form-control" value="<?= htmlspecialchars($site['zalo']) ?>"></div>
        <div class="col-12 mt-4"><button type="submit" class="btn btn-cta">Lưu thông tin</button></div>
      </form>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="admin-card">
      <div class="admin-card-header"><h2>Đổi mật khẩu quản trị</h2></div>
      <form method="POST" class="row g-3">
        <?= csrf_field() ?>
        <input type="hidden" name="hanh_dong" value="doi_mat_khau">
        <div class="col-12"><label class="form-label">Mật khẩu hiện tại</label><input type="password" name="mat_khau_hien_tai" class="form-control" required></div>
        <div class="col-12"><label class="form-label">Mật khẩu mới</label><input type="password" name="mat_khau_moi" class="form-control" minlength="8" required></div>
        <div class="col-12"><label class="form-label">Xác nhận mật khẩu mới</label><input type="password" name="mat_khau_xac_nhan" class="form-control" minlength="8" required></div>
        <div class="col-12 mt-3"><button type="submit" class="btn btn-outline-cta">Đổi mật khẩu</button></div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
