<?php include('template/head.php') ?>
<?php include('template/header.php') ?>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .main__container {
        max-width: 900px;
        margin: 40px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 5px;
        margin-bottom: 20px;
    }

    form input[type="text"],
    form input[type="email"],
    form textarea {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: border 0.3s ease;
    }

    form input:focus,
    form textarea:focus {
        border-color: #3498db;
        outline: none;
    }

    form button {
        padding: 10px 20px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }

    form button:hover {
        background-color: #2980b9;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #ecf0f1;
        color: #2c3e50;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    @media screen and (max-width: 600px) {
        .main__container {
            padding: 20px;
        }

        table, thead, tbody, th, td, tr {
            display: block;
        }

        table tr {
            margin-bottom: 15px;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
        }

        table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
        }

        table td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            width: 45%;
            font-weight: bold;
            text-align: left;
        }
    }
</style>

<div class="main__container">
    <?php
        include_once('model/m_database.php');
        $db = new M_database();
        $maKH = $_SESSION['user_id'] ?? 0;
        if ($maKH <= 0) die("Vui lòng đăng nhập");

        $db->setQuery("SELECT * FROM account WHERE MaTK = $maKH");
        $user = $db->excuteQuery()->fetch_assoc();

        // Lấy lịch sử đơn hàng
        $db->setQuery("SELECT * FROM cart WHERE MaTK = $maKH");
        $orders = $db->excuteQuery();

        $db->close();
    ?>

    <h2>Thông tin cá nhân</h2>
    <form action="controller/c_updateProfile.php" method="post">
        <label for="HoTen">Họ tên:</label>
        <input type="text" name="HoTen" value="<?= $user['TenTK'] ?>" required><br>
        <label for="Email">Email:</label>
        <input type="email" name="Email" value="<?= $user['Email'] ?>" required><br>
        <label for="SDT">Số điện thoại:</label>
        <input type="text" name="SDT" value="<?= $user['SDT'] ?>"><br>
        <label for="DiaChi">Địa chỉ:</label>
        <textarea name="DiaChi"><?= $user['DiaChi'] ?></textarea><br>
        <button type="submit">Cập nhật</button>
    </form>

    <hr>

    <h2>Lịch sử mua hàng</h2>
    <table>
        <tr>
            <th>Mã sản phẩm</th><th>Giá tiền</th><th>Số lượng</th><th>Tổng tiền</th><th>Trạng thái</th>
        </tr>
        <?php while ($row = $orders->fetch_assoc()): ?>
        <tr>
            <td data-label="Mã sản phẩm"><?= $row['MaSP'] ?></td>
            <td data-label="Giá tiền"><?= number_format($row['GiaTien'], 0, ',', '.') ?>đ</td>
            <td data-label="Số lượng"><?= $row['SoLuong'] ?></td>
            <td data-label="Tổng tiền"><?= number_format($row['GiaTien']*$row['SoLuong'], 0, ',', '.') ?>đ</td>
            <td data-label="Trạng thái"><?= $row['State'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include('template/footer.php') ?>
