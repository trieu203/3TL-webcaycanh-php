<?php
include("header.php");
include("ketnoi.php");

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
    <title>Giỏ Hàng</title>
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
        .cart {
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
        .btn-remove {
            display: inline-block;
            padding: 8px 16px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-remove:hover {
            background-color: #c82333;
        }
        .cart-summary {
            text-align: right;
            font-size: 1.2rem;
            margin-top: 20px;
        }
        .btn-checkout {
            display: inline-block;
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn-checkout:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Giỏ Hàng</h1>
        <div class="cart">
            <?php if (mysqli_num_rows($result_cart) > 0): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        while ($item = mysqli_fetch_assoc($result_cart)): 
                            $item_total = $item['gia'] * $item['soluongthem'];
                            $total += $item_total;
                        ?>
                        <tr>
                            <td><img src="<?php echo $item['hinhanh']; ?>" alt="<?php echo $item['tencay']; ?>" class="cart-image"></td>
                            <td><?php echo $item['tencay']; ?></td>
                            <td><?php echo number_format($item['gia'], 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo $item['soluongthem']; ?></td>
                            <td><?php echo number_format($item_total, 0, ',', '.'); ?> VNĐ</td>
                            <td><a href="xoa_giohang.php?id=<?php echo $item['macaycanh']; ?>" class="btn-remove">Xóa</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <p><strong>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</strong></p>
                    <a href="thanh_toan.php" class="btn-checkout">Thanh toán</a>
                </div>
            <?php else: ?>
                <p>Giỏ hàng của bạn đang trống.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
include("footer.php");
?>
