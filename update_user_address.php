<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
header('Content-Type: application/json');
require_once 'admin/config/db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$address = trim($input['address'] ?? '');

if (empty($address)) {
    echo json_encode(['success' => false, 'message' => 'Địa chỉ rỗng']);
    exit;
}

$user_id = $_SESSION['user_id'];

global $connect;

$query = "UPDATE users SET address = ? WHERE id = ?";
$stmt = mysqli_prepare($connect, $query);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Lỗi prepare: ' . mysqli_error($connect)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "si", $address, $user_id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    echo json_encode(['success' => true, 'message' => 'Đã lưu địa chỉ']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lưu thất bại: ' . mysqli_error($connect)]);
}

mysqli_stmt_close($stmt);
?>