# Landing Page Trường Mầm Non (PHP + Bootstrap 5)

Landing page phong cách cổ điển, tông màu sáng cho ngành giáo dục mầm non, kèm **trang quản trị nội dung (CMS)** đầy đủ.

## 1. Yêu cầu môi trường
- PHP >= 7.4 (khuyến nghị 8.x)
- MySQL / MariaDB
- Web server: Apache/Nginx hoặc dùng PHP built-in server để test nhanh

## 2. Cài đặt

1. Giải nén thư mục `mamnon-landing` vào thư mục web (VD: `htdocs`, `www`, hoặc thư mục dự án XAMPP/Laragon).
2. Tạo database và import dữ liệu mẫu:
   ```bash
   mysql -u root -p < database.sql
   ```
   (File `database.sql` sẽ tự tạo database `mamnon_landing`, các bảng và dữ liệu mẫu.)
3. Mở file `config/db.php` và chỉnh lại thông tin kết nối cho đúng với môi trường của bạn:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'mamnon_landing');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('BASE_URL', ''); // để trống nếu chạy ở domain gốc, hoặc '/mamnon-landing' nếu chạy trong thư mục con
   ```
4. Cấp quyền ghi cho thư mục upload (Linux):
   ```bash
   chmod -R 755 assets/uploads
   ```
5. Truy cập trang chủ: `http://localhost/index.php` (hoặc theo đường dẫn dự án của bạn).

### Chạy nhanh bằng PHP built-in server (test local)
```bash
cd mamnon-landing
php -S localhost:8000
```
Sau đó mở `http://localhost:8000`.

## 3. Đăng nhập trang quản trị

- Đường dẫn: `/admin/login.php`
- Tài khoản mặc định:
  - **Tài khoản:** `admin`
  - **Mật khẩu:** `admin123`

> ⚠️ Vui lòng đổi mật khẩu admin ngay sau khi cài đặt (cập nhật trực tiếp trong bảng `admin_users`, dùng `password_hash()` của PHP để tạo mật khẩu mới).

## 4. Các chức năng quản trị (CMS)

| Trang | Chức năng |
|---|---|
| Tổng quan | Thống kê nhanh, danh sách tin nhắn mới |
| Cài đặt chung | Logo, tên trường, banner (Hero), giới thiệu, số liệu thống kê, thông tin liên hệ, Google Map, Footer |
| Chương trình học | Thêm/sửa/xoá các lớp học (Mầm, Chồi, Lá...), chọn icon, sắp xếp thứ tự |
| Đội ngũ giáo viên | Thêm/sửa/xoá giáo viên kèm ảnh đại diện |
| Thư viện ảnh | Upload nhiều ảnh hoạt động, ẩn/hiện, xoá |
| Cảm nhận phụ huynh | Quản lý đánh giá/cảm nhận, số sao, ảnh đại diện |
| Tin tức | Đăng bài viết, upload ảnh, ẩn/hiện |
| Tin nhắn liên hệ | Xem danh sách phụ huynh đăng ký tư vấn từ form liên hệ |

## 5. Cấu trúc thư mục

```
mamnon-landing/
├── admin/                  # Toàn bộ trang quản trị (CMS)
│   ├── includes/           # Layout sidebar/topbar dùng chung
│   ├── login.php / logout.php
│   ├── dashboard.php
│   ├── settings.php
│   ├── programs.php
│   ├── teachers.php
│   ├── gallery.php
│   ├── testimonials.php
│   ├── news.php
│   └── messages.php
├── assets/
│   ├── css/style.css       # Giao diện tông màu sáng, phong cách cổ điển
│   ├── js/script.js
│   └── uploads/            # Ảnh do admin upload (settings, teachers, gallery, news)
├── config/db.php           # Cấu hình kết nối MySQL
├── includes/                # Header/footer + hàm dùng chung (functions.php)
├── database.sql            # Schema + dữ liệu mẫu
├── index.php                # Trang chủ (landing page)
└── contact-process.php      # Xử lý form đăng ký tư vấn (AJAX)
```

## 6. Bảo mật đã áp dụng
- Mật khẩu admin băm bằng `password_hash()` / xác thực bằng `password_verify()`
- CSRF token cho tất cả các form (frontend + admin)
- PDO prepared statements chống SQL Injection
- Escape output bằng `htmlspecialchars()` chống XSS
- Giới hạn định dạng & dung lượng file upload (jpg/png/webp/gif, tối đa 5MB)

## 7. Tuỳ biến thêm
- Đổi font/màu chủ đạo: sửa biến CSS trong `assets/css/style.css` (phần `:root`)
- Thêm section mới: thêm bảng trong `database.sql`, tạo trang quản trị tương ứng trong `admin/`, rồi hiển thị dữ liệu trong `index.php`
