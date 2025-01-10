<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập nếu không phải admin
    exit();
}

include("ketnoi.php"); // Kết nối với cơ sở dữ liệu

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM sanpham WHERE macaycanh = $id";
    $result = mysqli_query($kn, $sql);
    $product = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $tencay = $_POST['tencay'];
    $mota = $_POST['mota'];
    $gia = $_POST['gia'];
    $soluong = $_POST['soluong'];
    $maloai = $_POST['maloai'];

    // Kiểm tra nếu có hình ảnh mới được upload
    if ($_FILES['hinhanh']['name']) {
        $target_dir = "images/sanpham/"; // Đường dẫn lưu ảnh sản phẩm
        $target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);
        if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
            $hinhanh = $target_file;
        } else {
            $hinhanh = $product['hinhanh']; // Giữ nguyên ảnh cũ nếu không upload mới
        }
    } else {
        $hinhanh = $product['hinhanh']; // Giữ nguyên ảnh cũ nếu không upload mới
    }

    // Cập nhật thông tin sản phẩm vào cơ sở dữ liệu
    $sql = "UPDATE sanpham SET tencay = '$tencay', hinhanh = '$hinhanh', mota = '$mota', gia = '$gia', maloai = '$maloai', soluongsanpham = '$soluong' WHERE macaycanh = $id";
    if (mysqli_query($kn, $sql)) {
        echo("<script>alert('Cập nhật sản phẩm thành công'); window.location='trangadmin.php';</script>");
    } else {
        echo("<script>alert('Lỗi khi cập nhật sản phẩm'); window.location='atrangadmin.php';</script>");
    }
}
?>
