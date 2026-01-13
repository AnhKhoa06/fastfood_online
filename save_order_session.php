<?php
session_set_cookie_params(3600); // Giữ session 1 giờ
session_start();
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $_SESSION['pending_order'] = $data;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
}
?>