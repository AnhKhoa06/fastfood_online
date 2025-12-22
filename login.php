<?php
session_start();
require_once 'admin/config/db.php';

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $pass = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['email']   = $row['email'];     
        $_SESSION['username'] = $row['username'];

        if($row['is_admin'] == 1){
            $_SESSION['admin'] = true;  
        }

        if($row['is_admin'] == 1){
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!'); window.location='login-resigter.html';</script>";
    }
}
?>