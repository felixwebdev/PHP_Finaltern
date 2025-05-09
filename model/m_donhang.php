<?php

class DonHangModel {
    public $id, $ten_khach, $san_pham, $loai, $ngay_dat, $ngay_giao, $tong_tien, $trang_thai;

    public static $donHang = [];

    public function __construct($id, $ten_khach, $san_pham, $loai, $ngay_dat, $ngay_giao, $tong_tien, $trang_thai) {
        $this->id = $id;
        $this->ten_khach = $ten_khach;
        $this->san_pham = $san_pham;
        $this->loai = $loai;
        $this->ngay_dat = $ngay_dat;
        $this->ngay_giao = $ngay_giao;
        $this->tong_tien = $tong_tien;
        $this->trang_thai = $trang_thai;
    }

    public static function initData() {
        if (empty(self::$donHang)) {
            self::$donHang = [
                new DonHangModel(1, "Nguyễn Văn A", "Áo thun nam", "Thời trang", "2025-05-01", "2025-05-04", 250000, "Đã giao"),
                new DonHangModel(2, "Trần Thị B", "Mì cay", "Thực phẩm", "2025-05-02", null, 45000, "Chờ lấy hàng"),
                new DonHangModel(3, "Lê Văn C", "PS5", "Điện tử", "2025-05-03", null, 15000000, "Đang giao"),
                new DonHangModel(4, "Ngô Thanh D", "Laptop", "Điện tử", "2025-05-04", "2025-05-06", 25000000, "Đã giao"),
                new DonHangModel(5, "Phạm Thị E", "Váy nữ", "Thời trang", "2025-05-05", null, 350000, "Chờ lấy hàng"),
                new DonHangModel(1, "Nguyễn Văn A", "Áo thun nam", "Thời trang", "2025-05-01", "2025-05-04", 250000, "Đã giao"),
                new DonHangModel(2, "Trần Thị B", "Mì cay", "Thực phẩm", "2025-05-02", null, 45000, "Chờ lấy hàng"),
                new DonHangModel(3, "Lê Văn C", "PS5", "Điện tử", "2025-05-03", null, 15000000, "Đang giao"),
                new DonHangModel(4, "Ngô Thanh D", "Laptop", "Điện tử", "2025-05-04", "2025-05-06", 25000000, "Đã giao"),
                new DonHangModel(5, "Phạm Thị E", "Váy nữ", "Thời trang", "2025-05-05", null, 350000, "Chờ lấy hàng"),
                new DonHangModel(1, "Nguyễn Văn A", "Áo thun nam", "Thời trang", "2025-05-01", "2025-05-04", 250000, "Đã giao"),
                new DonHangModel(2, "Trần Thị B", "Mì cay", "Thực phẩm", "2025-05-02", null, 45000, "Chờ lấy hàng"),
                new DonHangModel(3, "Lê Văn C", "PS5", "Điện tử", "2025-05-03", null, 15000000, "Đang giao"),
                new DonHangModel(4, "Ngô Thanh D", "Laptop", "Điện tử", "2025-05-04", "2025-05-06", 25000000, "Đã giao"),
                new DonHangModel(5, "Phạm Thị E", "Váy nữ", "Thời trang", "2025-05-05", null, 350000, "Chờ lấy hàng"),
                new DonHangModel(1, "Nguyễn Văn A", "Áo thun nam", "Thời trang", "2025-05-01", "2025-05-04", 250000, "Đã giao"),
                new DonHangModel(2, "Trần Thị B", "Mì cay", "Thực phẩm", "2025-05-02", null, 45000, "Chờ lấy hàng"),
                new DonHangModel(3, "Lê Văn C", "PS5", "Điện tử", "2025-05-03", null, 15000000, "Đang giao"),
                new DonHangModel(4, "Ngô Thanh D", "Laptop", "Điện tử", "2025-05-04", "2025-05-06", 25000000, "Đã giao"),
                new DonHangModel(5, "Phạm Thị E", "Váy nữ", "Thời trang", "2025-05-05", null, 350000, "Chờ lấy hàng")
                
            ];
        }
    }

    public static function getFiltered($trang_thai = null, $loai = null, $from = null, $to = null) {
        self::initData();

        return array_filter(self::$donHang, function ($dh) use ($trang_thai, $loai, $from, $to) {
            if ($trang_thai && $dh->trang_thai !== $trang_thai) return false;
            if ($loai && $dh->loai !== $loai) return false;
            if ($from && $dh->ngay_dat < $from) return false;
            if ($to && $dh->ngay_dat > $to) return false;
            return true;
        });
    }

    public static function getPagedData($page, $perPage) {
        $filteredData = self::$donHang;
        $total = count($filteredData);
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        $pagedData = array_slice($filteredData, $offset, $perPage);

        return [
            'donHangs' => $pagedData,
            'total_pages' => $totalPages,
            'current_page' => $page
        ];
    }
}
?>
