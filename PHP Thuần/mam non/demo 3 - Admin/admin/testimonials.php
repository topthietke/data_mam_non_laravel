<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Cảm nhận phụ huynh';
require_admin_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        redirect_with_message('testimonials.php', 'danger', 'Phiên làm việc hết hạn.');
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id          = (int)($_POST['id'] ?? 0);
        $parent_name = trim($_POST['parent_name'] ?? '');
        $child_name  = trim($_POST['child_name'] ?? '');
        $content     = trim($_POST['content'] ?? '');
        $rating      = max(1, min(5, (int)($_POST['rating'] ?? 5)));
        $order       = (int)($_POST['display_order'] ?? 0);
        $status      = isset($_POST['status']) ? 1 : 0;

        if ($parent_name === '' || $content === '') {
            redirect_with_message('testimonials.php', 'danger', 'Vui lòng nhập tên phụ huynh và nội dung cảm nhận.');
        }

        $uploaded = handle_upload('avatar', 'settings');

        if ($id > 0) {
            if ($uploaded) {
                $stmt = $pdo->prepare("UPDATE testimonials SET parent_name=?, child_name=?, avatar=?, content=?, rating=?, display_order=?, status=? WHERE id=?");
                $stmt->execute([$parent_name, $child_name, $uploaded, $content, $rating, $order, $status, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE testimonials SET parent_name=?, child_name=?, content=?, rating=?, display_order=?, status=? WHERE id=?");
                $stmt->execute([$parent_name, $child_name, $content, $rating, $order, $status, $id]);
            }
            redirect_with_message('testimonials.php', 'success', 'Đã cập nhật cảm nhận.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO testimonials (parent_name, child_name, avatar, content, rating, display_order, status) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$parent_name, $child_name, $uploaded, $content, $rating, $order, $status]);
            redirect_with_message('testimonials.php', 'success', 'Đã thêm cảm nhận mới.');
        }
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare("DELETE FROM testimonials WHERE id = ?")->execute([$id]);
        redirect_with_message('testimonials.php', 'success', 'Đã xoá cảm nhận.');
    }
}

$items = $pdo->query("SELECT * FROM testimonials ORDER BY display_order ASC, id DESC")->fetchAll();
include __DIR__ . '/includes/admin_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-secondary mb-0">Quản lý các cảm nhận / đánh giá của phụ huynh hiển thị trên trang chủ.</p>
    <button class="btn btn-primary-playful" data-bs-toggle="modal" data-bs-target="#tsModal" onclick="openCreate()">
        <i class="bi bi-plus-lg me-1"></i> Thêm cảm nhận
    </button>
</div>

<div class="row g-3">
    <?php foreach ($items as $item): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card card-panel p-3 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
                <img src="<?= e(upload_url($item['avatar'], 'settings', 'https://ui-avatars.com/api/?background=FFC93C&color=7a4a00&name=' . urlencode($item['parent_name']))) ?>" class="thumb-preview">
                <div>
                    <div class="fw-bold"><?= e($item['parent_name']) ?></div>
                    <small class="text-secondary"><?= e($item['child_name']) ?></small>
                </div>
            </div>
            <p class="small text-secondary" style="min-height:60px;"><?= e($item['content']) ?></p>
            <div class="text-warning mb-2"><?php for ($i=0;$i<(int)$item['rating'];$i++) echo '<i class="bi bi-star-fill"></i>'; ?></div>
            <div class="d-flex justify-content-between align-items-center">
                <?= $item['status'] ? '<span class="badge bg-success-subtle text-success">Hiện</span>' : '<span class="badge bg-secondary-subtle text-secondary">Ẩn</span>' ?>
                <div>
                    <button class="btn btn-sm btn-outline-secondary" onclick='openEdit(<?= json_encode($item, JSON_UNESCAPED_UNICODE) ?>)'><i class="bi bi-pencil"></i></button>
                    <form method="POST" class="d-inline" onsubmit="return confirm('Xoá cảm nhận này?');">
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
        <p class="text-secondary text-center py-4">Chưa có cảm nhận nào.</p>
    <?php endif; ?>
</div>

<div class="modal fade" id="tsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id" id="f_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Thêm cảm nhận</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tên phụ huynh *</label>
                            <input type="text" name="parent_name" id="f_parent_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tên bé / mối quan hệ</label>
                            <input type="text" name="child_name" id="f_child_name" class="form-control" placeholder="VD: phụ huynh bé Bin">
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label fw-bold">Ảnh đại diện</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội dung cảm nhận *</label>
                        <textarea name="content" id="f_content" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-4">
                            <label class="form-label fw-bold">Số sao</label>
                            <select name="rating" id="f_rating" class="form-select">
                                <option value="5">5 sao</option>
                                <option value="4">4 sao</option>
                                <option value="3">3 sao</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-bold">Thứ tự</label>
                            <input type="number" name="display_order" id="f_display_order" class="form-control" value="0">
                        </div>
                        <div class="col-4 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" id="f_status" checked>
                                <label class="form-check-label fw-bold" for="f_status">Hiển thị</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary-playful">Lưu lại</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreate() {
    document.getElementById('modalTitle').textContent = 'Thêm cảm nhận';
    document.getElementById('f_id').value = '';
    document.getElementById('f_parent_name').value = '';
    document.getElementById('f_child_name').value = '';
    document.getElementById('f_content').value = '';
    document.getElementById('f_rating').value = '5';
    document.getElementById('f_display_order').value = 0;
    document.getElementById('f_status').checked = true;
}
function openEdit(item) {
    document.getElementById('modalTitle').textContent = 'Sửa cảm nhận';
    document.getElementById('f_id').value = item.id;
    document.getElementById('f_parent_name').value = item.parent_name;
    document.getElementById('f_child_name').value = item.child_name;
    document.getElementById('f_content').value = item.content;
    document.getElementById('f_rating').value = item.rating;
    document.getElementById('f_display_order').value = item.display_order;
    document.getElementById('f_status').checked = item.status == 1;
    new bootstrap.Modal(document.getElementById('tsModal')).show();
}
</script>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
