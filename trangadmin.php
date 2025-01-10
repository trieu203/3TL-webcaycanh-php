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
    <title>Trang Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-logout {
            padding: 10px 15px;
            background-color:rgb(4, 0, 231);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-logout:hover {
            background-color:rgb(0, 24, 236);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            max-width: 80px;
            border-radius: 8px;
        }
        .btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-add {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .btn-add:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="header">
        <h2>Quản Lý Sản Phẩm</h2>
        <a href="quanly.php" class="btn-logout">Quay lại</a>
    </div>
    <a href="themsanpham.php" class="btn-add">+ Thêm sản phẩm mới</a>
    <table>
        <thead>
            <tr>
                <th>Tên cây</th>
                <th>Hình ảnh</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Loại cây</th>
                <th>Chỉnh sửa</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['tencay']; ?></td>
                        <td><img src="<?php echo $row['hinhanh']; ?>" alt="<?php echo $row['tencay']; ?>"></td>
                        <td><?php echo $row['mota']; ?></td>
                        <td><?php echo number_format($row['gia'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo $row['soluongsanpham']; ?></td>
                        <td><?php echo $row['tenloai']; ?></td>
                        <td>
                            <a href="chinhsuasanpham.php?id=<?php echo $row['macaycanh']; ?>" class="btn">Sửa</a>
                            
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có sản phẩm nào!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
