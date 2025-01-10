<?php
include("header.php");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài Khoản</title>
    <link rel="stylesheet" href="style.css"> <!-- CSS chung -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
        }
        .account-options {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 20px;
        }
        .account-option {
            flex: 1;
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .account-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .account-option img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
        .account-option h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .account-option p {
            color: #555;
            font-size: 0.9rem;
        }
        .account-option a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .account-option a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản Lý Tài Khoản</h1>
        <div class="account-options">
            <!-- Xem thông tin -->
            <div class="account-option">
                <img src="images/icons/user.png" alt="Thông tin cá nhân">
                <h3>Thông tin cá nhân</h3>
                <p>Xem các thông tin cá nhân của bạn.</p>
                <a href="thong_tin_ca_nhan.php">Xem thông tin</a>
            </div>
            <!-- Thay đổi mật khẩu -->
            <div class="account-option">
                <img src="images/icons/change-password.png" alt="Thay đổi mật khẩu">
                <h3>Thay đổi mật khẩu</h3>
                <p>Đổi mật khẩu để bảo vệ tài khoản của bạn.</p>
                <a href="thay_doi_mat_khau.php">Đổi mật khẩu</a>
            </div>
            <!-- Lịch sử mua hàng -->
            <div class="account-option">
                <img src="images/icons/order-history.png" alt="Lịch sử mua hàng">
                <h3>Đơn Hàng</h3>
                <p>Xem thông tin các đơn hàng của bạn.</p>
                <a href="lich_su_mua_hang.php">Xem lịch sử</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
include("footer.php");
?>