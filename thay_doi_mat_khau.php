<?php
include("header.php");
include("ketnoi.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php");
    exit;
}

$tendangnhap = $_SESSION['user'];
$error = ''; // Biến để lưu thông báo lỗi

// Kiểm tra nếu người dùng đã gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sdt = $_POST['sdt']; // Số điện thoại nhập vào
    $matkhau_moi = $_POST['matkhau_moi']; // Mật khẩu mới
    $matkhau_cu = $_POST['matkhau_cu']; // Mật khẩu cũ

    // Kiểm tra số điện thoại đã đăng ký
    $sql = "SELECT * FROM nguoidung WHERE tendangnhap = '$tendangnhap' AND dienthoai = '$sdt'";

    $result = mysqli_query($kn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        // Kiểm tra mật khẩu cũ (sử dụng MD5)
        $user = mysqli_fetch_assoc($result);
        if (md5($matkhau_cu) === $user['matkhau']) {
            // Cập nhật mật khẩu mới (mã hóa MD5)
            $matkhau_moi_md5 = md5($matkhau_moi); // Mã hóa mật khẩu mới bằng MD5
            $sql_update = "UPDATE nguoidung SET matkhau = '$matkhau_moi_md5' WHERE tendangnhap = '$tendangnhap'";
            if (mysqli_query($kn, $sql_update)) {
                echo "<script>
                        alert('Mật khẩu đã được thay đổi thành công!');
                        window.location.href = 'index.php'; // Điều hướng về trang chủ
                      </script>";
            } else {
                $error = "Lỗi cập nhật mật khẩu. Vui lòng thử lại!";
            }
        } else {
            $error = "Mật khẩu cũ không đúng!";
        }
    } else {
        $error = "Số điện thoại không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thay Đổi Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-size: 1.1rem;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }
        .form-group input[type="submit"]:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            font-size: 1.1rem;
            margin-top: 10px;
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
        <h1>Thay Đổi Mật Khẩu</h1>
        <div class="form-container">
            <form method="POST" action="thay_doi_mat_khau.php">
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="sdt">Số điện thoại:</label>
                    <input type="text" id="sdt" name="sdt" required>
                </div>
                <div class="form-group">
                    <label for="matkhau_cu">Mật khẩu cũ:</label>
                    <input type="password" id="matkhau_cu" name="matkhau_cu" required>
                </div>
                <div class="form-group">
                    <label for="matkhau_moi">Mật khẩu mới:</label>
                    <input type="password" id="matkhau_moi" name="matkhau_moi" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Thay đổi mật khẩu">
                </div>
                <div class="form-group">
                    <a href="taikhoan.php" class="btn-back">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
include("footer.php");
?>
