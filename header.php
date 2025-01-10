<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website bán cây cảnh</title>
    <style>
        /* CSS cho banner */
        .banner {
            width: 100%;
            height: 200px;
            background-image: url('./images/banner.jpg'); /* Đường dẫn tới ảnh banner */
            background-size: cover;
            background-position: center;
            position: relative; /* Để đặt các nút vào trong banner */
        }

        /* Nút trong banner ở góc trên bên phải */
        .banner-buttons {
            position: absolute;
            top: 20px; /* Cách trên 20px */
            right: 20px; /* Cách phải 20px */
            display: flex;
            gap: 20px; /* Khoảng cách giữa các nút */
        }

        .banner-buttons a {
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            background-color: #2980b9;
            border-radius: 5px;
            font-size: 16px;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .banner-buttons a:hover {
            background-color: #3498db;
        }

        /* CSS cho thanh menu */
        .menu {
            background-color: #2c3e50;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .menu a:hover {
            background-color: #34495e;
            border-radius: 5px;
        }

        /* CSS cho footer */
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Banner -->
    <div class="banner">
        <!-- Nút trong banner -->
        <div class="banner-buttons">
            <?php if (isset($_SESSION['user'])): ?>
                <!-- If user is logged in, show "Đăng xuất" -->
                <a href="dangxuat.php">Đăng xuất</a>
            <?php else: ?>
                <!-- If user is not logged in, show "Đăng nhập" and "Đăng ký" -->
                <a href="dangnhap.php">Đăng nhập</a>
                <a href="dangky.php">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Thanh menu -->
    <div class="menu">
        <a href="index.php">Trang chủ</a>
        <a href="sanpham.php">Sản phẩm</a>
        <a href="giohang.php">Giỏ hàng</a>
        <a href="taikhoan.php">Tài khoản</a>
    </div>


