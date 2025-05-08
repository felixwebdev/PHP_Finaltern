<?php 
    require('../model/m_account.php');
    session_start();
    //Kiểm tra email vs sdt có trong account không?
    //Tự viết hàm findAccount, check nó bằng cách ktra giá trị trả về là null hoặc có value
    //Mẫu if ($result && $result->num_rows > 0)

    //Chúng ta sẽ có 2 loại tài khoản là LevelID 1 sẽ là Admin, và LevelID 0 là người dùng
    //Lúc user đăng nhập, hãy check cả LevelID nếu bằng 0 thì cứ chuyển qua trang bình thường
    //Nếu LevelID = 1 hãy chuyển qua trang của Admin
?>