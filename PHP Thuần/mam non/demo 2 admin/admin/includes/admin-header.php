<?php
/**
 * admin-header.php
 * Yêu cầu $trang_admin_hien_tai (tên file, vd 'index.php') và $tieu_de_admin
 * đã được set trước khi include file này.
 */
$trang_admin_hien_tai = $trang_admin_hien_tai ?? basename($_SERVER['PHP_SELF']);
$menu_admin = [
    ['ten' => 'Tổng quan',             'link' => 'index.php',          'icon' => 'speedometer2'],
    ['ten' => 'Đăng ký tham quan',     'link' => 'dang-ky.php',        'icon' => 'inbox-fill'],
    ['ten' => 'Điểm mạnh nổi bật',     'link' => 'gioi-thieu.php',     'icon' => 'shield-heart'],
    ['ten' => 'Chương trình học',      'link' => 'chuong-trinh.php',   'icon' => 'signpost-split-fill'],
    ['ten' => 'Hoạt động hằng ngày',   'link' => 'hoat-dong.php',      'icon' => 'stars'],
    ['ten' => 'Cảm nhận phụ huynh',    'link' => 'cam-nhan.php',       'icon' => 'chat-quote-fill'],
    ['ten' => 'Số liệu nổi bật',       'link' => 'so-lieu.php',        'icon' => 'graph-up-arrow'],
    ['ten' => 'Thông tin trường',      'link' => 'cai-dat.php',        'icon' => 'gear-fill'],
];
$thong_bao_admin = lay_thong_bao();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title><?= htmlspecialchars($tieu_de_admin ?? 'Quản trị') ?> — Quản trị Sao Nhỏ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<div class="admin-shell">
  <!-- ===== Sidebar ===== -->
  <aside class="admin-sidebar">
    <a href="index.php" class="admin-brand">
      <span class="admin-brand-mark"><i class="bi bi-flower2"></i></span>
      <span>
        <strong>Sao Nhỏ</strong>
        <small>Khu vực Quản trị</small>
      </span>
    </a>
    <nav class="admin-nav">
      <?php foreach ($menu_admin as $muc): ?>
        <a href="<?= htmlspecialchars($muc['link']) ?>"
           class="admin-nav-link <?= $trang_admin_hien_tai === $muc['link'] ? 'active' : '' ?>">
          <i class="bi bi-<?= htmlspecialchars($muc['icon']) ?>"></i>
          <span><?= htmlspecialchars($muc['ten']) ?></span>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="admin-sidebar-footer">
      <a href="../index.php" target="_blank" class="admin-nav-link">
        <i class="bi bi-box-arrow-up-right"></i><span>Xem trang web</span>
      </a>
      <a href="logout.php" class="admin-nav-link text-danger-emphasis">
        <i class="bi bi-box-arrow-left"></i><span>Đăng xuất</span>
      </a>
    </div>
  </aside>

  <!-- ===== Nội dung ===== -->
  <div class="admin-main">
    <header class="admin-topbar">
      <button class="admin-menu-toggle d-lg-none" type="button" id="adminMenuToggle" aria-label="Mở menu">
        <i class="bi bi-list"></i>
      </button>
      <h1 class="admin-page-title"><?= htmlspecialchars($tieu_de_admin ?? '') ?></h1>
      <div class="admin-user-chip">
        <i class="bi bi-person-circle"></i>
        <span><?= htmlspecialchars($_SESSION['admin_ho_ten'] ?? 'Quản trị viên') ?></span>
      </div>
    </header>

    <div class="admin-content">
      <?php if ($thong_bao_admin): ?>
        <div class="alert-admin alert-admin-<?= htmlspecialchars($thong_bao_admin['loai']) ?>">
          <i class="bi bi-<?= $thong_bao_admin['loai'] === 'thanh-cong' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?>"></i>
          <span><?= htmlspecialchars($thong_bao_admin['noi_dung']) ?></span>
        </div>
      <?php endif; ?>
