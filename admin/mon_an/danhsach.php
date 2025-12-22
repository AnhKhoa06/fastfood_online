<?php
    // Lấy danh sách món ăn kèm tên danh mục
    $sql = "SELECT p.*, c.category_name 
            FROM products p 
            INNER JOIN categories c ON p.category_id = c.category_id 
            ORDER BY p.prd_id DESC";
    $query = mysqli_query($connect, $sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="padding-top: 25px; padding-bottom: 25px;">
            <h2 class="mb-0">Danh sách món ăn</h2>
            <a class="btn btn-primary" href="index.php?page_layout=them">Thêm món ăn</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên món ăn</th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Danh mục</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['prd_name']); ?></td>
                            <td>
                                <img src="img/<?php echo htmlspecialchars($row['image']); ?>" width="80" height="80" alt="<?php echo htmlspecialchars($row['prd_name']); ?>">
                            </td>
                            <td><?php echo number_format($row['price'], 0, ',', '.'); ?> đ</td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="index.php?page_layout=sua&id=<?php echo $row['prd_id']; ?>">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa món ăn: <?php echo htmlspecialchars($row['prd_name']); ?>?')" 
                                   href="index.php?page_layout=xoa&id=<?php echo $row['prd_id']; ?>">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>  