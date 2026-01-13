<?php
session_start();
require_once 'admin/config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT username, phone, address FROM users WHERE username = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode([
        'success' => true,
        'username' => $row['username'],
        'phone' => $row['phone'],
        'address' => $row['address']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy thông tin user']);
}
?>