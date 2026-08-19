<?php
require_once __DIR__ . '/../includes/config.php';

// Nếu đã đăng nhập rồi thì vào thẳng trang tổng quan
if (!empty($_SESSION['admin_dang_nhap'])) {
    header('Location: index.php');
    exit;
}

$loi = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_dang_nhap = trim($_POST['ten_dang_nhap'] ?? '');
    $mat_khau      = (string) ($_POST['mat_khau'] ?? '');

    $nguoi_dung = tim_nguoi_dung($ten_dang_nhap);

    if ($nguoi_dung && password_verify($mat_khau, $nguoi_dung['mat_khau_hash'])) {
        // Chống cố định phiên (session fixation): tạo session mới sau khi đăng nhập thành công
        session_regenerate_id(true);
        $_SESSION['admin_dang_nhap'] = true;
        $_SESSION['admin_ten']       = $nguoi_dung['ten_dang_nhap'];
        $_SESSION['admin_ho_ten']    = $nguoi_dung['ho_ten'] ?? $nguoi_dung['ten_dang_nhap'];

        $den_trang = $_SESSION['admin_redirect_sau_dang_nhap'] ?? 'index.php';
        unset($_SESSION['admin_redirect_sau_dang_nhap']);
        header('Location: ' . $den_trang);
        exit;
    }

    $loi = 'Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại.';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>Đăng nhập quản trị — Mầm Non Sao Nhỏ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="login-body">
  <div class="login-card">
    <div class="login-brand">
      <span class="admin-brand-mark"><i class="bi bi-flower2"></i></span>
      <h1>Khu vực Quản trị</h1>
      <p>Trường Mầm Non <?= htmlspecialchars($site['ten_truong']) ?></p>
    </div>

    <?php if ($loi): ?>
      <div class="alert-admin alert-admin-loi">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span><?= htmlspecialchars($loi) ?></span>
      </div>
    <?php endif; ?>

    <form method="POST" novalidate>
      <div class="mb-3">
        <label for="ten_dang_nhap" class="form-label">Tên đăng nhập</label>
        <input type="text" class="form-control" id="ten_dang_nhap" name="ten_dang_nhap" required autofocus value="<?= htmlspecialchars($_POST['ten_dang_nhap'] ?? '') ?>">
      </div>
      <div class="mb-4">
        <label for="mat_khau" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="mat_khau" name="mat_khau" required>
      </div>
      <button type="submit" class="btn btn-cta w-100">Đăng nhập</button>
    </form>
    <a href="../index.php" class="login-back"><i class="bi bi-arrow-left"></i> Quay về trang chủ</a>
  </div>
</body>
</html>
