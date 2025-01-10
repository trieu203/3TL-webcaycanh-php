<?php
include("header.php");
include("ketnoi.php");


if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

$tendangnhap = $_SESSION['user'];

// Truy vấn thông tin người dùng từ cơ sở dữ liệu
$sql_user = "SELECT * FROM nguoidung WHERE tendangnhap = '$tendangnhap'";
$result_user = mysqli_query($kn, $sql_user);

if (mysqli_num_rows($result_user) > 0) {
    $user = mysqli_fetch_assoc($result_user);
    $hoten = $user['hoten'];
    $dienthoai = $user['dienthoai'];
    $diachi = $user['diachi'];
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}

$session_id = session_id(); // Lấy session ID của người dùng

// Lấy tất cả sản phẩm trong giỏ hàng của người dùng
$sql_cart = "SELECT giohang.*, sanpham.tencay, sanpham.gia, sanpham.hinhanh
             FROM giohang
             INNER JOIN sanpham ON giohang.macaycanh = sanpham.macaycanh
             WHERE giohang.maphien = '$session_id'";

$result_cart = mysqli_query($kn, $sql_cart);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
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
        .checkout {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .cart-table th, .cart-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .cart-table th {
            background-color: #007bff;
            color: white;
        }
        .cart-table td {
            background-color: #f9f9f9;
        }
        .cart-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 1rem;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[readonly] {
            background-color: #e9ecef;
            color: #495057;
        }
        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thanh Toán</h1>
        <div class="checkout">
            <h2>Sản phẩm trong giỏ hàng</h2>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    if (mysqli_num_rows($result_cart) > 0): 
                        while ($item = mysqli_fetch_assoc($result_cart)): 
                            $item_total = $item['gia'] * $item['soluongthem'];
                            $total += $item_total;
                    ?>
                    <tr>
                        <td><img src="<?php echo $item['hinhanh']; ?>" alt="<?php echo $item['tencay']; ?>" class="cart-image"></td>
                        <td><?php echo $item['tencay']; ?></td>
                        <td><?php echo $item['soluongthem']; ?></td>
                        <td><?php echo number_format($item_total, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold;">Tổng cộng:</td>
                        <td style="font-weight: bold;"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td colspan="4">Giỏ hàng của bạn đang trống.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <h2>Thông tin giao hàng</h2>
            <form action="xuly_thanhtoan.php" method="POST">
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo $hoten; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $dienthoai; ?>" placeholder="Nhập số điện thoại" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ nhận hàng</label>
                    <textarea id="address" name="address" rows="3" placeholder="Nhập địa chỉ nhận hàng" required><?php echo $diachi; ?></textarea>
                </div>
                <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                <button type="submit" class="btn-submit">Hoàn tất thanh toán</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
include("footer.php");
?>
