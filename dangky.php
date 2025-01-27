<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 14px;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .input-group input:focus {
            outline: none;
            border-color: #2980b9;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #3498db;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #2980b9;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Đăng Ký</h2>
        <form action="xuly_dangky.php" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label for="fullname">Họ và Tên</label>
                <input type="text" id="fullname" name="hoten" placeholder="Nhập họ và tên" required>
            </div>
            <div class="input-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="tendangnhap" placeholder="Nhập tên đăng nhập" required>
            </div>
            <div class="input-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="matkhau" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="input-group">
                <label for="confirm-password">Xác nhận mật khẩu</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
            </div>
            <div class="input-group">
                <label for="phone">Điện thoại</label>
                <input type="tel" id="phone" name="dienthoai" placeholder="Nhập số điện thoại" required>
            </div>
            <div class="input-group">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" name="diachi" placeholder="Nhập địa chỉ" required>
            </div>
            <div class="input-group">
                <label for="profile-picture">Ảnh đại diện</label>
                <input type="file" id="profile-picture" name="anhdaidien" accept="image/*">
            </div>
            <button type="submit" class="btn">Đăng Ký</button>
        </form>
        <div class="footer">
            <p>Đã có tài khoản? <a href="dangnhap.php">Đăng nhập ngay</a></p>
        </div>
    </div>
</body>
</html>
