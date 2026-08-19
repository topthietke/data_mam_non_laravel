<?php
require_once __DIR__ . '/../includes/functions.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        $error = 'Phiên làm việc đã hết hạn, vui lòng thử lại.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['full_name'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Đăng nhập quản trị</title>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800&family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #FFF3D6 0%, #FFE3EC 50%, #E4F6FF 100%);
    }
    .login-card { max-width: 420px; width: 100%; border-radius: 24px; border: none; box-shadow: 0 20px 50px rgba(0,0,0,0.12); }
    .login-card h1 { font-family: 'Baloo 2', cursive; font-size: 1.6rem; color: #FF8552; }
    .btn-login { background: #FF6F91; border: none; border-radius: 50px; font-weight: 700; padding: 10px; }
    .btn-login:hover { background: #ff5580; }
    .form-control { border-radius: 12px; padding: 10px 14px; }
</style>
</head>
<body>
<div class="card login-card p-4 p-md-5">
    <div class="text-center mb-4">
        <i class="bi bi-flower1" style="font-size:2.5rem;color:#FF8552;"></i>
        <h1 class="mt-2 mb-0">Quản trị nội dung</h1>
        <small class="text-secondary">Đăng nhập để quản lý website Mầm Non</small>
    </div>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <div class="mb-3">
            <label class="form-label fw-bold">Tên đăng nhập</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label fw-bold">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-login btn-danger w-100 text-white">Đăng nhập</button>
    </form>
    <div class="text-center mt-3">
        <a href="../index.php" class="text-secondary small"><i class="bi bi-arrow-left"></i> Về trang chủ</a>
    </div>
</div>
</body>
</html>
