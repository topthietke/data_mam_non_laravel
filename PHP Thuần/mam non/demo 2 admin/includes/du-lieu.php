<?php
/**
 * du-lieu.php
 * Lớp tiện ích đọc/ghi dữ liệu dạng JSON — đóng vai trò như một "CSDL file"
 * đơn giản cho website. Toàn bộ nội dung (chương trình học, điểm mạnh, cảm nhận
 * phụ huynh, số liệu, thông tin trường...) được lưu tại data/content.json và có
 * thể chỉnh sửa qua khu vực /admin mà không cần đụng vào code.
 *
 * Dùng flock() khi ghi file để tránh mất dữ liệu khi có nhiều yêu cầu ghi cùng lúc.
 */

define('THU_MUC_DU_LIEU', __DIR__ . '/../data');
define('FILE_NOI_DUNG', THU_MUC_DU_LIEU . '/content.json');
define('FILE_NGUOI_DUNG', THU_MUC_DU_LIEU . '/users.json');
define('FILE_DANG_KY', THU_MUC_DU_LIEU . '/dang-ky.json');

/**
 * Đọc một file JSON, trả về mảng liên hợp. Nếu file không tồn tại hoặc lỗi,
 * trả về $mac_dinh để trang vẫn hoạt động bình thường (không crash).
 */
function doc_json(string $duong_dan, array $mac_dinh = []): array
{
    if (!file_exists($duong_dan)) {
        return $mac_dinh;
    }
    $noi_dung = @file_get_contents($duong_dan);
    if ($noi_dung === false || trim($noi_dung) === '') {
        return $mac_dinh;
    }
    $du_lieu = json_decode($noi_dung, true);
    return is_array($du_lieu) ? $du_lieu : $mac_dinh;
}

/**
 * Ghi một mảng ra file JSON, có khoá file (flock) để an toàn khi ghi đồng thời.
 */
function ghi_json(string $duong_dan, array $du_lieu): bool
{
    $thu_muc = dirname($duong_dan);
    if (!is_dir($thu_muc)) {
        @mkdir($thu_muc, 0775, true);
    }
    $fp = @fopen($duong_dan, 'c+');
    if (!$fp) {
        return false;
    }
    $ket_qua = false;
    if (flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        rewind($fp);
        $json = json_encode($du_lieu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $ket_qua = fwrite($fp, $json) !== false;
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
    return $ket_qua;
}

/* ---------------------------------------------------------------------- */
/* Nội dung website (content.json): site, giai_doan, diem_manh, cam_nhan,  */
/* hoat_dong, so_lieu — mỗi danh mục là một mảng các item có khoá 'id'.    */
/* ---------------------------------------------------------------------- */

function doc_noi_dung(): array
{
    return doc_json(FILE_NOI_DUNG, []);
}

function ghi_noi_dung(array $du_lieu): bool
{
    return ghi_json(FILE_NOI_DUNG, $du_lieu);
}

function lay_danh_sach(string $khoa): array
{
    $nd = doc_noi_dung();
    return $nd[$khoa] ?? [];
}

function lay_thong_tin_truong(): array
{
    $nd = doc_noi_dung();
    return $nd['site'] ?? [];
}

function cap_nhat_thong_tin_truong(array $site_moi): bool
{
    $nd = doc_noi_dung();
    $nd['site'] = $site_moi;
    return ghi_noi_dung($nd);
}

/** Thêm một mục mới vào danh mục $khoa (ví dụ 'diem_manh', 'cam_nhan'...). */
function them_muc(string $khoa, array $item): string
{
    $nd = doc_noi_dung();
    $id = uniqid($khoa . '_', false);
    $item['id'] = $id;
    $nd[$khoa] = $nd[$khoa] ?? [];
    $nd[$khoa][] = $item;
    ghi_noi_dung($nd);
    return $id;
}

/** Cập nhật một mục theo id trong danh mục $khoa. */
function cap_nhat_muc(string $khoa, string $id, array $du_lieu_moi): bool
{
    $nd = doc_noi_dung();
    if (empty($nd[$khoa])) return false;
    foreach ($nd[$khoa] as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item = array_merge($item, $du_lieu_moi, ['id' => $id]);
            ghi_noi_dung($nd);
            return true;
        }
    }
    return false;
}

/** Xoá một mục theo id trong danh mục $khoa. */
function xoa_muc(string $khoa, string $id): bool
{
    $nd = doc_noi_dung();
    if (empty($nd[$khoa])) return false;
    $truoc = count($nd[$khoa]);
    $nd[$khoa] = array_values(array_filter($nd[$khoa], fn($item) => ($item['id'] ?? '') !== $id));
    if (count($nd[$khoa]) < $truoc) {
        ghi_noi_dung($nd);
        return true;
    }
    return false;
}

/** Đổi thứ tự hiển thị: hoán vị một mục lên trên / xuống dưới trong danh sách. */
function doi_thu_tu_muc(string $khoa, string $id, string $huong): bool
{
    $nd = doc_noi_dung();
    if (empty($nd[$khoa])) return false;
    $ds = $nd[$khoa];
    $vi_tri = null;
    foreach ($ds as $i => $item) {
        if (($item['id'] ?? '') === $id) { $vi_tri = $i; break; }
    }
    if ($vi_tri === null) return false;
    $moi = $huong === 'len' ? $vi_tri - 1 : $vi_tri + 1;
    if ($moi < 0 || $moi >= count($ds)) return false;
    [$ds[$vi_tri], $ds[$moi]] = [$ds[$moi], $ds[$vi_tri]];
    $nd[$khoa] = $ds;
    return ghi_noi_dung($nd);
}

/* ---------------------------------------------------------------------- */
/* Tài khoản quản trị (users.json)                                        */
/* ---------------------------------------------------------------------- */

function doc_nguoi_dung(): array
{
    return doc_json(FILE_NGUOI_DUNG, []);
}

function tim_nguoi_dung(string $ten_dang_nhap): ?array
{
    foreach (doc_nguoi_dung() as $nd) {
        if (($nd['ten_dang_nhap'] ?? '') === $ten_dang_nhap) return $nd;
    }
    return null;
}

/* ---------------------------------------------------------------------- */
/* Danh sách đăng ký tham quan (dang-ky.json) — gửi từ form Liên hệ        */
/* ---------------------------------------------------------------------- */

function doc_dang_ky(): array
{
    return doc_json(FILE_DANG_KY, []);
}

function them_dang_ky(array $item): string
{
    $ds = doc_dang_ky();
    $id = uniqid('dk_', false);
    $item['id'] = $id;
    $item['ngay_gui'] = date('Y-m-d H:i:s');
    $item['trang_thai'] = 'moi';
    $ds[] = $item;
    ghi_json(FILE_DANG_KY, $ds);
    return $id;
}

function cap_nhat_trang_thai_dang_ky(string $id, string $trang_thai): bool
{
    $ds = doc_dang_ky();
    foreach ($ds as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item['trang_thai'] = $trang_thai;
            ghi_json(FILE_DANG_KY, $ds);
            return true;
        }
    }
    return false;
}

function xoa_dang_ky(string $id): bool
{
    $ds = doc_dang_ky();
    $truoc = count($ds);
    $ds = array_values(array_filter($ds, fn($item) => ($item['id'] ?? '') !== $id));
    if (count($ds) < $truoc) {
        ghi_json(FILE_DANG_KY, $ds);
        return true;
    }
    return false;
}
