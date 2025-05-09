<?php 
    session_start();
    require_once("m_database.php");
    class M_account extends M_database {
        //Hàm insert account
        //Hàm isUserExist để check tài khoản đã tồn tại hay chưa
        //Hàm findUser để check lúc đăng nhập
    }

    $_SESSION['user_id'] = "123";
    $_SESSION['username'] = "JohnDoe";
    $_SESSION['levelID'] = 0;
?>