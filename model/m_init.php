<?php 
    require_once("m_database.php");
    
    class M_init extends M_database {   
        public function Create_Structure() {
            $sql_account = "Create Table If Not Exists Account (
                LevelID int(1) Not Null Default 0,
                MaTK int(6) Zerofill Unsigned Auto_Increment Primary Key ,
                TenTK varchar(100) Not Null,
                Email varchar(100) Unique Not Null,
                SDT varchar(10) Unique Not Null,
                DiaChi varchar(100) Not Null
            )";
            $this->setQuery($sql_account);
            $this->excuteQuery();

            $sql_product = "Create Table If Not Exists Products (
                MaSP varchar(6) Primary Key,
                TenSP varchar(50) Unique Not Null,
                NSX varchar(15) Not Null,
                HSD varchar(15) Not Null,
                SoLuong int Not Null,
                GiaTien float Not Null,
                MoTa varchar(100) Not Null,
                ImageSP varchar(100) Not Null,
                MaTK int(6) Zerofill,
                Constraint P_MaTK_FK Foreign Key (MaTK) References Account(MaTK) On Delete Cascade
            )";
            $this->setQuery($sql_product);
            $this->excuteQuery();

            $sql_LSMua = "Create Table If Not Exists LS_Mua (
                MaTK int(6) Zerofill Unsigned Not Null,
                MaSP varchar(6) Not Null,
                SoLuong int Not Null,
                GiaTien float Not Null,
                Primary Key (MaTK, MaSP),
                Constraint LS_MaTK_FK Foreign Key (MaTK) References Account(MaTK) On Delete cascade,
                Constraint LS_MaSP_FK Foreign Key (MaSP) References Products(MaSP) On Delete cascade
                )";
            $this->setQuery($sql_LSMua);
            $this->excuteQuery();
        }
        public function Insert_Data() {
            $sql_ad_1 = "INSERT INTO Account (LevelID, TenTK, Email, SDT, DiaChi) VALUES
                        (1 , 'Trương Anh Kiệt', 'anhkiet@gmail.com', '0987654321', 'TP Hồ Chí Minh')";
            $this->setQuery($sql_ad_1);
            $this->excuteQuery();
            
            $sql_pro_1 = "INSERT INTO Products (MaSP, TenSP, NSX, HSD, SoLuong, GiaTien, Mota, ImageSP, MaTK) VALUES
                            ('SP49x1', 'Snack Bí Đỏ', '01/05/2025', '31/05/2025', 10, 5.500, 'Vị ngon, ngọt, chua cay. Sản phẩm không chất phụ gia', 'Ảnh Sản Phẩm', '000001')";
            $this->setQuery($sql_pro_1);
            $this->excuteQuery();
        }
    }
    $myInit = new M_init();
    $myInit->Create_Structure();
    $myInit->Insert_Data();
?>