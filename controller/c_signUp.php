<?php
require('../model/m_account.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Tạo phương thức get set giống như thầy làm mẫu
//Dùng hàm isUserExist để check
//Nếu isUserExist báo tài khoản kh tồn tại thì Create nó


$tenTK = trim($_POST['TenTK'] ?? '');
$email = trim($_POST['Email'] ?? '');
$sdt = trim($_POST['SDT'] ?? '');
$diaChi = trim($_POST['DiaChi'] ?? '');




$acc = new M_account();


if ($acc->isUserExist($email, $sdt)) {
    header("Location: ../signUp.php?error=insertfail");
    exit();
}


if ($acc->insertAccount($tenTK, $email, $sdt, $diaChi)) {
    header("Location: ../signIn.php");
    exit();
} else {
    header("Location: ../signUp.php?error=insertfail");
    exit();
}
