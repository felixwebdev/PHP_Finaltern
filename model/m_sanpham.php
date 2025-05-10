<?php
    require_once("m_database.php");

    class SanPhamModel extends M_database {
        public $maSP, $tenSP, $phanLoai, $giaTien, $soLuong, $imageSP, $sold, $ngayNhap;

        // Constructor
        public function __construct($maSP, $tenSP, $phanLoai, $giaTien, $soLuong, $imageSP, $sold, $ngayNhap) {
            $this->maSP = $maSP;
            $this->tenSP = $tenSP;
            $this->phanLoai = $phanLoai;
            $this->giaTien = $giaTien;
            $this->soLuong = $soLuong;
            $this->imageSP = $imageSP;
            $this->sold = $sold;
            $this->ngayNhap = $ngayNhap;
        }

        // Insert a new product
        public static function insertSanPham($maSP, $tenSP, $phanLoai, $giaTien, $soLuong, $imageSP, $sold, $ngayNhap) {
            $db = new M_database();
            $sql = "INSERT INTO Products (MaSP, TenSP, PhanLoai, GiaTien, SoLuong, ImageSP, Sold, NgayNhap) 
            VALUES ('$maSP', '$tenSP', '$phanLoai', '$giaTien', '$soLuong', '$imageSP', '$sold', '$ngayNhap')";
    
            $db->setQuery($sql);
            $db->excuteQuery();
            $db->close();
            return true;
        }

        // Get all products
        public static function getAll() {
            $db = new M_database();
            $sql = "SELECT * FROM Products";
            $db->setQuery($sql);
            $result = $db->excuteQuery();

            $sanPhamList = [];
            while ($row = $result->fetch_assoc()) {
                $sanPhamList[] = new SanPhamModel(
                    $row['MaSP'],
                    $row['TenSP'],
                    $row['PhanLoai'],
                    $row['GiaTien'],
                    $row['SoLuong'],
                    $row['ImageSP'],
                    $row['Sold'],
                    $row['NgayNhap']
                );
            }

            $db->close();
            return $sanPhamList;
        }

        // Delete a product by ID
        public static function deleteSanPhamById($maSP) {
            $db = new M_database();
            $sql = "DELETE FROM Products WHERE MaSP = '$maSP'";
            $db->setQuery($sql);
            $db->excuteQuery();
            $db->close();
            return true;
        }

        // Update a product by ID (optional feature)
        public static function updateSanPham($maSP, $tenSP, $phanLoai, $giaTien, $soLuong, $imageSP, $sold) {
            $db = new M_database();
            $sql = "UPDATE Products SET 
                    TenSP = '$tenSP', 
                    PhanLoai = '$phanLoai', 
                    GiaTien = '$giaTien', 
                    SoLuong = '$soLuong', 
                    ImageSP = '$imageSP', 
                    Sold = '$sold'
                    WHERE MaSP = '$maSP'";
            $db->setQuery($sql);
            $db->excuteQuery();
            $db->close();
            return true;
        }
    }
?>
