<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php");
    exit();
}

include("ketnoi.php"); // Kết nối với cơ sở dữ liệu

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM sanpham WHERE macaycanh = $id";
    $result = mysqli_query($kn, $sql);
    $product = mysqli_fetch_assoc($result);
}

// Lấy danh sách loại cây từ bảng loaicay
$sql_loai = "SELECT * FROM loaicay";
$result_loai = mysqli_query($kn, $sql_loai);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
        }

        img {
            display: block;
            margin: 10px 0;
            max-width: 150px;
            border-radius: 8px;
        }

        .btn-submit {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .btn-cancel {
            margin-top: 15px;
            text-align: center;
            display: block;
            font-size: 16px;
            color: #6c757d;
            text-decoration: none;
        }

        .btn-cancel:hover {
            color: #495057;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chỉnh sửa sản phẩm</h2>
        <form action="xuly_chinhsua.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tencay">Tên cây:</label>
                <input type="text" name="tencay" id="tencay" value="<?php echo $product['tencay']; ?>" required>
            </div>

            <div class="form-group">
                <label for="hinhanh">Hình ảnh:</label>
                <input type="file" name="hinhanh" id="hinhanh" accept="image/*">
                <img src="<?php echo $product['hinhanh']; ?>" alt="Ảnh sản phẩm hiện tại">
            </div>

            <div class="form-group">
                <label for="mota">Mô tả:</label>
                <input type="text" name="mota" id="mota" value="<?php echo $product['mota']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gia">Giá (VNĐ):</label>
                <input type="number" name="gia" id="gia" value="<?php echo $product['gia']; ?>" min="0" step="500" required>
            </div>
            <div class="form-group">
                <label for="soluong">Số lượng:</label>
                <input type="number" name="soluong" id="soluong" value="<?php echo $product['soluongsanpham']; ?>" min="0" step="1" required>
            </div>

            <div class="form-group">
                <label for="maloai">Loại cây:</label>
                <select name="maloai" id="maloai" required>
                    <?php while ($row = mysqli_fetch_assoc($result_loai)): ?>
                        <option value="<?php echo $row['maloai']; ?>" 
                            <?php echo ($row['maloai'] == $product['maloai']) ? 'selected' : ''; ?>>
                            <?php echo $row['tenloai']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">Cập nhật sản phẩm</button>
            <a href="trangadmin.php" class="btn-cancel">Quay lại</a>
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
