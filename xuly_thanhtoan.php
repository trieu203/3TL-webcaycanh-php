<?php
include("ketnoi.php");
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php"); // Chuyển hướng đến trang đăng nhập
    exit;
}

$tendangnhap = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận thông tin từ form
    $sdt = $_POST['phone'];
    $diachi = $_POST['address'];
    $total_amount = $_POST['total_amount'];

    $session_id = session_id();

    // Lấy danh sách sản phẩm trong giỏ hàng
    $sql_cart = "SELECT giohang.*, sanpham.gia
                 FROM giohang
                 INNER JOIN sanpham ON giohang.macaycanh = sanpham.macaycanh
                 WHERE giohang.maphien = '$session_id'";

    $result_cart = mysqli_query($kn, $sql_cart);

    if (mysqli_num_rows($result_cart) > 0) {
        // Tạo hóa đơn
        $ngayxuat = date("Y-m-d");
        $sql_hoadon = "INSERT INTO hoadon (ngayxuat, tendangnhap, trangthai) VALUES ('$ngayxuat', '$tendangnhap', 0)";
        mysqli_query($kn, $sql_hoadon);

        // Lấy mã hóa đơn vừa tạo
        $mahoadon = mysqli_insert_id($kn);

        // Thêm chi tiết hóa đơn cho từng sản phẩm trong giỏ hàng
        while ($item = mysqli_fetch_assoc($result_cart)) {
            $macaycanh = $item['macaycanh'];
            $soluong = $item['soluongthem'];
            $tongtien = $item['gia'] * $soluong;

            $sql_chitiet = "INSERT INTO chitiethoadon (mahoadon, macaycanh, sdtnhanhang, diachinhanhang, soluong, tongtien)
                            VALUES ('$mahoadon', '$macaycanh', '$sdt', '$diachi', '$soluong', '$tongtien')";
            mysqli_query($kn, $sql_chitiet);
        }

        // Xóa giỏ hàng sau khi thanh toán
        $sql_delete_cart = "DELETE FROM giohang WHERE maphien = '$session_id'";
        mysqli_query($kn, $sql_delete_cart);

        // Thông báo và chuyển hướng
        echo "<script>
                alert('Thanh toán thành công. Đơn hàng của bạn đang chờ duyệt!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán!');
                window.location.href = 'giohang.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Yêu cầu không hợp lệ!');
            window.location.href = 'giohang.php';
          </script>";
}
?>
