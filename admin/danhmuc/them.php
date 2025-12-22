<?php
    $error = '';
    $category_name = ''; // Để giữ giá trị khi có lỗi

    if (isset($_POST['submit'])) {
        // Lấy và kiểm tra tên danh mục
        $category_name = trim($_POST['category_name']);
        if (empty($category_name)) {
            $error = "Vui lòng nhập tên danh mục!";
        } elseif (empty($_FILES['image']['name'])) {
            $error = "Vui lòng chọn ảnh cha!";
        } elseif (empty($_FILES['child_image']['name'])) {
            $error = "Vui lòng chọn ảnh con!";
        } else {
            // Hàm tạo tên file duy nhất (tránh trùng + tránh ghi đè)
            function generateUniqueFilename($directory, $original_name) {
                if (empty($original_name)) return '';

                $pathinfo = pathinfo($original_name);
                $basename = $pathinfo['filename'];
                $extension = isset($pathinfo['extension']) ? '.' . strtolower($pathinfo['extension']) : '';

                $new_name = $original_name;

                // Nếu file đã tồn tại → thêm time + random
                if (file_exists($directory . $new_name)) {
                    $new_name = $basename . '_' . time() . '_' . bin2hex(random_bytes(4)) . $extension;
                }

                return $new_name;
            }

            $upload_dir = 'img1/';

            // Xử lý ảnh cha
            $image = generateUniqueFilename($upload_dir, $_FILES['image']['name']);
            $image_tmp = $_FILES['image']['tmp_name'];

            // Xử lý ảnh con
            $child_image = generateUniqueFilename($upload_dir, $_FILES['child_image']['name']);
            $child_image_tmp = $_FILES['child_image']['tmp_name'];

            // Upload ảnh cha
            if (!move_uploaded_file($image_tmp, $upload_dir . $image)) {
                $error = "Lỗi upload ảnh cha! Vui lòng thử lại.";
            }
            // Upload ảnh con
            elseif (!move_uploaded_file($child_image_tmp, $upload_dir . $child_image)) {
                // Nếu ảnh con lỗi → xóa ảnh cha đã upload
                @unlink($upload_dir . $image);
                $error = "Lỗi upload ảnh con! Vui lòng thử lại.";
            } else {
                // Bảo mật dữ liệu trước khi insert
                $category_name_esc = mysqli_real_escape_string($connect, $category_name);
                $image_esc = mysqli_real_escape_string($connect, $image);
                $child_image_esc = mysqli_real_escape_string($connect, $child_image);

                // QUAN TRỌNG: Không chỉ định category_id → để AUTO_INCREMENT tự chạy
                $sql = "INSERT INTO categories (category_name, image, child_image) 
                        VALUES ('$category_name_esc', '$image_esc', '$child_image_esc')";

                if (mysqli_query($connect, $sql)) {
                    // Thành công → chuyển hướng
                    header('Location: index.php?page_layout=danhmuc');
                    exit;
                } else {
                    // Lỗi database → xóa ảnh đã upload
                    @unlink($upload_dir . $image);
                    @unlink($upload_dir . $child_image);
                    $error = "Lỗi lưu dữ liệu: " . mysqli_error($connect);
                }
            }
        }
    }
?>

<div class="container" style="margin-left: 20px; padding-top: 25px;">
    <h2>Thêm danh mục mới</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category_name">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" name="category_name" class="form-control" style="width: 400px;" 
                   value="<?php echo htmlspecialchars($category_name); ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Ảnh cha <span class="text-danger">*</span></label>
            <input type="file" name="image" class="form-control-file" style="width: 300px;" required accept="image/*">
            <small class="form-text text-muted">
                Định dạng: jpg, jpeg, png, gif, webp. Nếu trùng tên, hệ thống tự đổi tên để tránh ghi đè.
            </small>
        </div>

        <div class="form-group">
            <label for="child_image">Ảnh con <span class="text-danger">*</span></label>
            <input type="file" name="child_image" class="form-control-file" style="width: 300px;" required accept="image/*">
            <small class="form-text text-muted">
                Định dạng: jpg, jpeg, png, gif, webp. Nếu trùng tên, hệ thống tự đổi tên để tránh ghi đè.
            </small>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm danh mục</button>
        <a href="index.php?page_layout=danhmuc" class="btn btn-secondary ml-2">Hủy</a>
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)
    </form>
</div>