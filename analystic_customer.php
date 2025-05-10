<?php
// Gọi controller
require_once 'controller/c_khachhang.php';
$controller = new KhachHangController();

// Lấy danh sách khách hàng
$khachHangs = $controller->getKhachHangs();
$page = $khachHangs['current_page'];  // Trang hiện tại từ controller
?>

<?php include "template/sidebar.php"; ?>
<div class="bg-light flex-fill">
    <div id="mainContent" class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Quản lý khách hàng</h4>
        </div>

        <!-- Form lọc khách hàng -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-filter"></i> Bộ lọc
            </div>
            <div class="card-body">
                <form class="row g-3" method="GET" action="">
                    <div class="col-md-3">
                        <label class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" name="ten_khach" placeholder="Nhập tên khách hàng..." value="<?= $_GET['ten_khach'] ?? '' ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Nhập email..." value="<?= $_GET['email'] ?? '' ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="trang_thai">
                            <option value="">-- Tất cả --</option>
                            <option value="Hoạt động" <?= ($_GET['trang_thai'] ?? '') == 'Hoạt động' ? 'selected' : '' ?>>Hoạt động</option>
                            <option value="Đang khóa" <?= ($_GET['trang_thai'] ?? '') == 'Đang khóa' ? 'selected' : '' ?>>Đang khóa</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-dark w-100" type="submit">
                            <i class="fa fa-filter"></i> Áp dụng
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bảng hiển thị khách hàng -->
        <div class="table-responsive"  style="border-radius: 10px;">
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th>Ngày tham gia</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <!-- Kiểm tra xem mảng khách hàng có dữ liệu hay không -->
                <?php if (!empty($khachHangs['khachHangs'])): ?>
                    <?php foreach ($khachHangs['khachHangs'] as $khachHang): ?>
                        <tr>
                            <td><?= $khachHang['id'] ?></td>
                            <td><?= $khachHang['ten_khach'] ?></td>
                            <td><?= $khachHang['email'] ?></td>
                            <td><?= $khachHang['trang_thai'] ?></td>
                            <td><?= $khachHang['ngay_tham_gia'] ?></td>
                            <td>
                                <a href="sua_khach_hang.php?id=<?= $khachHang['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="xoa_khach_hang.php?id=<?= $khachHang['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có khách hàng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        
        <!-- Phân trang -->
        <div class="d-flex justify-content-center align-items-center mt-3">
            <a class="btn btn-sm btn-light <?= ($page == 1) ? 'disabled' : '' ?>" href="?page=<?= max(1, $page - 1) ?>&ten_khach=<?= $_GET['ten_khach'] ?? '' ?>&email=<?= $_GET['email'] ?? '' ?>&trang_thai=<?= $_GET['trang_thai'] ?? '' ?>">
                <i class="fa fa-chevron-left"></i>
            </a>

            <span class="mx-3">Trang <?= $page ?> / <?= $khachHangs['total_pages'] ?></span>

            <a class="btn btn-sm btn-light <?= ($page == $khachHangs['total_pages']) ? 'disabled' : '' ?>" href="?page=<?= min($khachHangs['total_pages'], $page + 1) ?>&ten_khach=<?= $_GET['ten_khach'] ?? '' ?>&email=<?= $_GET['email'] ?? '' ?>&trang_thai=<?= $_GET['trang_thai'] ?? '' ?>">
                <i class="fa fa-chevron-right"></i>
            </a>

            <form class="ms-3" method="GET" action="" style="display: inline-flex; align-items: center;">
                <input type="hidden" name="ten_khach" value="<?= $_GET['ten_khach'] ?? '' ?>">
                <input type="hidden" name="email" value="<?= $_GET['email'] ?? '' ?>">
                <input type="hidden" name="trang_thai" value="<?= $_GET['trang_thai'] ?? '' ?>">
                <input type="number" name="page" min="1" max="<?= $khachHangs['total_pages'] ?>" value="<?= $page ?>" class="form-control form-control-sm" style="width: 80px;">
                <button type="submit" class="btn btn-sm btn-secondary ms-2">Đi</button>
            </form>
        </div>
    </div>
</div>
<?php include "template/script_footer.php"; ?>
