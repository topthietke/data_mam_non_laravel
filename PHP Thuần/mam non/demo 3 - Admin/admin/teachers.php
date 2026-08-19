<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Đội ngũ giáo viên';
require_admin_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        redirect_with_message('teachers.php', 'danger', 'Phiên làm việc hết hạn.');
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id          = (int)($_POST['id'] ?? 0);
        $name        = trim($_POST['name'] ?? '');
        $position    = trim($_POST['position'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $order       = (int)($_POST['display_order'] ?? 0);
        $status      = isset($_POST['status']) ? 1 : 0;

        if ($name === '') {
            redirect_with_message('teachers.php', 'danger', 'Vui lòng nhập tên giáo viên.');
        }

        $uploaded = handle_upload('image', 'teachers');

        if ($id > 0) {
            if ($uploaded) {
                $old = $pdo->prepare("SELECT image FROM teachers WHERE id=?");
                $old->execute([$id]);
                delete_upload($old->fetchColumn(), 'teachers');
                $stmt = $pdo->prepare("UPDATE teachers SET name=?, position=?, image=?, description=?, display_order=?, status=? WHERE id=?");
                $stmt->execute([$name, $position, $uploaded, $description, $order, $status, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE teachers SET name=?, position=?, description=?, display_order=?, status=? WHERE id=?");
                $stmt->execute([$name, $position, $description, $order, $status, $id]);
            }
            redirect_with_message('teachers.php', 'success', 'Đã cập nhật thông tin giáo viên.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO teachers (name, position, image, description, display_order, status) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$name, $position, $uploaded, $description, $order, $status]);
            redirect_with_message('teachers.php', 'success', 'Đã thêm giáo viên mới.');
        }
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("SELECT image FROM teachers WHERE id=?");
        $stmt->execute([$id]);
        delete_upload($stmt->fetchColumn(), 'teachers');
        $pdo->prepare("DELETE FROM teachers WHERE id = ?")->execute([$id]);
        redirect_with_message('teachers.php', 'success', 'Đã xoá giáo viên.');
    }
}

$items = $pdo->query("SELECT * FROM teachers ORDER BY display_order ASC, id DESC")->fetchAll();
include __DIR__ . '/includes/admin_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-secondary mb-0">Quản lý danh sách đội ngũ giáo viên hiển thị trên trang chủ.</p>
    <button class="btn btn-primary-playful" data-bs-toggle="modal" data-bs-target="#teacherModal" onclick="openCreate()">
        <i class="bi bi-plus-lg me-1"></i> Thêm giáo viên
    </button>
</div>

<div class="card card-panel p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Ảnh</th><th>Họ tên</th><th>Chức vụ</th><th>Thứ tự</th><th>Trạng thái</th><th class="text-end">Thao tác</th></tr></thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><img src="<?= e(upload_url($item['image'], 'teachers', 'https://ui-avatars.com/api/?background=FFC93C&color=7a4a00&name=' . urlencode($item['name']))) ?>" class="thumb-preview"></td>
                    <td class="fw-bold"><?= e($item['name']) ?></td>
                    <td><?= e($item['position']) ?></td>
                    <td><?= (int)$item['display_order'] ?></td>
                    <td><?= $item['status'] ? '<span class="badge bg-success-subtle text-success">Hiện</span>' : '<span class="badge bg-secondary-subtle text-secondary">Ẩn</span>' ?></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary" onclick='openEdit(<?= json_encode($item, JSON_UNESCAPED_UNICODE) ?>)'><i class="bi bi-pencil"></i></button>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Xoá giáo viên này?');">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($items)): ?>
                <tr><td colspan="6" class="text-center text-secondary py-4">Chưa có giáo viên nào.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="teacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id" id="f_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Thêm giáo viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Họ tên *</label>
                        <input type="text" name="name" id="f_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chức vụ</label>
                        <input type="text" name="position" id="f_position" class="form-control" placeholder="VD: Giáo viên chủ nhiệm lớp Lá">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ảnh đại diện</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả ngắn</label>
                        <textarea name="description" id="f_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Thứ tự hiển thị</label>
                            <input type="number" name="display_order" id="f_display_order" class="form-control" value="0">
                        </div>
                        <div class="col-6 d-flex align-items-end">
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
    document.getElementById('modalTitle').textContent = 'Thêm giáo viên';
    document.getElementById('f_id').value = '';
    document.getElementById('f_name').value = '';
    document.getElementById('f_position').value = '';
    document.getElementById('f_description').value = '';
    document.getElementById('f_display_order').value = 0;
    document.getElementById('f_status').checked = true;
}
function openEdit(item) {
    document.getElementById('modalTitle').textContent = 'Sửa thông tin giáo viên';
    document.getElementById('f_id').value = item.id;
    document.getElementById('f_name').value = item.name;
    document.getElementById('f_position').value = item.position;
    document.getElementById('f_description').value = item.description;
    document.getElementById('f_display_order').value = item.display_order;
    document.getElementById('f_status').checked = item.status == 1;
    new bootstrap.Modal(document.getElementById('teacherModal')).show();
}
</script>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
