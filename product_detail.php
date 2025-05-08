<?php
include('db.php');

// Lấy ID sản phẩm từ URL
$id = $_GET['id'] ?? 0;

// Truy vấn sản phẩm
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Nếu không tìm thấy, chuyển hướng hoặc hiển thị thông báo
if (!$product) {
    echo "<div class='container my-5'><h3 class='text-danger'>Sản phẩm không tồn tại.</h3></div>";
    exit;
}
?>

<?php include('template/head.php') ?>
<?php include('template/header.php') ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-5">
            <img src="<?= $product['image'] ?>" class="img-fluid rounded shadow" alt="<?= $product['name'] ?>">
        </div>
        <div class="col-md-7">
            <h2><?= $product['name'] ?></h2>
            <p class="text-muted">Phân loại: <?= $product['category'] ?> | Năm: <?= $product['year'] ?></p>
            <h4 class="text-danger"><?= number_format($product['price'], 0, ',', '.') ?>đ</h4>
            <p class="mt-3"><?= nl2br($product['description']) ?></p>
            <a href="index.php" class="btn btn-secondary mt-4">← Quay lại</a>
        </div>
    </div>
</div>

<?php include('template/footer.php') ?>
