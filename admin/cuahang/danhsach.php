<?php
$sql = "SELECT * FROM stores ORDER BY id ASC";  // Sắp xếp theo ID mới nhất (vì không còn created_at)
$query = mysqli_query($connect, $sql);
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="padding-top: 25px; padding-bottom: 25px;">
            <h2 class="mb-0">Danh sách Cửa hàng</h2>
            <a class="btn btn-primary" href="index.php?page_layout=them_cuahang">Thêm Cửa hàng</a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Tên cửa hàng</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Giờ hoạt động</th>
                        <th>Trạng thái</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) { 
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['opening_hours']); ?></td>
                            <td>
                                <?php 
                                $status = $row['status'];
                                if ($status === 'Mở cửa') {
                                    echo '<span class="badge badge-success">Mở cửa</span>';
                                } else {
                                    echo '<span class="badge badge-danger">Đóng cửa</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="index.php?page_layout=sua_cuahang&id=<?php echo $row['id']; ?>">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-danger" onclick="return Del('<?php echo htmlspecialchars(addslashes($row['name'])); ?>')" 
                                   href="index.php?page_layout=xoa_cuahang&id=<?php echo $row['id']; ?>">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else { 
                    ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Chưa có cửa hàng nào. Hãy thêm mới!
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function Del(name) {
    return confirm("Bạn có chắc chắn muốn xóa cửa hàng: " + name + " ?");
}
</script>