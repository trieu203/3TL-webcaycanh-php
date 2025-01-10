<?php
include("ketnoi.php");
session_start();  // Bắt đầu session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];   // ID sản phẩm
    $quantity = $_POST['quantity'];        // Số lượng sản phẩm
    $session_id = session_id();            // Lấy session ID để phân biệt các giỏ hàng

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    $sql_check = "SELECT * FROM giohang WHERE macaycanh = '$product_id' AND maphien = '$session_id'";
    $result_check = mysqli_query($kn, $sql_check);
    
    if ($result_check) {  // Kiểm tra nếu truy vấn không có lỗi
        if (mysqli_num_rows($result_check) > 0) {
            // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
            $sql_update = "UPDATE giohang SET soluongthem = $quantity WHERE macaycanh = '$product_id' AND maphien = '$session_id'";
            $update_result = mysqli_query($kn, $sql_update);
            
            // Kiểm tra nếu cập nhật thành công
            if ($update_result) {
                // Chuyển hướng đến trang giỏ hàng
                header('Location: giohang.php');
                exit();
            } else {
                // Nếu không thành công, quay lại trang chi tiết sản phẩm
                header('Location: chitietsanpham.php?id=' . $product_id);
                exit();
            }
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ hàng
            $sql_insert = "INSERT INTO giohang (macaycanh, soluongthem, maphien) VALUES ('$product_id', '$quantity', '$session_id')";
            $insert_result = mysqli_query($kn, $sql_insert);
            
            // Kiểm tra nếu thêm mới thành công
            if ($insert_result) {
                // Chuyển hướng đến trang giỏ hàng
                header('Location: giohang.php');
                exit();
            } else {
                // Nếu không thành công, quay lại trang chi tiết sản phẩm
                header('Location: chitietsanpham.php?id=' . $product_id);
                exit();
            }
        }
    } else {
        // Nếu có lỗi trong truy vấn, quay lại trang chi tiết sản phẩm
        header('Location: chitietsanpham.php?id=' . $product_id);
        exit();
    }
}
?>

