<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Thư viện ảnh';
require_admin_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        redirect_with_message('gallery.php', 'danger', 'Phiên làm việc hết hạn.');
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $caption = trim($_POST['caption'] ?? '');
        $order   = (int)($_POST['display_order'] ?? 0);
        $uploaded = handle_upload('image', 'gallery');

        if (!$uploaded) {
            redirect_with_message('gallery.php', 'danger', 'Vui lòng chọn một ảnh hợp lệ (jpg, png, webp, gif - tối đa 5MB).');
        }
        $stmt = $pdo->prepare("INSERT INTO gallery (image, caption, display_order, status) VALUES (?,?,?,1)");
        $stmt->execute([$uploaded, $caption, $order]);
        redirect_with_message('gallery.php', 'success', 'Đã thêm ảnh vào thư viện.');
    }

    if ($action === 'toggle') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare("UPDATE gallery SET status = 1 - status WHERE id = ?")->execute([$id]);
        redirect_with_message('gallery.php', 'success', 'Đã cập nhật trạng thái ảnh.');
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("SELECT image FROM gallery WHERE id=?");
        $stmt->execute([$id]);
        delete_upload($stmt->fetchColumn(), 'gallery');
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        redirect_with_message('gallery.php', 'success', 'Đã xoá ảnh.');
    }
}

$items = $pdo->query("SELECT * FROM gallery ORDER BY display_order ASC, id DESC")->fetchAll();
include __DIR__ . '/includes/admin_header.php';
?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card card-panel p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-cloud-upload me-2"></i>Thêm ảnh mới</h6>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="save">
                <div class="mb-3">
                    <label class="form-label fw-bold">Chọn ảnh *</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Chú thích</label>
                    <input type="text" name="caption" class="form-control" placeholder="VD: Giờ ra chơi">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Thứ tự hiển thị</label>
                    <input type="number" name="display_order" class="form-control" value="0">
                </div>
                <button type="submit" class="btn btn-primary-playful w-100"><i class="bi bi-upload me-1"></i> Tải lên</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row g-3">
            <?php foreach ($items as $item): ?>
            <div class="col-md-4 col-6">
                <div class="card card-panel overflow-hidden h-100">
                    <img src="<?= e(upload_url($item['image'], 'gallery')) ?>" style="height:150px;object-fit:cover;">
                    <div class="p-2">
                        <div class="small text-truncate fw-bold"><?= e($item['caption'] ?: '(Không có chú thích)') ?></div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <form method="POST">
                                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                <input type="hidden" name="action" value="toggle">
                                <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                <button class="btn btn-sm <?= $item['status'] ? 'btn-outline-success' : 'btn-outline-secondary' ?>">
                                    <?= $item['status'] ? 'Đang hiện' : 'Đang ẩn' ?>
                                </button>
                            </form>
                            <form method="POST" onsubmit="return confirm('Xoá ảnh này?');">
                                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($items)): ?>
                <p class="text-secondary text-center py-4">Chưa có ảnh nào trong thư viện.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
