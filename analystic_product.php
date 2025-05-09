<?php include "template/sidebar.php" ?>
<?php require_once "controller/c_sanpham.php";?>
<div class="bg-light flex-fill">
    <div id="mainContent" class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Quản lý sản phẩm</h4>
        </div>

        <!-- Bộ lọc nâng cao -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-filter"></i> Bộ lọc
            </div>
            <div class="card-body">
                <form class="row g-3" method="GET" action="">
                    <!-- Tên sản phẩm -->
                    <div class="col-md-3">
                        <label class="form-label">Từ khóa</label>
                        <input type="text" class="form-control" name="keyword" placeholder="Tên sản phẩm..." value="<?= $_GET['keyword'] ?? '' ?>">
                    </div>

                    <!-- Thể loại -->
                    <div class="col-md-3">
                        <label class="form-label">Thể loại</label>
                        <select class="form-select" name="category">
                            <option value="">-- Tất cả --</option>
                            <option value="thoi-trang">Thời trang</option>
                            <option value="dien-tu">Điện tử</option>
                            <option value="thuc-pham">Thực phẩm</option>
                        </select>
                    </div>

                    <!-- Trạng thái -->
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="">-- Tất cả  --</option>
                            <option value="1">Còn hàng</option>
                            <option value="0">Hết hàng</option>
                        </select>
                    </div>

                    <!-- Ngày nhập -->
                    <div class="col-md-3">
                        <label class="form-label">Này nhập</label>
                        <select class="form-select" name="sort_ngay">
                            <option value="">Không sắp xếp</option>
                            <option value="ngay_nhap_desc">Mới → cũ</option>
                            <option value="ngay_nhap_asc">Cũ → mới</option>
                        </select>
                    </div>

                    <!-- Giá -->
                    <div class="col-md-3">
                        <label class="form-label">Giá</label>
                        <select class="form-select" name="sort_gia">
                            <option value="">Không sắp xếp</option>
                            <option value="gia_desc">Giá cao → thấp</option>
                            <option value="gia_asc">Giá thấp → cao</option>
                        </select>
                    </div>

                    <!-- Số lượng -->
                    <div class="col-md-3">
                        <label class="form-label">Số lượng</label>
                        <select class="form-select" name="sort_so_luong">
                            <option value="">Không sắp xếp</option>
                            <option value="so_luong_desc">Nhiều → ít</option>
                            <option value="so_luong_asc">Ít → nhiều</option>
                        </select>
                    </div>

                    <!-- Nút lọc -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-dark w-100" type="submit">
                            <i class="fa fa-filter"></i> Áp dụng
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Bảng dữ liệu -->
        <div class="table-responsive"  style="border-radius: 10px;">
        <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Ngày nhập</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($ds_tren_trang as $i => $sp): 
                            $index = ($page - 1) * $sanPhamController->limit + $i; // tính index toàn cục
                        ?>
                        <tr>
                            <td><img src="<?= $sp->img ?>" width="60"></td>
                            <td><?= $sp->ten ?></td>
                            <td><?= $sp->danh_muc ?></td>
                            <td><?= number_format($sp->gia, 0, ',', '.') ?> VNĐ</td>
                            <td><?= $sp->so_luong ?></td>
                            <td><?= $sp->ngay ?></td>
                            <td>
                                <?php if ($sp->trang_thai): ?>
                                    <span class="badge bg-success">Còn hàng</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Hết hàng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning">sửa</i></a>
                                <a class="btn btn-sm btn-danger" href="?action=delete&id=<?= array_search($sp, SanPhamModel::$sanPham) ?>" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
           <!-- phân trang -->
            <div class="d-flex justify-content-center align-items-center mt-3">
                <!-- Mũi tên qua lại -->
                <a class="btn btn-sm btn-light <?= ($page == 1) ? 'disabled' : '' ?>" href="?page=<?= max(1, $page - 1) ?>">
                    <i class="fa fa-chevron-left"></i>
                </a>

                <!-- Hiển thị số trang -->
                <span class="mx-3">Trang <?= $page ?> / <?= $total_pages ?></span>

                <!-- Mũi tên qua lại -->
                <a class="btn btn-sm btn-light <?= ($page == $total_pages) ? 'disabled' : '' ?>" href="?page=<?= min($total_pages, $page + 1) ?>">
                    <i class="fa fa-chevron-right"></i>
                </a>

                <!-- Tìm kiếm số trang -->
                <form class="ms-3" method="GET" action="" style="display: inline-flex; align-items: center;">
                    <input type="number" name="page" min="1" max="<?= $total_pages ?>" value="<?= $page ?>" class="form-control form-control-sm" style="width: 80px;">
                    <button type="submit" class="btn btn-sm btn-secondary ms-2">Đi</button>
                </form>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Thêm sản phẩm</h4>
            </div>
                       
           <!-- Form thêm sản phẩm -->
            <form id="addProductForm" method="POST" enctype="multipart/form-data" class="border p-3 rounded bg-light">
                <div class="mb-3">
                    <label for="image" class="form-label">Ảnh sản phẩm</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Danh mục</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">-- Chọn danh mục --</option>
                        <option value="Thời trang">Thời trang</option>
                        <option value="Điện tử">Điện tử</option>
                        <option value="Thực phẩm">Thực phẩm</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Giá (VNĐ)</label>
                    <input type="number" class="form-control" id="price" name="price" required min="0">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Ngày nhập</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-plus"></i> Thêm sản phẩm
                </button>
            </form>

                      


        </div>
    </div>
</div>
</div>
