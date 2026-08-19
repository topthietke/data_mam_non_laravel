<?php
/**
 * admin-auth.php
 * Bắt buộc đăng nhập cho mọi trang trong khu vực /admin (trừ login.php).
 * Include file này ở đầu mỗi trang quản trị, SAU khi đã require config.php.
 *
 * Đồng thời cung cấp các hàm hỗ trợ chống giả mạo yêu cầu (CSRF) cho các form
 * thêm/sửa/xoá dữ liệu trong khu quản trị.
 */

if (empty($_SESSION['admin_dang_nhap'])) {
    $_SESSION['admin_redirect_sau_dang_nhap'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
    header('Location: login.php');
    exit;
}

/** Tạo (hoặc lấy) CSRF token cho phiên làm việc hiện tại. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** In ra input ẩn chứa CSRF token, dùng trong mỗi <form> của khu quản trị. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token()) . '">';
}

/** Kiểm tra CSRF token gửi lên từ form có khớp với token trong session không. */
function csrf_kiem_tra(): bool
{
    $gui_len = $_POST['csrf_token'] ?? '';
    return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $gui_len);
}

/** Lưu một thông báo flash (hiện 1 lần rồi mất) để hiển thị sau khi redirect. */
function dat_thong_bao(string $loai, string $noi_dung): void
{
    $_SESSION['admin_thong_bao'] = ['loai' => $loai, 'noi_dung' => $noi_dung];
}

function lay_thong_bao(): ?array
{
    $tb = $_SESSION['admin_thong_bao'] ?? null;
    unset($_SESSION['admin_thong_bao']);
    return $tb;
}
