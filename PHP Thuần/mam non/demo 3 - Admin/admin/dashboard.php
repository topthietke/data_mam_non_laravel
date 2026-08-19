<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Tổng quan';

$counts = [
    'programs'     => (int) $pdo->query("SELECT COUNT(*) FROM programs")->fetchColumn(),
    'teachers'     => (int) $pdo->query("SELECT COUNT(*) FROM teachers")->fetchColumn(),
    'gallery'      => (int) $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn(),
    'testimonials' => (int) $pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn(),
    'news'         => (int) $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn(),
    'messages'     => (int) $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn(),
    'unread'       => (int) $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn(),
];
$recentMessages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5")->fetchAll();

include __DIR__ . '/includes/admin_header.php';
?>

<div class="row g-4 mb-4">
    <?php
    $cards = [
        ['label' => 'Chương trình học', 'value' => $counts['programs'], 'icon' => 'bi-mortarboard-fill', 'color' => '#FF6F91', 'link' => 'programs.php'],
        ['label' => 'Giáo viên', 'value' => $counts['teachers'], 'icon' => 'bi-people-fill', 'color' => '#4FC1E9', 'link' => 'teachers.php'],
        ['label' => 'Ảnh hoạt động', 'value' => $counts['gallery'], 'icon' => 'bi-images', 'color' => '#7BC950', 'link' => 'gallery.php'],
        ['label' => 'Tin nhắn chưa đọc', 'value' => $counts['unread'], 'icon' => 'bi-envelope-fill', 'color' => '#FFC93C', 'link' => 'messages.php'],
    ];
    foreach ($cards as $c): ?>
    <div class="col-sm-6 col-lg-3">
        <a href="<?= $c['link'] ?>" class="text-decoration-none">
            <div class="card card-panel p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:54px;height:54px;border-radius:16px;background:<?= $c['color'] ?>22;color:<?= $c['color'] ?>;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                        <i class="bi <?= $c['icon'] ?>"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark"><?= $c['value'] ?></div>
                        <div class="text-secondary small"><?= e($c['label']) ?></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<div class="card card-panel p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-envelope-open me-2"></i>Đăng ký / tin nhắn mới nhất</h6>
        <a href="messages.php" class="small">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>
    <?php if (empty($recentMessages)): ?>
        <p class="text-secondary mb-0">Chưa có tin nhắn nào.</p>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Phụ huynh</th><th>Điện thoại</th><th>Lời nhắn</th><th>Thời gian</th><th>Trạng thái</th></tr></thead>
            <tbody>
            <?php foreach ($recentMessages as $m): ?>
                <tr>
                    <td class="fw-bold"><?= e($m['name']) ?></td>
                    <td><?= e($m['phone']) ?></td>
                    <td class="text-truncate" style="max-width:280px;"><?= e($m['message']) ?></td>
                    <td class="small text-secondary"><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                    <td>
                        <?php if ($m['is_read']): ?>
                            <span class="badge bg-secondary-subtle text-secondary">Đã đọc</span>
                        <?php else: ?>
                            <span class="badge badge-soft">Mới</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
