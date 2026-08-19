<!-- ===== FOOTER ===== -->
<footer class="footer-mamnon">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5><i class="bi bi-flower1 me-2"></i><?= e(setting($settings, 'site_name', 'Mầm Non')) ?></h5>
                <p><?= e(setting($settings, 'footer_description', '')) ?></p>
                <div class="footer-social mt-3">
                    <a href="<?= e(setting($settings, 'fanpage_url', '#')) ?>"><i class="bi bi-facebook"></i></a>
                    <a href="<?= e(setting($settings, 'youtube_url', '#')) ?>"><i class="bi bi-youtube"></i></a>
                    <a href="<?= e(setting($settings, 'zalo_url', '#')) ?>"><i class="bi bi-chat-dots"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h5>Liên kết</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#about">Giới thiệu</a></li>
                    <li class="mb-2"><a href="#programs">Chương trình học</a></li>
                    <li class="mb-2"><a href="#teachers">Đội ngũ giáo viên</a></li>
                    <li class="mb-2"><a href="#news">Tin tức</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h5>Hỗ trợ</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#contact">Liên hệ</a></li>
                    <li class="mb-2"><a href="#gallery">Thư viện ảnh</a></li>
                    <li class="mb-2"><a href="admin/login.php">Quản trị</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5>Thông tin liên hệ</h5>
                <p class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i><?= e(setting($settings, 'address', '')) ?></p>
                <p class="mb-2"><i class="bi bi-telephone-fill me-2"></i><?= e(setting($settings, 'hotline', '')) ?></p>
                <p class="mb-2"><i class="bi bi-envelope-fill me-2"></i><?= e(setting($settings, 'email', '')) ?></p>
            </div>
        </div>
        <div class="footer-bottom text-center">
            &copy; <?= date('Y') ?> <?= e(setting($settings, 'site_name', 'Mầm Non')) ?>. Đã đăng ký bản quyền.
        </div>
    </div>
</footer>

<button class="back-to-top" id="backToTop"><i class="bi bi-arrow-up"></i></button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/script.js"></script>
</body>
</html>
