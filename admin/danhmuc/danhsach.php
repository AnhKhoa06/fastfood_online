<?php
    // Lấy danh sách danh mục - mới nhất lên đầu
    $sql = "SELECT * FROM categories ORDER BY category_id DESC";
    $query = mysqli_query($connect, $sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="padding-top: 25px; padding-bottom: 25px;">
            <h2 class="mb-0">Danh sách danh mục</h2>
            <a class="btn btn-primary" href="index.php?page_layout=them_danhmuc">Thêm danh mục</a>
        </div>
        <div class="card-body">
            <?php if (mysqli_num_rows($query) == 0): ?>
                <p class="text-center">Chưa có danh mục nào.</p>
            <?php else: ?>
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>STT</th>
                            <th>ID</th> <!-- Thêm cột ID thật để dễ debug -->
                            <th>Tên danh mục</th>
                            <th>Ảnh cha</th>
                            <th>Ảnh con</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stt = 1;
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $stt++; ?></td>
                                <td><strong><?php echo $row['category_id']; ?></strong></td> <!-- Hiển thị ID thật -->
                                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                <td>
                                    <img src="img1/<?php echo htmlspecialchars($row['image']); ?>"
                                         width="80" height="80" alt="Ảnh cha">
                                </td>
                                <td>
                                    <img src="img1/<?php echo htmlspecialchars($row['child_image']); ?>"
                                         width="80" height="80" alt="Ảnh con">
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="index.php?page_layout=sua_danhmuc&id=<?php echo $row['category_id']; ?>">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-danger" onclick="return Del(<?php echo $row['category_id']; ?>)"
                                       href="index.php?page_layout=xoa_danhmuc&id=<?php echo $row['category_id']; ?>">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function Del(id) {
        return confirm("Bạn có chắc chắn muốn xóa danh mục ID: " + id + "?\nHành động này không thể hoàn tác!");
    }
</script>