<?php 
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập nếu không phải admin
    exit();
}

include("ketnoi.php"); // Kết nối với cơ sở dữ liệu

// Lấy danh sách loại cây từ bảng loaicay
$sql_loai = "SELECT * FROM loaicay";
$result_loai = mysqli_query($kn, $sql_loai);

// Kiểm tra phương thức POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $tencay = $_POST['tencay'];
    $mota = $_POST['mota'];
    $gia = $_POST['gia'];
    $soluong = $_POST['soluong'];
    $maloai = $_POST['maloai'];

    // Xử lý upload hình ảnh sản phẩm
    $target_dir = "images/sanpham/"; // Đường dẫn lưu ảnh sản phẩm
    $target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra xem file có phải là ảnh không
    $check = getimagesize($_FILES["hinhanh"]["tmp_name"]);
    if ($check === false) {
        echo "File không phải là ảnh.";
        $upload_ok = 0;
    }

    // Kiểm tra kích thước file (giới hạn 5MB)
    if ($_FILES["hinhanh"]["size"] > 5000000) {
        echo "File của bạn quá lớn.";
        $upload_ok = 0;
    }

    // Cho phép các định dạng ảnh jpg, jpeg, png, gif
    if ($image_file_type != "jpg" && $image_file_type != "jpeg" && $image_file_type != "png" && $image_file_type != "gif") {
        echo "Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.";
        $upload_ok = 0;
    }

    // Kiểm tra xem có upload thành công không
    if ($upload_ok == 0) {
        echo "File của bạn không được tải lên.";
    } else {
        if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
            // Thêm sản phẩm vào cơ sở dữ liệu
            $sql = "INSERT INTO sanpham (tencay, hinhanh, mota, gia, maloai, soluongsanpham) VALUES ('$tencay', '$target_file', '$mota', '$gia', '$maloai','$soluong')";
            if (mysqli_query($kn, $sql)) {
                echo("<script>alert('Thêm sản phẩm thành công'); window.location='trangadmin.php';</script>");
            } else {
                echo("<script>alert('Lỗi khi thêm sản phẩm'); window.location='trangadmin.php';</script>");
            }
        } else {
            echo "Có lỗi khi tải lên ảnh.";
        }
    }
}
?>
