<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';

/** Lấy toàn bộ settings dạng mảng key => value */
function get_settings(PDO $pdo): array
{
    static $cache = null;
    if ($cache !== null) return $cache;
    $cache = [];
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    foreach ($stmt->fetchAll() as $row) {
        $cache[$row['setting_key']] = $row['setting_value'];
    }
    return $cache;
}

/** Lấy 1 giá trị setting, có fallback */
function setting(array $settings, string $key, string $default = ''): string
{
    return isset($settings[$key]) && $settings[$key] !== '' ? $settings[$key] : $default;
}

/** Chống XSS khi in dữ liệu ra HTML */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/** Sinh / kiểm tra CSRF token */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_check(): bool
{
    return isset($_POST['csrf_token']) && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

/** Kiểm tra đăng nhập admin, chuyển hướng nếu chưa đăng nhập */
function require_admin_login(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

/** Upload ảnh an toàn, trả về tên file đã lưu hoặc null nếu không có file */
function handle_upload(string $inputName, string $subfolder): ?string
{
    if (empty($_FILES[$inputName]['name']) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $ext = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        return null;
    }
    if ($_FILES[$inputName]['size'] > 5 * 1024 * 1024) { // giới hạn 5MB
        return null;
    }
    $targetDir = __DIR__ . '/../assets/uploads/' . $subfolder . '/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $filename = uniqid($subfolder . '_', true) . '.' . $ext;
    if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetDir . $filename)) {
        return $filename;
    }
    return null;
}

/** Xoá file ảnh cũ trong thư mục uploads (nếu tồn tại) */
function delete_upload(?string $filename, string $subfolder): void
{
    if (!$filename) return;
    $path = __DIR__ . '/../assets/uploads/' . $subfolder . '/' . $filename;
    if (is_file($path)) {
        @unlink($path);
    }
}

/** Đường dẫn ảnh public, dùng ảnh mặc định nếu rỗng */
function upload_url(?string $filename, string $subfolder, string $fallback = ''): string
{
    if ($filename && is_file(__DIR__ . '/../assets/uploads/' . $subfolder . '/' . $filename)) {
        return BASE_URL . '/assets/uploads/' . $subfolder . '/' . $filename;
    }
    return $fallback;
}

function redirect_with_message(string $url, string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    header('Location: ' . $url);
    exit;
}

function get_flash(): ?array
{
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
