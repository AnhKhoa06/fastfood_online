<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name           = trim($_POST['name']);
    $address        = trim($_POST['address']);
    $phone          = trim($_POST['phone']);
    $opening_time   = $_POST['opening_time'];
    $closing_time   = $_POST['closing_time'];
    $status         = $_POST['status'];

    $opening_hours = $opening_time . ' - ' . $closing_time;

    $sql = "INSERT INTO stores (name, address, phone, opening_hours, status) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $address, $phone, $opening_hours, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php?page_layout=cuahang");
    exit();
}
?>

<div class="container mt-4">
    <h2>Thêm Cửa hàng</h2>
    <form action="index.php?page_layout=them_cuahang" method="post">
        <div class="form-group">
            <label for="name">Tên cửa hàng</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Phần địa chỉ với gợi ý -->
        <div class="form-group" style="position: relative;">
            <label for="address">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ (gợi ý tự động)" required autocomplete="off">
            <!-- Dropdown gợi ý -->
            <ul id="suggestions-list" class="suggestions-list" style="display: none;"></ul>
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="opening_time">Giờ mở cửa</label>
                <input type="time" class="form-control" id="opening_time" name="opening_time" required>
            </div>
            <div class="form-group col-md-6">
                <label for="closing_time">Giờ đóng cửa</label>
                <input type="time" class="form-control" id="closing_time" name="closing_time" required>
            </div>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Mở cửa">Mở cửa</option>
                <option value="Đóng cửa">Đóng cửa</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thêm cửa hàng</button>
        <a href="index.php?page_layout=cuahang" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<!-- CSS cho dropdown gợi ý (đơn giản, đẹp) -->
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
    z-index: 1050; /* Cao hơn các phần tử khác trong admin */
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

<!-- JavaScript cho autocomplete -->
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

            // Gọi proxy PHP (điều chỉnh đường dẫn nếu cần)
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