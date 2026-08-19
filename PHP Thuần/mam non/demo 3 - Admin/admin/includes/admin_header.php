<?php
require_admin_login();
$currentPage = basename($_SERVER['PHP_SELF']);

// Đếm số tin nhắn chưa đọc để hiển thị badge
$unreadCount = (int) $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();

$menuItems = [
    'dashboard.php'     => ['icon' => 'bi-grid-1x2-fill', 'label' => 'Tổng quan'],
    'settings.php'       => ['icon' => 'bi-gear-fill', 'label' => 'Cài đặt chung'],
    'programs.php'       => ['icon' => 'bi-mortarboard-fill', 'label' => 'Chương trình học'],
    'teachers.php'       => ['icon' => 'bi-people-fill', 'label' => 'Đội ngũ giáo viên'],
    'gallery.php'        => ['icon' => 'bi-images', 'label' => 'Thư viện ảnh'],
    'testimonials.php'   => ['icon' => 'bi-chat-heart-fill', 'label' => 'Cảm nhận phụ huynh'],
    'news.php'           => ['icon' => 'bi-newspaper', 'label' => 'Tin tức'],
    'messages.php'       => ['icon' => 'bi-envelope-fill', 'label' => 'Tin nhắn liên hệ', 'badge' => $unreadCount],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản trị - Mầm Non Landing Page</title>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    body { font-family: 'Quicksand', sans-serif; background: #FAF7F0; }
    .heading-font { font-family: 'Baloo 2', cursive; }
    .admin-sidebar {
        position: fixed; top: 0; left: 0; bottom: 0; width: 260px; z-index: 1030;
        background: #fff; border-right: 1px solid #eee; overflow-y: auto;
        transition: transform .25s ease;
    }
    .admin-sidebar .brand { padding: 22px 20px; font-family: 'Baloo 2', cursive; font-size: 1.3rem; color: #FF8552; border-bottom: 1px solid #f0f0f0; }
    .admin-sidebar .nav-link { color: #444; font-weight: 600; padding: 12px 20px; border-radius: 0; display:flex; align-items:center; gap:10px; }
    .admin-sidebar .nav-link i { font-size: 1.1rem; width: 22px; }
    .admin-sidebar .nav-link.active { background: #FFF3D6; color: #FF8552; border-right: 4px solid #FF8552; }
    .admin-sidebar .nav-link:hover { background: #FFF8EC; color: #FF8552; }
    .admin-content { margin-left: 260px; min-height: 100vh; }
    .admin-topbar { background: #fff; border-bottom: 1px solid #eee; padding: 14px 24px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1020; }
    .admin-main { padding: 24px; }
    .card-panel { border: none; border-radius: 18px; box-shadow: 0 6px 20px rgba(0,0,0,0.05); }
    .btn-primary-playful { background: #FF6F91; border: none; border-radius: 12px; font-weight: 700; color: #fff; }
    .btn-primary-playful:hover { background: #ff5580; color: #fff; }
    .table thead { background: #FFF8EC; }
    .badge-soft { background: #FFE3EC; color: #FF6F91; font-weight: 700; }
    .thumb-preview { width: 56px; height: 56px; object-fit: cover; border-radius: 10px; }
    @media (max-width: 991px) {
        .admin-sidebar { transform: translateX(-100%); }
        .admin-sidebar.show { transform: translateX(0); }
        .admin-content { margin-left: 0; }
    }
</style>
</head>
<body>

<aside class="admin-sidebar" id="adminSidebar">
    <div class="brand"><i class="bi bi-flower1 me-2"></i>Quản trị Mầm Non</div>
    <nav class="nav flex-column py-2">
        <?php foreach ($menuItems as $file => $item): ?>
            <a class="nav-link <?= $currentPage === $file ? 'active' : '' ?>" href="<?= $file ?>">
                <i class="bi <?= $item['icon'] ?>"></i> <?= e($item['label']) ?>
                <?php if (!empty($item['badge'])): ?>
                    <span class="badge rounded-pill badge-soft ms-auto"><?= (int)$item['badge'] ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
        <hr>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
        <a class="nav-link" href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Xem website</a>
    </nav>
</aside>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light d-lg-none" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <h5 class="mb-0 heading-font"><?= e($pageTitle ?? 'Quản trị') ?></h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle fs-4 text-secondary"></i>
            <span class="fw-bold"><?= e($_SESSION['admin_name'] ?? 'Admin') ?></span>
        </div>
    </div>
    <main class="admin-main">
        <?php $flash = get_flash(); if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= e($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
