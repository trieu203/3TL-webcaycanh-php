<?php 
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập nếu không phải admin
    exit();
}

include("ketnoi.php"); // Kết nối với cơ sở dữ liệu

// Lấy danh sách loại cây từ bảng loaicay
$sql_loai = "SELECT * FROM loaicay";
$result_loai = mysqli_query($kn, $sql_loai);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 70%;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2980b9;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type="file"] {
            padding: 8px;
        }

        select {
            padding: 10px;
            font-size: 14px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: #2980b9;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #3498db;
        }

        .form-group span {
            color: #e74c3c;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Thêm sản phẩm mới</h2>
        <form action="xuly_themsp.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tencay">Tên cây:</label>
                <input type="text" name="tencay" id="tencay" required>
            </div>

            <div class="form-group">
                <label for="hinhanh">Hình ảnh:</label>
                <input type="file" name="hinhanh" accept="image/*" id="hinhanh" required>
            </div>

            <div class="form-group">
                <label for="mota">Mô tả:</label>
                <input type="text" name="mota" id="mota" required>
            </div>

            <div class="form-group">
                <label for="gia">Giá:</label>
                <input type="number" name="gia" id="gia" required min="0" step="1">
            </div>
            <div class="form-group">
                <label for="soluong">Số lượng:</label>
                <input type="number" name="soluong" id="soluong" required min="0" step="1">
            </div>
            <div class="form-group">
                <label for="maloai">Loại cây:</label>
                <select name="maloai" id="maloai" required>
                    <option value="">Chọn loại cây</option>
                    <?php while ($row = mysqli_fetch_assoc($result_loai)): ?>
                        <option value="<?php echo $row['maloai']; ?>"><?php echo $row['tenloai']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">Thêm sản phẩm</button>
        </form>
    </div>
    <script>
    document.getElementById('gia').addEventListener('input', function () {
        if (this.value < 0) this.value = 0;
    });

    document.getElementById('soluong').addEventListener('input', function () {
        if (this.value < 0) this.value = 0;
    });
    </script>

    <script>
    // Kiểm tra số nhập vào cho trường giá
    document.getElementById('gia').addEventListener('input', function () {
        // Loại bỏ phần thập phân nếu có
        if (this.value.includes('.')) {
            this.value = this.value.split('.')[0];
        }
    });

    // Kiểm tra số nhập vào cho trường số lượng
    document.getElementById('soluong').addEventListener('input', function () {
        // Loại bỏ phần thập phân nếu có
        if (this.value.includes('.')) {
            this.value = this.value.split('.')[0];
        }
    });
    </script>

</body>
</html>
