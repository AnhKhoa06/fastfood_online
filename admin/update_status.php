<?php
session_start();
require_once 'config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $order_code = $input['order_code'] ?? '';
    $new_status = $input['status'] ?? '';

    if (empty($order_code) || empty($new_status)) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
        exit;
    }

    // Kiểm tra quyền (tùy chọn: admin hoặc chủ đơn hàng)
    // Hiện tại cho phép cả 2 (có thể thêm kiểm tra sau)

    $query = "UPDATE orders SET status = ? WHERE order_code = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("ss", $new_status, $order_code);
    $success = $stmt->execute();

    echo json_encode(['success' => $success]);
    $stmt->close();
    exit;
}
?>