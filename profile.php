<?php
session_start();
require_once 'admin/config/db.php'; 

// Kiểm tra đăng nhập
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}

$mode = 'view'; // mặc định
if (isset($_GET['mode'])) {
    if ($_GET['mode'] === 'edit') $mode = 'edit';
    if ($_GET['mode'] === 'address') $mode = 'address';
    if ($_GET['mode'] === 'order') $mode = 'order';
    if ($_GET['mode'] === 'order_details') $mode = 'order_details';
}

$username = htmlspecialchars($_SESSION['username']);
$email = ''; // sẽ lấy từ DB
$phone = '';

// Lấy thông tin user từ DB (giả sử bạn có cột email và phone)
$stmt = $connect->query("SELECT email, phone FROM users WHERE username = '$username'");
if ($stmt && $row = $stmt->fetch_assoc()) {
    $email = htmlspecialchars($row['email'] ?? 'Chưa cập nhật');
    $phone = htmlspecialchars($row['phone'] ?? 'Chưa cập nhật');
} else {
    $email = 'Chưa cập nhật';
    $phone = 'Chưa cập nhật';
}

$address_db = ''; // địa chỉ từ DB
$stmt = $connect->query("SELECT address FROM users WHERE username = '$username'");
if ($stmt && $row = $stmt->fetch_assoc()) {
    $address_db = htmlspecialchars($row['address'] ?? '');
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/header/logo.jpg">
    <title>Phở Anh Hai | Tài khoản của tôi</title>
    <link rel="stylesheet" href="assets/css/profile5.css"> <!-- File CSS riêng -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
<body>
    <?php include_once 'components/header1.php'; ?>
        <?php if (isset($_SESSION['order_success'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin: 20px auto; margin-top: 10px; text-align: center; font-weight: bold;">
                <?php echo $_SESSION['order_success']; unset($_SESSION['order_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['update_success'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo $_SESSION['update_success']; unset($_SESSION['update_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['address_success'])): ?>
            <div class="alert-success">
                <?php echo $_SESSION['address_success']; unset($_SESSION['address_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['address_error'])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #dc3545;">
                <?php echo $_SESSION['address_error']; unset($_SESSION['address_error']); ?>
            </div>
        <?php endif; ?>

    <div class="profile-container">
        <div class="profile-sidebar">
            <h2>TÀI KHOẢN CỦA TÔI</h2>
            <ul class="sidebar-menu">
                <li id="menu-manage" <?php echo ($mode === 'view' ? 'class="active"' : ''); ?>>
                    <a href="profile.php">Quản lý tài khoản</a>
                </li>
                <li id="menu-order" <?php echo (in_array($mode, ['order', 'order_details']) ? 'class="active"' : ''); ?>>
                    <a href="profile.php?mode=order">Quản lý đơn hàng</a>
                </li>
                <li id="menu-address" <?php echo ($mode === 'address' ? 'class="active"' : ''); ?>>
                    <a href="profile.php?mode=address">Địa chỉ giao hàng</a>
                </li>
                <li id="menu-info" <?php echo ($mode === 'edit' ? 'class="active"' : ''); ?>>
                    <a href="profile.php?mode=edit">Thông tin tài khoản</a>
                </li>
                <li><a href="#">Danh sách ưu đãi</a></li>
            </ul>
        </div>

        <div class="profile-main">
            <!-- PHẦN HIỂN THỊ THÔNG TIN (MẶC ĐỊNH) -->
            <div id="view-mode" style="<?php echo $mode === 'view' ? 'display: block !important;' : 'display: none !important;'; ?>">
                <h1 class="title-view">QUẢN LÝ TÀI KHOẢN</h1>
                <p>Xin chào, <strong><?php echo $username; ?></strong>. Với trang này, bạn sẽ quản lý được tất cả thông tin tài khoản của mình.</p>

                <div class="info-box">
                    <div class="info-header">THÔNG TIN TÀI KHOẢN</div>
                    <div class="info-content">
                        <div class="info-left">
                            <h3>THÔNG TIN LIÊN HỆ</h3>
                            <p><?php echo $username; ?></p>
                            <p><?php echo $email; ?></p>
                            <p>
                                <a href="javascript:void(0)" onclick="switchToEditMode()">Chỉnh sửa</a> | 
                                <a href="javascript:void(0)" onclick="switchToEditMode()">Thay đổi mật khẩu</a>
                            </p>
                        </div>
                        <div class="info-right">
                            <h3>ĐĂNG KÝ NHẬN TIN</h3>
                            <p>Bạn chưa đăng ký nhận bản tin</p>
                            <a href="#">Chỉnh sửa</a>
                        </div>
                    </div>
                </div>

                <div class="info-box" style="margin-top: 40px;">
                    <div class="info-header" style="background: #ffd400; color: black;">
                        ĐỊA CHỈ GIAO HÀNG
                        <a href="profile.php?mode=address" style="margin-left: 20px; font-size: 14px; color: #0066cc; font-weight: normal;">Quản lý địa chỉ</a>
                    </div>
                    <div class="info-content" style="padding: 25px 30px;">
                        <h3 style="font-size: 16px; font-weight: 800; color: #333; margin-bottom: -35px;">
                            ĐỊA CHỈ GIAO HÀNG MẶC ĐỊNH
                        </h3>

                        <?php if (!empty($address_db)): ?>
                            <p style="font-size: 15px; color: #333; margin-bottom: -10px; line-height: 1.6;">
                                <i class="bi bi-geo-alt-fill" style="margin-right: 8px; color: #e31837;"></i>
                                <a href="profile.php?mode=address"><strong><?php echo $address_db; ?></strong></a>
                            </p>
                            <a href="profile.php?mode=address" style="color: #0066cc; font-size: 14px;">Chỉnh sửa</a>
                        <?php else: ?>
                            <p style="font-size: 15px; color: #555; margin-bottom: 20px;">
                                Bạn chưa thiết lập địa chỉ giao hàng mặc định.
                            </p>
                            <a href="profile.php?mode=address" style="color: #0066cc; font-size: 14px;">Thêm địa chỉ</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ==================== ĐƠN HÀNG GẦN ĐÂY ==================== -->
                <div class="info-box" style="margin-top: 40px;">
                    <div class="info-header" style="background: #ffd400; color: black;"> ĐƠN HÀNG GẦN ĐÂY</div>
                    <div class="info-content" style="padding: 25px 30px; text-align: center; background: #fff9e6;">
                        <p style="font-size: 15px; color: #d97706; margin: 5px 0;">
                            <i class="bi bi-exclamation-triangle-fill" style="margin-right: 10px; font-size: 18px;"></i>
                            Bạn chưa thực hiện giao dịch nào.
                        </p>
                    </div>
                </div>

                
            </div>

            <!-- PHẦN CHỈNH SỬA (ẨN BAN ĐẦU) -->
             <?php
                $old = $_SESSION['old_data'] ?? [];
                $errors = $_SESSION['update_errors'] ?? [];

                // Xóa session sau khi dùng
                unset($_SESSION['old_data'], $_SESSION['update_errors']);
                ?>
            <div id="edit-mode" style="<?php echo $mode === 'edit' ? 'display: block;' : 'display: none;'; ?>">
                <h1 class="title-edit">CHỈNH SỬA THÔNG TIN TÀI KHOẢN</h1>
                <p>Cập nhật thông tin cá nhân của bạn.</p>

                <form action="update_profile.php" method="POST" class="edit-form">
                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($old['username'] ?? $username); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? $email); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($old['phone'] ?? $phone); ?>">
                    </div>

                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="change_password" id="change-password-toggle" value="1"
                                <?php echo (isset($_POST['change_password']) || isset($errors['current_password']) || isset($errors['new_password'])) ? 'checked' : ''; ?>>
                            Thay đổi mật khẩu
                        </label>
                    </div>

                    <div id="password-fields" style="display: none;">
                        <div class="form-group">
                            <label>Mật khẩu hiện tại <span class="required">*</span></label>
                            <input type="password" name="current_password" id="current_password" value="<?php echo htmlspecialchars($old['current_password'] ?? ''); ?>">
                            <span class="error-msg"><?php echo $errors['current_password'] ?? ''; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Mật khẩu mới <span class="required">*</span></label>
                            <input type="password" name="new_password" id="new_password" value="<?php echo htmlspecialchars($old['new_password'] ?? ''); ?>">
                            <span class="error-msg"><?php echo $errors['new_password'] ?? ''; ?></span>
                        </div>
                    </div>

                    <div class="form-buttons">
                        <button type="button" onclick="switchToViewMode()" class="btn-cancel">Hủy</button>
                        <button type="submit" class="btn-update">CẬP NHẬT</button>
                    </div>
                </form>
            </div>

            <?php
            $old_address = $_SESSION['old_address_data'] ?? [];
            unset($_SESSION['old_address_data']); // xóa sau khi dùng
            ?>
            <!-- PHẦN ĐỊA CHỈ GIAO HÀNG -->
            <div id="address-mode" style="<?php echo $mode === 'address' ? 'display: block;' : 'display: none;'; ?>">
            
                <div class="address-form-box">
                    <h2 style="color: #e31837; font-size: 22px; margin-bottom: 20px; text-align: left;">THÊM ĐỊA CHỈ MỚI</h2>
                    
                    <form action="add_address.php" method="POST" class="address-form">
                        <div class="form-group">
                            <input type="text" name="full_name" placeholder="Họ và tên *" 
                                   value="<?php echo htmlspecialchars($old_address['full_name'] ?? $username); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Số điện thoại *" 
                                   value="<?php echo htmlspecialchars($old_address['phone'] ?? $phone); ?>" required>
                        </div>

                        <!-- Chỉ 1 ô input đơn giản -->
                        <div class="form-group" style="position: relative;">
                            <input type="text" name="address" id="address-input" placeholder="Nhập địa chỉ giao hàng" 
                                value="<?php echo htmlspecialchars($address_db); ?>" required style="width: 100%; padding: 18px 20px; border-radius: 10px; border: 1px solid #ddd; font-size: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); outline: none;">

                            <!-- Danh sách gợi ý - PHẢI có id="suggestions-list" -->
                            <ul id="suggestions-list" class="suggestions-list" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 8px; margin-top: 4px; max-height: 200px; overflow-y: auto; z-index: 1000; list-style: none; padding: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"></ul>
                        </div>
                        
                        <div class="form-buttons" style="margin-top: 30px; justify-content: flex-start;">
                            <a href="profile.php" class="btn-cancel">QUAY LẠI</a>
                            <button type="submit" class="btn-update">LƯU ĐỊA CHỈ</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- PHẦN QUẢN LÝ ĐƠN HÀNG (mode=order) -->
            <div id="order-mode" style="<?php echo $mode === 'order' ? 'display: block;' : 'display: none;'; ?>">
                <h1 class="title-view">QUẢN LÝ ĐƠN HÀNG</h1>
                <p>Xem và quản lý tất cả đơn hàng của bạn.</p>

                <div class="order-content">
                    <h2 class="order-title">Danh sách đơn hàng</h2>

                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Thời gian</th>
                                <th>PTTT</th>
                                <th>Trạng thái</th>
                                <th>Tổng tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy user_id từ DB
                            $user_query = "SELECT id FROM users WHERE username = ?";
                            $stmt_user = $connect->prepare($user_query);
                            $stmt_user->bind_param("s", $username);
                            $stmt_user->execute();
                            $result_user = $stmt_user->get_result();
                            $user_row = $result_user->fetch_assoc();
                            $user_id = $user_row['id'] ?? 0;
                            $stmt_user->close();

                            if ($user_id > 0) {
                                // Fetch danh sách đơn hàng
                                $query = "SELECT order_code, created_at, payment_method, status, total_amount 
                                        FROM orders 
                                        WHERE user_id = ? 
                                        ORDER BY created_at DESC";
                                $stmt = $connect->prepare($query);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($order = $result->fetch_assoc()) {
                                        $payment_text = ($order['payment_method'] === 'cod') ? 'Tiền mặt (COD)' : 'VNPay';
                                        $status_class = strtolower(str_replace(' ', '-', $order['status']));
                                        $status_text = htmlspecialchars($order['status']);
                                        ?>
                                        <tr data-order-code="<?php echo $order['order_code']; ?>">
                                            <td><?php echo htmlspecialchars($order['order_code']); ?></td>
                                            <td><?php echo date('d-m-Y / H:i', strtotime($order['created_at'])); ?></td>
                                            <td><?php echo $payment_text; ?></td>
                                            <td><span class="status-<?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                            <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> đ</td>
                                            <td>
                                                <?php if ($order['status'] === 'Chờ xác nhận'): ?>
                                                    <button class="action-btn cancel-order-btn" data-order-code="<?php echo $order['order_code']; ?>">Hủy đơn</button>
                                                <?php endif; ?>
                                                <?php if ($order['status'] === 'Đang xử lý'): ?>
                                                    <button class="action-btn receive-order-btn" data-order-code="<?php echo $order['order_code']; ?>">Nhận hàng</button>
                                                <?php endif; ?>
                                                <button class="action-btn view-btn" data-order-code="<?php echo $order['order_code']; ?>">Xem chi tiết</button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6" style="text-align:center; color:#999; padding:30px;">Bạn chưa có đơn hàng nào.</td></tr>';
                                }
                                $stmt->close();
                            } else {
                                echo '<tr><td colspan="6" style="text-align:center; color:red; padding:30px;">Lỗi: Không tìm thấy tài khoản.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                // Xử lý nút Hủy đơn (người dùng)
                document.addEventListener('DOMContentLoaded', function() {
                    const cancelButtons = document.querySelectorAll('.cancel-order-btn');
                    cancelButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const orderCode = this.getAttribute('data-order-code');
                            if (confirm('Bạn có chắc chắn muốn hủy đơn hàng ' + orderCode + '?')) {
                                fetch('admin/update_status.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ order_code: orderCode, status: 'Hủy đơn' })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Đã hủy đơn hàng ' + orderCode);
                                        const row = this.closest('tr');
                                        row.querySelector('td:nth-child(4) span').className = 'status-hủy-đơn';
                                        row.querySelector('td:nth-child(4) span').textContent = 'Hủy đơn';
                                        this.remove(); // Xóa nút Hủy
                                    } else {
                                        alert(data.message || 'Lỗi khi hủy đơn hàng');
                                    }
                                })
                                .catch(error => alert('Lỗi: ' + error));
                            }
                        });
                    });

                    // Xử lý nút Nhận hàng (người dùng)
                    const receiveButtons = document.querySelectorAll('.receive-order-btn');
                    receiveButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const orderCode = this.getAttribute('data-order-code');
                            if (confirm('Bạn đã nhận được hàng ' + orderCode + '?')) {
                                fetch('admin/update_status.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ order_code: orderCode, status: 'Đã giao' })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Đã xác nhận nhận hàng ' + orderCode);
                                        const row = this.closest('tr');
                                        row.querySelector('td:nth-child(4) span').className = 'status-đã-giao';
                                        row.querySelector('td:nth-child(4) span').textContent = 'Đã giao';
                                        this.remove(); // Xóa nút Nhận hàng
                                    } else {
                                        alert(data.message || 'Lỗi khi xác nhận nhận hàng');
                                    }
                                })
                                .catch(error => alert('Lỗi: ' + error));
                            }
                        });
                    });
                });
            </script>

            <!-- PHẦN CHI TIẾT ĐƠN HÀNG (mode=order_details) -->
            <div id="order-detail-mode" style="<?php echo $mode === 'order_details' ? 'display: block;' : 'display: none;'; ?>">
                <?php
                if ($mode === 'order_details' && isset($_GET['code'])) {
                    $order_code = $_GET['code'];

                    // Lấy thông tin đơn hàng từ orders
                    $query_order = "SELECT o.*, u.username, u.phone, u.address 
                                    FROM orders o 
                                    LEFT JOIN users u ON o.user_id = u.id 
                                    WHERE o.order_code = ? AND o.user_id = ?";
                    $stmt_order = $connect->prepare($query_order);
                    $stmt_order->bind_param("si", $order_code, $user_id); // $user_id lấy từ phần trên
                    $stmt_order->execute();
                    $result_order = $stmt_order->get_result();
                    $order = $result_order->fetch_assoc();
                    $stmt_order->close();

                    if ($order) {
                        $payment_text = ($order['payment_method'] === 'cod') ? 'Tiền mặt (COD)' : 'VNPay';
                        $total_amount = number_format($order['total_amount'], 0, ',', '.');
                        ?>
                        <div class="order-detail-content">
                            <div class="order-detail-header">
                                <h2>Chi Tiết Đơn Hàng #<?php echo htmlspecialchars($order['order_code']); ?></h2>
                                <a href="profile.php?mode=order" class="back-button"><i class="bi bi-arrow-left"></i> Quay lại danh sách đơn hàng</a>
                            </div>

                            <div class="order-info-container">
                                <div class="info-section">
                                    <h3>Thông Tin Tài Khoản</h3>
                                    <div class="info-content">
                                        <div class="info-row">
                                            <div class="info-label">Tên</div>
                                            <div class="info-value"><?php echo htmlspecialchars($order['username']); ?></div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Số Điện Thoại</div>
                                            <div class="info-value"><?php echo htmlspecialchars($order['phone']); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-section">
                                    <h3>Thông Tin Giao Hàng</h3>
                                    <div class="info-content">
                                        <div class="info-row">
                                            <div class="info-label">Địa Chỉ</div>
                                            <div class="info-value"><?php echo htmlspecialchars($order['address']); ?></div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Phương Thức</div>
                                            <div class="info-value">
                                                <?php 
                                                $delivery_text = ($order['delivery_mode'] === 'delivery') ? 'Giao hàng tận nơi' : 'Hẹn lấy tại cửa hàng';
                                                echo htmlspecialchars($delivery_text);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="order-details-section">
                                <h3>Thông Tin Đơn Hàng</h3>
                                <div class="info-content">
                                    <div class="info-row1">
                                        <div class="info-label">Mã Đơn hàng</div>
                                        <div class="info-value"><?php echo htmlspecialchars($order['order_code']); ?></div>
                                    </div>
                                    <div class="info-row1">
                                        <div class="info-label">Phương Thức Thanh Toán</div>
                                        <div class="info-value"><?php echo $payment_text; ?></div>
                                    </div>
                                    <div class="info-row1">
                                        <div class="info-label">Tổng tiền</div>
                                        <div class="info-value total-price"><?php echo $total_amount; ?> đ</div>
                                    </div>
                                    <!-- Có thể thêm các trường khác nếu cần -->
                                </div>
                            </div>

                            <div class="product-list-section">
                                <h3>Danh sách món ăn</h3>
                                <table class="product-table">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã Món</th>
                                            <th>Tên Món</th>
                                            <th>Số Lượng</th>
                                            <th>Đơn Giá</th>
                                            <th>Thành Tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_details = "SELECT od.*, p.product_code, p.prd_name 
                                                        FROM order_details od 
                                                        LEFT JOIN products p ON od.product_id = p.prd_id 
                                                        WHERE od.order_id = ?";
                                        $stmt_details = $connect->prepare($query_details);
                                        $stmt_details->bind_param("i", $order['id']);
                                        $stmt_details->execute();
                                        $result_details = $stmt_details->get_result();
                                        $stt = 1;
                                        $total_items = 0;
                                        while ($detail = $result_details->fetch_assoc()) {
                                            $subtotal = $detail['quantity'] * $detail['unit_price'];
                                            $total_items += $detail['quantity'];
                                            ?>
                                            <tr>
                                                <td><?php echo $stt++; ?></td>
                                                <td><?php echo htmlspecialchars($detail['product_code']); ?></td>
                                                <td><?php echo htmlspecialchars($detail['product_name'] ?: $detail['product_name']); ?></td>
                                                <td><?php echo $detail['quantity']; ?></td>
                                                <td><?php echo number_format($detail['unit_price'], 0, ',', '.'); ?> đ</td>
                                                <td><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</td>
                                            </tr>
                                            <?php
                                        }
                                        $stmt_details->close();
                                        ?>
                                    </tbody>
                                </table>
                                <p style="text-align:right; font-weight:bold; margin-top:10px;">
                                    Tổng số món: <?php echo $total_items; ?>
                                </p>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<p style="text-align:center; color:red; padding:30px;">Không tìm thấy đơn hàng #' . htmlspecialchars($order_code) . '.</p>';
                    }
                }
                ?>
            </div>

        </div>
    </div>

    <?php include_once 'components/footer.php'; ?>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Đợi DOM load xong mới lấy element
    const input = document.getElementById('address-input');
    const suggestionsList = document.getElementById('suggestions-list');
    let debounceTimer;

    // Chỉ chạy nếu đang ở mode address (có input + ul)
    if (!input || !suggestionsList) {
        console.log('Không tìm thấy input hoặc suggestions-list → script gợi ý không chạy');
        return;
    }

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const query = input.value.trim();
            
            if (query.length < 3) {
                suggestionsList.style.display = 'none';
                suggestionsList.innerHTML = '';
                return;
            }

            const url = `nominatim_proxy.php?q=${encodeURIComponent(query)}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Proxy error');
                    return response.json();
                })
                .then(data => {
                    suggestionsList.innerHTML = '';
                    if (data && data.length > 0) {
                        data.forEach(item => {
                            const address = item.address || {};
                            let label = [
                                address.house_number ? address.house_number + ' ' : '',
                                address.road || address.pedestrian || '',
                                address.suburb || address.village || '',
                                address.city || address.town || address.county || '',
                                address.state || '',
                                address.postcode || ''
                            ].filter(Boolean).join(', ');

                            const li = document.createElement('li');
                            li.textContent = label || item.display_name;
                            li.style.padding = '10px 14px';
                            li.style.cursor = 'pointer';
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
                    console.error('Lỗi fetch Nominatim:', error);
                    suggestionsList.innerHTML = '<li class="no-result">Lỗi kết nối</li>';
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



<!---------------------------------------->


<script>
// Giữ nguyên hàm cũ cho edit/view
function switchToEditMode() {
    document.getElementById('view-mode').style.display = 'none';
    document.getElementById('edit-mode').style.display = 'block';

    // Chuyển active sidebar
    document.getElementById('menu-manage').classList.remove('active');
    document.getElementById('menu-info').classList.add('active');
}

function switchToViewMode() {
    document.getElementById('view-mode').style.display = 'block';
    document.getElementById('edit-mode').style.display = 'none';

    // Chuyển active sidebar về
    document.getElementById('menu-manage').classList.add('active');
    document.getElementById('menu-info').classList.remove('active');
}

// BỔ SUNG: Hàm chuyển sang address-mode
function switchToAddressMode() {
    document.getElementById('view-mode').style.display = 'none';
    document.getElementById('edit-mode').style.display = 'none';
    document.getElementById('order-mode').style.display = 'none';
    document.getElementById('address-mode').style.display = 'block';

    // Active sidebar
    document.querySelectorAll('.sidebar-menu li').forEach(li => li.classList.remove('active'));
    document.getElementById('menu-address').classList.add('active');
}

// BỔ SUNG: Hàm chuyển sang order-mode
function switchToOrderMode() {
    document.getElementById('view-mode').style.display = 'none';
    document.getElementById('edit-mode').style.display = 'none';
    document.getElementById('address-mode').style.display = 'none';
    document.getElementById('order-mode').style.display = 'block';

    // Active sidebar
    document.querySelectorAll('.sidebar-menu li').forEach(li => li.classList.remove('active'));
    document.getElementById('menu-order').classList.add('active');
}

// Tick thay đổi mật khẩu (giữ nguyên)
document.getElementById('change-password-toggle').addEventListener('change', function() {
    document.getElementById('password-fields').style.display = this.checked ? 'block' : 'none';
});

// Tự động chuyển mode khi load trang dựa trên URL ?mode=...
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentMode = urlParams.get('mode') || 'view'; // mặc định view

    // Chuyển mode dựa trên URL
    if (currentMode === 'edit') {
        switchToEditMode();
    } else if (currentMode === 'address') {
        switchToAddressMode();
    } else if (currentMode === 'order') {
        switchToOrderMode();
    } else if (currentMode === 'order_details') {
        // BỔ SUNG: xử lý order_details (giống order-mode nhưng hiện chi tiết)
        switchToOrderMode(); // giữ active sidebar ở menu-order
        // Ẩn order-mode, hiện order-detail-mode
        document.getElementById('order-mode').style.display = 'none';
        document.getElementById('order-detail-mode').style.display = 'block';
    } else {
        switchToViewMode(); // mặc định view
    }

    // Giữ logic checkbox mật khẩu
    const toggle = document.getElementById('change-password-toggle');
    const fields = document.getElementById('password-fields');
    
    if (toggle && fields) {
        if (toggle.checked) {
            fields.style.display = 'block';
        }
    }
});

// BỔ SUNG: Xử lý nút "Xem chi tiết" trong mode order
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderCode = this.getAttribute('data-order-code');
            // Reload trang với mode=order_details và code đơn hàng
            window.location.href = 'profile.php?mode=order_details&code=' + orderCode;
        });
    });

    // Nút "Quay lại danh sách đơn hàng" trong chi tiết
    const backButton = document.querySelector('.back-button');
    if (backButton) {
        backButton.addEventListener('click', function() {
            // Reload trang về mode=order
            window.location.href = 'profile.php?mode=order';
        });
    }
});
</script>