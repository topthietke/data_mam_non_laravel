<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Cài đặt chung';
require_admin_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        redirect_with_message('settings.php', 'danger', 'Phiên làm việc hết hạn, vui lòng thử lại.');
    }

    $fields = [
        'site_name', 'site_slogan', 'hotline', 'email', 'address',
        'fanpage_url', 'youtube_url', 'zalo_url', 'map_iframe',
        'hero_title', 'hero_subtitle', 'hero_button_text',
        'about_title', 'about_content',
        'stat_students', 'stat_teachers', 'stat_years', 'stat_awards',
        'footer_description',
    ];

    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
                            ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    foreach ($fields as $field) {
        $stmt->execute([$field, trim($_POST[$field] ?? '')]);
    }

    // Xử lý upload ảnh (logo, hero, about)
    $imageFields = ['logo' => 'logo', 'hero_image' => 'hero_image', 'about_image' => 'about_image'];
    foreach ($imageFields as $inputName => $settingKey) {
        $uploaded = handle_upload($inputName, 'settings');
        if ($uploaded) {
            $stmt->execute([$settingKey, $uploaded]);
        }
    }

    redirect_with_message('settings.php', 'success', 'Đã lưu cài đặt thành công!');
}

$settings = get_settings($pdo);
include __DIR__ . '/includes/admin_header.php';
?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

    <div class="card card-panel p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-building me-2"></i>Thông tin chung</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Tên trường</label>
                <input type="text" class="form-control" name="site_name" value="<?= e(setting($settings, 'site_name')) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Slogan</label>
                <input type="text" class="form-control" name="site_slogan" value="<?= e(setting($settings, 'site_slogan')) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Logo</label>
                <input type="file" class="form-control" name="logo" accept="image/*">
                <?php $logo = upload_url(setting($settings, 'logo'), 'settings'); ?>
                <?php if ($logo): ?><img src="<?= $logo ?>" class="thumb-preview mt-2"><?php endif; ?>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Hotline</label>
                <input type="text" class="form-control" name="hotline" value="<?= e(setting($settings, 'hotline')) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" name="email" value="<?= e(setting($settings, 'email')) ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Địa chỉ</label>
                <input type="text" class="form-control" name="address" value="<?= e(setting($settings, 'address')) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Link Fanpage</label>
                <input type="text" class="form-control" name="fanpage_url" value="<?= e(setting($settings, 'fanpage_url')) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Link Youtube</label>
                <input type="text" class="form-control" name="youtube_url" value="<?= e(setting($settings, 'youtube_url')) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Link Zalo</label>
                <input type="text" class="form-control" name="zalo_url" value="<?= e(setting($settings, 'zalo_url')) ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Mã nhúng Google Map (iframe)</label>
                <textarea class="form-control" name="map_iframe" rows="2"><?= e(setting($settings, 'map_iframe')) ?></textarea>
            </div>
        </div>
    </div>

    <div class="card card-panel p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-image me-2"></i>Banner trang chủ (Hero)</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Tiêu đề chính</label>
                <textarea class="form-control" name="hero_title" rows="2"><?= e(setting($settings, 'hero_title')) ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Mô tả phụ</label>
                <textarea class="form-control" name="hero_subtitle" rows="2"><?= e(setting($settings, 'hero_subtitle')) ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Chữ trên nút CTA</label>
                <input type="text" class="form-control" name="hero_button_text" value="<?= e(setting($settings, 'hero_button_text')) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Ảnh banner</label>
                <input type="file" class="form-control" name="hero_image" accept="image/*">
                <?php $heroImg = upload_url(setting($settings, 'hero_image'), 'settings'); ?>
                <?php if ($heroImg): ?><img src="<?= $heroImg ?>" class="thumb-preview mt-2"><?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card card-panel p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Phần giới thiệu &amp; thống kê</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Tiêu đề giới thiệu</label>
                <input type="text" class="form-control" name="about_title" value="<?= e(setting($settings, 'about_title')) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Ảnh giới thiệu</label>
                <input type="file" class="form-control" name="about_image" accept="image/*">
                <?php $aboutImg = upload_url(setting($settings, 'about_image'), 'settings'); ?>
                <?php if ($aboutImg): ?><img src="<?= $aboutImg ?>" class="thumb-preview mt-2"><?php endif; ?>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Nội dung giới thiệu</label>
                <textarea class="form-control" name="about_content" rows="4"><?= e(setting($settings, 'about_content')) ?></textarea>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label fw-bold">Số học sinh</label>
                <input type="text" class="form-control" name="stat_students" value="<?= e(setting($settings, 'stat_students')) ?>">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label fw-bold">Số giáo viên</label>
                <input type="text" class="form-control" name="stat_teachers" value="<?= e(setting($settings, 'stat_teachers')) ?>">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label fw-bold">Số năm hoạt động</label>
                <input type="text" class="form-control" name="stat_years" value="<?= e(setting($settings, 'stat_years')) ?>">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label fw-bold">Số giải thưởng</label>
                <input type="text" class="form-control" name="stat_awards" value="<?= e(setting($settings, 'stat_awards')) ?>">
            </div>
        </div>
    </div>

    <div class="card card-panel p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-layout-text-window me-2"></i>Footer</h6>
        <label class="form-label fw-bold">Mô tả ngắn ở chân trang</label>
        <textarea class="form-control" name="footer_description" rows="3"><?= e(setting($settings, 'footer_description')) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary-playful btn-lg px-5"><i class="bi bi-save me-1"></i> Lưu thay đổi</button>
</form>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
