<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Tin nhắn liên hệ';
require_admin_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        redirect_with_message('messages.php', 'danger', 'Phiên làm việc hết hạn.');
    }
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);

    if ($action === 'mark_read') {
        $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?")->execute([$id]);
        redirect_with_message('messages.php', 'success', 'Đã đánh dấu đã đọc.');
    }
    if ($action === 'delete') {
        $pdo->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([$id]);
        redirect_with_message('messages.php', 'success', 'Đã xoá tin nhắn.');
    }
}

$items = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
include __DIR__ . '/includes/admin_header.php';
?>

<div class="card card-panel p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Phụ huynh</th><th>Điện thoại</th><th>Email</th><th>Lời nhắn</th><th>Thời gian</th><th>Trạng thái</th><th class="text-end">Thao tác</th></tr></thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr class="<?= $item['is_read'] ? '' : 'fw-bold' ?>">
                    <td><?= e($item['name']) ?></td>
                    <td><?= e($item['phone']) ?></td>
                    <td><?= e($item['email']) ?></td>
                    <td class="fw-normal small" style="max-width:260px;"><?= nl2br(e($item['message'])) ?></td>
                    <td class="small fw-normal"><?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></td>
                    <td>
                        <?php if ($item['is_read']): ?>
                            <span class="badge bg-secondary-subtle text-secondary">Đã đọc</span>
                        <?php else: ?>
                            <span class="badge badge-soft">Mới</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <?php if (!$item['is_read']): ?>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="mark_read">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button class="btn btn-sm btn-outline-success"><i class="bi bi-check-lg"></i></button>
                        </form>
                        <?php endif; ?>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Xoá tin nhắn này?');">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($items)): ?>
                <tr><td colspan="7" class="text-center text-secondary py-4">Chưa có tin nhắn nào.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
