<?php
/**
 * config.php
 * Nạp dữ liệu dùng chung cho toàn bộ website (trang public + có thể tái dùng ở admin).
 * Toàn bộ nội dung hiển thị (giới thiệu, chương trình học, cảm nhận phụ huynh...)
 * giờ được đọc từ data/content.json — có thể chỉnh sửa trực tiếp qua khu vực /admin
 * mà KHÔNG cần sửa code, giúp người quản trị (không biết lập trình) vẫn tự cập nhật được.
 */

session_start();
require_once __DIR__ . '/du-lieu.php';

// Dự phòng cho môi trường chưa bật extension mbstring (đa số hosting PHP đều có sẵn,
// nhưng vẫn thêm polyfill nhỏ này để form liên hệ không bị lỗi 500 nếu thiếu).
if (!function_exists('mb_strlen')) {
    function mb_strlen(string $s, string $encoding = 'UTF-8'): int
    {
        return preg_match_all('/./us', $s, $m);
    }
}
if (!function_exists('mb_substr')) {
    function mb_substr(string $s, int $start, ?int $length = null, string $encoding = 'UTF-8'): string
    {
        preg_match_all('/./us', $s, $m);
        $chars = array_slice($m[0], $start, $length);
        return implode('', $chars);
    }
}

// ----- Đọc dữ liệu động từ data/content.json -----
$site       = lay_thong_tin_truong();
$giai_doan  = lay_danh_sach('giai_doan');
$diem_manh  = lay_danh_sach('diem_manh');
$cam_nhan   = lay_danh_sach('cam_nhan');
$hoat_dong  = lay_danh_sach('hoat_dong');
$so_lieu    = lay_danh_sach('so_lieu');

// ----- Menu điều hướng chính (cấu trúc menu ít thay đổi nên vẫn để cố định trong code) -----
$menu = [
    ['ten' => 'Trang chủ',   'link' => 'index.php'],
    ['ten' => 'Giới thiệu',  'link' => 'index.php#gioi-thieu'],
    ['ten' => 'Chương trình','link' => 'index.php#chuong-trinh'],
    ['ten' => 'Hoạt động',   'link' => 'index.php#hoat-dong'],
    ['ten' => 'Phụ huynh nói gì', 'link' => 'index.php#cam-nhan'],
    ['ten' => 'Liên hệ',     'link' => 'lien-he.php'],
];

/**
 * Hàm tiện ích: xác định menu nào đang active dựa trên tên file hiện tại.
 */
function trang_hien_tai(): string
{
    return basename($_SERVER['PHP_SELF']);
}
