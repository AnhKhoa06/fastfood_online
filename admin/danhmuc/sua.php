<?php
<<<<<<< HEAD
    $id = $_GET['id'];
    
    // Lấy thông tin hiện tại
    $sql = "SELECT * FROM categories WHERE category_id = $id";
    $query = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($query);
    
    if (isset($_POST['submit'])) {
        $image = $row['image']; // giữ nguyên nếu không upload mới
        $child_image = $row['child_image'];
        
        // Nếu upload ảnh cha mới
        if ($_FILES['image']['name'] != "") {
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            move_uploaded_file($image_tmp, 'img1/'.$image);
        }
        
        // Nếu upload ảnh con mới
        if ($_FILES['child_image']['name'] != "") {
            $child_image = $_FILES['child_image']['name'];
            $child_image_tmp = $_FILES['child_image']['tmp_name'];
            move_uploaded_file($child_image_tmp, 'img1/'.$child_image);
        }
        
        // Cập nhật database
        $sql_update = "UPDATE categories SET image = '$image', child_image = '$child_image' WHERE category_id = $id";
        mysqli_query($connect, $sql_update);
        
        header('Location: index.php?page_layout=danhmuc');
        exit;
    }
?>
<div class="container" style="margin-left: 20px; padding-top: 25px;">
    <h2>Sửa danh mục</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Ảnh cha hiện tại</label><br>
            <img src="img1/<?php echo htmlspecialchars($row['image']); ?>" width="120" alt="Ảnh cha">
        </div>
        <div class="form-group">
            <label for="image">Đổi ảnh cha (nếu có)</label>
            <input type="file" name="image" class="form-control-file" style="width: 300px;">
        </div>
        
        <div class="form-group">
            <label>Ảnh con hiện tại</label><br>
            <img src="img1/<?php echo htmlspecialchars($row['child_image']); ?>" width="120" alt="Ảnh con">
        </div>
        <div class="form-group">
            <label for="child_image">Đổi ảnh con (nếu có)</label>
            <input type="file" name="child_image" class="form-control-file" style="width: 300px;">
        </div>
        
        <button type="submit" name="submit" class="btn btn-success">Cập nhật</button>
=======
    // Bảo mật ID từ URL
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        die("ID danh mục không hợp lệ!");
    }

    // Lấy thông tin danh mục
    $sql = "SELECT * FROM categories WHERE category_id = $id";
    $query = mysqli_query($connect, $sql);

    if (mysqli_num_rows($query) == 0) {
        die("Danh mục không tồn tại hoặc đã bị xóa!");
    }

    $row = mysqli_fetch_assoc($query);
    $error = '';

    if (isset($_POST['submit'])) {
        $category_name = trim($_POST['category_name']);
        if (empty($category_name)) {
            $error = "Vui lòng nhập tên danh mục!";
        } else {
            $image = $row['image'];
            $child_image = $row['child_image'];

            // Hàm tạo tên file duy nhất
            function generateUniqueFilename($directory, $original_name) {
                if (empty($original_name)) return $original_name;

                $pathinfo = pathinfo($original_name);
                $basename = $pathinfo['filename'];
                $extension = isset($pathinfo['extension']) ? '.' . strtolower($pathinfo['extension']) : '';

                $new_name = $original_name;
                if (file_exists($directory . $new_name)) {
                    $new_name = $basename . '_' . time() . '_' . bin2hex(random_bytes(4)) . $extension;
                }
                return $new_name;
            }

            $upload_dir = 'img1/';

            // Upload ảnh cha mới (nếu có)
            if (!empty($_FILES['image']['name'])) {
                $new_image_name = generateUniqueFilename($upload_dir, $_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_image_name)) {
                    $image = $new_image_name;
                    // Có thể xóa ảnh cũ nếu muốn: @unlink($upload_dir . $row['image']);
                } else {
                    $error = "Lỗi upload ảnh cha!";
                }
            }

            // Upload ảnh con mới (nếu có)
            if (empty($error) && !empty($_FILES['child_image']['name'])) {
                $new_child_name = generateUniqueFilename($upload_dir, $_FILES['child_image']['name']);
                if (move_uploaded_file($_FILES['child_image']['tmp_name'], $upload_dir . $new_child_name)) {
                    $child_image = $new_child_name;
                } else {
                    $error = "Lỗi upload ảnh con!";
                }
            }

            // Cập nhật database nếu không lỗi
            if (empty($error)) {
                $category_name_esc = mysqli_real_escape_string($connect, $category_name);
                $image_esc = mysqli_real_escape_string($connect, $image);
                $child_image_esc = mysqli_real_escape_string($connect, $child_image);

                $sql_update = "UPDATE categories SET 
                               category_name = '$category_name_esc',
                               image = '$image_esc',
                               child_image = '$child_image_esc'
                               WHERE category_id = $id";

                if (mysqli_query($connect, $sql_update)) {
                    header("Location: index.php?page_layout=danhmuc");
                    exit;
                } else {
                    $error = "Lỗi cập nhật: " . mysqli_error($connect);
                }
            }
        }
    }
?>

<div class="container" style="margin-left: 20px; padding-top: 25px;">
    <h2>Sửa danh mục: <?php echo htmlspecialchars($row['category_name']); ?></h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category_name">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" name="category_name" class="form-control" style="width: 400px;"
                   value="<?php echo htmlspecialchars($row['category_name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Ảnh cha hiện tại</label><br>
            <img src="img1/<?php echo htmlspecialchars($row['image']); ?>" width="150" alt="Ảnh cha">
            <small class="form-text text-muted">File: <?php echo htmlspecialchars($row['image']); ?></small>
        </div>
        <div class="form-group">
            <label for="image">Đổi ảnh cha</label>
            <input type="file" name="image" class="form-control-file" accept="image/*">
            <small class="form-text text-muted">Để trống nếu không muốn thay đổi. Trùng tên sẽ tự đổi.</small>
        </div>

        <div class="form-group">
            <label>Ảnh con hiện tại</label><br>
            <img src="img1/<?php echo htmlspecialchars($row['child_image']); ?>" width="150" alt="Ảnh con">
            <small class="form-text text-muted">File: <?php echo htmlspecialchars($row['child_image']); ?></small>
        </div>
        <div class="form-group">
            <label for="child_image">Đổi ảnh con</label>
            <input type="file" name="child_image" class="form-control-file" accept="image/*">
            <small class="form-text text-muted">Để trống nếu không muốn thay đổi. Trùng tên sẽ tự đổi.</small>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Cập nhật</button>
        <a href="index.php?page_layout=danhmuc" class="btn btn-secondary ml-2">Hủy</a>
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)
    </form>
</div>