<?php
require_once 'admin/config/db.php';

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 'all';

$sql = "SELECT p.prd_id AS id, p.prd_name AS name, p.image, p.price, p.description, c.category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id";

if ($category_id !== 'all') {
    $sql .= " WHERE p.category_id = $category_id";
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