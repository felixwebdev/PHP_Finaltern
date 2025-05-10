<?php
require('../model/m_account.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$tenTK = trim($_POST['TenTK'] ?? '');
$email = trim($_POST['Email'] ?? '');
$sdt = trim($_POST['SDT'] ?? '');
$diaChi = trim($_POST['DiaChi'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirmPassword = trim($_POST['confirnPassword'] ?? '');



// Kiểm tra mật khẩu khớp nhau
if ($password !== $confirmPassword) {
    header("Location: ../signUp.php?error=passwordmismatch");
    exit();
}

$acc = new M_account();

// Kiểm tra tài khoản đã tồn tại
if ($acc->isUserExist($email, $sdt)) {
    header("Location: ../signUp.php?error=exists");
    exit();
}

// Thêm tài khoản
if ($acc->insertAccount($tenTK, $email, $sdt, $diaChi, $password)) {
    header("Location: ../signIn.php?register=success");
    exit();
} else {
    header("Location: ../signUp.php?error=insertfail");
    exit();
}
