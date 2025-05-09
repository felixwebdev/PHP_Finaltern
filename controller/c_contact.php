<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Nhận dữ liệu từ form
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? 'Không có chủ đề';
$message = $_POST['message'] ?? '';

$mail = new PHPMailer(true);

try {
    // Cấu hình SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // Tài khoản Gmail của bạn
    $mail->Username = 'yourgmail@gmail.com';
    $mail->Password = 'your_app_password'; // Chú ý: dùng App Password chứ không phải mật khẩu Gmail

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Gửi từ đâu
    $mail->setFrom('yourgmail@gmail.com', 'Website PSHOP');
    $mail->addAddress('yourgmail@gmail.com'); // Gửi về chính bạn

    // Nội dung email
    $mail->isHTML(true);
    $mail->Subject = "[PHẢN HỒI PSHOP] $subject";
    $mail->Body    = "
        <b>Họ tên:</b> $name<br>
        <b>Email:</b> $email<br>
        <b>Nội dung:</b><br>$message
    ";

    $mail->send();
    echo "<script>alert('Phản hồi của bạn đã được gửi!');window.location.href='contact.php';</script>";
} catch (Exception $e) {
    echo "Lỗi khi gửi mail: {$mail->ErrorInfo}";
}
