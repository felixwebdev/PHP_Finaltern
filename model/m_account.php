<?php
session_start();
require_once("m_database.php");
class M_account extends M_database
{
    //Hàm insert account
    //Hàm isUserExist để check tài khoản đã tồn tại hay chưa
    //Hàm findUser để check lúc đăng nhập
    public function findAccount($email, $phone)
    {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM account WHERE Email = ? AND SDT = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function isUserExist($email, $phone)
    {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM account WHERE Email = ? OR SDT = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result && $result->num_rows > 0);
    }

    public function insertAccount($tenTK, $email, $phone, $diaChi)
    {
        $conn = $this->getConnection();
        $level = 0; // mặc định user thường

        $stmt = $conn->prepare("INSERT INTO account (TenTK, Email, SDT, DiaChi, LevelID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $tenTK, $email, $phone, $diaChi, $level);
        return $stmt->execute();
    }

}

$_SESSION['user_id'] = "123";
$_SESSION['username'] = "JohnDoe";
$_SESSION['levelID'] = 0;

?>