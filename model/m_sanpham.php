<?php
    class SanPhamModel {
        public $img, $ten, $danh_muc, $gia, $so_luong, $ngay, $trang_thai;
        
        public static $sanPham = [];

        public function __construct($img, $ten, $danh_muc, $gia, $so_luong, $ngay, $trang_thai) {
            $this->img = $img;
            $this->ten = $ten;
            $this->danh_muc = $danh_muc;
            $this->gia = $gia;
            $this->so_luong = $so_luong;
            $this->ngay = $ngay;
            $this->trang_thai = $trang_thai;
        }

        // Tạo dữ liệu mẫu ban đầu
        public static function initData() {
            if (empty(self::$sanPham)) {
                self::$sanPham = [
                    new SanPhamModel("image/products/ao thun nam.jpg", "Áo thun nam", "Thời trang", 250000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/ps5.jpeg", "Play Station 5", "Điện tử", 15000000, 0, "2025-05-05", 0),
                    new SanPhamModel("image/products/mi cay.jfif", "Mì cay", "Thực phẩm", 45000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/ao thun nam.jpg", "Áo thun nam", "Thời trang", 250000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/ps5.jpeg", "Play Station 5", "Điện tử", 15000000, 0, "2025-05-05", 0),
                    new SanPhamModel("image/products/mi cay.jfif", "Mì cay", "Thực phẩm", 45000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/quan jean nu.jfif", "Quần jean nữ", "Thời trang", 250000, 25, "2024-05-05", 1),
                    new SanPhamModel("image/products/ao thun nam.jpg", "Áo thun nam 2", "Thời trang", 250000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/ao thun nam.jpg", "Áo thun nam", "Thời trang", 250000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/ps5.jpeg", "Play Station 5", "Điện tử", 15000000, 0, "2025-05-05", 0),
                    new SanPhamModel("image/products/mi cay.jfif", "Mì cay", "Thực phẩm", 45000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/quan jean nu.jfif", "Quần jean nữ", "Thời trang", 250000, 25, "2024-05-05", 1),
                    new SanPhamModel("image/products/ao thun nam.jpg", "Áo thun nam 2", "Thời trang", 250000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/ao thun nam.jpg", "Áo thun nam", "Thời trang", 250000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/ps5.jpeg", "Play Station 5", "Điện tử", 15000000, 0, "2025-05-05", 0),
                    new SanPhamModel("image/products/mi cay.jfif", "Mì cay", "Thực phẩm", 45000, 30, "2025-05-05", 1),
                    new SanPhamModel("image/products/quan jean nu.jfif", "Quần jean nữ", "Thời trang", 250000, 25, "2024-05-05", 1),
                    new SanPhamModel("image/products/ao thun nam.jpg", "Áo thun nam 2", "Thời trang", 250000, 30, "2025-05-05", 1),
                    // thêm nếu muốn
                ];
            }
        }

        public static function insertSanPham($img, $ten, $danh_muc, $gia, $so_luong, $ngay, $trang_thai) {
            $sp = new SanPhamModel($img, $ten, $danh_muc, $gia, $so_luong, $ngay, $trang_thai);
            self::$sanPham[] = $sp;
            return true;
        }

        public static function getAll() {
            self::initData(); // đảm bảo dữ liệu mẫu có trước
            return self::$sanPham;
        }
        public static function deleteSanPhamByIndex($index) {
            self::initData();
            if (isset(self::$sanPham[$index])) {
                array_splice(self::$sanPham, $index, 1);
                return true;
            }
            return false;
        }
    }


?>