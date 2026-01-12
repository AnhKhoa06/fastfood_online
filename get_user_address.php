<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
header('Content-Type: application/json');
require_once 'admin/config/db.php';  // Kết nối DB của bạn

session_start();

if (!isset($_SESSION['user_id'])) {  // Thay bằng key session đăng nhập của bạn (ví dụ: $_SESSION['id'], $_SESSION['user'], ...)
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit;
}

$user_id = $_SESSION['user_id'];  // Điều chỉnh theo session thật của bạn

// Sử dụng mysqli (theo db.php của bạn)
global $connect;

$query = "SELECT address FROM users WHERE id = ?";
$stmt = mysqli_prepare($connect, $query);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Lỗi prepare: ' . mysqli_error($connect)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode([
        'success' => true,
        'address' => $row['address'] ?? ''
    ]);
} else {
    echo json_encode([
        'success' => true,
        'address' => ''  // Không có địa chỉ → rỗng nhưng vẫn success
    ]);
}

mysqli_stmt_close($stmt);
// Không cần đóng $connect vì dùng global
?>