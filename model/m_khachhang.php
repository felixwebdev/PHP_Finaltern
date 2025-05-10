<?php
    require_once("m_database.php");
    class KhachHangModel {
    public $id, $ten_khach, $email, $trang_thai, $ngay_tham_gia;
    public static $khachHang = [];

    // Hàm lấy tất cả khách hàng từ database
    public static function getAll($start, $recordsPerPage) {
        // Khởi tạo kết nối với database
        $db = new M_database();
        
        // Truy vấn lấy khách hàng từ vị trí $start và giới hạn $recordsPerPage
        $sql = "SELECT * FROM Account LIMIT $start, $recordsPerPage";
        $db->setQuery($sql);
        
        // Thực thi truy vấn
        $result = $db->excuteQuery();
        
        $khachHangs = [];
        // Kiểm tra xem có dữ liệu không
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $khachHangs[] = [
                    'id' => $row['MaTK'],
                    'ten_khach' => $row['TenTK'],
                    'email' => $row['Email'],
                    'trang_thai' => $row['LevelID'] == 0 ? 'Đang khóa' : 'Hoạt động', // Giả định LevelID 0 là "Đang khóa"
                    'ngay_tham_gia' => $row['NgayThamGia']
                ];
            }
        }
    
        // Đóng kết nối sau khi thực hiện xong
        $db->close();
    
        return $khachHangs;
    }
    
    public static function countAll() {
        // Khởi tạo kết nối với database
        $db = new M_database();
    
        // Truy vấn đếm tổng số khách hàng
        $sql = "SELECT COUNT(*) AS total FROM Account";
        $db->setQuery($sql);
    
        // Thực thi truy vấn
        $result = $db->excuteQuery();
        
        // Lấy tổng số bản ghi
        $row = $result->fetch_assoc();
        $totalRecords = $row['total'];
    
        // Đóng kết nối sau khi thực hiện xong
        $db->close();
    
        return $totalRecords;
    }
}
?>
