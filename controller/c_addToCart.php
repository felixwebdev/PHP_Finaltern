<?php
    session_start();
    include('../model/m_database.php');
    $db = new M_database();

    $maKH = $_SESSION['user_id'] ?? 0;
    $maSP = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
    $soLuong = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($maKH <= 0 || $maSP <= 0 || $soLuong <= 0) {
        die("Thiếu thông tin hoặc không hợp lệ.");
    }

    // Lấy giá sản phẩm
    $db->setQuery("SELECT GiaTien FROM products WHERE MaSP = '$maSP'");
    $result = $db->excuteQuery();
    $row = $result ? $result->fetch_assoc() : null;

    if (!$row) {
        die("Không tìm thấy sản phẩm.");
    }

    $gia = $row['GiaTien'];

    // Kiểm tra nếu sản phẩm đã có trong giỏ => update
    $db->setQuery("SELECT * FROM cart WHERE MaTK = $maKH AND MaSP = '$maSP' AND State = 'chưa thanh toán'");
    $res = $db->excuteQuery();

    if ($res && $res->num_rows > 0) {
        $db->setQuery("UPDATE cart 
                    SET SoLuong = SoLuong + $soLuong
                    WHERE MaTK = $maKH AND MaSP = '$maSP' AND State = 'chưa thanh toán'");
    } else {
        $db->setQuery("INSERT INTO cart (MaTK, MaSP, SoLuong, GiaTien, State)
                    VALUES ($maKH, '$maSP', $soLuong, $gia, 'chưa thanh toán')");
    }

    $db->excuteQuery();
    $db->close();

    header("Location: ../index.php");
    exit;
?>
