<?php
session_start();
include('../model/m_database.php');

$maKH = $_SESSION['user_id'] ?? 0;
$maSP = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
$soLuong = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($maKH <= 0 || $maSP <= 0 || $soLuong <= 0) {
    die("Thiếu thông tin hoặc không hợp lệ.");
}

$db = new M_database();

// Lấy giá sản phẩm
$db->setQuery("SELECT GiaTien FROM products WHERE MaSP = $maSP");

$result = $db->excuteQuery();
$row = $result->fetch_assoc();
$gia = $row['GiaTien'] ?? 0;

// Kiểm tra nếu sản phẩm đã có trong giỏ => update
$db->setQuery("SELECT * FROM cart WHERE MaTK = $maKH AND MaSP = $maSP AND State = 'chưa thanh toán'");
$res = $db->excuteQuery();

if ($res && $res->num_rows > 0) {
    $db->setQuery("UPDATE cart 
                   SET SoLuong = SoLuong + $soLuong, GiaTien = $gia
                   WHERE MaTK = $maKH AND MaSP = $maSP AND State = 'chưa thanh toán'");
} else {
    $db->setQuery("INSERT INTO cart (MaTK, MaSP, SoLuong, GiaTien, State)
                   VALUES ($maKH, $maSP, $soLuong, $gia, 'chưa thanh toán')");
}

$db->excuteQuery();
$db->close();

// Chuyển hướng về trang giỏ hàng
header("Location: index.php");
exit;
