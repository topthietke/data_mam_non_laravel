<?php
/**
 * xu-ly-lien-he.php
 * Xử lý dữ liệu form đăng ký tham quan / liên hệ được gửi bằng phương thức POST.
 * Thực hiện validate phía server (không chỉ dựa vào validate của trình duyệt),
 * sau đó lưu kết quả vào session để trang lien-he.php hiển thị lại thông báo,
 * và redirect để tránh việc người dùng bấm F5 gửi lại form (mẫu Post/Redirect/Get).
 */
require_once __DIR__ . '/includes/config.php';

$loi = [];
$du_lieu_cu = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Lấy và làm sạch dữ liệu đầu vào
    $ho_ten    = trim($_POST['ho_ten'] ?? '');
    $sdt       = trim($_POST['sdt'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $do_tuoi   = trim($_POST['do_tuoi_be'] ?? '');
    $loi_nhan  = trim($_POST['loi_nhan'] ?? '');

    $du_lieu_cu = compact('ho_ten', 'sdt', 'email', 'do_tuoi', 'loi_nhan');

    // ----- Validate phía server -----
    if ($ho_ten === '') {
        $loi['ho_ten'] = 'Vui lòng nhập họ tên phụ huynh.';
    } elseif (mb_strlen($ho_ten) < 2) {
        $loi['ho_ten'] = 'Họ tên quá ngắn.';
    }

    if ($sdt === '') {
        $loi['sdt'] = 'Vui lòng nhập số điện thoại.';
    } elseif (!preg_match('/^0[0-9]{9,10}$/', $sdt)) {
        $loi['sdt'] = 'Số điện thoại không hợp lệ (VD: 0909123456).';
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $loi['email'] = 'Địa chỉ email không hợp lệ.';
    }

    if ($do_tuoi === '') {
        $loi['do_tuoi'] = 'Vui lòng chọn độ tuổi của bé.';
    }

    if (empty($loi)) {
        // Lưu vào data/dang-ky.json để khu vực Quản trị có thể xem, đổi trạng thái, xử lý.
        // Trong môi trường thực tế có thể bổ sung gửi email thông báo cho nhà trường, ví dụ:
        // mail($site['email'], 'Đăng ký tham quan mới', "Họ tên: $ho_ten\nSĐT: $sdt");
        them_dang_ky([
            'ho_ten'   => $ho_ten,
            'sdt'      => $sdt,
            'email'    => $email,
            'do_tuoi'  => $do_tuoi,
            'loi_nhan' => $loi_nhan,
        ]);

        $_SESSION['thong_bao_thanh_cong'] = "Cảm ơn {$ho_ten}! Nhà trường đã nhận được thông tin đăng ký và sẽ liên hệ với anh/chị qua số {$sdt} trong thời gian sớm nhất.";
        unset($_SESSION['loi_form'], $_SESSION['du_lieu_cu']);

        header('Location: lien-he.php#form-tuyen-sinh');
        exit;
    }

    // Nếu có lỗi: lưu lại lỗi + dữ liệu cũ vào session rồi quay lại form
    $_SESSION['loi_form']   = $loi;
    $_SESSION['du_lieu_cu'] = $du_lieu_cu;
    header('Location: lien-he.php#form-tuyen-sinh');
    exit;
}

// Nếu truy cập trực tiếp không phải POST thì đưa về trang liên hệ
header('Location: lien-he.php');
exit;
