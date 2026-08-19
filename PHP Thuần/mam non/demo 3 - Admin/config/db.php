<?php
/**
 * Cấu hình kết nối cơ sở dữ liệu
 * Sửa lại các thông số bên dưới cho đúng với môi trường của bạn
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'mamnon_landing');
define('DB_USER', 'root');
define('DB_PASS', '!23456aA@');
define('DB_CHARSET', 'utf8mb4');

// Đường dẫn gốc của website (không có dấu / ở cuối)
// Ví dụ: nếu website chạy ở http://localhost/mamnon-landing thì để nguyên dòng dưới
define('BASE_URL', 'http://quiz.local');

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die('Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage());
}
