-- =========================================================
-- CSDL cho Landing Page Trường Mầm Non
-- =========================================================
CREATE DATABASE IF NOT EXISTS mamnon_landing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mamnon_landing;

-- Bảng tài khoản quản trị
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tài khoản mặc định: admin / admin123
INSERT INTO admin_users (username, password, full_name) VALUES
('admin', '$2b$12$jGaVSVAWtEVvnrkSSac9h.tVYjQu0id0reTU6wFuXx..8o76IYEBO', 'Quản trị viên');

-- Bảng cấu hình chung (key - value) dùng cho Header, Hero, Giới thiệu, Footer, Liên hệ...
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value LONGTEXT
) ENGINE=InnoDB;

INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'Mầm Non Ánh Dương'),
('site_slogan', 'Ươm mầm hạnh phúc - Vun đắp tương lai'),
('logo', ''),
('hotline', '0909 123 456'),
('email', 'lienhe@mamnonanhduong.vn'),
('address', '123 Đường Hoa Sữa, Quận 7, TP. Hồ Chí Minh'),
('fanpage_url', '#'),
('youtube_url', '#'),
('zalo_url', '#'),
('map_iframe', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.395!2d106.7!3d10.73" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'),
('hero_title', 'Chào mừng bé đến với ngôi nhà thứ hai'),
('hero_subtitle', 'Môi trường giáo dục an toàn - thân thiện - hiện đại, nơi mỗi ngày đến trường của con là một niềm vui'),
('hero_image', ''),
('hero_button_text', 'Đăng ký tư vấn'),
('about_title', 'Về chúng tôi'),
('about_content', 'Mầm Non Ánh Dương được thành lập với sứ mệnh mang đến cho trẻ một môi trường học tập và vui chơi an toàn, sáng tạo. Với đội ngũ giáo viên giàu kinh nghiệm, giáo trình song ngữ hiện đại và cơ sở vật chất đạt chuẩn, chúng tôi tự hào đồng hành cùng phụ huynh trong hành trình nuôi dạy con trẻ.'),
('about_image', ''),
('stat_students', '500+'),
('stat_teachers', '40+'),
('stat_years', '10+'),
('stat_awards', '15+'),
('footer_description', 'Mầm Non Ánh Dương - Nơi ươm mầm những giấc mơ tuổi thơ, giúp bé phát triển toàn diện cả về thể chất, trí tuệ và tâm hồn.');

-- Bảng chương trình học
CREATE TABLE programs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    icon VARCHAR(50) DEFAULT 'bi-stars',
    age_range VARCHAR(50),
    display_order INT DEFAULT 0,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO programs (title, description, icon, age_range, display_order) VALUES
('Lớp Mầm', 'Giúp bé làm quen với môi trường lớp học, phát triển kỹ năng vận động và giao tiếp cơ bản.', 'bi-flower1', '2 - 3 tuổi', 1),
('Lớp Chồi', 'Phát triển tư duy sáng tạo, kỹ năng xã hội và làm quen với chữ cái, con số qua trò chơi.', 'bi-tree', '3 - 4 tuổi', 2),
('Lớp Lá', 'Trang bị hành trang vững vàng để bé tự tin bước vào lớp Một với chương trình học song ngữ.', 'bi-flower3', '4 - 5 tuổi', 3),
('Kỹ Năng Sống', 'Rèn luyện tính tự lập, kỹ năng xử lý tình huống và giá trị sống tích cực cho trẻ.', 'bi-heart', 'Mọi lứa tuổi', 4);

-- Bảng đội ngũ giáo viên
CREATE TABLE teachers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100),
    image VARCHAR(255),
    description TEXT,
    display_order INT DEFAULT 0,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO teachers (name, position, image, description, display_order) VALUES
('Cô Nguyễn Thị Lan', 'Hiệu trưởng', '', 'Hơn 15 năm kinh nghiệm trong lĩnh vực giáo dục mầm non.', 1),
('Cô Trần Thị Mai', 'Giáo viên chủ nhiệm lớp Lá', '', 'Chuyên gia giảng dạy chương trình song ngữ cho trẻ.', 2),
('Cô Lê Thị Hoa', 'Giáo viên chủ nhiệm lớp Chồi', '', 'Tận tâm, yêu trẻ và giàu kinh nghiệm sư phạm.', 3);

-- Bảng thư viện ảnh hoạt động
CREATE TABLE gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    display_order INT DEFAULT 0,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Bảng cảm nhận phụ huynh
CREATE TABLE testimonials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    parent_name VARCHAR(100) NOT NULL,
    child_name VARCHAR(100),
    avatar VARCHAR(255),
    content TEXT,
    rating TINYINT DEFAULT 5,
    display_order INT DEFAULT 0,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO testimonials (parent_name, child_name, content, rating, display_order) VALUES
('Chị Phạm Thu Hương', 'phụ huynh bé Bin', 'Con mình rất thích đi học, cô giáo tận tâm và luôn cập nhật tình hình học tập hàng ngày. Rất yên tâm khi gửi con ở đây.', 5, 1),
('Anh Nguyễn Văn Đức', 'phụ huynh bé Kem', 'Cơ sở vật chất sạch đẹp, an toàn. Bé nhà mình tiến bộ rõ rệt về khả năng giao tiếp sau nửa năm học tại trường.', 5, 2),
('Chị Đỗ Ngọc Anh', 'phụ huynh bé Sushi', 'Chương trình học sáng tạo, các hoạt động ngoại khóa phong phú giúp con phát triển toàn diện.', 5, 3);

-- Bảng tin tức - hoạt động
CREATE TABLE news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255),
    summary TEXT,
    content LONGTEXT,
    image VARCHAR(255),
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO news (title, slug, summary, content, status) VALUES
('Khai giảng năm học mới 2026 - 2027', 'khai-giang-nam-hoc-moi', 'Trường tổ chức lễ khai giảng chào đón các bé vào năm học mới với nhiều hoạt động thú vị.', 'Nội dung chi tiết về lễ khai giảng năm học mới...', 1),
('Ngày hội trải nghiệm STEM cho bé', 'ngay-hoi-stem', 'Các bé được tham gia trải nghiệm các hoạt động STEM sáng tạo, phát triển tư duy logic.', 'Nội dung chi tiết về ngày hội STEM...', 1);

-- Bảng tin nhắn liên hệ / đăng ký tư vấn
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
