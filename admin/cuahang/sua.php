<?php
// Xử lý form POST trước
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id             = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name           = trim($_POST['name']);
    $address        = trim($_POST['address']);
    $phone          = trim($_POST['phone']);
    $opening_time   = $_POST['opening_time'];
    $closing_time   = $_POST['closing_time'];
    $status         = $_POST['status'];

    $opening_hours = $opening_time . ' - ' . $closing_time;

    if ($id > 0) {
        $sql = "UPDATE stores 
                SET name = ?, address = ?, phone = ?, opening_hours = ?, status = ? 
                WHERE id = ?";
        
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $address, $phone, $opening_hours, $status, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: index.php?page_layout=cuahang");
        exit();
    }
}

// Lấy thông tin cửa hàng để hiển thị form
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$row = null;

if ($id > 0) {
    $sql = "SELECT * FROM stores WHERE id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Tách opening_hours thành opening_time và closing_time để hiển thị
$opening_time = '';
$closing_time = '';
if ($row && !empty($row['opening_hours'])) {
    $times = explode(' - ', $row['opening_hours']);
    $opening_time = $times[0] ?? '';
    $closing_time = $times[1] ?? '';
}
?>

<div class="container mt-4">
    <h2>Sửa Cửa hàng</h2>

    <?php if ($row === null): ?>
        <p style="color: red;">Không tìm thấy cửa hàng với ID <?php echo $id; ?>!</p>
    <?php else: ?>
        <form action="index.php?page_layout=sua_cuahang" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="form-group">
                <label for="name">Tên cửa hàng</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?php echo htmlspecialchars($row['name']); ?>" required>
            </div>

            <!-- Phần địa chỉ với gợi ý autocomplete -->
            <div class="form-group" style="position: relative;">
                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" 
                       value="<?php echo htmlspecialchars($row['address']); ?>" 
                       placeholder="Nhập địa chỉ (gợi ý tự động)" required autocomplete="off">
                <!-- Dropdown gợi ý -->
                <ul id="suggestions-list" class="suggestions-list" style="display: none;"></ul>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" 
                       value="<?php echo htmlspecialchars($row['phone']); ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="opening_time">Giờ mở cửa</label>
                    <input type="time" class="form-control" id="opening_time" name="opening_time" 
                           value="<?php echo htmlspecialchars($opening_time); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="closing_time">Giờ đóng cửa</label>
                    <input type="time" class="form-control" id="closing_time" name="closing_time" 
                           value="<?php echo htmlspecialchars($closing_time); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Mở cửa"   <?php echo ($row['status'] == 'Mở cửa')   ? 'selected' : ''; ?>>Mở cửa</option>
                    <option value="Đóng cửa" <?php echo ($row['status'] == 'Đóng cửa') ? 'selected' : ''; ?>>Đóng cửa</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="index.php?page_layout=cuahang" class="btn btn-secondary">Quay lại</a>
        </form>
    <?php endif; ?>
</div>

<!-- CSS cho dropdown gợi ý (đơn giản, đẹp, đồng bộ với them.php) -->
<style>
.suggestions-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-top: 4px;
    max-height: 280px;
    overflow-y: auto;
    z-index: 1050; /* Cao để không bị che trong admin */
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    list-style: none;
    padding: 6px 0;
    font-size: 14px;
}

.suggestions-list li {
    padding: 10px 14px;
    cursor: pointer;
    transition: background 0.15s ease;
}

.suggestions-list li:hover,
.suggestions-list li:focus {
    background: #f5f5f5;
}

.suggestions-list li.no-result {
    padding: 12px;
    color: #888;
    cursor: default;
    font-style: italic;
}
</style>

<!-- JavaScript cho autocomplete (đồng bộ với them.php) -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById('address');
    const suggestionsList = document.getElementById('suggestions-list');
    let debounceTimer;

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const query = input.value.trim();
            
            if (query.length < 3) {
                suggestionsList.style.display = 'none';
                suggestionsList.innerHTML = '';
                return;
            }

            // Gọi proxy PHP (điều chỉnh nếu đường dẫn khác)
            const url = `../nominatim_proxy.php?q=${encodeURIComponent(query)}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Proxy error: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    suggestionsList.innerHTML = '';
                    if (data && data.length > 0) {
                        data.forEach(item => {
                            const address = item.address || {};
                            let label = [
                                address.road || address.pedestrian || address.path || '',
                                address.house_number ? address.house_number + ' ' : '',  // Thêm số nhà nếu có
                                address.suburb || address.village || '',
                                address.city || address.town || address.county || '',
                                address.state || '',
                               
                            ].filter(Boolean).join(', ');

                            const li = document.createElement('li');
                            li.textContent = label || item.display_name;
                            li.addEventListener('click', () => {
                                input.value = label || item.display_name;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.innerHTML = '<li class="no-result">Không tìm thấy kết quả phù hợp</li>';
                        suggestionsList.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    suggestionsList.innerHTML = '<li class="no-result">Lỗi kết nối, thử lại sau</li>';
                    suggestionsList.style.display = 'block';
                });
        }, 600);
    });

    // Ẩn dropdown khi click ngoài
    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !suggestionsList.contains(e.target)) {
            suggestionsList.style.display = 'none';
        }
    });
});
</script>