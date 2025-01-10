<?php
include("header.php");
include("ketnoi.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php");
    exit;
}

$tendangnhap = $_SESSION['user'];
$mahoadon = $_GET['mahoadon'];

// Lấy chi tiết hóa đơn từ bảng chitiethoadon và thông tin từ bảng hoadon
$sql_details = "SELECT cthd.*, sanpham.tencay, sanpham.hinhanh, hoadon.trangthai
                FROM chitiethoadon cthd
                INNER JOIN sanpham ON cthd.macaycanh = sanpham.macaycanh
                INNER JOIN hoadon ON cthd.mahoadon = hoadon.mahoadon
                WHERE cthd.mahoadon = '$mahoadon'";

$result_details = mysqli_query($kn, $sql_details);

// Lấy thông tin về hóa đơn
$hoadon_sql = "SELECT * FROM hoadon WHERE mahoadon = '$mahoadon'";
$hoadon_result = mysqli_query($kn, $hoadon_sql);
$hoadon = mysqli_fetch_assoc($hoadon_result);

// Lấy thông tin địa chỉ và số điện thoại từ bảng chitiethoadon
$sql_address = "SELECT DISTINCT diachinhanhang, sdtnhanhang FROM chitiethoadon WHERE mahoadon = '$mahoadon'";
$address_result = mysqli_query($kn, $sql_address);
$address_info = mysqli_fetch_assoc($address_result);

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
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 1.8rem;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        .order-info {
            margin-bottom: 30px;
            font-size: 1rem;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 15px;
        }
        .order-info p {
            margin: 5px 0;
        }
        .order-info span {
            font-weight: bold;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .order-table th, .order-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f1f1f1;
        }
        .order-table th {
            background-color: #007bff;
            color: #fff;
        }
        .order-table td {
            background-color: #f9f9f9;
        }
        .order-table img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 20px 0;
            color: white;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Chi Tiết Hóa Đơn #<?php echo $mahoadon; ?></h1>

    <div class="order-info">
        <p><span>Ngày mua:</span> <?php echo date("d-m-Y", strtotime($hoadon['ngayxuat'])); ?></p>
        <p><span>Địa chỉ nhận hàng:</span> <?php echo $address_info['diachinhanhang']; ?></p>
        <p><span>Số điện thoại nhận hàng:</span> <?php echo $address_info['sdtnhanhang']; ?></p>
    </div>

    <table class="order-table">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = mysqli_fetch_assoc($result_details)): ?>
                <tr>
                    <td><img src="<?php echo $item['hinhanh']; ?>" alt="<?php echo $item['tencay']; ?>"></td>
                    <td><?php echo $item['tencay']; ?></td>
                    <td><?php echo $item['soluong']; ?></td>
                    <td><?php echo number_format($item['tongtien'], 0, ',', '.'); ?> VNĐ</td>
                    <td>
                        <?php 
                        if ($item['trangthai'] == 0) {
                            echo "<span class='status-pending'>Đang chờ duyệt</span>";
                        } else {
                            echo "<span class='status-approved'>Đã duyệt</span>";
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn">Quay lại trang chủ</a>
</div>

</body>
</html>

<?php
include("footer.php");
?>
