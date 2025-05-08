<?php
require('../model/m_account.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lấy dữ liệu từ form
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// Kiểm tra đầu vào
if (empty($email) || empty($phone)) {
    die('Vui lòng nhập đầy đủ thông tin.');
}

// Xác định là email hay số điện thoại
$is_email = filter_var($email, FILTER_VALIDATE_EMAIL);
$is_phone = preg_match('/^0\d{9}$/', $email); // Bắt đầu bằng 0, 10 số

if (!$is_email && !$is_phone) {
    die('Email hoặc số điện thoại không hợp lệ.');
}

$acc = new M_account();
$result = $acc->findAccount($email, $phone);


if ($result && $result->num_rows > 0) {
    $account = $result->fetch_assoc();

    // Lưu thông tin vào session
    // $_SESSION['MaTK'] = $account['MaTK'];
    $_SESSION['TenTK'] = $account['TenTK'];
    $_SESSION['LevelID'] = $account['LevelID'];

    // Điều hướng
    if ($account['LevelID'] == 1) {
        header('Location: ../admin/dashboard.php');
    } else {
        header('Location: ../index.php');
    }
    exit();
} else {
    header('Location: ../signIn.php?error=invalid');
    exit();
}
