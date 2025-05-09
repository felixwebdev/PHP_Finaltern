<?php

require_once './model/m_khachhang.php';

class KhachHangController {

    public function getKhachHangs($filters, $page) {
        $dsKhach = KhachHangModel::getFiltered(
            $filters['ten_khach'] ?? null,
            $filters['email'] ?? null,
            $filters['trang_thai'] ?? null
        );

        $tong = count($dsKhach);
        $limit = 5;
        $tong_trang = ceil($tong / $limit);
        $bat_dau = ($page - 1) * $limit;
        $dsPhanTrang = array_slice($dsKhach, $bat_dau, $limit);

        return [
            'khachHangs' => $dsPhanTrang,
            'total_pages' => $tong_trang,
            'current_page' => $page
        ];
    }
}
?>
