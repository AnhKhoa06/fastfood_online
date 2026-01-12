<?php
// Tắt hiển thị lỗi ra màn hình
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Buffer để loại bỏ output thừa
ob_start();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$province = trim($_GET['province'] ?? '');

if (empty($province)) {
    ob_end_clean();
    echo json_encode(['error' => 'Thiếu tham số province']);
    exit;
}

// Kết nối DB - ĐÃ SỬA TÊN DB CỦA BẠN
$host     = 'localhost';
$user     = 'root';
$password = '';
$dbname   = 'fastfood';  // Đã thay rồi thì giữ nguyên

$connect = new mysqli($host, $user, $password, $dbname);

if ($connect->connect_error) {
    ob_end_clean();
    echo json_encode(['error' => 'Kết nối DB thất bại: ' . $connect->connect_error]);
    exit;
}

// Query thực tế (lấy cửa hàng theo tỉnh)
$sql = "SELECT * FROM stores WHERE address LIKE ? ORDER BY name";
$stmt = $connect->prepare($sql);

if (!$stmt) {
    ob_end_clean();
    echo json_encode(['error' => 'Lỗi prepare SQL: ' . $connect->error]);
    $connect->close();
    exit;
}

$likeProvince = "%$province%";
$stmt->bind_param("s", $likeProvince);

if (!$stmt->execute()) {
    ob_end_clean();
    echo json_encode(['error' => 'Lỗi execute: ' . $stmt->error]);
    $stmt->close();
    $connect->close();
    exit;
}

$result = $stmt->get_result();
$stores = [];

while ($row = $result->fetch_assoc()) {
    $stores[] = $row;
}

$stmt->close();
$connect->close();

// Output JSON duy nhất, sạch sẽ
ob_end_clean();
echo json_encode([
    'status' => 'success',
    'stores' => $stores,
    'count'  => count($stores)
]);
exit;
?>