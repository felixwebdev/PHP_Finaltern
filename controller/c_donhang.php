<?php
    require_once "./model/m_donhang.php";

    class DonHangController {
        public function locDonHang($page) {
            // Lấy các tham số lọc từ form
            $ten_khach = $_GET['ten_khach'] ?? null;
            $trang_thai = $_GET['trang_thai'] ?? null;
            $loai = $_GET['loai'] ?? null;
            $ngay_dat = $_GET['ngay_dat'] ?? null;
            $ngay_giao = $_GET['ngay_giao'] ?? null;
    
            // Xử lý bộ lọc ngày tháng
            $from = $ngay_dat ? $ngay_dat : null;
            $to = $ngay_giao ? $ngay_giao : null;
    
            // Lấy dữ liệu đơn hàng từ model với bộ lọc
            $donHangs = DonHangModel::getFiltered($trang_thai, $loai, $from, $to);
    
            // Phân trang
            $perPage = 5; // số đơn hàng mỗi trang
            $result = DonHangModel::getPagedData($page, $perPage);
    
            return $result;
        }
    }
    
?>
