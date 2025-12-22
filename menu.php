<?php
session_start();
require_once 'admin/config/db.php'; 

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/header/logo.jpg">
    <title>Phở Anh Hai | Thực Đơn</title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <?php include_once 'components/header.php'; ?>

    <!-- Menu Tabs -->
    <div class="menu-tabs">
        <button class="active" data-category="all">Tất Cả</button>
        <button data-category="mon-ngon">MÓN NGON PHẢI THỬ</button>
        <button data-category="ga-gion">GÀ GIÒN VUI VẺ</button>
        <button data-category="mi-jolly">MỲ JOLLY</button>
        <button data-category="ga-sot-cay">GÀ SỐT CAY</button>
        <button data-category="burger">BURGER.COM</button>
        <button data-category="phu">PHẦN ĂN PHỤ</button>
        <button data-category="trang-mieng">MÓN TRÁNG MIỆNG</button>
        <button data-category="do-uong">THỨC UỐNG</button>
    </div>

    <!-- Grid sản phẩm -->
    <div class="products-grid" id="products">
        <!-- Đang tải... -->
        <p style="grid-column: 1/-1; text-align: center; font-size: 18px; color: #666;">Đang tải món ăn...</p>
    </div>

    <?php include_once 'components/footer.php'; ?>

    <script>
        async function loadProducts(category = 'all') {
            const grid = document.getElementById('products');
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; font-size: 18px; color: #666;">Đang tải món ăn...</p>';

            try {
                const response = await fetch(`get_products.php?category=${category}`);
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
                            <div class="product-name">${product.name}</div>
                            <div class="product-desc">${product.description || 'Món ăn ngon, chất lượng cao cấp'}</div>
                            <div class="product-price">${product.price} đ</div>
                            <button class="add-to-cart" onclick="addToCart(${product.id})">Thêm vào giỏ</button>
                        </div>
                    `;
                    grid.appendChild(card);
                });
            } catch (error) {
                grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: red;">Lỗi tải dữ liệu. Vui lòng thử lại!</p>';
            }
        }

        // Tab click
        document.querySelectorAll('.menu-tabs button').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelector('.menu-tabs .active').classList.remove('active');
                btn.classList.add('active');
                loadProducts(btn.dataset.category);
            });
        });

        // Load mặc định
        loadProducts();

        // Hàm thêm vào giỏ (có thể mở rộng sau)
        function addToCart(id) {
            alert('Đã thêm món ăn ID ' + id + ' vào giỏ hàng!');
            // Sau này: gửi AJAX đến cart.php hoặc dùng localStorage
        }
    </script>
</body>
</html>