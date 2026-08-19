<?php
$tieu_de_trang = 'Trường Mầm Non Sao Nhỏ - Mỗi ngày đến lớp là một ngày vui';
$mo_ta_trang   = 'Trường mầm non Sao Nhỏ: môi trường an toàn, học qua chơi, chương trình phù hợp từng độ tuổi từ Nhà Trẻ đến Lớp Lá.';
require_once __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO ===== -->
<section class="hero" id="top">
  <div class="hero-blob" aria-hidden="true"></div>
  <div class="container hero-inner">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6" data-reveal>
        <span class="eyebrow"><i class="bi bi-stars me-1"></i> Tuyển sinh năm học mới</span>
        <h1 class="hero-title">Ươm mầm <span class="text-underline-doodle">yêu thương</span>,<br>vun đắp tương lai</h1>
        <p class="hero-desc"><?= htmlspecialchars($site['khau_hieu']) ?>. Tại <?= htmlspecialchars($site['ten_day_du']) ?>, mỗi bé được học tập trong môi trường an toàn, được yêu thương và khơi dậy sự tò mò khám phá thế giới xung quanh.</p>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="lien-he.php#form-tuyen-sinh" class="btn btn-cta btn-lg">Đăng ký tham quan</a>
          <a href="#chuong-trinh" class="btn btn-outline-cta btn-lg">Xem chương trình học</a>
        </div>
      </div>
      <div class="col-lg-6" data-reveal data-reveal-delay="150">
        <div class="hero-art">
          <svg viewBox="0 0 480 420" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Minh hoạ các bé vui chơi dưới nắng">
            <defs>
              <clipPath id="blobClip"><path d="M410,120 C450,190 440,290 370,340 C300,390 210,410 130,370 C50,330 10,240 40,160 C70,80 160,30 250,30 C320,30 370,50 410,120 Z"/></clipPath>
            </defs>
            <path fill="#FFE4B8" d="M410,120 C450,190 440,290 370,340 C300,390 210,410 130,370 C50,330 10,240 40,160 C70,80 160,30 250,30 C320,30 370,50 410,120 Z"/>
            <circle cx="120" cy="90" r="34" fill="#FFC857"/>
            <circle cx="120" cy="90" r="34" fill="none" stroke="#FFB238" stroke-width="2" stroke-dasharray="4 6"/>
            <g clip-path="url(#blobClip)">
              <circle cx="230" cy="330" r="120" fill="#8FD9C4"/>
              <path d="M150,260 Q230,200 320,260 L320,420 L150,420 Z" fill="#4CAF7D"/>
              <circle cx="190" cy="230" r="30" fill="#2D2A4A"/>
              <circle cx="290" cy="245" r="24" fill="#FF7A59"/>
              <circle cx="255" cy="180" r="18" fill="#FFC857"/>
            </g>
            <path d="M60,380 Q240,340 420,385" stroke="#2D2A4A" stroke-width="3" fill="none" stroke-linecap="round" stroke-dasharray="1 12"/>
          </svg>
        </div>
      </div>
    </div>
  </div>
  <div class="wave-divider" aria-hidden="true">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none"><path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,90 L0,90 Z"></path></svg>
  </div>
</section>

