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
    include('model/m_database.php');
    // Lấy params từ URL (nếu có)
    $filterYear     = $_GET['year']     ?? '';
    $filterCategory = $_GET['category'] ?? '';
    $sortPrice      = $_GET['sort']     ?? '';

    // Mockup data mẫu (thêm year & category)
    $products = [
        ['id'=>1,'name'=>'SP 1','image'=>'./media/image/product1.jpg','price'=>199000,'description'=>'Mô tả 1','year'=>2021,'category'=>'Điện thoại'],
        ['id'=>2,'name'=>'SP 2','image'=>'./media/image/product2.jpg','price'=>249000,'description'=>'Mô tả 2','year'=>2022,'category'=>'Laptop'],
        ['id'=>3,'name'=>'SP 3','image'=>'./media/image/product3.jpg','price'=>299000,'description'=>'Mô tả 3','year'=>2021,'category'=>'Tablet'],
        ['id'=>4,'name'=>'SP 4','image'=>'./media/image/product4.jpg','price'=>179000,'description'=>'Mô tả 4','year'=>2023,'category'=>'Điện thoại'],
        ['id'=>5,'name'=>'SP 5','image'=>'./media/image/product5.jpg','price'=>219000,'description'=>'Mô tả 5','year'=>2022,'category'=>'Laptop'],
    ];

    // Danh sách năm & category để dựng dropdown
    $years = array_unique(array_column($products, 'year'));
    sort($years);
    $categories = array_unique(array_column($products, 'category'));
    sort($categories);

    // 1. Filter theo year & category
    $filtered = array_filter($products, function($p) use($filterYear,$filterCategory){
        if ($filterYear && $p['year'] != $filterYear) return false;
        if ($filterCategory && $p['category'] != $filterCategory) return false;
        return true;
    });

    // 2. Sort theo giá
    if ($sortPrice === 'asc') {
        usort($filtered, fn($a,$b)=>$a['price'] <=> $b['price']);
    } elseif ($sortPrice === 'desc') {
        usort($filtered, fn($a,$b)=>$b['price'] <=> $a['price']);
    }
?>

<div class="container__product container py-5">
    <h2 class="text-center mb-4">Danh sách sản phẩm</h2>

    <!-- Filter Form -->
    <form class="row g-3 mb-4" method="get">
        <div class="col-md-3">
            <select name="year" class="form-select">
                <option value="">-- Năm sản xuất --</option>
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
                <option value="">-- Phân loại --</option>
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
                <option value="">-- Sắp xếp giá --</option>
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
        <?php if(empty($filtered)): ?>
            <div class="col-12">
                <p class="text-center text-muted">Không có sản phẩm nào phù hợp.</p>
            </div>
        <?php else: ?>
            <?php foreach ($filtered as $product): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text text-danger fw-bold"><?= number_format($product['price'],0,',','.') ?>đ</p>
                            <p class="card-text small text-muted mb-1">
                                <?= $product['category'] ?> • <?= $product['year'] ?>
                            </p>
                            <p class="card-text small"><?= $product['description'] ?></p>
                            <a href="product-detail.php?id=<?= $product['id'] ?>" class="btn btn-primary mt-auto">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include('template/footer.php') ?>
