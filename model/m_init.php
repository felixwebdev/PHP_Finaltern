<?php 
    require_once("m_database.php");
    
    class M_init extends M_database {   
        public function Create_Structure() {
            $sql_account = "Create Table If Not Exists Account (
                LevelID int(1) Not Null Default 0,
                MaTK int(6) Zerofill Unsigned Auto_Increment Primary Key,
                TenTK varchar(100) Not Null,
                Password varchar(10) Not Null,
                Email varchar(100) Unique Not Null,
                SDT varchar(10) Unique Not Null,
                DiaChi varchar(100) Not Null,
                NgayThamGia DATE Not Null
            )";
            
            $this->setQuery($sql_account);
            $this->excuteQuery();
           
            
            $sql_Voucher = "Create Table If Not Exists Vouchers (
                MaV varchar(10) Not Null Primary Key,
                Discount float Not Null
                )";
            $this->setQuery($sql_Voucher);
            $this->excuteQuery();
           // ban san pham
           $sql_product = "Create Table If Not Exists Products (
            MaSP varchar(6) Primary Key,
            TenSP varchar(50) Unique Not Null,
            PhanLoai varchar(100) Not Null,
            SoLuong int Not Null,
            GiaTien float Not Null,
            ImageSP varchar(100) Not Null,
            Sold int Not Null Default 0,
            NgayNhap DATE Not Null   -- Thêm cột NgayNhap vào đây
            )";
            $this->setQuery($sql_product);
            $this->excuteQuery();
        

            // bang don hang
            $sql_donhang = "CREATE TABLE IF NOT EXISTS DonHang (
                MaDH INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                MaTK INT UNSIGNED NOT NULL,  -- Liên kết với Account
                MaSP VARCHAR(6) NOT NULL,    -- Liên kết với Products
                TenKH VARCHAR(100) NOT NULL,
                TenSP VARCHAR(100) NOT NULL,
                PhanLoai VARCHAR(100) NOT NULL,
                NgayDat DATE NOT NULL,
                NgayGiao DATE DEFAULT NULL,
                GiaTien FLOAT NOT NULL,
                TrangThai ENUM('Chờ lấy hàng', 'Đang giao', 'Đã giao') NOT NULL,
                CONSTRAINT FK_MaTK FOREIGN KEY (MaTK) REFERENCES Account(MaTK) ON DELETE CASCADE,
                CONSTRAINT FK_MaSP FOREIGN KEY (MaSP) REFERENCES Products(MaSP) ON DELETE CASCADE
            )";
            $this->setQuery($sql_donhang);
            $this->excuteQuery();
            
            $sql_LSMua = "Create Table If Not Exists Cart (
                MaTK int(6) Zerofill Unsigned Not Null,
                MaSP varchar(6) Not Null,
                SoLuong int Not Null,
                GiaTien float Not Null,
                State varchar(50) Not Null,
                Primary Key (MaTK, MaSP),
                Constraint LS_MaTK_FK Foreign Key (MaTK) References Account(MaTK) On Delete cascade,
                Constraint LS_MaSP_FK Foreign Key (MaSP) References Products(MaSP) On Delete cascade
                )";
            $this->setQuery($sql_LSMua);
            $this->excuteQuery();


        }
        public function Insert_Data() {
            // Dữ liệu cho bảng Account
            $sql_ad_1 = "INSERT INTO Account (LevelID, TenTK, Password, Email, SDT, DiaChi, NgayThamGia) VALUES
            (1 , 'admin', 'admin123', 'admin@web.com', '0900000000', 'System', '2025-01-01'),
            (0 , 'Lê Thị H', 'password123', 'lethih@gmail.com', '0987654321', 'TP Hồ Chí Minh', '2025-02-15'),
            (0 , 'Nguyễn Văn A', 'password456', 'nguyenvana@gmail.com', '0912345678', 'Hà Nội', '2025-02-18'),
            (0 , 'Lê Thị B', 'password789', 'lethib@gmail.com', '0934567890', 'Đà Nẵng', '2025-02-20'),
            (0 , 'Trần Hoàng C', 'password321', 'tranhoangc@gmail.com', '0945678901', 'Cần Thơ', '2025-03-01'),
            (0 , 'Phạm Minh D', 'password654', 'phaminhd@gmail.com', '0956789012', 'Hải Phòng', '2025-03-03'),
            (0 , 'Bùi Thị E', 'password987', 'buithie@gmail.com', '0967890123', 'Vũng Tàu', '2025-03-07'),
            (0 , 'Vũ Anh F', 'password135', 'vuanhf@gmail.com', '0978901234', 'Quảng Ninh', '2025-03-10'),
            (0 , 'Đặng Thái G', 'password246', 'dangthaig@gmail.com', '0989012345', 'Hồ Chí Minh', '2025-04-01'),
            (0 , 'Hoàng Thanh H', 'password369', 'hoangthanhh@gmail.com', '0990123456', 'Bắc Giang', '2025-04-03')";

            $this->setQuery($sql_ad_1);
            $this->excuteQuery();
        
            // Dữ liệu cho bảng Products
            $sql_pro_1 = "INSERT INTO Products (MaSP, TenSP, PhanLoai, SoLuong, GiaTien, ImageSP, NgayNhap) VALUES
                ('SP49x1', 'Asus VivoBook 15 Pro', 'Điện tử', 10, 27950000, './media/image/Product_img/SP49x1.png', '2025-01-15'),
                ('SP49x2', 'Áo thun', 'Thời trang', 15, 30000000, './media/image/Product_img/SP49x2.jpg', '2025-02-20'),
                ('SP49x3', 'Mì cay cấp 2', 'Thực phẩm', 5, 25000000, './media/image/Product_img/SP49x3.jfif', '2025-03-05'),
                ('SP49x4', 'Play station 5', 'Điện tử', 20, 18000000, './media/image/Product_img/SP49x4.jpeg', '2025-04-01'),
                ('SP49x5', 'Quần jean', 'Thời trang', 8, 35000000, './media/image/Product_img/SP49x5.jfif', '2025-04-10'),
                ('SP49x6', 'Acer Swift 3', 'Điện tử', 12, 22000000, './media/image/Product_img/SP49x1.png', '2025-04-15'),
                ('SP49x7', 'Mì cay cấp 3', 'Thực phẩm', 6, 29000000, './media/image/Product_img/SP49x3.jfif', '2025-04-17'),
                ('SP49x8', 'Play station 4', 'Điện tử', 7, 45000000, './media/image/Product_img/SP49x4.jpeg', '2025-04-22'),
                ('SP49x9', 'Quần jean chính hãng', 'Thời gian', 3, 40000000, './media/image/Product_img/SP49x5.jfif', '2025-05-01')";
            $this->setQuery($sql_pro_1);
            $this->excuteQuery();
        
            // Dữ liệu cho bảng Vouchers
            $sql_vou_1 = "INSERT INTO Vouchers (MaV, Discount) VALUES
                            ('VCNamMoi', 50),
                            ('VCMungTet', 60),
                            ('VC30T4', 20),
                            ('VCBlackFriday', 70),
                            ('VCSaleTuan', 30),
                            ('VCTet2025', 40),
                            ('VCGiamGia', 10),
                            ('VCTrieuDuc', 80),
                            ('VCGiangSinh', 25)";
            $this->setQuery($sql_vou_1);
            $this->excuteQuery();
        
            // Dữ liệu cho bảng DonHang
            $sql_donhang = "INSERT INTO DonHang (MaTK, MaSP, TenKH, TenSP, PhanLoai, NgayDat, NgayGiao, GiaTien, TrangThai) VALUES
                            (1, 'SP49x1', 'Lê Thị H', 'Asus VivoBook 15 Pro', 'Điện tử', '2025-05-01', '2025-05-04', 27950000, 'Đã giao'),
                            (2, 'SP49x2', 'Nguyễn Văn A', 'Áo thun', 'Thời trang', '2025-04-20', '2025-04-23', 30000000, 'Đang giao'),
                            (3, 'SP49x3', 'Lê Thị B', 'Mì cay', 'Thực phẩm', '2025-04-10', '2025-04-12', 25000000, 'Chờ lấy hàng'),
                            (4, 'SP49x4', 'Trần Hoàng C', 'Play station 5', 'Điện tử', '2025-05-02', '2025-05-05', 18000000, 'Đã giao'),
                            (5, 'SP49x5', 'Phạm Minh D', 'Quần jean', 'Thời trang', '2025-03-18', '2025-03-20', 35000000, 'Đang giao'),
                            (6, 'SP49x6', 'Bùi Thị E', 'Acer Swift 3', 'Điện tử', '2025-05-06', '2025-05-09', 22000000, 'Chờ lấy hàng'),
                            (7, 'SP49x7', 'Vũ Anh F', 'Mì cay', 'Thực phẩm', '2025-04-25', '2025-04-28', 29000000, 'Đã giao'),
                            (8, 'SP49x8', 'Đặng Thái G', 'Play station 4', 'Điện tử', '2025-05-01', '2025-05-03', 45000000, 'Chờ lấy hàng'),
                            (9, 'SP49x9', 'Hoàng Thanh H', 'Quần jean chính hãng', 'Thời trang', '2025-04-15', '2025-04-17', 40000000, 'Đang giao')";
            $this->setQuery($sql_donhang);
            $this->excuteQuery();
        
            // Dữ liệu cho bảng Cart (Giỏ hàng)
            $sql_cart_1 = "INSERT INTO Cart (MaTK, MaSP, SoLuong, GiaTien, State) VALUES
                            (1, 'SP49x1', 2, 55900000, 'Đang xử lý'),
                            (2, 'SP49x2', 1, 30000000, 'Đang xử lý'),
                            (3, 'SP49x3', 1, 25000000, 'Chờ xử lý'),
                            (4, 'SP49x4', 3, 54000000, 'Đang xử lý'),
                            (5, 'SP49x5', 2, 70000000, 'Chờ xử lý'),
                            (6, 'SP49x6', 1, 22000000, 'Đang xử lý'),
                            (7, 'SP49x7', 4, 116000000, 'Chờ xử lý'),
                            (8, 'SP49x8', 1, 45000000, 'Đang xử lý'),
                            (9, 'SP49x9', 1, 40000000, 'Chờ xử lý')";
            $this->setQuery($sql_cart_1);
            $this->excuteQuery();
        }
        
    }
    $myInit = new M_init();
    $myInit->Create_Structure();
    $myInit->Insert_Data();

    echo "Cơ sở dữ liệu đã được tạo thành công!";
?>