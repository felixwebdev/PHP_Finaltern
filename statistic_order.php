<?php include "template/sidebar.php"; ?>
<?php require_once "controller/c_donhang.php"; ?>

<div class="bg-light flex-fill">
    <div id="mainContent" class="p-4">
        <h3 class="mb-4">Quản lý đơn hàng</h3>

        <?php
             $ctrl = new DonHangController();
             $page = $_GET['page'] ?? 1; // lấy trang hiện tại
             $result = $ctrl->locDonHang($page);
         
             $ds_donhang = $result['donHangs'];
             $total_pages = $result['total_pages'];
             $current_page = $result['current_page'];
        ?>

        <!-- Bộ lọc -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-filter"></i> Bộ lọc
            </div>
            <div class="card-body">
                <form class="row g-3" method="GET" action="">
                    <!-- Tìm kiếm tên khách hàng -->
                <div class="col-md-3">
                    <label class="form-label">Tìm kiếm tên khách</label>
                    <input type="text" name="ten_khach" class="form-control">
                </div>

                    <!-- Trạng thái -->
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="">-- Tất cả --</option>
                            <option value="Chờ lấy hàng">Chờ lấy hàng</option>
                            <option value="Đang giao">Đang giao</option>
                            <option value="Đã giao">Đã giao</option>
                        </select>
                    </div>

                    <!-- Loại mặt hàng -->
                    <div class="col-md-3">
                        <label class="form-label">Loại mặt hàng</label>
                        <select name="loai" class="form-select">
                            <option value="">-- Tất cả --</option>
                            <option value="Điện tử">Điện tử</option>
                            <option value="Thời trang">Thời trang</option>
                            <option value="Thực phẩm">Thực phẩm</option>
                        </select>
                    </div>

                    <!-- Ngày đặt hàng -->
                    <div class="col-md-3">
                        <label class="form-label">Ngày đặt</label>
                        <input type="date" name="ngay_dat" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Ngày giao</label>
                        <input type="date" name="ngay_giao" class="form-control">
                    </div>

                    <!-- Nút lọc -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fa fa-filter"></i> Áp dụng
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Nội dung bảng -->
        <div class="table-responsive" style="border-radius: 10px;">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên khách</th>
                        <th>Sản phẩm</th>
                        <th>Loại</th>
                        <th>Ngày đặt</th>
                        <th>Ngày giao</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ds_donhang)): ?>
                        <tr><td colspan="8" class="text-center">Không có đơn hàng nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($ds_donhang as $dh): ?>
                            <tr>
                                <td><?= $dh->id ?></td>
                                <td><?= $dh->ten_khach ?></td>
                                <td><?= $dh->san_pham ?></td>
                                <td><?= $dh->loai ?></td>
                                <td><?= $dh->ngay_dat ?></td>
                                <td><?= $dh->ngay_giao ?? "Chưa giao" ?></td>
                                <td><?= number_format($dh->tong_tien) ?> VNĐ</td>
                                <td><?= $dh->trang_thai ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center align-items-center mt-3">
            <a class="btn btn-sm btn-light <?= ($current_page == 1) ? 'disabled' : '' ?>" href="?page=<?= max(1, $current_page - 1) ?>">
                <i class="fa fa-chevron-left"></i>
            </a>
            <span class="mx-3">Trang <?= $current_page ?> / <?= $total_pages ?></span>
            <a class="btn btn-sm btn-light <?= ($current_page == $total_pages) ? 'disabled' : '' ?>" href="?page=<?= min($total_pages, $current_page + 1) ?>">
                <i class="fa fa-chevron-right"></i>
            </a>
            <form class="ms-3" method="GET" action="" style="display: inline-flex; align-items: center;">
                <input type="number" name="page" min="1" max="<?= $total_pages ?>" value="<?= $current_page ?>" class="form-control form-control-sm" style="width: 80px;">
                <button type="submit" class="btn btn-sm btn-secondary ms-2">Đi</button>
            </form>
        </div>
    </div>
</div>
