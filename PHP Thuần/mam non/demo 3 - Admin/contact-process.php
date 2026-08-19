<?php
require_once __DIR__ . '/includes/functions.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_check()) {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ, vui lòng tải lại trang.']);
    exit;
}

$name    = trim($_POST['name'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $phone === '') {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ họ tên và số điện thoại.']);
    exit;
}
if (!preg_match('/^[0-9+\s().-]{8,20}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'Số điện thoại không hợp lệ.']);
    exit;
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email không hợp lệ.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, phone, email, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $email, $message]);
    echo json_encode(['success' => true, 'message' => 'Cảm ơn bạn đã đăng ký! Nhà trường sẽ liên hệ tư vấn sớm nhất.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.']);
}
