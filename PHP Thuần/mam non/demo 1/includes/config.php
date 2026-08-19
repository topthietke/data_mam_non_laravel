<?php
/**
 * config.php
 * Nơi lưu trữ dữ liệu dùng chung cho toàn bộ website:
 * thông tin trường, menu điều hướng, các giai đoạn học, cảm nhận phụ huynh, số liệu nổi bật...
 * Tách dữ liệu ra file riêng giúp header/footer và các trang tái sử dụng mà không lặp code.
 */

session_start();

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

// ----- Thông tin chung của trường -----
$site = [
    'ten_truong'   => 'Sao Nhỏ',
    'ten_day_du'   => 'Trường Mầm Non Sao Nhỏ',
    'khau_hieu'    => 'Mỗi ngày đến lớp là một ngày vui',
    'hotline'      => '0909 123 456',
    'email'        => 'lienhe@saonho.edu.vn',
    'dia_chi'      => '12 Đường Hoa Sữa, Phường Bình Thạnh, TP. Hồ Chí Minh',
    'gio_hoc'      => 'Thứ 2 - Thứ 6, 7:00 - 17:00',
    'facebook'     => '#',
    'zalo'         => '#',
];

// ----- Menu điều hướng chính -----
$menu = [
    ['ten' => 'Trang chủ',   'link' => 'index.php'],
    ['ten' => 'Giới thiệu',  'link' => 'index.php#gioi-thieu'],
    ['ten' => 'Chương trình','link' => 'index.php#chuong-trinh'],
    ['ten' => 'Hoạt động',   'link' => 'index.php#hoat-dong'],
    ['ten' => 'Phụ huynh nói gì', 'link' => 'index.php#cam-nhan'],
    ['ten' => 'Liên hệ',     'link' => 'lien-he.php'],
];

// ----- 4 giai đoạn phát triển (đúng theo cách gọi lớp mầm non tại Việt Nam) -----
// Dùng để dựng "hành trình khôn lớn" - yếu tố đồ họa đặc trưng của trang
$giai_doan = [
    [
        'ma'      => 'nha-tre',
        'ten'     => 'Nhà Trẻ',
        'do_tuoi' => '18 - 36 tháng',
        'mo_ta'   => 'Làm quen với lớp học, xây dựng nền nếp sinh hoạt và cảm giác an toàn đầu đời.',
        'icon'    => 'seedling',
        'size'    => 1,
    ],
    [
        'ma'      => 'mam',
        'ten'     => 'Lớp Mầm',
        'do_tuoi' => '3 - 4 tuổi',
        'mo_ta'   => 'Phát triển ngôn ngữ, vận động tinh và kỹ năng tự phục vụ cơ bản qua trò chơi.',
        'icon'    => 'sprout',
        'size'    => 2,
    ],
    [
        'ma'      => 'choi',
        'ten'     => 'Lớp Chồi',
        'do_tuoi' => '4 - 5 tuổi',
        'mo_ta'   => 'Khơi gợi tư duy sáng tạo, làm quen chữ cái - con số, rèn kỹ năng hợp tác nhóm.',
        'icon'    => 'sapling',
        'size'    => 3,
    ],
    [
        'ma'      => 'la',
        'ten'     => 'Lớp Lá',
        'do_tuoi' => '5 - 6 tuổi',
        'mo_ta'   => 'Trang bị hành trang sẵn sàng vào lớp 1: nền nếp học tập, sự tự tin và tính tự lập.',
        'icon'    => 'tree',
        'size'    => 4,
    ],
];

// ----- Điểm mạnh / lý do phụ huynh chọn trường -----
$diem_manh = [
    [
        'icon'  => 'shield-heart',
        'tieu_de' => 'An toàn là ưu tiên số 1',
        'mo_ta' => 'Camera giám sát 24/7, khuôn viên khép kín, quy trình đón trả kiểm soát chặt chẽ.',
    ],
    [
        'icon'  => 'palette',
        'tieu_de' => 'Học qua chơi, chơi qua học',
        'mo_ta' => 'Giáo trình lấy trẻ làm trung tâm, khuyến khích khám phá và sáng tạo mỗi ngày.',
    ],
    [
        'icon'  => 'people-fill',
        'tieu_de' => 'Sĩ số nhỏ, quan tâm sát sao',
        'mo_ta' => 'Tối đa 18 bé/lớp với 2 giáo viên và 1 bảo mẫu, đảm bảo mỗi bé đều được chú ý.',
    ],
    [
        'icon'  => 'egg-fried',
        'tieu_de' => 'Dinh dưỡng khoa học',
        'mo_ta' => 'Thực đơn xây dựng cùng chuyên gia dinh dưỡng, thay đổi theo mùa, rõ nguồn gốc.',
    ],
];

// ----- Cảm nhận phụ huynh -----
$cam_nhan = [
    [
        'ten'    => 'Chị Minh Anh',
        'vai_tro'=> 'Phụ huynh bé Bo - Lớp Chồi',
        'noi_dung' => 'Bé nhà mình từ nhút nhát đã tự tin phát biểu, tự xúc ăn và biết chia sẻ đồ chơi với bạn. Cảm ơn các cô rất nhiều!',
    ],
    [
        'ten'    => 'Anh Quốc Huy',
        'vai_tro'=> 'Phụ huynh bé Susu - Lớp Lá',
        'noi_dung' => 'Trường có chương trình chuẩn bị vào lớp 1 rất bài bản, con mình không hề bỡ ngỡ khi bước vào năm học mới.',
    ],
    [
        'ten'    => 'Chị Thanh Hằng',
        'vai_tro'=> 'Phụ huynh bé Kem - Lớp Mầm',
        'noi_dung' => 'Cô giáo luôn cập nhật hình ảnh, video hoạt động hàng ngày qua app riêng, mình an tâm khi đi làm.',
    ],
];

// ----- Số liệu nổi bật -----
$so_lieu = [
    ['so' => '12', 'don_vi' => '+', 'nhan' => 'năm hoạt động'],
    ['so' => '480', 'don_vi' => '+', 'nhan' => 'bé đang theo học'],
    ['so' => '36', 'don_vi' => '', 'nhan' => 'giáo viên & bảo mẫu'],
    ['so' => '98', 'don_vi' => '%', 'nhan' => 'phụ huynh giới thiệu tiếp'],
];

/**
 * Hàm tiện ích: xác định menu nào đang active dựa trên tên file hiện tại.
 */
function trang_hien_tai(): string
{
    return basename($_SERVER['PHP_SELF']);
}
