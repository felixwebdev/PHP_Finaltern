<?php include('template/head.php') ?>
<?php include('template/header.php') ?>
<?php
    include_once('model/m_database.php');
    $db = new M_database();

    $query = $_GET['query'] ?? '';  // Lấy từ khóa tìm kiếm từ query string
    echo "Kết quả tìm kiếm cho từ khóa: <strong>" . htmlspecialchars($query) . "</strong><br>";

    if ($query) {
        // Escape query từ kết nối gốc
        $conn = $db->getConnection();
        $query = $conn->real_escape_string($query);

        $query = $_GET['query'] ?? '';
        $keywords = explode(" ", $query);
        $sql = "SELECT * FROM products WHERE ";

        // foreach ($keywords as $i => $word) {
        //     $sql .= "TenSP LIKE '%" .$word. "%'";
        //     $sql .= " OR MaSP LIKE '%" .$word. "%'";
        //     $sql .= " OR PhanLoai LIKE '%" .$word. "%'";
        //     $sql .= " OR MoTa LIKE '%" .$word. "%'";
        //     $sql .= " OR GiaTien LIKE '%" .$word. "%'";
        //     if ($i < count($keywords) - 1) {
        //         $sql .= " OR ";
        //     }
        // }

        $sql = "SELECT * FROM products WHERE TenSP LIKE '%" . $query . "%' OR MaSP LIKE '%" . $query . "%' 
        OR MoTa LIKE '%" . $query . "%' OR PhanLoai LIKE '%" . $query . "%' 
        OR GiaTien LIKE '%" . $query . "%' OR TagName LIKE '%" . $query . "%'";

        // Thực hiện truy vấn tìm kiếm
        $db->setQuery($sql);        

        $result = $db->excuteQuery();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div>{$row['TenSP']} - {$row['GiaTien']}</div>";
            }
        } else {
            echo "<p>Không tìm thấy sản phẩm nào.</p>";
        }
    } else {
        include('template/productList.php');
    }

    $db->close();
?>

<?php include('template/footer.php') ?>
