<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Chương trình học';
require_admin_login();

// ==== Xử lý thêm / sửa / xoá ====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        redirect_with_message('programs.php', 'danger', 'Phiên làm việc hết hạn.');
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id          = (int)($_POST['id'] ?? 0);
        $title       = trim($_POST['title'] ?? '');
        $age_range   = trim($_POST['age_range'] ?? '');
        $icon        = trim($_POST['icon'] ?? 'bi-stars');
        $description = trim($_POST['description'] ?? '');
        $order       = (int)($_POST['display_order'] ?? 0);
        $status      = isset($_POST['status']) ? 1 : 0;

        if ($title === '') {
            redirect_with_message('programs.php', 'danger', 'Vui lòng nhập tiêu đề chương trình.');
        }

        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE programs SET title=?, age_range=?, icon=?, description=?, display_order=?, status=? WHERE id=?");
            $stmt->execute([$title, $age_range, $icon, $description, $order, $status, $id]);
            redirect_with_message('programs.php', 'success', 'Đã cập nhật chương trình học.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO programs (title, age_range, icon, description, display_order, status) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$title, $age_range, $icon, $description, $order, $status]);
            redirect_with_message('programs.php', 'success', 'Đã thêm chương trình học mới.');
        }
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare("DELETE FROM programs WHERE id = ?")->execute([$id]);
        redirect_with_message('programs.php', 'success', 'Đã xoá chương trình học.');
    }
}

$items = $pdo->query("SELECT * FROM programs ORDER BY display_order ASC, id DESC")->fetchAll();
include __DIR__ . '/includes/admin_header.php';

$iconOptions = ['bi-flower1', 'bi-tree', 'bi-flower3', 'bi-heart', 'bi-stars', 'bi-mortarboard-fill', 'bi-book-half', 'bi-palette-fill', 'bi-music-note-beamed', 'bi-puzzle-fill'];
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-secondary mb-0">Quản lý danh sách các lớp học / chương trình đào tạo hiển thị trên trang chủ.</p>
    <button class="btn btn-primary-playful" data-bs-toggle="modal" data-bs-target="#programModal" onclick="openCreate()">
        <i class="bi bi-plus-lg me-1"></i> Thêm chương trình
    </button>
</div>

<div class="card card-panel p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>#</th><th>Icon</th><th>Tiêu đề</th><th>Độ tuổi</th><th>Thứ tự</th><th>Trạng thái</th><th class="text-end">Thao tác</th></tr></thead>
            <tbody>
            <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><i class="bi <?= e($item['icon']) ?> fs-4 text-warning"></i></td>
                    <td class="fw-bold"><?= e($item['title']) ?></td>
                    <td><?= e($item['age_range']) ?></td>
                    <td><?= (int)$item['display_order'] ?></td>
                    <td><?= $item['status'] ? '<span class="badge bg-success-subtle text-success">Hiện</span>' : '<span class="badge bg-secondary-subtle text-secondary">Ẩn</span>' ?></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary" onclick='openEdit(<?= json_encode($item, JSON_UNESCAPED_UNICODE) ?>)'><i class="bi bi-pencil"></i></button>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Xoá chương trình này?');">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($items)): ?>
                <tr><td colspan="7" class="text-center text-secondary py-4">Chưa có chương trình học nào.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal thêm / sửa -->
<div class="modal fade" id="programModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id" id="f_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Thêm chương trình học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề *</label>
                        <input type="text" name="title" id="f_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Độ tuổi</label>
                        <input type="text" name="age_range" id="f_age_range" class="form-control" placeholder="VD: 3 - 4 tuổi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon</label>
                        <select name="icon" id="f_icon" class="form-select">
                            <?php foreach ($iconOptions as $ic): ?>
                                <option value="<?= $ic ?>"><?= $ic ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
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
    document.getElementById('modalTitle').textContent = 'Thêm chương trình học';
    document.getElementById('f_id').value = '';
    document.getElementById('f_title').value = '';
    document.getElementById('f_age_range').value = '';
    document.getElementById('f_icon').value = 'bi-stars';
    document.getElementById('f_description').value = '';
    document.getElementById('f_display_order').value = 0;
    document.getElementById('f_status').checked = true;
}
function openEdit(item) {
    document.getElementById('modalTitle').textContent = 'Sửa chương trình học';
    document.getElementById('f_id').value = item.id;
    document.getElementById('f_title').value = item.title;
    document.getElementById('f_age_range').value = item.age_range;
    document.getElementById('f_icon').value = item.icon;
    document.getElementById('f_description').value = item.description;
    document.getElementById('f_display_order').value = item.display_order;
    document.getElementById('f_status').checked = item.status == 1;
    new bootstrap.Modal(document.getElementById('programModal')).show();
}
</script>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
