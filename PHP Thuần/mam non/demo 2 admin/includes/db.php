<?php
/**
 * db.php
 * Khởi tạo kết nối PDO tới SQLite, tự tạo bảng nếu chưa có,
 * và tự chèn dữ liệu mẫu (seed) trong lần chạy đầu tiên.
 * Dùng SQLite (1 file duy nhất, không cần cài đặt máy chủ CSDL riêng)
 * để bản demo có thể chạy ngay trên bất kỳ hosting PHP nào.
 */

$duong_dan_csdl = __DIR__ . '/../data/mamnon.sqlite';
$can_tao_bang = !file_exists($duong_dan_csdl);

try {
    $pdo = new PDO('sqlite:' . $duong_dan_csdl);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');
} catch (PDOException $e) {
    die('Không thể kết nối cơ sở dữ liệu: ' . htmlspecialchars($e->getMessage()));
}

if ($can_tao_bang) {

    $pdo->exec("CREATE TABLE settings (
        khoa TEXT PRIMARY KEY,
        gia_tri TEXT
    )");

    $pdo->exec("CREATE TABLE stages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ten TEXT NOT NULL,
        do_tuoi TEXT NOT NULL,
        mo_ta TEXT,
        icon TEXT DEFAULT 'flower1',
        kich_co INTEGER DEFAULT 1,
        thu_tu INTEGER DEFAULT 0
    )");

    $pdo->exec("CREATE TABLE features (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        icon TEXT DEFAULT 'stars',
        tieu_de TEXT NOT NULL,
        mo_ta TEXT,
        thu_tu INTEGER DEFAULT 0
    )");

    $pdo->exec("CREATE TABLE activities (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ten TEXT NOT NULL,
        icon TEXT DEFAULT 'stars',
        mau TEXT DEFAULT '#FFE4B8',
        thu_tu INTEGER DEFAULT 0
    )");

    $pdo->exec("CREATE TABLE testimonials (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ten TEXT NOT NULL,
        vai_tro TEXT,
        noi_dung TEXT NOT NULL,
        thu_tu INTEGER DEFAULT 0
    )");

    $pdo->exec("CREATE TABLE stats (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        so INTEGER NOT NULL,
        don_vi TEXT DEFAULT '',
        nhan TEXT NOT NULL,
        thu_tu INTEGER DEFAULT 0
    )");

    $pdo->exec("CREATE TABLE registrations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ho_ten TEXT NOT NULL,
        sdt TEXT NOT NULL,
        email TEXT,
        do_tuoi TEXT,
        loi_nhan TEXT,
        trang_thai TEXT DEFAULT 'moi',
        tao_luc TEXT DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE admin_users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ten_dang_nhap TEXT UNIQUE NOT NULL,
        mat_khau_hash TEXT NOT NULL,
        ho_ten TEXT,
        tao_luc TEXT DEFAULT CURRENT_TIMESTAMP
    )");

    // ----- Dữ liệu cài đặt chung -----
    $cai_dat_mac_dinh = [
        'ten_truong'  => 'Sao Nhỏ',
        'ten_day_du'  => 'Trường Mầm Non Sao Nhỏ',
        'khau_hieu'   => 'Mỗi ngày đến lớp là một ngày vui',
        'hotline'     => '0909 123 456',
        'email'       => 'lienhe@saonho.edu.vn',
        'dia_chi'     => '12 Đường Hoa Sữa, Phường Bình Thạnh, TP. Hồ Chí Minh',
        'gio_hoc'     => 'Thứ 2 - Thứ 6, 7:00 - 17:00',
        'facebook'    => '#',
        'zalo'        => '#',
        'hero_eyebrow'=> 'Tuyển sinh năm học mới',
        'hero_tieude' => 'Ươm mầm yêu thương, vun đắp tương lai',
        'hero_mota'   => 'Tại Trường Mầm Non Sao Nhỏ, mỗi bé được học tập trong môi trường an toàn, được yêu thương và khơi dậy sự tò mò khám phá thế giới xung quanh.',
        'gioithieu_tieude' => 'Nơi mỗi buổi sáng con đều háo hức đến lớp',
        'gioithieu_mota'   => 'Chúng tôi tin rằng tuổi thơ chỉ đến một lần. Sao Nhỏ xây dựng môi trường học tập lấy trẻ làm trung tâm, nơi con được tự do khám phá, vui chơi và trưởng thành theo nhịp độ riêng của mình - luôn có cô giáo đồng hành sát cánh.',
    ];
    $stmt = $pdo->prepare("INSERT INTO settings (khoa, gia_tri) VALUES (:khoa, :gia_tri)");
    foreach ($cai_dat_mac_dinh as $khoa => $gia_tri) {
        $stmt->execute(['khoa' => $khoa, 'gia_tri' => $gia_tri]);
    }

    // ----- 4 giai đoạn học -----
    $giai_doan_mac_dinh = [
        ['Nhà Trẻ', '18 - 36 tháng', 'Làm quen với lớp học, xây dựng nền nếp sinh hoạt và cảm giác an toàn đầu đời.', 'flower1', 1],
        ['Lớp Mầm', '3 - 4 tuổi', 'Phát triển ngôn ngữ, vận động tinh và kỹ năng tự phục vụ cơ bản qua trò chơi.', 'flower2', 2],
        ['Lớp Chồi', '4 - 5 tuổi', 'Khơi gợi tư duy sáng tạo, làm quen chữ cái - con số, rèn kỹ năng hợp tác nhóm.', 'tree', 3],
        ['Lớp Lá', '5 - 6 tuổi', 'Trang bị hành trang sẵn sàng vào lớp 1: nền nếp học tập, sự tự tin và tính tự lập.', 'tree-fill', 4],
    ];
    $stmt = $pdo->prepare("INSERT INTO stages (ten, do_tuoi, mo_ta, icon, kich_co, thu_tu) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($giai_doan_mac_dinh as $i => $gd) { $stmt->execute([...$gd, $i]); }

    // ----- Điểm mạnh -----
    $diem_manh_mac_dinh = [
        ['shield-heart', 'An toàn là ưu tiên số 1', 'Camera giám sát 24/7, khuôn viên khép kín, quy trình đón trả kiểm soát chặt chẽ.'],
        ['palette', 'Học qua chơi, chơi qua học', 'Giáo trình lấy trẻ làm trung tâm, khuyến khích khám phá và sáng tạo mỗi ngày.'],
        ['people-fill', 'Sĩ số nhỏ, quan tâm sát sao', 'Tối đa 18 bé/lớp với 2 giáo viên và 1 bảo mẫu, đảm bảo mỗi bé đều được chú ý.'],
        ['egg-fried', 'Dinh dưỡng khoa học', 'Thực đơn xây dựng cùng chuyên gia dinh dưỡng, thay đổi theo mùa, rõ nguồn gốc.'],
    ];
    $stmt = $pdo->prepare("INSERT INTO features (icon, tieu_de, mo_ta, thu_tu) VALUES (?, ?, ?, ?)");
    foreach ($diem_manh_mac_dinh as $i => $dm) { $stmt->execute([...$dm, $i]); }

    // ----- Hoạt động -----
    $hoat_dong_mac_dinh = [
        ['Giờ vận động ngoài trời', 'bicycle', '#FFE4B8'],
        ['Góc nghệ thuật & tô màu', 'palette2', '#C9E8DD'],
        ['Giờ kể chuyện cùng cô', 'book-half', '#FFD3C2'],
        ['Khám phá khoa học vui', 'stars', '#DCE3F7'],
        ['Bữa ăn dinh dưỡng', 'egg-fried', '#F6E3C5'],
        ['Âm nhạc & vận động', 'music-note-beamed', '#E4D6EF'],
    ];
    $stmt = $pdo->prepare("INSERT INTO activities (ten, icon, mau, thu_tu) VALUES (?, ?, ?, ?)");
    foreach ($hoat_dong_mac_dinh as $i => $hd) { $stmt->execute([...$hd, $i]); }

    // ----- Cảm nhận phụ huynh -----
    $cam_nhan_mac_dinh = [
        ['Chị Minh Anh', 'Phụ huynh bé Bo - Lớp Chồi', 'Bé nhà mình từ nhút nhát đã tự tin phát biểu, tự xúc ăn và biết chia sẻ đồ chơi với bạn. Cảm ơn các cô rất nhiều!'],
        ['Anh Quốc Huy', 'Phụ huynh bé Susu - Lớp Lá', 'Trường có chương trình chuẩn bị vào lớp 1 rất bài bản, con mình không hề bỡ ngỡ khi bước vào năm học mới.'],
        ['Chị Thanh Hằng', 'Phụ huynh bé Kem - Lớp Mầm', 'Cô giáo luôn cập nhật hình ảnh, video hoạt động hàng ngày qua app riêng, mình an tâm khi đi làm.'],
    ];
    $stmt = $pdo->prepare("INSERT INTO testimonials (ten, vai_tro, noi_dung, thu_tu) VALUES (?, ?, ?, ?)");
    foreach ($cam_nhan_mac_dinh as $i => $cn) { $stmt->execute([...$cn, $i]); }

    // ----- Số liệu nổi bật -----
    $so_lieu_mac_dinh = [
        [12, '+', 'năm hoạt động'],
        [480, '+', 'bé đang theo học'],
        [36, '', 'giáo viên & bảo mẫu'],
        [98, '%', 'phụ huynh giới thiệu tiếp'],
    ];
    $stmt = $pdo->prepare("INSERT INTO stats (so, don_vi, nhan, thu_tu) VALUES (?, ?, ?, ?)");
    foreach ($so_lieu_mac_dinh as $i => $sl) { $stmt->execute([...$sl, $i]); }

    // ----- Tài khoản quản trị mặc định -----
    // Tên đăng nhập: admin / Mật khẩu: MamNon@2026 (khuyến nghị đổi ngay sau khi đăng nhập lần đầu)
    $pdo->prepare("INSERT INTO admin_users (ten_dang_nhap, mat_khau_hash, ho_ten) VALUES (?, ?, ?)")
        ->execute(['admin', password_hash('MamNon@2026', PASSWORD_DEFAULT), 'Quản trị viên']);
}
