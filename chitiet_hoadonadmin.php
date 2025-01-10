<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php");
    exit();
}

include("ketnoi.php");
// Kiểm tra có tham số mahoadon
if (isset($_GET['mahoadon'])) {
    $mahoadon = $_GET['mahoadon'];

    // Truy vấn thông tin hóa đơn
    $sql_hoadon = "SELECT hoadon.mahoadon, hoadon.ngayxuat, hoadon.tendangnhap
                   FROM hoadon
                   WHERE hoadon.mahoadon = '$mahoadon'";

    $result_hoadon = mysqli_query($kn, $sql_hoadon);

    // Kiểm tra xem truy vấn có thành công không
    if (!$result_hoadon) {
        die("Lỗi truy vấn hóa đơn: " . mysqli_error($kn));
    }

    $hoadon = mysqli_fetch_assoc($result_hoadon);

    // Kiểm tra nếu không có hóa đơn
    if (!$hoadon) {
        echo "Không tìm thấy hóa đơn!";
        exit;
    }

    // Truy vấn chi tiết hóa đơn, sửa bảng macaycanh thành sanpham
    $sql_chitiethoadon = "SELECT chitiethoadon.machitiet, chitiethoadon.soluong, chitiethoadon.tongtien, hoadon.trangthai, 
                                  chitiethoadon.diachinhanhang, chitiethoadon.sdtnhanhang, sanpham.tencay
                          FROM chitiethoadon
                          JOIN sanpham ON chitiethoadon.macaycanh = sanpham.macaycanh
                          JOIN hoadon ON chitiethoadon.mahoadon = hoadon.mahoadon
                          WHERE chitiethoadon.mahoadon = '$mahoadon'";

    $result_chitiethoadon = mysqli_query($kn, $sql_chitiethoadon);

    // Kiểm tra xem truy vấn có thành công không
    if (!$result_chitiethoadon) {
        die("Lỗi truy vấn chi tiết hóa đơn: " . mysqli_error($kn));
    }

} else {
    echo "Không có mã hóa đơn!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Hóa Đơn</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table td {
            background-color: #f9f9f9;
        }
        .btn-approve {
            display: inline-block;
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 0;
        }
        .btn-approve:hover {
            background-color: #218838;
        }
        .btn-back {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 0;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chi Tiết Hóa Đơn - Mã Hóa Đơn: <?php echo isset($hoadon['mahoadon']) ? $hoadon['mahoadon'] : 'N/A'; ?></h1>

        <!-- Thông tin hóa đơn -->
        <table>
            <tr>
                <th>Mã Hóa Đơn</th>
                <td><?php echo isset($hoadon['mahoadon']) ? $hoadon['mahoadon'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <th>Ngày Xuất</th>
                <td><?php echo isset($hoadon['ngayxuat']) ? $hoadon['ngayxuat'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <th>Tên Người Dùng</th>
                <td><?php echo isset($hoadon['tendangnhap']) ? $hoadon['tendangnhap'] : 'N/A'; ?></td>
            </tr>
        </table>

        <!-- Chi tiết các sản phẩm trong đơn hàng -->
        <h2>Chi Tiết Đơn Hàng</h2>
        <table>
            <thead>
                <tr>
                    <th>Tên Cây Cảnh</th>
                    <th>Số Lượng</th>
                    <th>Địa Chỉ Nhận Hàng</th>
                    <th>Số Điện Thoại Nhận Hàng</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($chitiethoadon = mysqli_fetch_assoc($result_chitiethoadon)): ?>
                    <tr>
                        <td><?php echo isset($chitiethoadon['tencay']) ? $chitiethoadon['tencay'] : 'N/A'; ?></td>
                        <td><?php echo isset($chitiethoadon['soluong']) ? $chitiethoadon['soluong'] : 'N/A'; ?></td>
                        <td><?php echo isset($chitiethoadon['diachinhanhang']) ? $chitiethoadon['diachinhanhang'] : 'N/A'; ?></td>
                        <td><?php echo isset($chitiethoadon['sdtnhanhang']) ? $chitiethoadon['sdtnhanhang'] : 'N/A'; ?></td>
                        <td><?php echo isset($chitiethoadon['tongtien']) ? number_format($chitiethoadon['tongtien'], 0, ',', '.') . ' VND' : 'N/A'; ?></td>
                        <td>
                            <?php
                            if (isset($chitiethoadon['trangthai'])) {
                                if ($chitiethoadon['trangthai'] == 0) {
                                    echo "Đang Chờ Duyệt";
                                } elseif ($chitiethoadon['trangthai'] == 1) {
                                    echo "Đã Duyệt";
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Nút quay lại -->
        <a href="duyet_don_hang.php" class="btn-back"><i class="fas fa-arrow-left"></i> Quay Lại</a>

        <!-- Nút duyệt nếu đơn hàng chưa duyệt -->
        <?php if (isset($chitiethoadon['trangthai']) && $chitiethoadon['trangthai'] == 0): ?>
            <a href="xuly_duyethoadon.php?mahoadon=<?php echo $hoadon['mahoadon']; ?>" class="btn-approve"><i class="fas fa-check"></i> Duyệt Đơn Hàng</a>
        <?php endif; ?>
    </div>
</body>
</html>
