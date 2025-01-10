<?php
include("header.php");
include("ketnoi.php");

// Lấy danh mục nếu có
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Số sản phẩm trên mỗi trang
$products_per_page = 6;

// Tính toán số trang và vị trí bắt đầu
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $products_per_page;

// Truy vấn tổng số sản phẩm
$sql_count = "SELECT COUNT(*) AS total
              FROM sanpham
              INNER JOIN loaicay ON sanpham.maloai = loaicay.maloai
              WHERE (sanpham.tencay LIKE '%$search%' OR loaicay.tenloai LIKE '%$search%')";
if (!empty($category_filter)) {
    $sql_count .= " AND sanpham.maloai = '$category_filter'";
}
$result_count = mysqli_query($kn, $sql_count);
$total_products = mysqli_fetch_assoc($result_count)['total'];

// Tính tổng số trang
$total_pages = ceil($total_products / $products_per_page);

// Truy vấn sản phẩm theo phân trang
$sql_products = "SELECT sanpham.macaycanh, sanpham.hinhanh, sanpham.tencay, sanpham.gia, sanpham.soluongsanpham, loaicay.tenloai
                 FROM sanpham
                 INNER JOIN loaicay ON sanpham.maloai = loaicay.maloai
                 WHERE (sanpham.tencay LIKE '%$search%' OR loaicay.tenloai LIKE '%$search%')";
if (!empty($category_filter)) {
    $sql_products .= " AND sanpham.maloai = '$category_filter'";
}
$sql_products .= " LIMIT $offset, $products_per_page";

$result_products = mysqli_query($kn, $sql_products);

// Lấy danh mục
$sql_categories = "SELECT * FROM loaicay";
$result_categories = mysqli_query($kn, $sql_categories);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
        }

        /* Menu dọc */
        .menu-danhmuc {
            width: 20%;
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
        }
        .menu-danhmuc h3 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }
        .menu-danhmuc ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .menu-danhmuc ul li {
            margin-bottom: 10px;
        }
        .menu-danhmuc ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            background-color: #0069d9;
            border-radius: 5px;
            transition: 0.3s;
        }
        .menu-danhmuc ul li a:hover {
            background-color: #0056b3;
        }

        /* Phần hiển thị sản phẩm */
        .content {
            width: 80%;
            padding: 20px;
        }
        .search-bar {
            display: flex;
            margin-bottom: 20px;
        }
        .search-input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
        }
        .search-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 cột */
            gap: 20px; /* Khoảng cách giữa các sản phẩm */
        }
        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .product:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .product img {
            width: 100%;
            height: 200px; /* Chiều cao cố định */
            object-fit: contain; /* Không cắt xén ảnh */
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }
        .product h4 {
            font-size: 16px;
            color: #333;
            margin: 10px 0;
        }
        .product p {
            font-size: 14px;
            margin: 5px 0;
        }
        .product p span {
            font-weight: bold;
            color: #007bff;
        }

        /* Phân trang */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            text-decoration: none;
            color: #007bff;
            padding: 10px 15px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: 0.3s;
        }
        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }
        .pagination .active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Menu dọc -->
        <div class="menu-danhmuc">
            <h3>Danh mục sản phẩm</h3>
            <ul>
                <li><a href="sanpham.php">Tất cả sản phẩm</a></li>
                <?php
                while ($category = mysqli_fetch_assoc($result_categories)) {
                    echo '<li><a href="sanpham.php?category=' . $category['maloai'] . '">' . $category['tenloai'] . '</a></li>';
                }
                ?>
            </ul>
        </div>

        <!-- Nội dung -->
        <div class="content">
            <!-- Thanh tìm kiếm -->
            <div class="search-bar">
                <form action="sanpham.php" method="GET">
                    <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." class="search-input">
                    <button type="submit" class="search-button">Tìm kiếm</button>
                </form>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="products">
                <?php if (mysqli_num_rows($result_products) > 0): ?>
                    <?php while ($product = mysqli_fetch_assoc($result_products)): ?>
                        <div class="product">
                            <a href="chitietsanpham.php?id=<?php echo $product['macaycanh']; ?>">
                                <img src="<?php echo $product['hinhanh']; ?>" alt="<?php echo $product['tencay']; ?>">
                                <h4><?php echo $product['tencay']; ?></h4>
                            </a>
                            <p>Loại: <?php echo $product['tenloai']; ?></p>
                            <?php if ($product['soluongsanpham'] > 0): ?>
                                <p>Giá: <span><?php echo number_format($product['gia'], 0, ',', '.'); ?> VNĐ</span></p>
                            <?php else: ?>
                                <p style="color: red; font-weight: bold;">Hết hàng</p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Không có sản phẩm nào phù hợp.</p>
                <?php endif; ?>
            </div>

            <!-- Phân trang -->
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = $i == $current_page ? 'active' : '';
                    echo "<a href='sanpham.php?page=$i&search=$search&category=$category_filter' class='$active'>$i</a>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
include("footer.php");
?>
