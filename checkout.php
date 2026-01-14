<?php
session_start();
require_once 'admin/config/db.php'; 

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}

// Lấy dữ liệu đơn hàng từ session
$order = $_SESSION['pending_order'] ?? null;

// Nếu reload mà session hết → hiển thị trang checkout với thông báo (không redirect)
if (!$order) {
    $order = [
        'selected_items' => [],
        'total_qty' => 0,
        'total_price' => 0,
        'delivery_mode' => 'delivery',
        'store_address' => '',
        'user_info' => []
    ];
    echo '<div class="alert" style="color:red; text-align:center; margin:20px;">Phiên đơn hàng hết hạn hoặc chưa chọn món. Vui lòng quay lại giỏ hàng.</div>';
}

$selected_items = $order['selected_items'] ?? [];
$total_qty = $order['total_qty'] ?? 0;
$total_price = $order['total_price'] ?? 0;
$delivery_mode = $order['delivery_mode'] ?? 'delivery';
$store_address = $order['store_address'] ?? '';
$user_info = $order['user_info'] ?? [];

// Lấy username an toàn
$username = htmlspecialchars($_SESSION['username'] ?? '');
if (empty($username)) {
    echo '<div class="alert" style="color:red; text-align:center; margin:20px;">Phiên đăng nhập hết hạn. Vui lòng đăng nhập lại.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $payment_method = $_POST['payment'] ?? 'cod';
    $selected_items_post = json_decode($_POST['selected_items'] ?? '[]', true); // Lấy từ hidden field để an toàn (nhất quán với hiển thị)
    $total_price = floatval($_POST['total_price'] ?? 0); // Từ hidden
    $delivery_mode = $_POST['delivery_mode'] ?? 'delivery'; // Từ hidden

    // Lấy user_id
    $user_query = "SELECT id FROM users WHERE username = ?";
    $stmt_user = $connect->prepare($user_query);
    $stmt_user->bind_param("s", $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user_row = $result_user->fetch_assoc();

    if (!$user_row || empty($user_row['id'])) {
        echo '<div class="alert" style="color:red; text-align:center; margin:20px;">Lỗi: Không tìm thấy tài khoản. Vui lòng đăng nhập lại.</div>';
    } else {
        $user_id = $user_row['id'];

        // Tạo order_code
        $order_code = 'DH' . rand(100000000, 999999999);
        $status = 'Chờ xác nhận';

        // Insert vào orders
        $insert_order = "INSERT INTO orders (user_id, order_code, created_at, payment_method, status, total_amount, delivery_mode) 
                         VALUES (?, ?, NOW(), ?, ?, ?, ?)";
        $stmt_order = $connect->prepare($insert_order);
        $stmt_order->bind_param("isssds", $user_id, $order_code, $payment_method, $status, $total_price, $delivery_mode);
        $stmt_order->execute();
        $order_id = $connect->insert_id; // ID đơn hàng vừa tạo
        $stmt_order->close();

        // SỬA: Insert vào order_details từ $selected_items_post (từ POST/session, không query cart DB nữa)
        if (!empty($selected_items_post)) {
            foreach ($selected_items_post as $item) {
                $product_id   = $item['product_id'] ?? 0; // Giả sử có 'id' = product_id từ pending_order
                $product_code = $item['code'] ?? ''; // Giả sử có 'code' = product_code
                $product_name = $item['name'] ?? '';
                $quantity     = $item['quantity'] ?? 0;
                $unit_price   = $item['price'] ?? 0;

                // Query lấy product_code từ bảng products dựa trên product_id
                $product_code = '';
                if ($product_id > 0) {
                    $stmt_code = $connect->prepare("SELECT product_code FROM products WHERE prd_id = ? LIMIT 1");
                    $stmt_code->bind_param("i", $product_id);
                    $stmt_code->execute();
                    $code_res = $stmt_code->get_result();
                    if ($code_row = $code_res->fetch_assoc()) {
                        $product_code = $code_row['product_code'] ?? '';
                    }
                    $stmt_code->close();
                }

                if ($product_id > 0 && $quantity > 0) { // Kiểm tra dữ liệu hợp lệ
                    $insert_detail = "INSERT INTO order_details 
                                      (order_id, product_id, product_code, product_name, quantity, unit_price) 
                                      VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt_detail = $connect->prepare($insert_detail);
                    $stmt_detail->bind_param("iissid", $order_id, $product_id, $product_code, $product_name, $quantity, $unit_price);
                    $stmt_detail->execute();
                    $stmt_detail->close();
                }
            }
        } else {
            echo '<div class="alert" style="color:red; text-align:center; margin:20px;">Không có món ăn nào để lưu chi tiết đơn hàng.</div>';
        }

        // Thu thập danh sách product_id đã đặt hàng (từ selected_items_post)
        $placed_product_ids = [];
        foreach ($selected_items_post as $item) {
            $product_id = (int)($item['product_id'] ?? 0);
            if ($product_id > 0) {
                $placed_product_ids[] = $product_id;
            }
        }

        if (!empty($placed_product_ids)) {
            // Xóa CHỈ những product_id đã đặt hàng
            $placeholders = implode(',', array_fill(0, count($placed_product_ids), '?'));
            $delete_cart = "DELETE FROM cart WHERE user_id = ? AND product_id IN ($placeholders)";
            
            $stmt_delete = $connect->prepare($delete_cart);
            
            // Bind: user_id + danh sách product_id
            $types = 'i' . str_repeat('i', count($placed_product_ids));
            $params = array_merge([$user_id], $placed_product_ids);
            $stmt_delete->bind_param($types, ...$params);
            
            $stmt_delete->execute();
            $affected = $stmt_delete->affected_rows;
            echo "<!-- DEBUG: Đã xóa $affected món đã đặt khỏi giỏ hàng -->"; // Để debug
            
            $stmt_delete->close();
        } else {
            // Nếu không có món nào đặt → không xóa gì
        }
        
        unset($_SESSION['cart']); 

        // Thành công
        unset($_SESSION['pending_order']);
        $_SESSION['order_success'] = "Đặt hàng thành công! Đơn hàng #$order_code đã được gửi.";
        header("Location: profile.php?mode=order");
        exit();
    }
    $stmt_user->close();
}

?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/header/logo.jpg">
    <title>Phở Anh Hai | Thanh Toán</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/checkout2.css">
</head>
<body>
    <?php include_once 'components/header1.php'; ?>

    <div class="checkout-container">
        <div class="breadcrumb">
            <i class="bi bi-house-door-fill" style="color: red;"></i>
            <a href="index.php">Trang chủ</a>
            <i class="bi bi-chevron-right"></i>
            <a href="menu.php">Thực đơn</a>
            <i class="bi bi-chevron-right"></i>
            <span>Thanh toán</span>
        </div>

        <div class="checkout-title">
            <h2>THANH TOÁN</h2>
        </div>

        <form id="checkout-form" method="POST">
            <input type="hidden" name="place_order" value="1">
            <input type="hidden" name="selected_items" value='<?php echo htmlspecialchars(json_encode($selected_items)); ?>'>
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <input type="hidden" name="delivery_mode" value="<?php echo $delivery_mode; ?>">

            <div class="checkout-content">
                <div class="checkout-left">
                    <div class="order-details">
                        <h3>Sản phẩm trong đơn (<?php echo $total_qty; ?>)</h3>
                        <div class="order-items">
                            <?php foreach ($selected_items as $item): ?>
                                <div class="order-item">
                                    <div class="item-img">
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    </div>
                                    <div class="item-info">
                                        <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                    </div>
                                    <div class="item-quantity">x<?php echo $item['quantity']; ?></div>
                                    <div class="item-price">
                                        <div class="current-price"><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="payment-methods">
                        <h3>Vui lòng chọn phương thức thanh toán</h3>
                        <div class="payment-options">
                            <!-- COD -->
                            <div class="payment-option active" onclick="updateDescription(this, 'cod'); document.getElementById('payment-method').value='cod';">
                                <input type="radio" id="cod" name="payment" value="cod" checked>
                                <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                                <div class="payment-description">
                                    Bạn chỉ phải thanh toán khi nhận hàng
                                </div>
                            </div>

                            <!-- VN Pay -->
                            <div class="payment-option" onclick="updateDescription(this, 'vnpay'); document.getElementById('payment-method').value='vnpay';">
                                <input type="radio" id="vnpay" name="payment" value="vnpay">
                                <label for="vnpay">Thanh toán Online (Online Payment)</label>
                                <div class="payment-description">
                                    Thanh toán qua cổng thanh toán VN Pay
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="checkout-right">
                    <div class="shipping-info">
                        <div class="section-header">
                            <h3>Thông tin giao hàng</h3>
                            <a href="account.php" class="change-btn">Thay đổi</a>
                        </div>
                        <div class="customer-info" style="color: #333;">
                            <p><strong style="color: #000000;">Họ tên:</strong> <span style="color: #797676;"><?php echo htmlspecialchars($user_info['username'] ?? 'Chưa cập nhật'); ?></span></p>
                            <p><strong style="color: #000000;">Số điện thoại:</strong> <span style="color: #797676;"><?php echo htmlspecialchars($user_info['phone'] ?? 'Chưa cập nhật'); ?></span></p>

                            <?php if ($delivery_mode === 'delivery'): ?>
                                <p><strong style="color: #000000;">Địa chỉ:</strong> <span style="color: #797676;"><?php echo htmlspecialchars($user_info['address'] ?? 'Chưa cập nhật'); ?></span></p>
                                <p><strong style="color: #000000;">Phương thức:</strong> <span style="color: #797676;">Giao hàng tận nơi</span></p>
                            <?php else: ?>
                                <p><strong style="color: #000000;">Nhận tại cửa hàng:</strong> <span style="color: #797676;"><?php echo htmlspecialchars($store_address); ?></span></p>
                                <p><strong style="color: #000000;">Phương thức:</strong> <span style="color: #797676;">Hẹn lấy tại cửa hàng</span></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="section-header">
                            <h3>Đơn hàng</h3>
                        </div>
                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Tạm tính</span>
                                <span class="price"><?php echo number_format($total_price, 0, ',', '.'); ?></span><span class="currency2"><u>đ</u></span>
                            </div>
                            <div class="summary-row">
                                <span>Phí vận chuyển</span>
                                <span class="price">Miễn phí</span>
                            </div>
                            <div class="summary-row">
                                <span>Giảm giá</span>
                                <span class="discount1" id="discount-amount">- 0</span><span class="currency3"><u>đ</u></span>
                            </div>
                            <div class="summary-row total">
                                <span>Tổng tiền</span>
                                <span class="total-price" id="total-price"><?php echo number_format($total_price, 0, ',', '.'); ?></span><span class="currency4"><u>đ</u></span>
                            </div>
                        </div>
                        <button type="submit" class="order-btn">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        function updateDescription(element, method) {
            // Xóa class active khỏi tất cả
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('active');
            });

            // Thêm active vào phần được click
            element.classList.add('active');

            // Đánh dấu radio button tương ứng
            const radio = element.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }

            // Ẩn tất cả mô tả
            document.querySelectorAll('.payment-description').forEach(desc => {
                desc.style.display = 'none';
            });

            // Hiện mô tả của phần được chọn
            const description = element.querySelector('.payment-description');
            if (description) {
                description.style.display = 'block';
            }

            // Cập nhật input hidden payment-method
            document.getElementById('payment-method').value = method;
        }
    </script>

    <?php include_once 'components/footer.php'; ?>
</body>
</html>