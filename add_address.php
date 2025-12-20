<?php
session_start();
require_once 'admin/config/db.php'; 

// Kiểm tra đăng nhập
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? 0; // nếu bạn có lưu user_id trong session
    $username_current = $_SESSION['username'];

    // Lấy dữ liệu từ form
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? ''); // địa chỉ đầy đủ đã gộp từ JS
    $note = trim($_POST['note'] ?? '');

    // Kiểm tra bắt buộc
    if (empty($full_name) || empty($phone) || empty($address)) {
        $_SESSION['address_error'] = "Vui lòng điền đầy đủ thông tin bắt buộc!";
        header("Location: profile.php?mode=address");
        exit();
    }

    // Gộp địa chỉ + ghi chú nếu có
    $final_address = $address;
    if (!empty($note)) {
        $final_address .= " (Ghi chú: $note)";
    }

    // Cập nhật vào cột address của bảng users
    $sql = "UPDATE users SET address = ? WHERE username = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ss", $final_address, $username_current);

    if ($stmt->execute()) {
        $_SESSION['address_success'] = "Lưu địa chỉ thành công!";
    } else {
        $_SESSION['address_error'] = "Có lỗi khi lưu địa chỉ, vui lòng thử lại.";
    }

    $stmt->close();
    header("Location: profile.php?mode=address");
    exit();
}
?>