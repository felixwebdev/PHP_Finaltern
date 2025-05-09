<?php
    session_start();
    include('../model/m_database.php');

    $maKH = $_SESSION['user_id'] ?? 0;
    if ($maKH <= 0) die("Không xác định người dùng.");

    $hoTen = $_POST['HoTen'] ?? '';
    $email = $_POST['Email'] ?? '';
    $sdt = $_POST['SDT'] ?? '';
    $diaChi = $_POST['DiaChi'] ?? '';

    $db = new M_database();
    $db->setQuery("UPDATE account SET TenTK='$hoTen', Email='$email', SDT='$sdt', DiaChi='$diaChi' WHERE MaTK=$maKH");
    $db->excuteQuery();
    $db->close();

    header("Location: ../user.php");
exit;
