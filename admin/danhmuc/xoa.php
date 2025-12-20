<?php
    $id = $_GET['id'];
    
    // Xóa tất cả sản phẩm thuộc danh mục này trước (nếu có)
    $sql_delete_products = "DELETE FROM products WHERE category_id = $id";
    mysqli_query($connect, $sql_delete_products);
    
    // Sau đó xóa danh mục
    $sql_delete_category = "DELETE FROM categories WHERE category_id = $id";
    mysqli_query($connect, $sql_delete_category);
    
    header('Location: index.php?page_layout=danhmuc');
    exit;
?>