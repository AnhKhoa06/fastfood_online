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
    <link rel="stylesheet" href="assets/css/menu5.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <?php include_once 'components/header.php'; ?>

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
</body>
</html>