<?php
require_once 'admin/config/db.php';

$category_filter = $_GET['category'] ?? 'all';

$sql = "SELECT p.prd_id AS id, p.prd_name AS name, p.image, p.price, p.description, c.category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id";

if ($category_filter !== 'all') {
    // Map data-category từ button sang tên danh mục thực tế (bạn có thể điều chỉnh nếu cần)
    $category_map = [
        'mon-ngon' => 'MÓN NGON PHẢI THỬ',
        'ga-gion' => 'GÀ GIÒN VUI VẺ',
        'mi-jolly' => 'MỲ JOLLY',
        'ga-sot-cay' => 'GÀ SỐT CAY',
        'burger' => 'BURGER.COM',
        'phu' => 'PHẦN ĂN PHỤ',
        'trang-mieng' => 'MÓN TRÁNG MIỆNG',
        'do-uong' => 'THỨC UỐNG'
    ];
    
    $cat_name = $category_map[$category_filter] ?? '';
    if ($cat_name) {
        $sql .= " WHERE c.category_name = '$cat_name'";
    }
}

$sql .= " ORDER BY p.prd_id DESC";

$query = mysqli_query($connect, $sql);
$products = [];

while ($row = mysqli_fetch_assoc($query)) {
    $row['image'] = 'admin/img/' . $row['image']; // Đường dẫn đầy đủ
    $row['price'] = number_format($row['price'], 0, ',', '.');
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
?>