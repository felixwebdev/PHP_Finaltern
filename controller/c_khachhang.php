<?php
require_once './model/m_khachhang.php';

class KhachHangController {

    public function getKhachHangs() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $recordsPerPage = 5;
        $start = ($page - 1) * $recordsPerPage;
    
        // Lấy danh sách khách hàng từ model
        $khachHangs = KhachHangModel::getAll($start, $recordsPerPage);
    
        // Tính tổng số bản ghi
        $totalRecords = KhachHangModel::countAll();  // Cần viết một hàm đếm tổng số bản ghi
        $totalPages = ceil($totalRecords / $recordsPerPage);  // Tính số trang
    
        return [
            'khachHangs' => $khachHangs,  // Mảng khách hàng
            'total_pages' => $totalPages,  // Tổng số trang
            'current_page' => $page      // Trang hiện tại
        ];
    }
    
    
    
}
?>
