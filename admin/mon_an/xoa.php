<?php
    $id = intval($_GET['id']);

    if ($id > 0) {
        // Xóa món ăn (các món thuộc danh mục sẽ tự xóa nhờ ON DELETE CASCADE nếu cần)
        $sql = "DELETE FROM products WHERE prd_id = $id";
        mysqli_query($connect, $sql);
    }

    header('Location: index.php?page_layout=danhsach');
    exit;
?>