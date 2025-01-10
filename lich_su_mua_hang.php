<?php
include("header.php");
include("ketnoi.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php");
    exit;
}

$tendangnhap = $_SESSION['user'];

// Lấy tất cả hóa đơn của người dùng
$sql = "SELECT hoadon.mahoadon, hoadon.ngayxuat, hoadon.trangthai
        FROM hoadon
        INNER JOIN chitiethoadon cthd ON hoadon.mahoadon = cthd.mahoadon
        WHERE hoadon.tendangnhap = '$tendangnhap'
        GROUP BY hoadon.mahoadon";

$result = mysqli_query($kn, $sql);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Mua Hàng</title>
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
        }
        .order-history {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }
        .btn-view-details {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-view-details:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lịch Sử Mua Hàng</h1>
        <div class="order-history">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Mã Hóa Đơn</th>
                            <th>Ngày Mua</th>
                            <th>Trạng Thái</th>
                            <th>Chi Tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $order['mahoadon']; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($order['ngayxuat'])); ?></td>
                                <td>
                                    <?php 
                                    // Kiểm tra trạng thái của đơn hàng
                                    if ($order['trangthai'] == 0) {
                                        echo "<span class='status-pending'>Đang chờ duyệt</span>";
                                    } else {
                                        echo "<span class='status-approved'>Đã duyệt</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="chitiet_hoadon.php?mahoadon=<?php echo $order['mahoadon']; ?>" class="btn-view-details">Xem chi tiết</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Không có đơn hàng nào.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
include("footer.php");
?>
