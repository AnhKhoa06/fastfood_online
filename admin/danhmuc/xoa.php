<?php
<<<<<<< HEAD
    $id = $_GET['id'];
    
    // Xóa tất cả sản phẩm thuộc danh mục này trước (nếu có)
    $sql_delete_products = "DELETE FROM products WHERE category_id = $id";
    mysqli_query($connect, $sql_delete_products);
    
    // Sau đó xóa danh mục
    $sql_delete_category = "DELETE FROM categories WHERE category_id = $id";
    mysqli_query($connect, $sql_delete_category);
    
    header('Location: index.php?page_layout=danhmuc');
    exit;
=======
    // Bảo mật: chuyển $_GET['id'] thành int, tránh SQL injection cơ bản
    $id = intval($_GET['id'] ?? 0);

    if ($id <= 0) {
        die("ID danh mục không hợp lệ!");
    }

    // OPTIONAL: Nếu bạn có bảng products và muốn xóa hết sản phẩm thuộc danh mục này trước
    // (tránh lỗi foreign key nếu có ràng buộc)
    $sql_delete_products = "DELETE FROM products WHERE category_id = $id";
    mysqli_query($connect, $sql_delete_products);

    // Xóa danh mục chính
    $sql_delete_category = "DELETE FROM categories WHERE category_id = $id";
    $result = mysqli_query($connect, $sql_delete_category);

    if ($result) {
        // Thành công
        header('Location: index.php?page_layout=danhmuc');
        exit;
    } else {
        die("Lỗi khi xóa danh mục: " . mysqli_error($connect));
    }
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)
?>