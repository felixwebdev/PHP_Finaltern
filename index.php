<?php include('template/head.php') ?>
<?php include('template/header.php') ?>
<div class="main__container">
    <div class="container__banner"></div>
    <main>
        <div class="slider" style="
            --width: 100px;
            --height: 50px;
            --quantity: 10;
        ">
            <div class="list">
                <div class="item" style="--position: 1"><img src="./media/image/Slider/slider1_1.png" alt=""></div>
                <div class="item" style="--position: 2"><img src="./media/image/Slider/slider1_2.png" alt=""></div>
                <div class="item" style="--position: 3"><img src="./media/image/Slider/slider1_3.png" alt=""></div>
                <div class="item" style="--position: 4"><img src="./media/image/Slider/slider1_4.png" alt=""></div>
                <div class="item" style="--position: 5"><img src="./media/image/Slider/slider1_5.png" alt=""></div>
                <div class="item" style="--position: 6"><img src="./media/image/Slider/slider1_6.png" alt=""></div>
                <div class="item" style="--position: 7"><img src="./media/image/Slider/slider1_7.png" alt=""></div>
                <div class="item" style="--position: 8"><img src="./media/image/Slider/slider1_8.png" alt=""></div>
                <div class="item" style="--position: 9"><img src="./media/image/Slider/slider1_9.png" alt=""></div>
                <div class="item" style="--position: 10"><img src="./media/image/Slider/slider1_10.png" alt=""></div>
            </div>
        </div>
    </main>
</div>
<?php
    $db = new M_database();

    // Lấy danh sách năm duy nhất từ NSX (DATE) → chỉ lấy phần năm
    $db->setQuery("SELECT DISTINCT NSX FROM products ORDER BY NSX DESC");
    $resYear = $db->excuteQuery();
    $years = [];
    while ($row = $resYear->fetch_assoc()) {
        $years[] = date('Y', strtotime($row['NSX'])); 
    }

    // Lấy danh sách phân loại
    $db->setQuery("SELECT DISTINCT PhanLoai FROM products");
    $resCategory = $db->excuteQuery();
    $categories = [];
    while ($row = $resCategory->fetch_assoc()) {
        $categories[] = $row['PhanLoai'];
    }

    // Lấy filter từ URL
    $filterYear = $_GET['year'] ?? '';
    $filterCategory = $_GET['category'] ?? '';
    $sortPrice = $_GET['sort'] ?? '';

    // Xây dựng query động
    $sql = "SELECT * FROM products WHERE 1=1";

    // Lọc theo năm sản xuất
    if ($filterYear !== '') {
        $sql .= " AND YEAR(NSX) = " . (int)$filterYear;
    }

    // Lọc theo phân loại
    if ($filterCategory !== '') {
        $sql .= " AND PhanLoai = '" . $db->conn->real_escape_string($filterCategory) . "'";
    }

    // Sắp xếp theo giá
    if ($sortPrice === 'asc') {
        $sql .= " ORDER BY GiaTien ASC";
    } elseif ($sortPrice === 'desc') {
        $sql .= " ORDER BY GiaTien DESC";
    }

    // Thực thi query và lấy dữ liệu
    $db->setQuery($sql);
    $result = $db->excuteQuery();

    $products = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    $db->close();
?>


<div class="container__product container py-5">
    <h2 class="text-center mb-4">Danh sách sản phẩm</h2>

    <!-- Filter Form -->
    <form class="row g-3 mb-4" method="get">
        <div class="col-md-3">
            <select name="year" class="form-select">
                <option value=""> Năm sản xuất </option>
                <?php foreach($years as $y): ?>
                    <option value="<?= $y ?>"
                        <?= $filterYear===$y?'selected':'' ?>>
                        <?= $y ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value=""> Phân loại </option>
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c ?>"
                        <?= $filterCategory===$c?'selected':'' ?>>
                        <?= $c ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value=""> Sắp xếp giá </option>
                <option value="asc"  <?= $sortPrice==='asc'?'selected':'' ?>>Giá tăng dần</option>
                <option value="desc" <?= $sortPrice==='desc'?'selected':'' ?>>Giá giảm dần</option>
            </select>
        </div>
        <div class="col-md-3 d-grid">
            <button type="submit" class="btn btn-success">Áp dụng</button>
        </div>
    </form>

    <!-- Product Grid -->
    <div class="row">
        <?php if(empty($products)): ?>
            <div class="col-12">
                <p class="text-center text-muted">Không có sản phẩm nào phù hợp.</p>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <img src="<?= $product['ImageSP'] ?>" class="card-img-top" alt="<?= $product['TenSP'] ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $product['TenSP'] ?></h5>
                            <p class="card-text text-danger fw-bold"><?= number_format($product['GiaTien'],0,',','.') ?>đ</p>
                            <p class="card-text small text-muted mb-1">
                                <?= $product['PhanLoai'] ?> • <?= $product['NSX'] ?>
                            </p>
                            <p class="card-text small"><?= $product['MoTa'] ?></p>
                            <a href="product_detail.php?id=<?= $product['MaSP'] ?>" class="btn btn-primary mt-auto">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include('template/footer.php') ?>
