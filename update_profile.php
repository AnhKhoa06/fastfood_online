<?php
session_start();
require_once 'admin/config/db.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}

$username_current = $_SESSION['username'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['username']);
    $new_email    = trim($_POST['email']);
    $new_phone    = trim($_POST['phone'] ?? '');

    // Kiểm tra nếu có tick thay đổi mật khẩu
    $change_password = isset($_POST['change_password']) && $_POST['change_password'] === '1';

    if ($change_password) {
        $current_password = $_POST['current_password'] ?? '';
        $new_password     = $_POST['new_password'] ?? '';

        if (empty($current_password)) {
            $errors['current_password'] = "Đây là thông tin bắt buộc";
        }
        if (empty($new_password)) {
            $errors['new_password'] = "Đây là thông tin bắt buộc";
        }

        // Kiểm tra mật khẩu hiện tại đúng không
        if (empty($errors)) {
            $hashed_current = md5($current_password);
            $check = mysqli_query($connect, "SELECT id FROM users WHERE username='$username_current' AND password='$hashed_current'");
            if (mysqli_num_rows($check) == 0) {
                $errors['current_password'] = "Mật khẩu hiện tại không đúng";
            }
        }
    }

    // Nếu có lỗi → lưu lỗi + dữ liệu cũ → quay lại form
    if (!empty($errors)) {
        $_SESSION['update_errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: profile.php?mode=edit");
        exit();
    }

    // Cập nhật thông tin
    $sql = "UPDATE users SET username='$new_username', email='$new_email', phone='$new_phone'";

    if ($change_password) {
        $hashed_new = md5($new_password);
        $sql .= ", password='$hashed_new'";
    }

    $sql .= " WHERE username='$username_current'";

    if (mysqli_query($connect, $sql)) {
        // Cập nhật session nếu username thay đổi
        $_SESSION['username'] = $new_username;

        $_SESSION['update_success'] = "Cập nhật thông tin thành công!";
        header("Location: profile.php?mode=edit");
    } else {
        $_SESSION['update_error'] = "Có lỗi xảy ra!";
        header("Location: profile.php?mode=edit");
    }
    exit();
}
?>