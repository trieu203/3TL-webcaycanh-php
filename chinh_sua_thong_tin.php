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
    <title>Chỉnh Sửa Thông Tin</title>
    <style>
        /* Thêm các style cơ bản */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-group img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-top: 10px;
        }
        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .btn-back {
            display: block;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chỉnh Sửa Thông Tin Cá Nhân</h2>
        <form action="xuly_chinhsuatt.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="hoten">Họ tên</label>
                <input type="text" id="hoten" name="hoten" value="<?php echo $user['hoten']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dienthoai">Số điện thoại</label>
                <input type="text" id="dienthoai" name="dienthoai" value="<?php echo $user['dienthoai']; ?>" required>
            </div>
            <div class="form-group">
                <label for="diachi">Địa chỉ</label>
                <input type="text" id="diachi" name="diachi" value="<?php echo $user['diachi']; ?>" required>
            </div>
            <div class="form-group">
                <label for="anhdaidien">Ảnh đại diện</label>
                <input type="file" id="anhdaidien" name="anhdaidien">
                <?php if (!empty($user['anhdaidien'])): ?>
                    <img src="<?php echo $user['anhdaidien']; ?>" alt="Ảnh đại diện">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="submit" class="btn-submit" value="Lưu thay đổi">
            </div >
            <div class="form-group">
                <a href="taikhoan.php" class="btn-back">Quay lại</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
include("footer.php");
?>
