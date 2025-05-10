<?php
    include_once('model/m_database.php');
    $db = new M_database();
    session_start();

    $isLoggedIn = isset($_SESSION['user_id']);
    $isAdmin = isset($_SESSION['levelID']) && $_SESSION['levelID'] == 1;

    $maKH = $_SESSION['user_id'] ?? 0;
    $currentPage = basename($_SERVER['PHP_SELF']);

    $username = null;

    if ($isLoggedIn && $maKH > 0) {
        $db->setQuery("SELECT TenTK FROM account WHERE MaTK = $maKH");
        $result = $db->excuteQuery();
        if ($result && $row = $result->fetch_assoc()) {
            $username = $row['TenTK'];
        }
    }


    if ($isLoggedIn) {
        $db->setQuery("SELECT c.MaSP, c.SoLuong, c.GiaTien, p.TenSP, p.ImageSP
        FROM cart c
        JOIN products p ON c.MaSP = p.MaSP
        WHERE c.MaTK = $maKH AND c.State = 'chưa thanh toán'");

        $result = $db->excuteQuery();

        if ($result && $result->num_rows > 0) {
        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row; 
        }
        } else {
        $cartItems = [];
        }

        $db->close();
        } else {
        $cartItems = [];
    }

    if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
        $product_id = intval($_GET['id']);
        $maKH = $_SESSION['user_id'] ?? 0;
    
        $db = new M_database();
        $sql = "DELETE FROM cart WHERE MaTK = $maKH AND MaSP = $product_id";
        $db->setQuery($sql);
        $db->excuteQuery();
        $db->close();
    
        header("Location: " . basename($_SERVER['PHP_SELF']));
        exit();
    }    
?>

<nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="index.php" style="font-style:normal">PSHOP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?= ($currentPage === 'index.php') ? 'active' : '' ?>">
                    <a class="nav-link" href="index.php">Trang chủ</a>
                </li>
                <li class="nav-item <?= ($currentPage === 'introduce.php') ? 'active' : '' ?>">
                    <a class="nav-link" href="introduce.php">Giới thiệu</a>
                </li>
                <li class="nav-item <?= ($currentPage === 'contact.php') ? 'active' : '' ?>">
                    <a class="nav-link" href="contact.php">Liên hệ</a>
                </li>

                <?php if ($isLoggedIn): ?>
                    <?php if ($isAdmin): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="analystic_general.php">Quản lý</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item cart-icon d-none d-lg-block">
                            <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-basket2" viewBox="0 0 16 16">
                                <path d="M4 10a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0zm3 0a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0zm3 0a1 1 0 1 1 2 0v2a1 1 0 0 1-2 0z"/>
                                <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-.623l-1.844 6.456a.75.75 0 0 1-.722.544H3.69a.75.75 0 0 1-.722-.544L1.123 8H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.163 8l1.714 6h8.246l1.714-6z"/>
                            </svg>
                            </a>
                        </li>
                        <li class="nav-item cart-sub-icon d-block d-lg-none">
                         <a class="nav-link" href="#">Giỏ hàng</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="user.php"><?= htmlspecialchars($username) ?></a></li>
                            <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                        </ul>
                    </li>
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link" href="user.php"><?= htmlspecialchars($username) ?></a>
                    </li>
                    <li class="nav-item d-block d-lg-none">
                         <a class="nav-link" href="logout.php">Đăng xuất</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item <?= ($currentPage === 'signup.php') ? 'active' : '' ?>">
                        <a class="nav-link" href="signup.php">Đăng ký</a>
                    </li>
                    <li class="nav-item <?= ($currentPage === 'signin.php') ? 'active' : '' ?>">
                        <a class="nav-link" href="signin.php">Đăng nhập</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
</nav>


<div class="cartTab">
    <header class="cartTab-header">
        <span class="close-cartTab">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </span>
    </header>
    <div class="listCart">
        <?php if (count($cartItems) > 0): ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <div class="cart-item-details">
                        <h5><?= htmlspecialchars($item['TenSP']) ?></h5>
                        <p>Giá: $<?= number_format($item['GiaTien'], 2) ?></p>
                        <p>Số lượng: <?= $item['SoLuong'] ?></p>
                    </div>
                    <a href="?action=remove&id=<?= $item['MaSP'] ?>" class="remove-item">Bỏ</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="cart-item">Giỏ hàng đang trống.</p>
        <?php endif; ?>
    </div>
    <?php if (count($cartItems) > 0): ?>
    <!-- Add Checkout Button -->
    <div class="checkout-section">
        <button class="checkout-button">Thanh Toán</button>
    </div>
    <?php endif; ?>
</div>
