<?php
require_once __DIR__ . '/config.php';
$trang = trang_hien_tai();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($tieu_de_trang ?? $site['ten_day_du']) ?></title>
<meta name="description" content="<?= htmlspecialchars($mo_ta_trang ?? $site['khau_hieu']) ?>">

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<!-- Fonts: Baloo 2 (tiêu đề, bo tròn, thân thiện) + Be Vietnam Pro (nội dung, hỗ trợ tốt tiếng Việt) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
<!-- CSS riêng -->
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<a class="skip-link" href="#noi-dung-chinh">Bỏ qua đến nội dung chính</a>

<!-- ===== Thanh thông báo trên cùng ===== -->
<div class="top-strip">
  <div class="container d-flex flex-wrap justify-content-center justify-content-md-between align-items-center py-1 small">
    <div class="d-none d-md-flex gap-3">
      <span><i class="bi bi-telephone-fill me-1"></i><?= htmlspecialchars($site['hotline']) ?></span>
      <span><i class="bi bi-envelope-fill me-1"></i><?= htmlspecialchars($site['email']) ?></span>
    </div>
    <div><i class="bi bi-clock-fill me-1"></i><?= htmlspecialchars($site['gio_hoc']) ?></div>
  </div>
</div>

<!-- ===== Thanh điều hướng chính ===== -->
<header class="site-navbar sticky-top">
  <nav class="navbar navbar-expand-lg container py-2">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <span class="brand-mark" aria-hidden="true">
        <i class="bi bi-flower2"></i>
      </span>
      <span class="brand-text">
        <span class="brand-ten">Mầm Non <?= htmlspecialchars($site['ten_truong']) ?></span>
        <span class="brand-khauhieu"><?= htmlspecialchars($site['khau_hieu']) ?></span>
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuChinh" aria-controls="menuChinh" aria-expanded="false" aria-label="Mở menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="menuChinh">
      <ul class="navbar-nav align-items-lg-center gap-lg-1">
        <?php foreach ($menu as $muc): ?>
          <li class="nav-item">
            <a class="nav-link <?= ($muc['link'] === $trang || ($trang === 'index.php' && str_contains($muc['link'], 'index.php#'))) ? '' : '' ?>"
               href="<?= htmlspecialchars($muc['link']) ?>"><?= htmlspecialchars($muc['ten']) ?></a>
          </li>
        <?php endforeach; ?>
        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
          <a class="btn btn-cta" href="lien-he.php#form-tuyen-sinh">Đăng ký tham quan</a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<main id="noi-dung-chinh">
