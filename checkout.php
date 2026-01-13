<?php
session_start();
require_once 'admin/config/db.php'; 

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}

// Lấy dữ liệu đơn hàng từ session
$order = $_SESSION['pending_order'] ?? null;
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
                        <div class="customer-info">
                            <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($user_info['username'] ?? 'Chưa cập nhật'); ?></p>
                            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user_info['phone'] ?? 'Chưa cập nhật'); ?></p>

                            <?php if ($delivery_mode === 'delivery'): ?>
                                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user_info['address'] ?? 'Chưa cập nhật'); ?></p>
                                <strong>Phương thức:</strong> Giao hàng tận nơi
                            <?php else: ?>
                                <p><strong>Nhận tại cửa hàng:</strong> <?php echo htmlspecialchars($store_address); ?></p>
                                <strong>Phương thức:</strong> Hẹn lấy tại cửa hàng
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