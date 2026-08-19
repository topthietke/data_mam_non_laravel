<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(setting($settings, 'site_name', 'Mầm Non')) ?> - <?= e(setting($settings, 'site_slogan', '')) ?></title>
<meta name="description" content="<?= e(setting($settings, 'about_content', '')) ?>">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;700;800&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-mamnon sticky-top" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>/index.php">
            <?php $logo = upload_url(setting($settings, 'logo'), 'settings'); ?>
            <?php if ($logo): ?>
                <img src="<?= e($logo) ?>" alt="Logo">
            <?php else: ?>
                <i class="bi bi-flower1 me-2" style="color:var(--color-orange)"></i>
            <?php endif; ?>
            <?= e(setting($settings, 'site_name', 'Mầm Non')) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="#home">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="#programs">Chương trình học</a></li>
                <li class="nav-item"><a class="nav-link" href="#gallery">Hoạt động</a></li>
                <li class="nav-item"><a class="nav-link" href="#teachers">Đội ngũ</a></li>
                <li class="nav-item"><a class="nav-link" href="#news">Tin tức</a></li>
                <li class="nav-item ms-lg-2">
                    <a href="#contact" class="btn btn-playful btn-pink">Liên hệ ngay</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
