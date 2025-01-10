<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Registration</title>
</head>
<body>

<?php
include("ketnoi.php");  // Ensure this file contains the proper database connection setup

// Get POST data
$tendangnhap = $_POST["tendangnhap"];
$matkhau = md5($_POST["matkhau"]);
$hoten = $_POST["hoten"];
$dienthoai = $_POST["dienthoai"];
$diachi = $_POST["diachi"];

// Handle file upload for profile picture
$anhdaidien = "images/anhdaidien/" . basename($_FILES["anhdaidien"]["name"]);
$filetam = $_FILES["anhdaidien"]["tmp_name"];
move_uploaded_file($filetam, $anhdaidien);

// Check if the username already exists
$sql1 = "SELECT * FROM nguoidung WHERE tendangnhap = ?";
$stmt1 = $kn->prepare($sql1);
$stmt1->bind_param("s", $tendangnhap);
$stmt1->execute();
$result = $stmt1->get_result();

if ($result->num_rows > 0) {
    echo("<script language='javascript'>
        alert('Tên đăng nhập đã tồn tại');
        window.location = 'dangky.php';
    </script>");
    exit(); // Stop further execution
}

// Set default access level
$quyentruycap = 0;

// Insert new user into database
$sql2 = "INSERT INTO nguoidung (tendangnhap, matkhau, hoten, dienthoai, diachi, anhdaidien, quyentruycap) 
         VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt2 = $kn->prepare($sql2);
$stmt2->bind_param("ssssssi", $tendangnhap, $matkhau, $hoten, $dienthoai, $diachi, $anhdaidien, $quyentruycap);

if ($stmt2->execute()) {
    // Set session variable for logged in user
    $_SESSION["user"] = $tendangnhap;

    // Redirect to user profile page
    echo "<script language='javascript'>
        alert('Đăng ký thành công');
        window.location = 'dangnhap.php';
    </script>";
} else {
    echo("<script language='javascript'>
        alert('Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.');
        window.location = 'dangky.php';
    </script>");
}
?>

</body>
</html>
