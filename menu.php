<?php
session_start();
require_once 'admin/config/db.php'; 

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}

// Lấy category từ query string (từ link dropdown header)
$category = isset($_GET['category']) ? (int)$_GET['category'] : 'all';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/header/logo.jpg">
    <title>Phở Anh Hai | Thực Đơn</title>
    <link rel="stylesheet" href="assets/css/menu6.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <?php include_once 'components/header.php'; ?>
    <div class="delivery-section" style="margin-top: 180px; margin-bottom: -150px;"> <!-- Nhích xuống dưới 60px để không bị che -->
        <div class="delivery-tabs">
            <button class="tab-btn active" data-type="delivery">
                GIAO HÀNG TẬN NƠI
            </button>
            <button class="tab-btn" data-type="pickup">
                ĐẶT ĐẾN LẤY
            </button>
        </div>

        <div class="search-box">
            <input type="text" id="address-input" placeholder="Nhập địa chỉ giao hàng">
            <button class="search-btn">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="white">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Tiêu đề trang -->

    <div class="products-grid" id="products">
        <p style="grid-column: 1/-1; text-align: center; font-size: 18px; color: #666;">Đang tải món ăn...</p>
    </div>

    <!-- Giỏ hàng cố định góc dưới phải - giống Jollibee -->
    <div class="cart-fixed" onclick="viewCart()">
        <i class="bi bi-cart-check"></i>  
        <span class="cart-count" id="cart-count">0</span>
        <span class="cart-label">đ</span>
    </div>

    <?php include_once 'components/footer.php'; ?>

<script>
        // Giỏ hàng tạm (localStorage)
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function updateCartCount() {
            document.getElementById('cart-count').textContent = cart.length;
        }

        function viewCart() {
            if (cart.length === 0) {
                alert('Giỏ hàng trống!');
            } else {
                alert('Giỏ hàng hiện có ' + cart.length + ' món. (Sẽ mở rộng sau!)');
            }
        }

        // Load count khi trang load
        updateCartCount();

        async function loadProducts(category = 'all') {
            const grid = document.getElementById('products');
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; font-size: 18px; color: #666;">Đang tải món ăn...</p>';

            try {
                let url = 'get_products.php';
                if (category !== 'all' && category !== '13') {
                    url += `?category=${category}`;
                }

                const response = await fetch(url);
                const products = await response.json();

                if (products.length === 0) {
                    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #999; font-size: 20px;">Chưa có món ăn nào trong danh mục này.</p>';
                    return;
                }

                grid.innerHTML = '';
                products.forEach(product => {
                    const card = document.createElement('div');
                    card.className = 'product-card';
                    card.innerHTML = `
                        <img src="${product.image}" alt="${product.name}" onerror="this.src='assets/img/placeholder.jpg'">
                        <div class="product-info">
                            <div class="product-name">${product.name.toUpperCase()}</div>
                            <div class="product-desc">${product.description || 'Món ăn ngon, chất lượng cao cấp'}</div>
                            <div class="product-price">${product.price} đ</div>
                        </div>
                    `;
                    grid.appendChild(card);
                });
            } catch (error) {
                grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: red;">Lỗi tải dữ liệu. Vui lòng thử lại!</p>';
            }
        }

        // Load sản phẩm theo category từ URL
        const urlParams = new URLSearchParams(window.location.search);
        let categoryFromUrl = urlParams.get('category') || 'all';

        // Đặc biệt: nếu category_id = 13 → load 'all'
        if (categoryFromUrl === '13') {
            categoryFromUrl = 'all';
        }

        loadProducts(categoryFromUrl);
    </script>
    <script src="assets/js/index5.js"></script>
</body>
</html>
