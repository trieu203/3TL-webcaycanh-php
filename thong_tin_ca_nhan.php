<?php
include("header.php");
include("ketnoi.php");

$tendangnhap = $_SESSION['user']; // Lấy tên đăng nhập từ session

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql_user = "SELECT * FROM nguoidung WHERE tendangnhap = '$tendangnhap'";
$result_user = mysqli_query($kn, $sql_user);
$user = mysqli_fetch_assoc($result_user);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 50px auto; /* Căn giữa theo chiều ngang và tạo khoảng cách trên */
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-header h1 {
            font-size: 2rem;
            color: #007bff;
        }
        .profile-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-info img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .profile-info .info-group {
            margin-bottom: 15px;
        }
        .profile-info .info-group label {
            font-weight: bold;
        }
        .profile-info .info-group p {
            font-size: 1.2rem;
            color: #333;
        }
        .edit-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .edit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-header">
        <h1>Thông Tin Cá Nhân</h1>
    </div>

    <div class="profile-info">
        <div class="text-center">
            <?php if (!empty($user['anhdaidien'])): ?>
                <img src="<?php echo $user['anhdaidien']; ?>" alt="Ảnh đại diện">
            <?php else: ?>
                <img src="images/anhdaidien/default.png" alt="Ảnh đại diện">
            <?php endif; ?>
        </div>

        <div class="info-group">
            <label>Họ và tên:</label>
            <p><?php echo $user['hoten']; ?></p>
        </div>

        <div class="info-group">
            <label>Số điện thoại:</label>
            <p><?php echo $user['dienthoai']; ?></p>
        </div>

        <div class="info-group">
            <label>Địa chỉ:</label>
            <p><?php echo $user['diachi']; ?></p>
        </div>

        <a href="chinh_sua_thong_tin.php" class="edit-btn">Chỉnh sửa thông tin</a>
    </div>
</div>


</body>
</html>

<?php
include("footer.php");
?>
