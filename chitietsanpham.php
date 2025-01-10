<?php 
include("header.php");
?>
<?php
include("ketnoi.php"); // Kết nối cơ sở dữ liệu

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Truy vấn thông tin chi tiết sản phẩm
$sql_product = "SELECT sanpham.*, loaicay.tenloai 
                FROM sanpham 
                INNER JOIN loaicay ON sanpham.maloai = loaicay.maloai 
                WHERE sanpham.macaycanh = '$product_id'";
$result_product = mysqli_query($kn, $sql_product);

// Kiểm tra nếu không tìm thấy sản phẩm
if (!$result_product || mysqli_num_rows($result_product) == 0) {
    echo "<p>Sản phẩm không tồn tại.</p>";
    exit();
}

$product = mysqli_fetch_assoc($result_product);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="stylesheet" href="style.css"> <!-- CSS chung -->
</head>
<body>
    <div class="container">
        <div class="product-detail">
            <!-- Hình ảnh sản phẩm -->
            <div class="product-image">
                <img src="<?php echo $product['hinhanh']; ?>" alt="<?php echo $product['tencay']; ?>">
            </div>
            
            <!-- Thông tin sản phẩm -->
            <div class="product-info">
                <h2><?php echo $product['tencay']; ?></h2>
                <p><strong>Loại cây:</strong> <?php echo $product['tenloai']; ?></p>
                <p><strong>Giá:</strong> <?php echo number_format($product['gia'], 0, ',', '.'); ?> VNĐ</p>
                <p><strong>Mô tả:</strong> <?php echo $product['mota']; ?></p>

                <!-- Số lượng sản phẩm còn lại -->
                <p><strong>Số lượng còn lại:</strong> <?php echo $product['soluongsanpham']; ?></p>

                <?php if ($product['soluongsanpham'] > 0): ?>
                    <!-- Form thêm vào giỏ hàng -->
                    <form action="xuly_themgiohang.php" method="POST">
                        <div class="quantity">
                            <label for="quantity">Số lượng mua:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['soluongsanpham']; ?>">
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $product['macaycanh']; ?>">
                        <button type="submit" class="btn-add-to-cart">Thêm vào giỏ hàng</button>
                    </form>
                <?php else: ?>
                    <!-- Hết hàng -->
                    <p style="color: red; font-weight: bold;">Hết hàng</p>
                    <p><em>Không thể chọn số lượng hoặc thêm vào giỏ hàng.</em></p>
                    <!-- Disable the quantity input and button -->
                    <script>
                        document.querySelector('#quantity').disabled = true;
                        document.querySelector('.btn-add-to-cart').disabled = true;
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
include("footer.php");
?>
