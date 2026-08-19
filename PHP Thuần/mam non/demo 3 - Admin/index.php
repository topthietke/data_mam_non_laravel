<?php
try {
    require_once __DIR__ . '/includes/functions.php';
    $settings = get_settings($pdo);
    $programs = $pdo->query("SELECT * FROM programs WHERE status = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
    $teachers = $pdo->query("SELECT * FROM teachers WHERE status = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
    $gallery  = $pdo->query("SELECT * FROM gallery WHERE status = 1 ORDER BY display_order ASC, id DESC LIMIT 8")->fetchAll();
    $testimonials = $pdo->query("SELECT * FROM testimonials WHERE status = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
    $news = $pdo->query("SELECT * FROM news WHERE status = 1 ORDER BY created_at DESC LIMIT 3")->fetchAll();

    $flash = get_flash();
    include __DIR__ . '/includes/header.php';
    } catch (\Throwable $th) {
       die('Lỗi: ' . $th->getMessage());
    }

?>

<!-- ===== HERO ===== -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-content">
                <span class="section-tag"><i class="bi bi-stars me-1"></i> Trường mầm non uy tín</span>
                <h1 class="hero-title"><?= nl2br(e(setting($settings, 'hero_title', 'Chào mừng bé đến với ngôi nhà thứ hai'))) ?></h1>
                <p class="hero-subtitle"><?= nl2br(e(setting($settings, 'hero_subtitle', ''))) ?></p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#contact" class="btn btn-playful btn-yellow btn-lg">
                        <i class="bi bi-send me-1"></i> <?= e(setting($settings, 'hero_button_text', 'Đăng ký tư vấn')) ?>
                    </a>
                    <a href="#about" class="btn btn-outline-playful btn-lg">Tìm hiểu thêm</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="hero-image-wrap">
                        <?php $heroImg = upload_url(setting($settings, 'hero_image'), 'settings'); ?>
                        <img src="<?= $heroImg ?: 'https://images.unsplash.com/photo-1587616211892-b8482ef9d2a4?q=80&w=900&auto=format&fit=crop' ?>" alt="Trẻ em vui chơi">
                    </div>
                    <div class="hero-badge" style="top:10px; right:-10px;">
                        <i class="bi bi-emoji-smile"></i>
                        <div>
                            <div class="fw-bold"><?= e(setting($settings, 'stat_students', '500+')) ?></div>
                            <small>Học sinh</small>
                        </div>
                    </div>
                    <div class="hero-badge" style="bottom:10px; left:-20px;">
                        <i class="bi bi-award"></i>
                        <div>
                            <div class="fw-bold"><?= e(setting($settings, 'stat_years', '10+')) ?> năm</div>
                            <small>Kinh nghiệm</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS BAR ===== -->
<div class="stats-bar">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3 stat-item">
                <div class="num"><?= e(setting($settings, 'stat_students', '500+')) ?></div>
                <div class="label">Học sinh</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="num"><?= e(setting($settings, 'stat_teachers', '40+')) ?></div>
                <div class="label">Giáo viên</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="num"><?= e(setting($settings, 'stat_years', '10+')) ?></div>
                <div class="label">Năm hoạt động</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="num"><?= e(setting($settings, 'stat_awards', '15+')) ?></div>
                <div class="label">Giải thưởng</div>
            </div>
        </div>
    </div>
</div>

<!-- ===== ABOUT ===== -->
<section class="section-padding" id="about">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 aos-fade">
                <div class="about-image-wrap">
                    <?php $aboutImg = upload_url(setting($settings, 'about_image'), 'settings'); ?>
                    <img src="<?= $aboutImg ?: 'https://images.unsplash.com/photo-1526634332515-d56c5fd16991?q=80&w=900&auto=format&fit=crop' ?>" alt="Giới thiệu trường">
                </div>
            </div>
            <div class="col-lg-6 aos-fade">
                <span class="section-tag">Về chúng tôi</span>
                <h2 class="section-title mb-3"><?= e(setting($settings, 'about_title', 'Về chúng tôi')) ?></h2>
                <p class="text-secondary mb-4"><?= nl2br(e(setting($settings, 'about_content', ''))) ?></p>
                <ul class="list-unstyled about-feature-list">
                    <li>
                        <span class="icon-circle"><i class="bi bi-check-lg"></i></span>
                        <div><strong>Giáo trình chuẩn quốc tế</strong><br><span class="text-secondary">Kết hợp phương pháp giáo dục hiện đại và truyền thống.</span></div>
                    </li>
                    <li>
                        <span class="icon-circle"><i class="bi bi-check-lg"></i></span>
                        <div><strong>Đội ngũ giáo viên tận tâm</strong><br><span class="text-secondary">Giàu kinh nghiệm, yêu thương và thấu hiểu trẻ nhỏ.</span></div>
                    </li>
                    <li>
                        <span class="icon-circle"><i class="bi bi-check-lg"></i></span>
                        <div><strong>Môi trường an toàn</strong><br><span class="text-secondary">Cơ sở vật chất đạt chuẩn, camera giám sát 24/7.</span></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ===== PROGRAMS ===== -->
<section class="section-padding" id="programs" style="background:#fff;">
    <div class="container text-center">
        <span class="section-tag">Chương trình học</span>
        <h2 class="section-title mb-3">Các lớp học theo độ tuổi</h2>
        <p class="section-subtitle mb-5">Chương trình được thiết kế phù hợp với từng giai đoạn phát triển của trẻ, giúp bé phát triển toàn diện cả thể chất lẫn trí tuệ.</p>
        <div class="row g-4">
            <?php foreach ($programs as $p): ?>
            <div class="col-md-6 col-lg-3 aos-fade">
                <div class="program-card">
                    <div class="program-icon"><i class="bi <?= e($p['icon'] ?: 'bi-stars') ?>"></i></div>
                    <?php if (!empty($p['age_range'])): ?>
                        <span class="program-age"><?= e($p['age_range']) ?></span>
                    <?php endif; ?>
                    <h4 class="mb-2"><?= e($p['title']) ?></h4>
                    <p class="text-secondary mb-0"><?= nl2br(e($p['description'])) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($programs)): ?>
                <p class="text-secondary">Chưa có chương trình học nào được cập nhật.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ===== GALLERY ===== -->
<section class="section-padding gallery-section" id="gallery">
    <div class="container text-center">
        <span class="section-tag">Khoảnh khắc đáng yêu</span>
        <h2 class="section-title mb-3">Hoạt động tại trường</h2>
        <p class="section-subtitle mb-5">Những khoảnh khắc vui chơi, học tập và trải nghiệm hàng ngày của các bé.</p>
        <div class="row g-3">
            <?php if (!empty($gallery)): foreach ($gallery as $g): ?>
            <div class="col-6 col-md-3 aos-fade">
                <div class="gallery-item">
                    <img src="<?= e(upload_url($g['image'], 'gallery')) ?>" alt="<?= e($g['caption']) ?>">
                    <?php if (!empty($g['caption'])): ?>
                        <div class="gallery-caption"><?= e($g['caption']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; else: ?>
                <?php
                $placeholders = [
                    'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=500&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1544776193-352d25ca82cd?q=80&w=500&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1587654780291-39c9404d746b?q=80&w=500&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1541692641319-981cc79ee10a?q=80&w=500&auto=format&fit=crop',
                ];
                foreach ($placeholders as $img): ?>
                <div class="col-6 col-md-3 aos-fade">
                    <div class="gallery-item"><img src="<?= $img ?>" alt="Hoạt động"></div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ===== TEACHERS ===== -->
<section class="section-padding" id="teachers">
    <div class="container text-center">
        <span class="section-tag">Đội ngũ của chúng tôi</span>
        <h2 class="section-title mb-3">Giáo viên tận tâm - giàu kinh nghiệm</h2>
        <p class="section-subtitle mb-5">Mỗi giáo viên đều được đào tạo bài bản về nghiệp vụ sư phạm mầm non và tâm lý trẻ em.</p>
        <div class="row g-4">
            <?php foreach ($teachers as $t): ?>
            <div class="col-md-6 col-lg-4 aos-fade">
                <div class="teacher-card">
                    <img src="<?= e(upload_url($t['image'], 'teachers', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=500&auto=format&fit=crop')) ?>" alt="<?= e($t['name']) ?>">
                    <div class="teacher-body">
                        <h5 class="mb-1"><?= e($t['name']) ?></h5>
                        <div class="teacher-position mb-2"><?= e($t['position']) ?></div>
                        <p class="text-secondary small mb-0"><?= nl2br(e($t['description'])) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="section-padding testimonial-section">
    <div class="container text-center">
        <span class="section-tag">Phụ huynh nói gì</span>
        <h2 class="section-title mb-5">Cảm nhận từ phụ huynh</h2>
        <div class="row g-4">
            <?php foreach ($testimonials as $ts): ?>
            <div class="col-md-6 col-lg-4 aos-fade">
                <div class="testimonial-card text-start">
                    <i class="bi bi-quote quote-icon"></i>
                    <p class="text-secondary my-3"><?= nl2br(e($ts['content'])) ?></p>
                    <div class="testimonial-stars mb-3">
                        <?php for ($i = 0; $i < (int)$ts['rating']; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <img class="testimonial-avatar" src="<?= e(upload_url($ts['avatar'], 'settings', 'https://ui-avatars.com/api/?background=FFC93C&color=7a4a00&name=' . urlencode($ts['parent_name']))) ?>" alt="<?= e($ts['parent_name']) ?>">
                        <div>
                            <div class="fw-bold"><?= e($ts['parent_name']) ?></div>
                            <small class="text-secondary"><?= e($ts['child_name']) ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== NEWS ===== -->
<?php if (!empty($news)): ?>
<section class="section-padding" id="news">
    <div class="container text-center">
        <span class="section-tag">Tin tức - Sự kiện</span>
        <h2 class="section-title mb-5">Hoạt động &amp; tin tức mới nhất</h2>
        <div class="row g-4">
            <?php foreach ($news as $n): ?>
            <div class="col-md-4 aos-fade">
                <div class="news-card text-start">
                    <img src="<?= e(upload_url($n['image'], 'news', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=500&auto=format&fit=crop')) ?>" alt="<?= e($n['title']) ?>">
                    <div class="news-body">
                        <div class="news-date"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($n['created_at'])) ?></div>
                        <h5 class="my-2"><?= e($n['title']) ?></h5>
                        <p class="text-secondary small"><?= e($n['summary']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== CONTACT ===== -->
<section class="section-padding contact-section" id="contact" style="background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">Liên hệ</span>
            <h2 class="section-title mb-3">Đăng ký tư vấn miễn phí</h2>
            <p class="section-subtitle">Để lại thông tin, nhà trường sẽ liên hệ tư vấn cho quý phụ huynh trong thời gian sớm nhất.</p>
        </div>
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="contact-info-item">
                    <span class="icon-circle"><i class="bi bi-geo-alt-fill"></i></span>
                    <div><strong>Địa chỉ</strong><p class="text-secondary mb-0"><?= e(setting($settings, 'address', '')) ?></p></div>
                </div>
                <div class="contact-info-item">
                    <span class="icon-circle"><i class="bi bi-telephone-fill"></i></span>
                    <div><strong>Hotline</strong><p class="text-secondary mb-0"><?= e(setting($settings, 'hotline', '')) ?></p></div>
                </div>
                <div class="contact-info-item">
                    <span class="icon-circle"><i class="bi bi-envelope-fill"></i></span>
                    <div><strong>Email</strong><p class="text-secondary mb-0"><?= e(setting($settings, 'email', '')) ?></p></div>
                </div>
                <div class="map-wrap mt-4"><?= setting($settings, 'map_iframe', '') ?></div>
            </div>
            <div class="col-lg-7">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm">
                    <div id="contactAlert" class="alert d-none" role="alert"></div>
                    <form id="contactForm" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Họ và tên phụ huynh *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại *</label>
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Lời nhắn</label>
                                <textarea class="form-control" name="message" rows="4" placeholder="Cho chúng tôi biết độ tuổi của bé và điều bạn quan tâm..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-playful btn-pink btn-lg w-100">
                                    <i class="bi bi-send me-1"></i> Gửi đăng ký
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
