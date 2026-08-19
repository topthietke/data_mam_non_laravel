<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Tin tức';
require_admin_login();

function make_slug(string $str): string
{
    $str = strtolower(trim($str));
    $str = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $str);
    $str = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $str);
    $str = preg_replace('/[íìỉĩị]/u', 'i', $str);
    $str = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $str);
    $str = preg_replace('/[úùủũụưứừửữự]/u', 'u', $str);
    $str = preg_replace('/[ýỳỷỹỵ]/u', 'y', $str);
    $str = preg_replace('/đ/u', 'd', $str);
    $str = preg_replace('/[^a-z0-9\s-]/', '', $str);
    $str = preg_replace('/[\s-]+/', '-', $str);
    return trim($str, '-') ?: 'tin-tuc';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        redirect_with_message('news.php', 'danger', 'Phiên làm việc hết hạn.');
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id      = (int)($_POST['id'] ?? 0);
        $title   = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $status  = isset($_POST['status']) ? 1 : 0;

        if ($title === '') {
            redirect_with_message('news.php', 'danger', 'Vui lòng nhập tiêu đề bài viết.');
        }
        $slug = make_slug($title);
        $uploaded = handle_upload('image', 'news');

        if ($id > 0) {
            if ($uploaded) {
                $old = $pdo->prepare("SELECT image FROM news WHERE id=?");
                $old->execute([$id]);
                delete_upload($old->fetchColumn(), 'news');
                $stmt = $pdo->prepare("UPDATE news SET title=?, slug=?, summary=?, content=?, image=?, status=? WHERE id=?");
                $stmt->execute([$title, $slug, $summary, $content, $uploaded, $status, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE news SET title=?, slug=?, summary=?, content=?, status=? WHERE id=?");
                $stmt->execute([$title, $slug, $summary, $content, $status, $id]);
            }
            redirect_with_message('news.php', 'success', 'Đã cập nhật bài viết.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO news (title, slug, summary, content, image, status) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$title, $slug, $summary, $content, $uploaded, $status]);
            redirect_with_message('news.php', 'success', 'Đã đăng bài viết mới.');
        }
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("SELECT image FROM news WHERE id=?");
        $stmt->execute([$id]);
        delete_upload($stmt->fetchColumn(), 'news');
        $pdo->prepare("DELETE FROM news WHERE id = ?")->execute([$id]);
        redirect_with_message('news.php', 'success', 'Đã xoá bài viết.');
    }
}

$items = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
include __DIR__ . '/includes/admin_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-secondary mb-0">Quản lý tin tức, hoạt động và sự kiện của trường.</p>
    <button class="btn btn-primary-playful" data-bs-toggle="modal" data-bs-target="#newsModal" onclick="openCreate()">
        <i class="bi bi-plus-lg me-1"></i> Đăng bài mới
    </button>
</div>

<div class="card card-panel p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Ảnh</th><th>Tiêu đề</th><th>Tóm tắt</th><th>Ngày đăng</th><th>Trạng thái</th><th class="text-end">Thao tác</th></tr></thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><img src="<?= e(upload_url($item['image'], 'news', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=200&auto=format&fit=crop')) ?>" class="thumb-preview"></td>
                    <td class="fw-bold"><?= e($item['title']) ?></td>
                    <td class="text-truncate small text-secondary" style="max-width:220px;"><?= e($item['summary']) ?></td>
                    <td class="small"><?= date('d/m/Y', strtotime($item['created_at'])) ?></td>
                    <td><?= $item['status'] ? '<span class="badge bg-success-subtle text-success">Hiện</span>' : '<span class="badge bg-secondary-subtle text-secondary">Ẩn</span>' ?></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary" onclick='openEdit(<?= json_encode($item, JSON_UNESCAPED_UNICODE) ?>)'><i class="bi bi-pencil"></i></button>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Xoá bài viết này?');">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($items)): ?>
                <tr><td colspan="6" class="text-center text-secondary py-4">Chưa có bài viết nào.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="newsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id" id="f_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Đăng bài mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề *</label>
                        <input type="text" name="title" id="f_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ảnh đại diện</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tóm tắt</label>
                        <textarea name="summary" id="f_summary" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội dung chi tiết</label>
                        <textarea name="content" id="f_content" class="form-control" rows="6"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status" id="f_status" checked>
                        <label class="form-check-label fw-bold" for="f_status">Hiển thị trên trang chủ</label>
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
    document.getElementById('modalTitle').textContent = 'Đăng bài mới';
    document.getElementById('f_id').value = '';
    document.getElementById('f_title').value = '';
    document.getElementById('f_summary').value = '';
    document.getElementById('f_content').value = '';
    document.getElementById('f_status').checked = true;
}
function openEdit(item) {
    document.getElementById('modalTitle').textContent = 'Sửa bài viết';
    document.getElementById('f_id').value = item.id;
    document.getElementById('f_title').value = item.title;
    document.getElementById('f_summary').value = item.summary;
    document.getElementById('f_content').value = item.content;
    document.getElementById('f_status').checked = item.status == 1;
    new bootstrap.Modal(document.getElementById('newsModal')).show();
}
</script>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
