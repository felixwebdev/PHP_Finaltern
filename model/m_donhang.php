<?php
    require_once("m_database.php");
    class DonHangModel {
        public $id, $ten_khach, $san_pham, $loai, $ngay_dat, $ngay_giao, $tong_tien, $trang_thai;
    
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
    
        // Lấy dữ liệu từ database
        public static function getFiltered($trang_thai = null, $loai = null, $from = null, $to = null) {
            $db = new M_database();
            $sql = "SELECT * FROM DonHang WHERE 1";
    
            // Thêm điều kiện vào câu truy vấn nếu có các bộ lọc
            if ($trang_thai) {
                $sql .= " AND TrangThai = '$trang_thai'";
            }
            if ($loai) {
                $sql .= " AND PhanLoai = '$loai'";
            }
            if ($from) {
                $sql .= " AND NgayDat >= '$from'";
            }
            if ($to) {
                $sql .= " AND NgayDat <= '$to'";
            }
    
            $db->setQuery($sql);
            $result = $db->excuteQuery();
    
            $donHangList = [];
            while ($row = $result->fetch_assoc()) {
                $donHangList[] = new DonHangModel(
                    $row['MaDH'],
                    $row['TenKH'],
                    $row['TenSP'],
                    $row['PhanLoai'],
                    $row['NgayDat'],
                    $row['NgayGiao'],
                    $row['GiaTien'],
                    $row['TrangThai']
                );
            }
            $db->close();
            return $donHangList;
        }
    
        // Lấy dữ liệu với phân trang
        public static function getPagedData($page, $perPage) {
            $db = new M_database();
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM DonHang LIMIT $offset, $perPage";
    
            $db->setQuery($sql);
            $result = $db->excuteQuery();
    
            $donHangList = [];
            while ($row = $result->fetch_assoc()) {
                $donHangList[] = new DonHangModel(
                    $row['MaDH'],
                    $row['TenKH'],
                    $row['TenSP'],
                    $row['PhanLoai'],
                    $row['NgayDat'],
                    $row['NgayGiao'],
                    $row['GiaTien'],
                    $row['TrangThai']
                );
            }
    
            // Đếm tổng số trang
            $sqlCount = "SELECT COUNT(*) AS total FROM DonHang";
            $db->setQuery($sqlCount);
            $resultCount = $db->excuteQuery();
            $total = $resultCount->fetch_assoc()['total'];
            $totalPages = ceil($total / $perPage);
    
            $db->close();
    
            return [
                'donHangs' => $donHangList,
                'total_pages' => $totalPages,
                'current_page' => $page
            ];
        }
    }
    
?>
