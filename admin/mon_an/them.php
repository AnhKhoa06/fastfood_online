<?php
    $sql_category = "SELECT * FROM categories ORDER BY category_id ASC";
    $query_category = mysqli_query($connect, $sql_category);

    if (isset($_POST['sbm'])) {
        $prd_name = trim($_POST['prd_name']);
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'] ?? '';
        $additional_options = $_POST['additional_options'] ?? '';
        $category_id = $_POST['category_id'];

        // Xử lý ảnh
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($image_tmp, 'img/' . $image);

        $sql = "INSERT INTO products 
                (category_id, prd_name, image, price, description, additional_options, quantity)
                VALUES 
                ($category_id, '$prd_name', '$image', $price, '$description', '$additional_options', $quantity)";

        mysqli_query($connect, $sql);
        header('Location: index.php?page_layout=danhsach');
        exit;
    }
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>Thêm món ăn mới</h2>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php while ($row = mysqli_fetch_assoc($query_category)) { ?>
                            <option value="<?php echo $row['category_id']; ?>">
                                <?php echo htmlspecialchars($row['category_name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tên món ăn</label>
                    <input type="text" name="prd_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Ảnh món ăn</label>
                    <input type="file" name="image" class="form-control-file" required>
                </div>
                <div class="form-group">
                    <label>Giá (VNĐ)</label>
                    <input type="number" name="price" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label>Mô tả ngắn</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Lựa chọn thêm (JSON - ví dụ: {"topping":["phô mai","trứng"],"drink":["coca","pepsi"]})</label>
                    <textarea name="additional_options" class="form-control" rows="4" placeholder='{"topping":["phô mai","trứng"],"drink":["coca","pepsi","trà sữa"],"size":["nhỏ","vừa","lớn"]}'></textarea>
                </div>
                <div class="form-group">
                    <label>Số lượng tồn kho</label>
                    <input type="number" name="quantity" class="form-control" required min="0" value="0">
                </div>
                <button type="submit" name="sbm" class="btn btn-success">Thêm món ăn</button>
                <a href="index.php?page_layout=danhsach" class="btn btn-secondary ml-2">Hủy</a>
            </form>
        </div>
    </div>
</div>