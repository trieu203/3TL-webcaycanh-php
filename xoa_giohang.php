<?php
include("header.php");
include("ketnoi.php");

session_start(); // Đảm bảo rằng session đang được sử dụng

if (isset($_GET['id'])) {
    $macaycanh = $_GET['id']; // Lấy mã cây từ URL

    // Lấy session ID để xác định giỏ hàng của người dùng
    $session_id = session_id();

    // Xóa sản phẩm khỏi giỏ hàng
    $sql_delete = "DELETE FROM giohang WHERE macaycanh = '$macaycanh' AND maphien = '$session_id'";

    if (mysqli_query($kn, $sql_delete)) {
        // Nếu xóa thành công, chuyển hướng về trang giỏ hàng với thông báo
        header("Location: giohang.php?message=Xóa sản phẩm thành công!");
        exit();
    } else {
        // Nếu có lỗi xảy ra khi xóa
        header("Location: giohang.php?message=Lỗi khi xóa sản phẩm!");
        exit();
    }
} else {
    // Nếu không có mã cây, chuyển hướng về trang giỏ hàng
    header("Location: giohang.php?message=Sản phẩm không tồn tại.");
    exit();
}
?>
