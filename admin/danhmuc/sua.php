<?php
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
    </form>
</div>