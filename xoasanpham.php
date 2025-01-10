<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập nếu không phải admin
    exit();
}

include("ketnoi.php"); // Kết nối với cơ sở dữ liệu

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Xóa sản phẩm khỏi cơ sở dữ liệu
    $sql = "DELETE FROM sanpham WHERE macaycanh = $id";
    if (mysqli_query($kn, $sql)) {
        echo("<script>alert('Xóa sản phẩm thành công'); window.location='trangadmin.php';</script>");
    } else {
        echo("<script>alert('Lỗi khi xóa sản phẩm'); window.location='trangadmin.php';</script>");
    }
}
?>
