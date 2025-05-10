<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("model/m_giohang.php");

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Bạn cần đăng nhập để thanh toán!');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$maTK = $_SESSION['user_id'] ?? 0;

// echo "MaTK hiện tại là: " . $maTK . "<br>";

$gioHang = new M_giohang();
$result = $gioHang->thanhToanGioHang($maTK);
// Nếu thanh toán thành công, chuyển hướng về trang chủ
if ($result) {
    echo "<script>
        alert('Thanh toán thành công!');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
        alert('Thanh toán thất bại!');
        window.location.href = 'index.php';
    </script>";
}
