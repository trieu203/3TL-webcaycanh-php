<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dangnhap.php");
    exit();
}

include("ketnoi.php");

// Kiểm tra nếu có tham số mahoadon
if (isset($_GET['mahoadon'])) {
    $mahoadon = $_GET['mahoadon'];

    // Truy vấn lấy chi tiết hóa đơn để kiểm tra số lượng sản phẩm
    $sql_chitiethoadon = "SELECT chitiethoadon.machitiet, chitiethoadon.soluong, chitiethoadon.macaycanh 
                          FROM chitiethoadon
                          JOIN hoadon ON chitiethoadon.mahoadon = hoadon.mahoadon
                          WHERE chitiethoadon.mahoadon = '$mahoadon' AND hoadon.trangthai = 0";
    $result_chitiethoadon = mysqli_query($kn, $sql_chitiethoadon);

    if (!$result_chitiethoadon) {
        die("Lỗi truy vấn chi tiết hóa đơn: " . mysqli_error($kn));
    }

    // Kiểm tra nếu số lượng sản phẩm trong kho đủ để duyệt đơn hàng
    $canApprove = true;  // Biến cờ kiểm tra số lượng sản phẩm
    while ($chitiethoadon = mysqli_fetch_assoc($result_chitiethoadon)) {
        $macaycanh = $chitiethoadon['macaycanh'];
        $soluong = $chitiethoadon['soluong'];

        // Kiểm tra số lượng sản phẩm trong kho
        $sql_check_stock = "SELECT soluongsanpham FROM sanpham WHERE macaycanh = '$macaycanh'";
        $result_stock = mysqli_query($kn, $sql_check_stock);
        if ($result_stock) {
            $product = mysqli_fetch_assoc($result_stock);
            if ($product['soluongsanpham'] < $soluong) {
                $canApprove = false;  // Nếu không đủ sản phẩm thì không duyệt
                break;  // Thoát vòng lặp nếu phát hiện sản phẩm không đủ
            }
        } else {
            die("Lỗi kiểm tra số lượng sản phẩm: " . mysqli_error($kn));
        }
    }

    if ($canApprove) {
        // Nếu số lượng đủ, cập nhật trạng thái và trừ số lượng sản phẩm trong kho
        // Truy vấn lại chi tiết hóa đơn
        $result_chitiethoadon = mysqli_query($kn, $sql_chitiethoadon);  // Lấy lại kết quả truy vấn để cập nhật

        // Trừ số lượng sản phẩm cho mỗi chi tiết hóa đơn
        while ($chitiethoadon = mysqli_fetch_assoc($result_chitiethoadon)) {
            $macaycanh = $chitiethoadon['macaycanh'];
            $soluong = $chitiethoadon['soluong'];

            // Cập nhật số lượng sản phẩm trong bảng sanpham
            $sql_update_soluong = "UPDATE sanpham 
                                   SET soluongsanpham = soluongsanpham - $soluong
                                   WHERE macaycanh = '$macaycanh' AND soluongsanpham >= $soluong";

            if (!mysqli_query($kn, $sql_update_soluong)) {
                die("Lỗi khi cập nhật số lượng sản phẩm: " . mysqli_error($kn));
            }
        }

        // Cập nhật trạng thái hóa đơn là đã duyệt
        $sql_update_hoadon = "UPDATE hoadon SET trangthai = 1 WHERE mahoadon = '$mahoadon' AND trangthai = 0";
        
        if (mysqli_query($kn, $sql_update_hoadon)) {
            // Thành công, hiển thị thông báo và quay lại trang duyệt đơn hàng
            echo "<script type='text/javascript'>
                    alert('Đơn hàng đã được duyệt thành công!');
                    window.location.href = 'duyet_don_hang.php';
                  </script>";
            exit;
        } else {
            echo "<script type='text/javascript'>
                    alert('Có lỗi khi duyệt đơn hàng. Vui lòng thử lại!');
                    window.location.href = 'duyet_don_hang.php';
                  </script>";
        }
    } else {
        // Nếu không đủ số lượng, thông báo lỗi
        echo "<script type='text/javascript'>
                alert('Không đủ sản phẩm trong kho để duyệt đơn hàng. Vui lòng kiểm tra lại.');
                window.location.href = 'duyet_don_hang.php';
              </script>";
    }

} else {
    echo "<script type='text/javascript'>
            alert('Không có mã hóa đơn!');
            window.location.href = 'duyet_don_hang.php';
          </script>";
}
?>
