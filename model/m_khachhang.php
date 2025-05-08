<?php

class KhachHangModel {
    public $id, $ten_khach, $email, $trang_thai, $ngay_tham_gia;
    public static $khachHang = [];

    public function __construct($id, $ten_khach, $email, $trang_thai, $ngay_tham_gia) {
        $this->id = $id;
        $this->ten_khach = $ten_khach;
        $this->email = $email;
        $this->trang_thai = $trang_thai;
        $this->ngay_tham_gia = $ngay_tham_gia;
    }

    // Hàm khởi tạo dữ liệu giả
    public static function initData() {
        if (empty(self::$khachHang)) {
            self::$khachHang = [
                ['id' => 1, 'ten_khach' => 'Nguyễn A', 'email' => 'nguyena@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-01-01'],
                ['id' => 2, 'ten_khach' => 'Nguyễn B', 'email' => 'nguyenb@example.com', 'trang_thai' => 'Đang khóa', 'ngay_tham_gia' => '2025-02-01'],
                ['id' => 3, 'ten_khach' => 'Nguyễn C', 'email' => 'nguyenc@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-03-01'],
                ['id' => 4, 'ten_khach' => 'Nguyễn D', 'email' => 'nguyend@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-04-01'],
                ['id' => 1, 'ten_khach' => 'Nguyễn A', 'email' => 'nguyena@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-01-01'],
                ['id' => 2, 'ten_khach' => 'Nguyễn B', 'email' => 'nguyenb@example.com', 'trang_thai' => 'Đang khóa', 'ngay_tham_gia' => '2025-02-01'],
                ['id' => 3, 'ten_khach' => 'Nguyễn C', 'email' => 'nguyenc@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-03-01'],
                ['id' => 4, 'ten_khach' => 'Nguyễn D', 'email' => 'nguyend@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-04-01'],
                ['id' => 1, 'ten_khach' => 'Nguyễn A', 'email' => 'nguyena@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-01-01'],
                ['id' => 2, 'ten_khach' => 'Nguyễn B', 'email' => 'nguyenb@example.com', 'trang_thai' => 'Đang khóa', 'ngay_tham_gia' => '2025-02-01'],
                ['id' => 3, 'ten_khach' => 'Nguyễn C', 'email' => 'nguyenc@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-03-01'],
                ['id' => 4, 'ten_khach' => 'Nguyễn D', 'email' => 'nguyend@example.com', 'trang_thai' => 'Hoạt động', 'ngay_tham_gia' => '2025-04-01'],
            ];
        }
    }

    // Lọc dữ liệu khách hàng
    public static function getFiltered($ten_khach = null, $email = null, $trang_thai = null) {
        self::initData();

        return array_filter(self::$khachHang, function ($kh) use ($ten_khach, $email, $trang_thai) {
            if ($ten_khach && stripos($kh['ten_khach'], $ten_khach) === false) return false;
            if ($email && stripos($kh['email'], $email) === false) return false;
            if ($trang_thai && $kh['trang_thai'] !== $trang_thai) return false;
            return true;
        });
    }

    // Phân trang dữ liệu khách hàng
    public static function getPagedData($page, $perPage) {
        self::initData();
        $total = count(self::$khachHang);
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        $pagedData = array_slice(self::$khachHang, $offset, $perPage);

        return [
            'khachHangs' => $pagedData,
            'total_pages' => $totalPages,
            'current_page' => $page
        ];
    }
    public static function xoaTheoId($id) {
        self::initData();
        foreach (self::$khachHang as $index => $kh) {
            if ($kh['id'] == $id) {
                unset(self::$khachHang[$index]);
            }
        }
        // Sắp xếp lại key sau khi unset để tránh lỗi hiển thị
        self::$khachHang = array_values(self::$khachHang);
    }
}
?>
