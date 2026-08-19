<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trường Mầm Non Sao Nhỏ - Ươm mầm yêu thương, vun đắp tương lai</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        coral: {
                            50: '#fff5f2',
                            100: '#ffe8e1',
                            500: '#f26522',
                            600: '#e05310',
                            700: '#bc3e09',
                        },
                        cream: {
                            50: '#fcfaf5',
                            100: '#f7f3e8',
                            200: '#efe7d3',
                        },
                        navy: {
                            900: '#1e1b38',
                            800: '#282449',
                        },
                        forest: {
                            600: '#228654',
                            700: '#1b6e44',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #fcfaf5;
            color: #2d3748;
        }
        .badge-pill {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800">

    <!-- Top Mode Switcher Bar -->
    <div id="mode-bar" class="bg-slate-900 text-white text-xs py-2 px-4 sticky top-0 z-50 flex justify-between items-center border-b border-slate-800 shadow-lg">
        <div class="flex items-center gap-2">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="font-medium">Chế độ xem: <strong id="current-mode-text" class="text-emerald-400">Trang Khách (Landing Page)</strong></span>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="toggleAdminView('landing')" id="btn-view-landing" class="px-3 py-1 bg-emerald-600 text-white rounded hover:bg-emerald-500 transition font-semibold flex items-center gap-1.5 hidden">
                <i class="fa-solid fa-globe"></i> Xem Landing Page
            </button>
            <button onclick="toggleAdminView('admin')" id="btn-view-admin" class="px-3 py-1 bg-coral-500 text-white rounded hover:bg-coral-600 transition font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-sliders"></i> Mở Trang Quản Trị (CMS Admin)
            </button>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- PUBLIC LANDING PAGE VIEW                                          -->
    <!-- ================================================================= -->
    <div id="landing-page-view" class="transition-all duration-300">
        
        <!-- Top Contact Info Header Bar -->
        <div class="bg-cream-100 border-b border-cream-200 text-slate-600 text-xs sm:text-sm py-2">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
                <div class="flex items-center gap-6">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-phone text-coral-500"></i> <span id="pub-top-phone">0909 123 456</span></span>
                    <span class="flex items-center gap-2"><i class="fa-solid fa-envelope text-coral-500"></i> <span id="pub-top-email">baotruong@saonho.edu.vn</span></span>
                </div>
                <div class="flex items-center gap-2 text-slate-500">
                    <i class="fa-regular fa-clock text-coral-500"></i> <span id="pub-top-hours">Thứ 2 - Thứ 6, 7:00 - 17:00</span>
                </div>
            </div>
        </div>

        <!-- Main Navigation Bar -->
        <nav class="bg-white/90 backdrop-blur-md sticky top-[33px] z-40 border-b border-slate-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
                <!-- Logo -->
                <a href="#hero" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-full bg-coral-500 text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-slate-900 block leading-tight" id="pub-brand-name">Mầm Non Sao Nhỏ</span>
                        <span class="text-[11px] text-coral-500 font-medium block" id="pub-brand-slogan">Mỗi ngày đến lớp là một ngày vui</span>
                    </div>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-7 text-sm font-semibold text-slate-700">
                    <a href="#hero" class="hover:text-coral-500 transition">Trang chủ</a>
                    <a href="#about" class="hover:text-coral-500 transition">Giới thiệu</a>
                    <a href="#programs" class="hover:text-coral-500 transition">Chương trình</a>
                    <a href="#activities" class="hover:text-coral-500 transition">Hoạt động</a>
                    <a href="#testimonials" class="hover:text-coral-500 transition">Phụ huynh nói gì</a>
                    <a href="#footer" class="hover:text-coral-500 transition">Liên hệ</a>
                </div>

                <!-- Action CTA -->
                <div class="flex items-center gap-3">
                    <button onclick="openRegisterModal()" class="bg-coral-500 hover:bg-coral-600 text-white font-bold text-sm px-5 py-2.5 rounded-full shadow-md hover:shadow-lg transition-all transform active:scale-95">
                        Đăng ký tham quan
                    </button>
                </div>
            </div>
        </nav>

        <!-- 1. HERO SECTION -->
        <section id="hero" class="relative py-12 md:py-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <!-- Left Hero Content -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <div>
                            <span class="badge-pill mb-4" id="pub-hero-badge">
                                <i class="fa-solid fa-sparkles text-amber-500"></i> Tuyển sinh năm học mới
                            </span>
                        </div>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.15]" id="pub-hero-title">
                            Ươm mầm <span class="text-coral-500">yêu thương</span>,<br>vun đắp tương lai
                        </h1>
                        <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0" id="pub-hero-subtitle">
                            Mỗi ngày đến lớp là một ngày vui. Tại Trường Mầm Non Sao Nhỏ, mỗi bé được học tập trong môi trường an toàn, được yêu thương và khơi dậy sự tò mò khám phá thế giới xung quanh.
                        </p>
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                            <button onclick="openRegisterModal()" class="bg-coral-500 hover:bg-coral-600 text-white font-bold text-base px-7 py-3.5 rounded-full shadow-lg hover:shadow-coral-500/30 transition-all">
                                Đăng ký tham quan
                            </button>
                            <a href="#programs" class="bg-white hover:bg-slate-50 text-slate-700 font-bold text-base px-7 py-3.5 rounded-full border border-slate-200 shadow-sm transition">
                                Xem chương trình học
                            </a>
                        </div>
                    </div>

                    <!-- Right Hero Graphic/Illustration -->
                    <div class="lg:col-span-5 flex justify-center relative">
                        <div class="w-72 h-72 sm:w-96 sm:h-96 rounded-full bg-amber-100 flex items-center justify-center relative shadow-inner p-6">
                            <div class="w-full h-full rounded-full bg-amber-200/60 flex items-center justify-center overflow-hidden relative">
                                <svg class="w-48 h-48 text-coral-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                                </svg>
                                <div class="absolute bottom-6 bg-white/90 backdrop-blur px-4 py-2 rounded-2xl shadow-md text-xs font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fa-solid fa-heart text-coral-500"></i> Môi trường giáo dục mầm non chất lượng
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. STATS COUNTER BAR (Navy Blue Background) -->
        <section class="bg-navy-900 text-white py-10 shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-slate-700/60">
                    <div class="pt-4 md:pt-0">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mb-1" id="pub-stat-1-num">12+</div>
                        <div class="text-xs sm:text-sm text-slate-300 font-medium" id="pub-stat-1-lbl">năm hoạt động</div>
                    </div>
                    <div class="pt-4 md:pt-0">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mb-1" id="pub-stat-2-num">480+</div>
                        <div class="text-xs sm:text-sm text-slate-300 font-medium" id="pub-stat-2-lbl">bé đang theo học</div>
                    </div>
                    <div class="pt-4 md:pt-0">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mb-1" id="pub-stat-3-num">36</div>
                        <div class="text-xs sm:text-sm text-slate-300 font-medium" id="pub-stat-3-lbl">giáo viên & bảo mẫu</div>
                    </div>
                    <div class="pt-4 md:pt-0">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mb-1" id="pub-stat-4-num">98%</div>
                        <div class="text-xs sm:text-sm text-slate-300 font-medium" id="pub-stat-4-lbl">phụ huynh giới thiệu tiếp</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. SECTION: VÌ SAO CHỌN SAO NHỎ -->
        <section id="about" class="py-16 md:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <!-- Left Title & Intro -->
                    <div class="lg:col-span-5 space-y-4">
                        <span class="badge-pill" id="pub-about-badge">Vì sao chọn Sao Nhỏ</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight" id="pub-about-title">
                            Nơi mỗi buổi sáng con đều háo hức đến lớp
                        </h2>
                        <p class="text-slate-600 leading-relaxed text-sm sm:text-base" id="pub-about-desc">
                            Chúng tôi tin rằng tuổi thơ chỉ đến một lần. Sao Nhỏ xây dựng môi trường học tập lấy trẻ làm trung tâm, nơi con được tự do khám phá, vui chơi và trưởng thành theo nhịp độ riêng của mình - luôn có cô giáo đồng hành sát cánh.
                        </p>
                    </div>

                    <!-- Right 4 Feature Cards Grid -->
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6" id="pub-features-grid">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. SECTION: CHƯƠNG TRÌNH HỌC -->
        <section id="programs" class="py-16 bg-cream-100/60 border-y border-cream-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
                    <span class="badge-pill" id="pub-prog-badge">Chương trình học</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900" id="pub-prog-title">Hành trình khôn lớn cùng Sao Nhỏ</h2>
                    <p class="text-slate-600 text-sm sm:text-base" id="pub-prog-subtitle">
                        4 giai đoạn phát triển được thiết kế riêng theo từng độ tuổi, tiếp nối tự nhiên như một cây lớn lên từng ngày.
                    </p>
                </div>

                <!-- 4 Grade Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="pub-programs-grid">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
        </section>

        <!-- 5. SECTION: MỘT NGÀY Ở SAO NHỎ -->
        <section id="activities" class="py-16 md:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
                    <span class="badge-pill" id="pub-act-badge">Một ngày ở Sao Nhỏ</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900" id="pub-act-title">Khoảnh khắc mỗi ngày của các con</h2>
                </div>

                <!-- 6 Colorful Grid Items -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="pub-activities-grid">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
        </section>

        <!-- 6. SECTION: PHỤ HUYNH NÓI GÌ (TESTIMONIALS) -->
        <section id="testimonials" class="py-16 bg-cream-100/60 border-y border-cream-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
                    <span class="badge-pill" id="pub-testi-badge">Phụ huynh nói gì</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900" id="pub-testi-title">Niềm tin từ những người đồng hành</h2>
                </div>

                <!-- Testimonial Display Card -->
                <div class="max-w-3xl mx-auto bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-slate-100 relative text-center">
                    <div class="text-amber-400 text-5xl mb-4 font-serif">“</div>
                    <p class="text-slate-700 text-base sm:text-lg italic font-medium leading-relaxed mb-6" id="pub-quote-text">
                        "Bé nhà mình từ nhút nhát đã tự tin phát biểu, tự giác ăn và biết chia sẻ đồ chơi với bạn. Cảm ơn các cô rất nhiều!"
                    </p>
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-coral-100 text-coral-600 font-bold flex items-center justify-center text-lg" id="pub-quote-avatar">
                            C
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-slate-900 text-sm" id="pub-quote-name">Chị Minh Anh</h4>
                            <p class="text-xs text-slate-500" id="pub-quote-class">Phụ huynh bé Trí - Lớp Chồi</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. CTA SECTION (Green Background) -->
        <section class="bg-forest-600 text-white py-16">
            <div class="max-w-5xl mx-auto px-4 text-center space-y-6">
                <h2 class="text-3xl sm:text-4xl font-extrabold" id="pub-cta-title">Cho con một khởi đầu đầy yêu thương</h2>
                <p class="text-emerald-100 text-base max-w-2xl mx-auto" id="pub-cta-subtitle">
                    Đặt lịch tham quan lớp học thực tế - phụ huynh có thể quan sát trực tiếp giờ học của các bé.
                </p>
                <div>
                    <button onclick="openRegisterModal()" class="bg-white text-forest-700 hover:bg-emerald-50 font-extrabold px-8 py-4 rounded-full shadow-lg transition-transform transform hover:-translate-y-0.5">
                        Đăng ký tham quan miễn phí
                    </button>
                </div>
            </div>
        </section>

        <!-- 8. FOOTER (Navy Blue Background) -->
        <footer id="footer" class="bg-navy-900 text-slate-300 pt-16 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800 text-xs sm:text-sm">
                <!-- Col 1: Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-coral-500 text-white flex items-center justify-center font-bold">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-lg font-bold text-white" id="pub-ft-brand">Mầm Non Sao Nhỏ</span>
                    </div>
                    <p class="text-slate-400 max-w-sm leading-relaxed" id="pub-ft-desc">
                        Trường Mầm Non Sao Nhỏ - nơi ươm mầm những điều tốt đẹp đầu tiên trong hành trình khôn lớn của con.
                    </p>
                    <div class="flex items-center gap-3 text-slate-400">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-white hover:bg-coral-500 transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-white hover:bg-coral-500 transition"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-sm">Khám phá</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li><a href="#hero" class="hover:text-white transition">Trang chủ</a></li>
                        <li><a href="#about" class="hover:text-white transition">Giới thiệu</a></li>
                        <li><a href="#programs" class="hover:text-white transition">Chương trình</a></li>
                        <li><a href="#activities" class="hover:text-white transition">Hoạt động</a></li>
                        <li><a href="#testimonials" class="hover:text-white transition">Phụ huynh nói gì</a></li>
                    </ul>
                </div>

                <!-- Col 3: Grade Levels -->
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-sm">Các khối lớp</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li>Nhà Trẻ (12 - 36 tháng)</li>
                        <li>Lớp Mầm (3 - 4 tuổi)</li>
                        <li>Lớp Chồi (4 - 5 tuổi)</li>
                        <li>Lớp Lá (5 - 6 tuổi)</li>
                    </ul>
                </div>

                <!-- Col 4: Contact Info -->
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-sm">Liên hệ</h4>
                    <ul class="space-y-2.5 text-slate-400">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-coral-500 mt-1"></i>
                            <span id="pub-ft-address">12 Đường Hoa Sữa, Phường Bính Thạnh, TP. Hồ Chí Minh</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-coral-500"></i>
                            <span id="pub-ft-phone">0909 123 456</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-coral-500"></i>
                            <span id="pub-ft-email">baotruong@saonho.edu.vn</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>© 2026 Trường Mầm Non Sao Nhỏ. Bảo lưu mọi quyền.</p>
                <p class="flex items-center gap-1">Thiết kế với <i class="fa-solid fa-heart text-coral-500"></i> dành cho các bé</p>
            </div>
        </footer>
    </div>


    <!-- ================================================================= -->
    <!-- ADMIN PANEL VIEW (CMS EDIT MODE)                                  -->
    <!-- ================================================================= -->
    <div id="admin-panel-view" class="hidden min-h-screen bg-slate-100 pb-20">
        <!-- Admin Header Banner -->
        <div class="bg-slate-900 text-white py-6 px-4 sm:px-8 shadow-md">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-coral-500"></i> Trang Quản Trị Content CMS
                    </h1>
                    <p class="text-slate-400 text-xs mt-1">Chỉnh sửa nội dung cho landing page Mầm Non Sao Nhỏ và quản lý danh sách đăng ký tham quan.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="saveCmsData()" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm px-5 py-2.5 rounded-lg shadow flex items-center gap-2 transition">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu Thay Đổi
                    </button>
                    <button onclick="resetCmsData()" class="bg-slate-700 hover:bg-slate-600 text-slate-200 font-semibold text-sm px-4 py-2.5 rounded-lg transition flex items-center gap-1">
                        <i class="fa-solid fa-rotate-left"></i> Khôi Phục Mặc Định
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <!-- Tabs Bar -->
            <div class="flex flex-wrap border-b border-slate-300 gap-2 mb-8 bg-white p-2 rounded-xl shadow-sm">
                <button onclick="switchAdminTab('hero')" id="tab-btn-hero" class="tab-btn active px-4 py-2.5 text-sm font-bold rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-house"></i> Hero & Thống kê
                </button>
                <button onclick="switchAdminTab('about')" id="tab-btn-about" class="tab-btn px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i> Vì sao chọn Sao Nhỏ
                </button>
                <button onclick="switchAdminTab('programs')" id="tab-btn-programs" class="tab-btn px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap"></i> Chương trình học
                </button>
                <button onclick="switchAdminTab('activities')" id="tab-btn-activities" class="tab-btn px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-icons"></i> Khoảnh khắc & Phụ huynh
                </button>
                <button onclick="switchAdminTab('registrations')" id="tab-btn-registrations" class="tab-btn px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-lg transition flex items-center gap-2 relative">
                    <i class="fa-solid fa-clipboard-list"></i> Danh Sách Đăng Ký
                    <span id="reg-badge-count" class="bg-coral-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">0</span>
                </button>
            </div>

            <!-- TAB 1: HERO & STATS -->
            <div id="tab-content-hero" class="admin-tab-section bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-heading text-coral-500"></i> Quản lý Hero Section & Thông Tin Liên Hệ Trên
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại Hotlines</label>
                        <input type="text" id="adm-top-phone" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-coral-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email liên hệ</label>
                        <input type="text" id="adm-top-email" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-coral-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Giờ làm việc</label>
                        <input type="text" id="adm-top-hours" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-coral-500">
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Badge Thông Báo Hero</label>
                        <input type="text" id="adm-hero-badge" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-coral-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tiêu đề Hero chính</label>
                        <input type="text" id="adm-hero-title" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-coral-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Đoạn văn giới thiệu Hero</label>
                        <textarea id="adm-hero-subtitle" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-coral-500"></textarea>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 pt-6 flex items-center gap-2">
                    <i class="fa-solid fa-chart-simple text-coral-500"></i> Quản lý Thanh Thống Kê (4 chỉ số)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-slate-50 p-4 rounded-xl border">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Chỉ số 1 (Con số)</label>
                        <input type="text" id="adm-stat-1-num" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm mb-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mô tả 1</label>
                        <input type="text" id="adm-stat-1-lbl" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm">
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Chỉ số 2 (Con số)</label>
                        <input type="text" id="adm-stat-2-num" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm mb-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mô tả 2</label>
                        <input type="text" id="adm-stat-2-lbl" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm">
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Chỉ số 3 (Con số)</label>
                        <input type="text" id="adm-stat-3-num" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm mb-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mô tả 3</label>
                        <input type="text" id="adm-stat-3-lbl" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm">
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Chỉ số 4 (Con số)</label>
                        <input type="text" id="adm-stat-4-num" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm mb-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mô tả 4</label>
                        <input type="text" id="adm-stat-4-lbl" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm">
                    </div>
                </div>
            </div>

            <!-- TAB 2: VÌ SAO CHỌN SAO NHỎ -->
            <div id="tab-content-about" class="admin-tab-section hidden bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-bullseye text-coral-500"></i> Tiêu đề & Mô tả Phần "Vì sao chọn Sao Nhỏ"
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Badge</label>
                        <input type="text" id="adm-about-badge" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tiêu đề chính</label>
                        <input type="text" id="adm-about-title" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Đoạn văn mô tả</label>
                        <textarea id="adm-about-desc" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"></textarea>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 pt-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-coral-500"></i> Danh Sách 4 Tính Năng Nổi Bật
                </h3>
                <div id="adm-features-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Dynamic Feature Editors -->
                </div>
            </div>

            <!-- TAB 3: CHƯƠNG TRÌNH HỌC -->
            <div id="tab-content-programs" class="admin-tab-section hidden bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-coral-500"></i> Quản lý Chương Trình Học (4 Khối Lớp)
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tiêu đề chính section</label>
                        <input type="text" id="adm-prog-title" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Phụ đề section</label>
                        <input type="text" id="adm-prog-subtitle" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>

                <div id="adm-programs-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4">
                    <!-- Dynamic Program Editors -->
                </div>
            </div>

            <!-- TAB 4: KHOẢNH KHẮC & PHỤ HUYNH -->
            <div id="tab-content-activities" class="admin-tab-section hidden bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-comments text-coral-500"></i> Quản lý Đánh Giá Của Phụ Huynh (Testimonial)
                </h3>
                <div class="bg-slate-50 p-4 rounded-xl border space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nội dung trích dẫn</label>
                        <textarea id="adm-quote-text" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tên phụ huynh</label>
                            <input type="text" id="adm-quote-name" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Thông tin con / Lớp học</label>
                            <input type="text" id="adm-quote-class" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 5: DANH SÁCH ĐĂNG KÝ THAM QUAN -->
            <div id="tab-content-registrations" class="admin-tab-section hidden bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-coral-500"></i> Danh Sách Phụ Huynh Đăng Ký Tham Quan
                    </h3>
                    <button onclick="clearAllRegistrations()" class="text-xs text-rose-600 hover:text-rose-700 font-bold hover:underline">
                        Xóa tất cả danh sách
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm text-slate-600">
                        <thead class="bg-slate-100 text-slate-800 font-bold border-b">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Họ tên Phụ huynh</th>
                                <th class="p-3">Số điện thoại</th>
                                <th class="p-3">Tên bé & Tuổi</th>
                                <th class="p-3">Khối lớp muốn học</th>
                                <th class="p-3">Thời gian đăng ký</th>
                            </tr>
                        </thead>
                        <tbody id="adm-registrations-tbody" class="divide-y">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- REGISTRATION MODAL POPUP -->
    <div id="register-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-6 sm:p-8 relative transform transition-all animate-bounce-in">
            <button onclick="closeRegisterModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 text-xl font-bold">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="text-center mb-6">
                <div class="w-12 h-12 rounded-full bg-coral-100 text-coral-500 flex items-center justify-center mx-auto mb-2 text-xl">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Đăng Ký Tham Quan</h3>
                <p class="text-xs text-slate-500 mt-1">Trải nghiệm không gian học tập thực tế cùng bé yêu</p>
            </div>

            <form id="reg-form" onsubmit="handleRegistrationSubmit(event)" class="space-y-4 text-xs sm:text-sm">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Họ và tên Phụ huynh *</label>
                    <input type="text" required id="reg-parent-name" placeholder="Nguyễn Văn A" class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-coral-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Số điện thoại liên hệ *</label>
                    <input type="tel" required id="reg-phone" placeholder="0901234567" class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-coral-500 focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tên của bé</label>
                        <input type="text" id="reg-child-name" placeholder="Bé Bún" class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-coral-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Khối lớp quan tâm</label>
                        <select id="reg-grade" class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-coral-500 focus:outline-none bg-white">
                            <option value="Nhà Trẻ">Nhà Trẻ (12-36T)</option>
                            <option value="Lớp Mầm">Lớp Mầm (3-4T)</option>
                            <option value="Lớp Chồi">Lớp Chồi (4-5T)</option>
                            <option value="Lớp Lá">Lớp Lá (5-6T)</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full bg-coral-500 hover:bg-coral-600 text-white font-bold py-3.5 rounded-xl shadow-lg transition duration-200 text-base mt-2">
                    Xác Nhận Đăng Ký
                </button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT APP LOGIC & CMS LOCALSTORAGE MANAGEMENT -->
    <script>
        const defaultCmsData = {
            topBar: {
                phone: "0909 123 456",
                email: "baotruong@saonho.edu.vn",
                hours: "Thứ 2 - Thứ 6, 7:00 - 17:00"
            },
            hero: {
                badge: "Tuyển sinh năm học mới",
                title: "Ươm mầm yêu thương, vun đắp tương lai",
                subtitle: "Mỗi ngày đến lớp là một ngày vui. Tại Trường Mầm Non Sao Nhỏ, mỗi bé được học tập trong môi trường an toàn, được yêu thương và khơi dậy sự tò mò khám phá thế giới xung quanh."
            },
            stats: [
                { num: "12+", lbl: "năm hoạt động" },
                { num: "480+", lbl: "bé đang theo học" },
                { num: "36", lbl: "giáo viên & bảo mẫu" },
                { num: "98%", lbl: "phụ huynh giới thiệu tiếp" }
            ],
            about: {
                badge: "Vì sao chọn Sao Nhỏ",
                title: "Nơi mỗi buổi sáng con đều háo hức đến lớp",
                desc: "Chúng tôi tin rằng tuổi thơ chỉ đến một lần. Sao Nhỏ xây dựng môi trường học tập lấy trẻ làm trung tâm, nơi con được tự do khám phá, vui chơi và trưởng thành theo nhịp độ riêng của mình - luôn có cô giáo đồng hành sát cánh."
            },
            features: [
                {
                    icon: "fa-shield-halved",
                    title: "An toàn là ưu tiên số 1",
                    desc: "Camera giám sát 24/7, khuôn viên khép kín, quy trình đón trả kiểm soát chặt chẽ."
                },
                {
                    icon: "fa-shapes",
                    title: "Học qua chơi, chơi qua học",
                    desc: "Giáo trình lấy trẻ làm trung tâm, khuyến khích khám phá và sáng tạo mỗi ngày."
                },
                {
                    icon: "fa-users",
                    title: "Sĩ số nhỏ, quan tâm sát sao",
                    desc: "Tối đa 15 bé/lớp với 2 giáo viên và 1 bảo mẫu, đảm bảo mỗi bé đều được chăm sóc."
                },
                {
                    icon: "fa-apple-whole",
                    title: "Dinh dưỡng khoa học",
                    desc: "Thực đơn xây dựng cùng chuyên gia dinh dưỡng, thực phẩm sạch, rõ nguồn gốc."
                }
            ],
            programs: {
                badge: "Chương trình học",
                title: "Hành trình khôn lớn cùng Sao Nhỏ",
                subtitle: "4 giai đoạn phát triển được thiết kế riêng theo từng độ tuổi, tiếp nối tự nhiên như một cây lớn lên từng ngày.",
                items: [
                    {
                        name: "Nhà Trẻ",
                        age: "12 - 36 tháng",
                        desc: "Làm quen với lớp học, xây dựng nếp sinh hoạt và cảm giác an toàn ban đầu."
                    },
                    {
                        name: "Lớp Mầm",
                        age: "3 - 4 tuổi",
                        desc: "Phát triển ngôn ngữ, vận động tinh và kỹ năng tự phục vụ qua các trò chơi."
                    },
                    {
                        name: "Lớp Chồi",
                        age: "4 - 5 tuổi",
                        desc: "Khơi gợi tư duy sáng tạo, làm quen chữ cái - chữ số, rèn kỹ năng hợp tác nhóm."
                    },
                    {
                        name: "Lớp Lá",
                        age: "5 - 6 tuổi",
                        desc: "Trang bị hành trang sẵn sàng vào lớp 1: rèn nếp học tập, sự tự tin và tính tự lập."
                    }
                ]
            },
            activities: [
                { title: "Giờ vận động ngoài trời", icon: "fa-bicycle", bg: "bg-amber-100", text: "text-amber-800" },
                { title: "Góc nghệ thuật & tô màu", icon: "fa-palette", bg: "bg-emerald-100", text: "text-emerald-800" },
                { title: "Giờ kể chuyện cùng cô", icon: "fa-book-open-reader", bg: "bg-orange-100", text: "text-orange-800" },
                { title: "Khám phá khoa học vui", icon: "fa-flask-vial", bg: "bg-indigo-100", text: "text-indigo-800" },
                { title: "Bữa ăn dinh dưỡng", icon: "fa-bowl-rice", bg: "bg-yellow-100", text: "text-yellow-800" },
                { title: "Âm nhạc & vận động", icon: "fa-music", bg: "bg-purple-100", text: "text-purple-800" }
            ],
            testimonial: {
                quote: "Bé nhà mình từ nhút nhát đã tự tin phát biểu, tự giác ăn và biết chia sẻ đồ chơi với bạn. Cảm ơn các cô rất nhiều!",
                name: "Chị Minh Anh",
                childClass: "Phụ huynh bé Trí - Lớp Chồi"
            },
            registrations: [
                { parentName: "Trần Thị Mai", phone: "0912 345 678", childName: "Bé Su", grade: "Lớp Mầm", time: "2026-08-07 09:30" },
                { parentName: "Lê Hoàng Nam", phone: "0988 777 666", childName: "Bé Ken", grade: "Nhà Trẻ", time: "2026-08-07 14:15" }
            ]
        };

        let cmsData = {};

        function initApp() {
            const stored = localStorage.getItem('saonho_cms_data');
            if (stored) {
                try {
                    cmsData = JSON.parse(stored);
                } catch(e) {
                    cmsData = defaultCmsData;
                }
            } else {
                cmsData = JSON.parse(JSON.stringify(defaultCmsData));
            }

            renderLandingPage();
            populateAdminForm();
        }

        function renderLandingPage() {
            document.getElementById('pub-top-phone').innerText = cmsData.topBar.phone;
            document.getElementById('pub-top-email').innerText = cmsData.topBar.email;
            document.getElementById('pub-top-hours').innerText = cmsData.topBar.hours;

            document.getElementById('pub-ft-phone').innerText = cmsData.topBar.phone;
            document.getElementById('pub-ft-email').innerText = cmsData.topBar.email;

            document.getElementById('pub-hero-badge').innerHTML = `<i class="fa-solid fa-sparkles text-amber-500"></i> ${cmsData.hero.badge}`;
            document.getElementById('pub-hero-title').innerHTML = cmsData.hero.title.replace('yêu thương', '<span class="text-coral-500">yêu thương</span>');
            document.getElementById('pub-hero-subtitle').innerText = cmsData.hero.subtitle;

            document.getElementById('pub-stat-1-num').innerText = cmsData.stats[0].num;
            document.getElementById('pub-stat-1-lbl').innerText = cmsData.stats[0].lbl;
            document.getElementById('pub-stat-2-num').innerText = cmsData.stats[1].num;
            document.getElementById('pub-stat-2-lbl').innerText = cmsData.stats[1].lbl;
            document.getElementById('pub-stat-3-num').innerText = cmsData.stats[2].num;
            document.getElementById('pub-stat-3-lbl').innerText = cmsData.stats[2].lbl;
            document.getElementById('pub-stat-4-num').innerText = cmsData.stats[3].num;
            document.getElementById('pub-stat-4-lbl').innerText = cmsData.stats[3].lbl;

            document.getElementById('pub-about-badge').innerText = cmsData.about.badge;
            document.getElementById('pub-about-title').innerText = cmsData.about.title;
            document.getElementById('pub-about-desc').innerText = cmsData.about.desc;

            const featContainer = document.getElementById('pub-features-grid');
            featContainer.innerHTML = cmsData.features.map(f => `
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg mb-3 font-bold">
                        <i class="fa-solid ${f.icon}"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1.5">${f.title}</h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">${f.desc}</p>
                </div>
            `).join('');

            document.getElementById('pub-prog-title').innerText = cmsData.programs.title;
            document.getElementById('pub-prog-subtitle').innerText = cmsData.programs.subtitle;

            const progContainer = document.getElementById('pub-programs-grid');
            progContainer.innerHTML = cmsData.programs.items.map(p => `
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-3 hover:-translate-y-1 transition duration-200 shadow-sm">
                    <div class="w-12 h-12 rounded-full bg-emerald-600 text-white flex items-center justify-center text-lg mx-auto font-bold shadow-md">
                        <i class="fa-solid fa-tree"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg">${p.name}</h3>
                    <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold">${p.age}</span>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">${p.desc}</p>
                </div>
            `).join('');

            const actContainer = document.getElementById('pub-activities-grid');
            actContainer.innerHTML = cmsData.activities.map(a => `
                <div class="${a.bg} p-8 rounded-2xl text-center space-y-3 shadow-sm flex flex-col items-center justify-center border border-slate-200/50 min-h-[160px]">
                    <i class="fa-solid ${a.icon} text-3xl ${a.text}"></i>
                    <h3 class="font-bold text-slate-800 text-base">${a.title}</h3>
                </div>
            `).join('');

            document.getElementById('pub-quote-text').innerText = `"${cmsData.testimonial.quote}"`;
            document.getElementById('pub-quote-name').innerText = cmsData.testimonial.name;
            document.getElementById('pub-quote-class').innerText = cmsData.testimonial.childClass;
            document.getElementById('pub-quote-avatar').innerText = cmsData.testimonial.name ? cmsData.testimonial.name.charAt(0) : "P";
        }

        function toggleAdminView(mode) {
            const landingView = document.getElementById('landing-page-view');
            const adminView = document.getElementById('admin-panel-view');
            const btnLanding = document.getElementById('btn-view-landing');
            const btnAdmin = document.getElementById('btn-view-admin');
            const modeText = document.getElementById('current-mode-text');

            if (mode === 'admin') {
                landingView.classList.add('hidden');
                adminView.classList.remove('hidden');
                btnLanding.classList.remove('hidden');
                btnAdmin.classList.add('hidden');
                modeText.innerText = "Trang Quản Trị CMS";
                modeText.className = "text-coral-400";
                populateAdminForm();
            } else {
                adminView.classList.add('hidden');
                landingView.classList.remove('hidden');
                btnLanding.classList.add('hidden');
                btnAdmin.classList.remove('hidden');
                modeText.innerText = "Trang Khách (Landing Page)";
                modeText.className = "text-emerald-400";
                renderLandingPage();
            }
        }

        function switchAdminTab(tabName) {
            document.querySelectorAll('.admin-tab-section').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-coral-500', 'text-white');
                btn.classList.add('text-slate-600');
            });

            document.getElementById(`tab-content-${tabName}`).classList.remove('hidden');
            const activeBtn = document.getElementById(`tab-btn-${tabName}`);
            activeBtn.classList.add('bg-coral-500', 'text-white');
            activeBtn.classList.remove('text-slate-600');
        }

        function populateAdminForm() {
            document.getElementById('adm-top-phone').value = cmsData.topBar.phone;
            document.getElementById('adm-top-email').value = cmsData.topBar.email;
            document.getElementById('adm-top-hours').value = cmsData.topBar.hours;

            document.getElementById('adm-hero-badge').value = cmsData.hero.badge;
            document.getElementById('adm-hero-title').value = cmsData.hero.title;
            document.getElementById('adm-hero-subtitle').value = cmsData.hero.subtitle;

            document.getElementById('adm-stat-1-num').value = cmsData.stats[0].num;
            document.getElementById('adm-stat-1-lbl').value = cmsData.stats[0].lbl;
            document.getElementById('adm-stat-2-num').value = cmsData.stats[1].num;
            document.getElementById('adm-stat-2-lbl').value = cmsData.stats[1].lbl;
            document.getElementById('adm-stat-3-num').value = cmsData.stats[2].num;
            document.getElementById('adm-stat-3-lbl').value = cmsData.stats[2].lbl;
            document.getElementById('adm-stat-4-num').value = cmsData.stats[3].num;
            document.getElementById('adm-stat-4-lbl').value = cmsData.stats[3].lbl;

            document.getElementById('adm-about-badge').value = cmsData.about.badge;
            document.getElementById('adm-about-title').value = cmsData.about.title;
            document.getElementById('adm-about-desc').value = cmsData.about.desc;

            const featAdmin = document.getElementById('adm-features-container');
            featAdmin.innerHTML = cmsData.features.map((f, i) => `
                <div class="bg-slate-50 p-4 rounded-xl border">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tính năng ${i+1} (Tiêu đề)</label>
                    <input type="text" id="adm-feat-title-${i}" value="${f.title}" class="w-full border border-slate-300 rounded px-2.5 py-1 text-sm mb-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Mô tả</label>
                    <input type="text" id="adm-feat-desc-${i}" value="${f.desc}" class="w-full border border-slate-300 rounded px-2.5 py-1 text-sm">
                </div>
            `).join('');

            document.getElementById('adm-prog-title').value = cmsData.programs.title;
            document.getElementById('adm-prog-subtitle').value = cmsData.programs.subtitle;

            const progAdmin = document.getElementById('adm-programs-container');
            progAdmin.innerHTML = cmsData.programs.items.map((p, i) => `
                <div class="bg-slate-50 p-4 rounded-xl border space-y-2">
                    <label class="block text-xs font-bold text-slate-700">Tên khối ${i+1}</label>
                    <input type="text" id="adm-prog-name-${i}" value="${p.name}" class="w-full border border-slate-300 rounded px-2.5 py-1 text-sm">
                    <label class="block text-xs font-bold text-slate-700">Độ tuổi</label>
                    <input type="text" id="adm-prog-age-${i}" value="${p.age}" class="w-full border border-slate-300 rounded px-2.5 py-1 text-sm">
                    <label class="block text-xs font-bold text-slate-700">Mô tả</label>
                    <textarea id="adm-prog-desc-${i}" rows="2" class="w-full border border-slate-300 rounded px-2.5 py-1 text-sm">${p.desc}</textarea>
                </div>
            `).join('');

            document.getElementById('adm-quote-text').value = cmsData.testimonial.quote;
            document.getElementById('adm-quote-name').value = cmsData.testimonial.name;
            document.getElementById('adm-quote-class').value = cmsData.testimonial.childClass;

            renderRegistrationTable();
        }

        function renderRegistrationTable() {
            const tbody = document.getElementById('adm-registrations-tbody');
            const regs = cmsData.registrations || [];
            document.getElementById('reg-badge-count').innerText = regs.length;

            if (regs.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="p-6 text-center text-slate-400 italic">Chưa có lượt đăng ký nào.</td></tr>`;
                return;
            }

            tbody.innerHTML = regs.map((r, i) => `
                <tr class="hover:bg-slate-50">
                    <td class="p-3 font-bold">${i+1}</td>
                    <td class="p-3 font-semibold text-slate-900">${r.parentName}</td>
                    <td class="p-3 text-emerald-600 font-bold">${r.phone}</td>
                    <td class="p-3">${r.childName || '—'}</td>
                    <td class="p-3"><span class="px-2 py-0.5 bg-coral-50 text-coral-600 font-bold text-xs rounded">${r.grade}</span></td>
                    <td class="p-3 text-slate-400 text-xs">${r.time}</td>
                </tr>
            `).join('');
        }

        function saveCmsData() {
            cmsData.topBar.phone = document.getElementById('adm-top-phone').value;
            cmsData.topBar.email = document.getElementById('adm-top-email').value;
            cmsData.topBar.hours = document.getElementById('adm-top-hours').value;

            cmsData.hero.badge = document.getElementById('adm-hero-badge').value;
            cmsData.hero.title = document.getElementById('adm-hero-title').value;
            cmsData.hero.subtitle = document.getElementById('adm-hero-subtitle').value;

            cmsData.stats[0].num = document.getElementById('adm-stat-1-num').value;
            cmsData.stats[0].lbl = document.getElementById('adm-stat-1-lbl').value;
            cmsData.stats[1].num = document.getElementById('adm-stat-2-num').value;
            cmsData.stats[1].lbl = document.getElementById('adm-stat-2-lbl').value;
            cmsData.stats[2].num = document.getElementById('adm-stat-3-num').value;
            cmsData.stats[2].lbl = document.getElementById('adm-stat-3-lbl').value;
            cmsData.stats[3].num = document.getElementById('adm-stat-4-num').value;
            cmsData.stats[3].lbl = document.getElementById('adm-stat-4-lbl').value;

            cmsData.about.badge = document.getElementById('adm-about-badge').value;
            cmsData.about.title = document.getElementById('adm-about-title').value;
            cmsData.about.desc = document.getElementById('adm-about-desc').value;

            cmsData.features.forEach((f, i) => {
                f.title = document.getElementById(`adm-feat-title-${i}`).value;
                f.desc = document.getElementById(`adm-feat-desc-${i}`).value;
            });

            cmsData.programs.title = document.getElementById('adm-prog-title').value;
            cmsData.programs.subtitle = document.getElementById('adm-prog-subtitle').value;
            cmsData.programs.items.forEach((p, i) => {
                p.name = document.getElementById(`adm-prog-name-${i}`).value;
                p.age = document.getElementById(`adm-prog-age-${i}`).value;
                p.desc = document.getElementById(`adm-prog-desc-${i}`).value;
            });

            cmsData.testimonial.quote = document.getElementById('adm-quote-text').value;
            cmsData.testimonial.name = document.getElementById('adm-quote-name').value;
            cmsData.testimonial.childClass = document.getElementById('adm-quote-class').value;

            localStorage.setItem('saonho_cms_data', JSON.stringify(cmsData));
            alert('✅ Đã lưu thay đổi thành công!');
        }

        function resetCmsData() {
            if (confirm('Bạn có chắc muốn khôi phục toàn bộ nội dung về mặc định không?')) {
                cmsData = JSON.parse(JSON.stringify(defaultCmsData));
                localStorage.removeItem('saonho_cms_data');
                populateAdminForm();
                alert('Khôi phục dữ liệu gốc thành công!');
            }
        }

        function clearAllRegistrations() {
            if (confirm('Bạn có chắc muốn xóa tất cả lượt đăng ký?')) {
                cmsData.registrations = [];
                localStorage.setItem('saonho_cms_data', JSON.stringify(cmsData));
                renderRegistrationTable();
            }
        }

        function openRegisterModal() {
            document.getElementById('register-modal').classList.remove('hidden');
        }

        function closeRegisterModal() {
            document.getElementById('register-modal').classList.add('hidden');
        }

        function handleRegistrationSubmit(e) {
            e.preventDefault();
            const parentName = document.getElementById('reg-parent-name').value;
            const phone = document.getElementById('reg-phone').value;
            const childName = document.getElementById('reg-child-name').value;
            const grade = document.getElementById('reg-grade').value;

            const now = new Date();
            const timeStr = `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')} ${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}`;

            if (!cmsData.registrations) cmsData.registrations = [];
            cmsData.registrations.unshift({ parentName, phone, childName, grade, time: timeStr });

            localStorage.setItem('saonho_cms_data', JSON.stringify(cmsData));

            alert(`Cảm ơn Phụ huynh ${parentName}! Đã đăng ký lịch tham quan thành công. Nhà trường sẽ liên hệ qua SĐT ${phone} sớm nhất!`);
            document.getElementById('reg-form').reset();
            closeRegisterModal();
        }

        window.addEventListener('DOMContentLoaded', initApp);
    </script>
</body>
</html>