<!-- ===== SỐ LIỆU NỔI BẬT ===== -->
<section class="stats-band">
  <div class="container">
    <div class="row g-4 text-center">
      <?php foreach ($so_lieu as $sl): ?>
        <div class="col-6 col-lg-3" data-reveal>
          <div class="stat-so" data-count="<?= (int)$sl['so'] ?>"><?= (int)$sl['so'] ?><?= htmlspecialchars($sl['don_vi']) ?></div>
          <div class="stat-nhan"><?= htmlspecialchars($sl['nhan']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== GIỚI THIỆU ===== -->
<section class="section" id="gioi-thieu">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-5" data-reveal>
        <span class="section-eyebrow">Vì sao chọn Sao Nhỏ</span>
        <h2 class="section-title">Nơi mỗi buổi sáng<br>con đều háo hức đến lớp</h2>
        <p class="section-desc">Chúng tôi tin rằng tuổi thơ chỉ đến một lần. Sao Nhỏ xây dựng môi trường học tập lấy trẻ làm trung tâm, nơi con được tự do khám phá, vui chơi và trưởng thành theo nhịp độ riêng của mình - luôn có cô giáo đồng hành sát cánh.</p>
      </div>
      <div class="col-lg-7">
        <div class="row g-4">
          <?php foreach ($diem_manh as $i => $dm): ?>
            <div class="col-sm-6" data-reveal data-reveal-delay="<?= $i * 100 ?>">
              <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-<?= htmlspecialchars($dm['icon']) ?>"></i></div>
                <h3 class="feature-title"><?= htmlspecialchars($dm['tieu_de']) ?></h3>
                <p class="feature-desc"><?= htmlspecialchars($dm['mo_ta']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== HÀNH TRÌNH KHÔN LỚN (yếu tố đồ hoạ đặc trưng) ===== -->
<section class="section section-alt" id="chuong-trinh">
  <div class="container">
    <div class="text-center mb-5" data-reveal>
      <span class="section-eyebrow">Chương trình học</span>
      <h2 class="section-title">Hành trình khôn lớn cùng Sao Nhỏ</h2>
      <p class="section-desc mx-auto" style="max-width:640px">4 giai đoạn phát triển được thiết kế riêng theo từng độ tuổi, tiếp nối tự nhiên như một cái cây lớn lên từng ngày.</p>
    </div>

    <div class="growth-path">
      <svg class="growth-path-line d-none d-lg-block" viewBox="0 0 1200 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M40,90 C 260,10 380,150 600,60 S 940,10 1160,80" fill="none" stroke="#C9BFE0" stroke-width="3" stroke-dasharray="2 14" stroke-linecap="round"/>
      </svg>
      <div class="row g-4">
        <?php foreach ($giai_doan as $i => $gd): ?>
          <div class="col-6 col-lg-3" data-reveal data-reveal-delay="<?= $i * 120 ?>">
            <div class="stage-card stage-size-<?= (int)$gd['size'] ?>">
              <div class="stage-icon"><i class="bi bi-<?= htmlspecialchars($gd['icon'] === 'seedling' ? 'flower1' : ($gd['icon'] === 'sprout' ? 'flower2' : ($gd['icon'] === 'sapling' ? 'tree' : 'tree-fill'))) ?>"></i></div>
              <h3 class="stage-ten"><?= htmlspecialchars($gd['ten']) ?></h3>
              <div class="stage-tuoi"><?= htmlspecialchars($gd['do_tuoi']) ?></div>
              <p class="stage-mota"><?= htmlspecialchars($gd['mo_ta']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ===== HOẠT ĐỘNG / THƯ VIỆN ẢNH ===== -->
<section class="section" id="hoat-dong">
  <div class="container">
    <div class="text-center mb-5" data-reveal>
      <span class="section-eyebrow">Một ngày ở Sao Nhỏ</span>
      <h2 class="section-title">Khoảnh khắc mỗi ngày của các con</h2>
    </div>
    <div class="row g-3">
      <?php
      $hoat_dong = [
          ['mau' => '#FFE4B8', 'ten' => 'Giờ vận động ngoài trời', 'icon' => 'bicycle'],
          ['mau' => '#C9E8DD', 'ten' => 'Góc nghệ thuật & tô màu', 'icon' => 'palette2'],
          ['mau' => '#FFD3C2', 'ten' => 'Giờ kể chuyện cùng cô', 'icon' => 'book-half'],
          ['mau' => '#DCE3F7', 'ten' => 'Khám phá khoa học vui', 'icon' => 'stars'],
          ['mau' => '#F6E3C5', 'ten' => 'Bữa ăn dinh dưỡng', 'icon' => 'egg-fried'],
          ['mau' => '#E4D6EF', 'ten' => 'Âm nhạc & vận động', 'icon' => 'music-note-beamed'],
      ];
      foreach ($hoat_dong as $i => $hd):
      ?>
        <div class="col-6 col-lg-4" data-reveal data-reveal-delay="<?= ($i % 3) * 100 ?>">
          <div class="gallery-tile" style="--tile-bg: <?= htmlspecialchars($hd['mau']) ?>">
            <i class="bi bi-<?= htmlspecialchars($hd['icon']) ?>"></i>
            <span><?= htmlspecialchars($hd['ten']) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== CẢM NHẬN PHỤ HUYNH ===== -->
<section class="section section-alt" id="cam-nhan">
  <div class="container">
    <div class="text-center mb-5" data-reveal>
      <span class="section-eyebrow">Phụ huynh nói gì</span>
      <h2 class="section-title">Niềm tin từ những người đồng hành</h2>
    </div>

    <div class="testimonial-slider" data-reveal>
      <div class="testimonial-track" id="testimonialTrack">
        <?php foreach ($cam_nhan as $cn): ?>
          <div class="testimonial-card">
            <i class="bi bi-quote testimonial-quote-icon"></i>
            <p class="testimonial-noidung">"<?= htmlspecialchars($cn['noi_dung']) ?>"</p>
            <div class="testimonial-nguoi">
              <div class="testimonial-avatar"><?= htmlspecialchars(mb_substr($cn['ten'], 0, 1)) ?></div>
              <div>
                <div class="testimonial-ten"><?= htmlspecialchars($cn['ten']) ?></div>
                <div class="testimonial-vaitro"><?= htmlspecialchars($cn['vai_tro']) ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="testimonial-dots" id="testimonialDots"></div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
