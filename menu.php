<?php
session_start();
require_once 'admin/config/db.php'; 

// Kiểm tra đăng nhập
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}
?>













<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/header/logo.jpg">
    <title>Phở Anh Hai | Thực Đơn</title>
    <link rel="stylesheet" href="assets/css/menu.css"> <!-- File CSS riêng -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
<body>
    <?php include_once 'components/header.php'; ?>

        









    

        

    <?php include_once 'components/footer.php'; ?>
</body>
</html>