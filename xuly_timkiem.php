<?php
include("ketnoi.php"); // Kết nối cơ sở dữ liệu

// Lấy dữ liệu tìm kiếm từ GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Truy vấn sản phẩm
$sql_products = "SELECT sanpham.macaycanh, sanpham.hinhanh, sanpham.tencay, sanpham.gia, loaicay.tenloai 
                 FROM sanpham 
                 INNER JOIN loaicay ON sanpham.maloai = loaicay.maloai 
                 WHERE (sanpham.tencay LIKE '%$search%' OR loaicay.tenloai LIKE '%$search%')";

if (!empty($category_filter)) {
    $sql_products .= " AND sanpham.maloai = '$category_filter'";
}

$result_products = mysqli_query($kn, $sql_products);
