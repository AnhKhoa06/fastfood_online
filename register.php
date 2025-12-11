<?php
require_once 'admin/config/db.php';

if(isset($_POST['sign_up'])){
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email    = mysqli_real_escape_string($connect, $_POST['email']);
    $phone    = mysqli_real_escape_string($connect, $_POST['phone'] ?? '');
    $password = md5($_POST['password']);

    // Kiểm tra trùng username hoặc email
    $check = mysqli_query($connect, "SELECT id FROM users WHERE username='$username' OR email='$email'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Username hoặc Email đã tồn tại!'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO users (username, email, phone, password, is_admin) 
            VALUES ('$username', '$email', '$phone', '$password', 0)";

    if(mysqli_query($connect, $sql)){
        echo "<script>alert('Đăng ký thành công!'); window.location='login-resigter.html?mode=signin';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($connect);
    }
}
?>