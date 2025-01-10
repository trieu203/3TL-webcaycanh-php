<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
if (isset($_POST["sbmDNhap"])) {
    $tdn = $_POST["txttdn"]; // User login (username)
    $mk = md5($_POST["password"]); // Encrypt the password
    
    include("ketnoi.php"); // Connect to the database
    
    // Check user credentials
    $sql1 = "SELECT * FROM nguoidung WHERE tendangnhap = '$tdn' AND matkhau = '$mk'";
    $kq1 = mysqli_query($kn, $sql1);
    
    if (mysqli_num_rows($kq1) == 1) {
        // Login success with user
        $rows = mysqli_fetch_assoc($kq1);
        $_SESSION["user"] = $tdn; // Store session for user
        
        // Check the access level (quyentruycap)
        if ($rows['quyentruycap'] == 1) {
            // Admin access
            $_SESSION['admin'] = $tdn;
            echo("<script language='javascript'>
                alert('Đăng nhập thành công với tư cách admin');
                window.location='quanly.php';  // Redirect to admin dashboard
            </script>");
        } else {
            // Regular user access
            echo("<script language='javascript'>
                alert('Đăng nhập thành công với tư cách người dùng');
                window.location='index.php';  // Redirect to user homepage
            </script>");
        }
    } else {
        // Login failed
        echo("<script language='javascript'>
            alert('Đăng nhập thất bại');
            window.location='dangnhap.php';  // Redirect back to login page
        </script>");
    }
}
?>
</body>
</html>