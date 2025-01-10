<?php
include("header.php");
include("ketnoi.php");

session_start();
$tendangnhap = $_SESSION['user']; // Lấy tên đăng nhập từ session

// Lấy dữ liệu từ form
$hoten = $_POST['hoten'];
$dienthoai = $_POST['dienthoai'];
$diachi = $_POST['diachi'];

// Khởi tạo biến để lưu đường dẫn ảnh
$upload_path = '';

// Xử lý ảnh đại diện nếu có
if (isset($_FILES['anhdaidien']) && $_FILES['anhdaidien']['error'] == 0) {
    $file_tmp = $_FILES['anhdaidien']['tmp_name'];
    $file_name = $_FILES['anhdaidien']['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $allowed_extensions = ['jpg', 'jpeg', 'png'];

    // Kiểm tra định dạng ảnh
    if (in_array(strtolower($file_ext), $allowed_extensions)) {
        $new_file_name = uniqid() . '.' . $file_ext;
        $upload_path = 'images/anhdaidien/' . $new_file_name;
        move_uploaded_file($file_tmp, $upload_path);
    } else {
        echo "Định dạng ảnh không hợp lệ!";
        exit();
    }
} else {
    // Nếu không có ảnh mới, lấy ảnh cũ từ cơ sở dữ liệu
    $sql_get_old_image = "SELECT anhdaidien FROM nguoidung WHERE tendangnhap = '$tendangnhap'";
    $result = mysqli_query($kn, $sql_get_old_image);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $upload_path = $row['anhdaidien']; // Giữ nguyên ảnh cũ
    }
}

// Cập nhật thông tin người dùng
$sql_update = "UPDATE nguoidung 
               SET hoten = '$hoten', dienthoai = '$dienthoai', diachi = '$diachi', anhdaidien = '$upload_path' 
               WHERE tendangnhap = '$tendangnhap'";

if (mysqli_query($kn, $sql_update)) {
    // Cập nhật thành công
    header("Location: thong_tin_ca_nhan.php?message=Chỉnh sửa thông tin thành công!");
} else {
    // Cập nhật thất bại
    echo "Lỗi khi cập nhật thông tin!";
}

mysqli_close($kn);
?>
