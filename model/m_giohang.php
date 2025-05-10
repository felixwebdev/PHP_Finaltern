<?php
include_once("m_database.php");
$db = new M_database();
class M_giohang extends M_database
{
    public function getCartItems($maTK)
    {
        $this->setQuery("SELECT * FROM Cart WHERE MaTK = ? AND State = 'chưa thanh toán'");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("i", $maTK);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getCartItem($maTK, $maSP)
    {
        $this->setQuery("SELECT * FROM Cart WHERE MaTK = ? AND MaSP = ?");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("is", $maTK, $maSP);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getQuantity($maTK, $maSP)
    {
        $this->setQuery("SELECT SoLuong FROM Cart WHERE MaTK = ? AND MaSP = ?");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("is", $maTK, $maSP);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addToCart($maTK, $maSP, $soLuong, $giaTien, $state)
    {
        $this->setQuery("INSERT INTO Cart (MaTK, MaSP, SoLuong, GiaTien, State) VALUES (?, ?, ?, ?, ?)");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("isiss", $maTK, $maSP, $soLuong, $giaTien, $state);
        $stmt->execute();

        $this->setQuery("UPDATE Products SET SoLuong = SoLuong - ? WHERE MaSP = ?");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("is", $soLuong, $maSP);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function updateCart($maTK, $maSP, $soLuong)
    {
        $this->setQuery("UPDATE Cart SET SoLuong = SoLuong + ? WHERE MaTK = ? AND MaSP = ?");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("iis", $soLuong, $maTK, $maSP);
        $stmt->execute();
        $this->setQuery("UPDATE Products SET SoLuong = SoLuong - ? WHERE MaSP = ?");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("is", $soLuong, $maSP);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function removeFromCart($maTK, $maSP)
    {
        $result = $this->getQuantity($maTK, $maSP);
        $row = $result->fetch_assoc();
        $soLuong = $row['SoLuong'] ?? 0;

        $this->setQuery("DELETE FROM Cart WHERE MaTK = ? AND MaSP = ?");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("is", $maTK, $maSP);
        $stmt->execute();

        $this->setQuery("UPDATE Products SET SoLuong = SoLuong + ? WHERE MaSP = ?");
        $stmt = $this->conn->prepare($this->query);
        $stmt->bind_param("is", $soLuong, $maSP);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function excuteQuery($params = [])
    {
        // Nếu không có truy vấn đã chuẩn bị, trả về false
        if ($this->query == '') {
            return false;
        }

        // Thực thi truy vấn với các tham số
        $stmt = $this->conn->prepare($this->query);
        if ($stmt === false) {
            return false;
        }

        // Ràng buộc tham số
        if (!empty($params)) {
            // Lấy loại tham số
            $types = str_repeat('s', count($params));  // Giả sử tất cả các tham số là chuỗi
            $stmt->bind_param($types, ...$params);
        }

        // Thực hiện câu lệnh
        if ($stmt->execute()) {
            return $stmt; // Trả về đối tượng stmt nếu truy vấn thành công
        }

        return false; // Trả về false nếu có lỗi
    }

    // Hàm thanh toán toàn bộ giỏ hàng theo MaTK
    public function thanhToanGioHang($maTK)
    {
        // Câu truy vấn SQL
        $sql = "UPDATE Cart 
            SET State = 'đã thanh toán' 
            WHERE MaTK = ? AND State = 'chưa thanh toán'";

        // Thực hiện truy vấn
        $this->setQuery($sql);
        $stmt = $this->excuteQuery([$maTK]);

        // Kiểm tra xem $stmt có phải là một đối tượng hợp lệ không
        if ($stmt === false) {
            // Nếu có lỗi trong truy vấn, trả về false
            return false;
        }

        // Kiểm tra số lượng dòng bị ảnh hưởng
        return $stmt->affected_rows > 0;
    }
}
