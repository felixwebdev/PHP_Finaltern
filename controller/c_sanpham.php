<?php
require_once "./model/m_sanpham.php";

class SanPhamController {
    public $limit = 5;

    public function getSanPhamTheoTrang($page) {
        $all = SanPhamModel::getAll();
        $total = count($all);
        $total_pages = ceil($total / $this->limit);
        $start = ($page - 1) * $this->limit;
        $ds_tren_trang = array_slice($all, $start, $this->limit);

        return [
            'data' => $ds_tren_trang,
            'total_pages' => $total_pages,
            'current_page' => $page
        ];
    }

    public function themSanPham($img, $ten, $danh_muc, $gia, $so_luong, $ngay, $trang_thai) {
        return SanPhamModel::insertSanPham($img, $ten, $danh_muc, $gia, $so_luong, $ngay, $trang_thai);
    }
    public function xoaSanPham($index) {
        return SanPhamModel::deleteSanPhamByIndex($index);
    }
    
}

// ======= XỬ LÝ THÊM SẢN PHẨM VÀ PHÂN TRANG =======

// Tạo controller
$sanPhamController = new SanPhamController();

// Nếu có dữ liệu POST từ form thêm sản phẩm
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ten"])) {
    $ten = $_POST["name"];
    $gia = (int)$_POST["price"];
    $danh_muc = $_POST["category"];
    $so_luong = (int)$_POST["quantity"];
    $ngay = $_POST["date"];

    // Xử lý ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'image/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // tạo thư mục nếu chưa tồn tại
        }

        $filename = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $filename;

        // Di chuyển file ảnh vào thư mục
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $img = $targetPath;
        } else {
            $img = ""; // có thể xử lý lỗi ở đây nếu muốn
        }
    } else {
        $img = ""; // hoặc ảnh mặc định
    }

    // Mặc định trạng thái là 1 nếu số lượng > 0, ngược lại là 0
    $trang_thai = $so_luong > 0 ? 1 : 0;

    // Thêm vào danh sách sản phẩm
    $sanPhamController->themSanPham($img, $ten, $danh_muc, $gia, $so_luong, $ngay, $trang_thai);

    // Chuyển hướng tránh bị submit lại khi refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
// Nếu có yêu cầu xóa sản phẩm
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $index = (int)$_GET['id'];
    $sanPhamController->xoaSanPham($index);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Xử lý phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$result = $sanPhamController->getSanPhamTheoTrang($page);
$ds_tren_trang = $result['data'];
$total_pages = $result['total_pages'];
?>
