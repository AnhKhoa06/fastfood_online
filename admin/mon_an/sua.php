<?php
    $id = intval($_GET['id']);
    $sql_up = "SELECT * FROM products WHERE prd_id = $id";
    $query_up = mysqli_query($connect, $sql_up);
    $row_up = mysqli_fetch_assoc($query_up);

    $sql_category = "SELECT * FROM categories ORDER BY category_id ASC";
    $query_category = mysqli_query($connect, $sql_category);

    if (isset($_POST['sbm'])) {
        $prd_name = trim($_POST['prd_name']);
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'] ?? '';
        $additional_options = $_POST['additional_options'] ?? '';
        $category_id = $_POST['category_id'];

        // Xử lý ảnh mới (nếu có)
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            move_uploaded_file($image_tmp, 'img/' . $image);
        } else {
            $image = $row_up['image'];
        }

        $sql = "UPDATE products SET 
                category_id = $category_id,
                prd_name = '$prd_name',
                image = '$image',
                price = $price,
                description = '$description',
                additional_options = '$additional_options',
                quantity = $quantity
                WHERE prd_id = $id";

        mysqli_query($connect, $sql);
        header('Location: index.php?page_layout=danhsach');
        exit;
    }
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>Sửa món ăn: <?php echo htmlspecialchars($row_up['prd_name']); ?></h2>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        <?php while ($row = mysqli_fetch_assoc($query_category)) { ?>
                            <option value="<?php echo $row['category_id']; ?>" <?php if ($row['category_id'] == $row_up['category_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($row['category_name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tên món ăn</label>
                    <input type="text" name="prd_name" class="form-control" required value="<?php echo htmlspecialchars($row_up['prd_name']); ?>">
                </div>
                <div class="form-group">
                    <label>Ảnh hiện tại</label><br>
                    <img src="img/<?php echo htmlspecialchars($row_up['image']); ?>" width="150" alt="">
                    <br><small>File: <?php echo htmlspecialchars($row_up['image']); ?></small>
                </div>
                <div class="form-group">
                    <label>Đổi ảnh mới (nếu cần)</label>
                    <input type="file" name="image" class="form-control-file">
                </div>
                <div class="form-group">
                    <label>Giá (VNĐ)</label>
                    <input type="number" name="price" class="form-control" required value="<?php echo $row_up['price']; ?>">
                </div>
                <div class="form-group">
                    <label>Mô tả ngắn</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($row_up['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Lựa chọn thêm (JSON)</label>
                    <textarea name="additional_options" class="form-control" rows="4"><?php echo htmlspecialchars($row_up['additional_options']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Số lượng tồn kho</label>
                    <input type="number" name="quantity" class="form-control" required value="<?php echo $row_up['quantity']; ?>">
                </div>
                <button type="submit" name="sbm" class="btn btn-success">Cập nhật</button>
                <a href="index.php?page_layout=danhsach" class="btn btn-secondary ml-2">Hủy</a>
            </form>
        </div>
    </div>
</div>