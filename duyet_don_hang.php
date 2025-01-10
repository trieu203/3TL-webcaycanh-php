<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php");
    exit();
}

include("ketnoi.php");
// Lấy tất cả các hóa đơn chưa duyệt
$sql_hoadon = "SELECT hoadon.mahoadon, hoadon.ngayxuat, hoadon.tendangnhap
               FROM hoadon
               WHERE hoadon.mahoadon NOT IN (SELECT DISTINCT mahoadon FROM chitiethoadon WHERE trangthai = 1)";
$result_hoadon = mysqli_query($kn, $sql_hoadon);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyệt Đơn Hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            font-size: 2rem;
            margin-bottom: 20px;
            color: #007bff;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .order-table th, .order-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .order-table th {
            background-color: #007bff;
            color: white;
        }
        .order-table td {
            background-color: #f9f9f9;
        }
        .btn-view, .btn-approve {
            display: inline-block;
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 0;
        }
        .btn-view:hover, .btn-approve:hover {
            background-color: #218838;
        }
        .btn-approve {
            background-color: #007bff;
        }
        .btn-approve:hover {
            background-color: #0056b3;
        }
        .btn-back {
            display: inline-block;
            padding: 8px 16px;
            background-color:rgb(52, 31, 245);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color:rgb(23, 1, 117);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Duyệt Đơn Hàng</h1>

        <!-- Nút quay lại trang quản lý -->
        <a href="quanly.php" class="btn-back"><i class="fas fa-arrow-left"></i> Quay Lại</a>

        <!-- Hiển thị các đơn hàng chưa duyệt -->
        <?php if (mysqli_num_rows($result_hoadon) > 0): ?>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Mã Hóa Đơn</th>
                        <th>Ngày Xuất</th>
                        <th>Tên Người Dùng</th>
                        <th>Chi Tiết</th>
                        <th>Duyệt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($hoadon = mysqli_fetch_assoc($result_hoadon)): ?>
                        <tr>
                            <td><?php echo $hoadon['mahoadon']; ?></td>
                            <td><?php echo $hoadon['ngayxuat']; ?></td>
                            <td><?php echo $hoadon['tendangnhap']; ?></td>
                            <td>
                                <a href="chitiet_hoadonadmin.php?mahoadon=<?php echo $hoadon['mahoadon']; ?>" class="btn-view">
                                    <i class="fas fa-eye"></i> Xem Chi Tiết
                                </a>
                            </td>
                            <td>
                                <a href="xuly_duyethoadon.php?mahoadon=<?php echo $hoadon['mahoadon']; ?>" class="btn-approve">
                                    <i class="fas fa-check"></i> Duyệt
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có đơn hàng nào chưa được duyệt.</p>
        <?php endif; ?>
    </div>
</body>
</html>