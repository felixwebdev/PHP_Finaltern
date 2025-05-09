<?php
    require_once "./model/m_donhang.php";

    class DonHangController {
        public function locDonHang($page) {
            // Lấy dữ liệu từ các tham số GET
            $trang_thai = $_GET['trang_thai'] ?? null;
            $loai = $_GET['loai'] ?? null;
            $from_date = $_GET['from_date'] ?? null;
            $to_date = $_GET['to_date'] ?? null;
    
            // Lọc dữ liệu đơn hàng
            $filteredDonHang = DonHangModel::getFiltered($trang_thai, $loai, $from_date, $to_date);
    
            // Phân trang
            $perPage = 5; // Số đơn hàng mỗi trang
            return DonHangModel::getPagedData($page, $perPage);
        }
    }
?>
