<?php
    if (isset($_POST['submit'])) {
        // Ảnh cha (bắt buộc)
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        
        // Ảnh con (bắt buộc)
        $child_image = $_FILES['child_image']['name'];
        $child_image_tmp = $_FILES['child_image']['tmp_name'];
        
        // Di chuyển file lên thư mục
        move_uploaded_file($image_tmp, 'img1/'.$image);
        move_uploaded_file($child_image_tmp, 'img1/'.$child_image);
        
        // Insert vào databasea
        $sql = "INSERT INTO categories (image, child_image) VALUES ('$image', '$child_image')";
        mysqli_query($connect, $sql);
        
        header('Location: index.php?page_layout=danhmuc');
        exit;
    }
?>
<div class="container" style="margin-left: 20px; padding-top: 25px;">
    <h2>Thêm danh mục mới</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Ảnh cha</label>
            <input type="file" name="image" class="form-control-file" style="width: 300px;" required>
        </div>
        <div class="form-group">
            <label for="child_image">Ảnh con</label>
            <input type="file" name="child_image" class="form-control-file" style="width: 300px;" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
    </form>
</div>