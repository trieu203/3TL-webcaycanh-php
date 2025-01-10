<?php
include('header.php');
?>

<style>
    /* Chào mừng người dùng */
    .welcome {
        text-align: center;
        margin: 40px 0;
    }

    .welcome h1 {
        font-size: 32px;
        color: #333;
        margin-bottom: 15px;
    }

    .welcome p {
        font-size: 18px;
        color: #555;
        margin-top: 10px;
    }

    /* Sản phẩm nổi bật */
    .featured-products {
        margin: 40px 0;
    }

    .featured-products h2 {
        font-size: 28px;
        color: #333;
        text-align: center;
        margin-bottom: 30px;
    }

    .products {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        justify-items: center;
        margin: 0 auto;
        max-width: 1200px;
    }

    .product {
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .product img {
        width: 100%;
        height: 200px;
        object-fit: contain;
        margin-bottom: 15px;
    }

    .product h3 {
        font-size: 18px;
        margin: 10px 0;
    }

    .product p {
        font-size: 16px;
        color: #007bff;
    }

    /* Khuyến mãi */
    .promotions {
        text-align: center;
        margin: 40px 0;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }

    .promotions h2 {
        font-size: 26px;
        color: #333;
        margin-bottom: 20px;
    }

    .promotions p {
        font-size: 18px;
        color: #555;
        margin-bottom: 30px;
    }

    .promotions .btn-promotion {
        display: inline-block;
        background-color: #2980b9;
        color: white;
        padding: 15px 30px;
        font-size: 18px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .promotions .btn-promotion:hover {
        background-color: #3498db;
    }
</style>

<!-- Nội dung trang chủ -->
<div class="container">
    <!-- Chào mừng người dùng -->
    <section class="welcome">
        <h1>Chào mừng đến với Website Bán Cây Cảnh</h1>
        <p>Chúng tôi cung cấp các loại cây cảnh đẹp, chất lượng với giá cả hợp lý. Khám phá ngay các sản phẩm mới và các ưu đãi hấp dẫn!</p>
    </section>

    <!-- Sản phẩm nổi bật -->
    <section class="featured-products">
        <h2>Sản phẩm nổi bật</h2>
        <div class="products">
            <?php
            include('ketnoi.php');
            $sql = "SELECT * FROM sanpham ORDER BY gia DESC LIMIT 8";  // Lấy 6 sản phẩm nổi bật
            $result = mysqli_query($kn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($product = mysqli_fetch_assoc($result)) {
                    echo '<div class="product">';
                    echo '<a href="chitietsanpham.php?id=' . $product['macaycanh'] . '">';
                    echo '<img src="' . $product['hinhanh'] . '" alt="' . $product['tencay'] . '">';
                    echo '<h3>' . $product['tencay'] . '</h3>';
                    echo '<p>Giá: ' . number_format($product['gia'], 0, ',', '.') . ' VNĐ</p>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>Không có sản phẩm nổi bật hiện tại.</p>';
            }
            ?>
        </div>
    </section>

    <!-- Khuyến mãi và ưu đãi -->
    <section class="promotions">
        <h2>Khuyến mãi đặc biệt</h2>
        <p>Đừng bỏ lỡ các ưu đãi và khuyến mãi hấp dẫn của chúng tôi! Giảm giá lên đến 30% cho một số sản phẩm chọn lọc.</p>
        <a href="sanpham.php" class="btn-promotion">Xem các sản phẩm khuyến mãi</a>
    </section>
</div>

<?php
include('footer.php');
?>
