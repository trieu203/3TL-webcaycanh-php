<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php");
    exit();
}

include("ketnoi.php"); // Kết nối với cơ sở dữ liệu

// Lấy danh sách sản phẩm và tên loại cây từ cơ sở dữ liệu
$sql = "SELECT sanpham.macaycanh, sanpham.tencay, sanpham.hinhanh, sanpham.mota, sanpham.gia, loaicay.tenloai, sanpham.soluongsanpham 
        FROM sanpham 
        INNER JOIN loaicay ON sanpham.maloai = loaicay.maloai";

$result = mysqli_query($kn, $sql);

// Kiểm tra nếu câu truy vấn bị lỗi
if (!$result) {
    die("Lỗi truy vấn SQL: " . mysqli_error($kn));
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Lý Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #007bff;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .sidebar h2 {
            font-size: 1.6rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

        .sidebar .logout {
            margin-top: auto;
            background-color: #dc3545;
        }

        .content {
            width: 100%;
            padding: 20px;
            background-color: #fff;
        }

        .content h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #007bff;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .card h3 {
            font-size: 1.5rem;
            color: #007bff;
        }

        .card a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .card a:hover {
            background-color: #218838;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            color: white;
        }

        .footer p {
            margin: 0;
            font-size: 1rem;
        }

    </style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Quản Lý</h2>
        <a href="duyet_don_hang.php"><i class="fas fa-cogs"></i> Duyệt Đơn Hàng</a>
        <a href="trangadmin.php"><i class="fas fa-box-open"></i> Quản Lý Sản Phẩm</a>
        <a href="dangxuat.php" class="logout"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Chào mừng, Admin</h1>
        <div class="card">
            <h3>Duyệt Đơn Hàng</h3>
            <p>Quản lý các đơn hàng đang chờ duyệt và xác nhận trạng thái.</p>
            <a href="duyet_don_hang.php">Xem Đơn Hàng</a>
        </div>
        <div class="card">
            <h3>Quản Lý Sản Phẩm</h3>
            <p>Quản lý tất cả các sản phẩm có sẵn trong hệ thống.</p>
            <a href="trangadmin.php">Xem Sản Phẩm</a>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2025 Admin 3TL. All Rights Reserved.</p>
</div>

</body>
</html>
