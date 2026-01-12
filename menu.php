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
    <link rel="stylesheet" href="assets/css/menu7.css">
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

        <div class="search-box" style="position: relative;">
            <input type="text" id="address-input" placeholder="Nhập địa chỉ giao hàng">
            <button class="search-btn">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="white">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
            </button>
            <!-- Dropdown gợi ý (sẽ tự hiện khi có data) -->
             <ul id="suggestions-list" class="suggestions-list" style="display: none;"></ul>
        </div>
    </div>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
                let input = document.getElementById('address-input');
                let suggestionsList = document.getElementById('suggestions-list');
                const deliverySection = document.querySelector('.delivery-section');
                let debounceTimer;
                let currentTabType = 'delivery'; // Mặc định là GIAO HÀNG TẬN NƠI

                // Load trạng thái từ localStorage khi trang load
                // Load trạng thái khi trang load (từ DB thay vì localStorage)
                let userAddressFromDB = ''; // Biến tạm để lưu địa chỉ từ server

                fetch('get_user_address.php')
                    .then(response => {
                        if (!response.ok) throw new Error('Lỗi lấy địa chỉ');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.address) {
                            userAddressFromDB = data.address;
                            console.log('Địa chỉ từ DB khi load:', userAddressFromDB);
                        
                            // Nếu đã có cửa hàng được chọn trước đó (vẫn giữ localStorage cho store + tab)
                            const savedState = localStorage.getItem('deliveryState');
                            if (savedState) {
                                const state = JSON.parse(savedState);
                                currentTabType = state.tabType || 'delivery';
                                const selectedStore = state.selectedStore;
                            
                                if (selectedStore) {
                                    document.querySelectorAll('.tab-btn').forEach(tab => {
                                        tab.classList.remove('active');
                                        if (tab.getAttribute('data-type') === currentTabType) {
                                            tab.classList.add('active');
                                        }
                                    });
                                    replaceDeliverySection(selectedStore, userAddressFromDB, true);
                                }
                            }
                        } else {
                            console.log('Không có địa chỉ trong DB hoặc lỗi:', data.message || 'Không có dữ liệu');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi lấy địa chỉ từ server:', error);
                    });

                // Theo dõi tab active
                const tabs = document.querySelectorAll('.tab-btn');
                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        tabs.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        currentTabType = this.getAttribute('data-type');
                    });
                });

                // Tạo modal nếu chưa có (append vào body)
                const modal = document.createElement('div');
                modal.id = 'store-modal';
                modal.style.display = 'none';
                modal.innerHTML = `
                    <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9998;"></div>
                    <div class="modal-content" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 12px; width: 90%; max-width: 500px; max-height: 80vh; overflow-y: auto; z-index: 9999; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        <div style="padding: 15px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="margin: 0; font-size: 18px;">CHỌN CỬA HÀNG</h3>
                            <button id="close-modal" style="background: none; border: none; font-size: 24px; cursor: pointer;">×</button>
                        </div>
                        <div id="store-list" style="padding: 15px;"></div>
                    </div>
                `;
                document.body.appendChild(modal);

                const closeModal = () => {
                    modal.style.display = 'none';
                };

                document.getElementById('close-modal').addEventListener('click', closeModal);
                modal.querySelector('.modal-overlay').addEventListener('click', closeModal);

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

                                        // Sửa tỉnh nếu cần (tùy chọn)
                                        // if (label.includes('Gia Lai') && label.includes('Quy Nhơn')) {
                                        //     label = label.replace('Gia Lai', 'Bình Định');
                                        // }

                                        const li = document.createElement('li');
                                        li.textContent = label || item.display_name;
                                        li.style.padding = '10px 14px';
                                        li.style.cursor = 'pointer';
                                        li.addEventListener('click', () => {
                                            input.value = label || item.display_name;
                                            suggestionsList.style.display = 'none';

                                            // Trích xuất tỉnh từ label (giả sử tỉnh là phần cuối cùng trước mã bưu điện hoặc cuối chuỗi)
                                            const parts = label.split(', ');
                                            let province = parts[parts.length - 2] || ''; // Thường là state (tỉnh)
                                            if (province.includes('Tỉnh')) province = province.replace('Tỉnh ', '');
                                            province = province.trim();

                                            if (province) {
                                                showStoresModal(province);
                                            } else {
                                                alert('Không trích xuất được tỉnh từ địa chỉ.');
                                            }
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
                                suggestionsList.innerHTML = '<li class="no-result">Lỗi kết nối</li>';
                                suggestionsList.style.display = 'block';
                            });
                    }, 600);
                });

                // Hàm hiển thị modal với danh sách cửa hàng theo tỉnh
                function showStoresModal(province) {
                    console.log('Đang tải cửa hàng cho tỉnh:', province); // Debug

                    fetch(`get_stores_by_province.php?province=${encodeURIComponent(province)}`)
                        .then(response => {
                            console.log('Response status:', response.status); // Debug
                            if (!response.ok) throw new Error('Proxy error: ' + response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Data nhận được:', data); // Debug toàn bộ response

                            const storeList = document.getElementById('store-list');
                            storeList.innerHTML = '';

                            if (data.error) {
                                storeList.innerHTML = `<p style="color:red;">${data.error}</p>`;
                            } else if (data.stores && data.stores.length > 0) {
                                data.stores.forEach(store => {
                                    const card = document.createElement('div');
                                    card.style.marginBottom = '15px';
                                    card.style.border = '1px solid #ddd';
                                    card.style.borderRadius = '8px';
                                    card.style.padding = '12px';
                                    card.style.background = '#fff';
                                    card.style.cursor = 'pointer';
                                    card.style.transition = 'all 0.2s ease';

                                    // Hover
                                    card.addEventListener('mouseover', () => {
                                        card.style.background = '#f8f9fa';
                                        card.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
                                    });
                                    card.addEventListener('mouseout', () => {
                                        card.style.background = '#fff';
                                        card.style.boxShadow = 'none';
                                    });
                                    // Xác định màu trạng thái
                                    let statusColor = '#28a745'; // Xanh lá mặc định cho "Mở cửa"
                                    if (store.status.toLowerCase().includes('đóng cửa')) {
                                        statusColor = '#dc3545'; // Đỏ cho "Đóng cửa"
                                    }

                                    card.innerHTML = `
                                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                            <span style="font-size: 24px; margin-right: 10px;">🍔</span>
                                            <strong>${store.name}</strong>
                                            <span style="margin-left: auto; background: ${statusColor}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                                ${store.status}
                                            </span>
                                        </div>
                                        <p style="margin: 5px 0; font-size: 14px;">${store.address}</p>
                                        <p style="margin: 5px 0;"><strong>☎</strong> ${store.phone}</p>
                                        <p style="margin: 5px 0;"><strong>🕒</strong> ${store.opening_hours}</p>
                                    `;

                                    // Gắn sự kiện click + debug
                                    card.addEventListener('click', () => {
                                        console.log('Đã click cửa hàng:', store.name); // Kiểm tra console có log không
                                        if (typeof replaceDeliverySection === 'function') {
                                            replaceDeliverySection(store);
                                        } else {
                                            console.error('Hàm replaceDeliverySection không tồn tại!');
                                        }
                                        closeModal();
                                    });

                                    storeList.appendChild(card);
                                });
                            } else {
                                storeList.innerHTML = '<p style="text-align:center; color:#888;">Không có cửa hàng nào ở tỉnh này.</p>';
                            }

                            document.getElementById('store-modal').style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Lỗi lấy cửa hàng:', error);
                            document.getElementById('store-list').innerHTML = '<p style="color:red;">Lỗi tải dữ liệu cửa hàng.</p>';
                            document.getElementById('store-modal').style.display = 'block';
                        });
                }

                // Hàm thay thế phần delivery-section
                function replaceDeliverySection(store, savedAddress = '', isLoadFromStorage = false) {
                    console.log('replaceDeliverySection được gọi với cửa hàng:', store.name);
                    const deliverySection = document.querySelector('.delivery-section');
                    if (!deliverySection) {
                        console.error('Không tìm thấy .delivery-section');
                        return;
                    }

                    // Logic lấy địa chỉ hiển thị: ƯU TIÊN savedAddress khi load từ DB
                    let displayAddress = '';
                    if (isLoadFromStorage) {
                        displayAddress = savedAddress;  // Dùng địa chỉ từ DB
                    } else {
                        const currentInput = document.getElementById('address-input');
                        displayAddress = currentInput?.value.trim() || savedAddress || '';
                        // Lưu vào DB khi chọn mới
                        if (displayAddress) {
                            saveAddressToServer(displayAddress);
                        }
                    }

                    console.log('Địa chỉ sẽ hiển thị:', displayAddress);  // Debug thêm

                    let newContent = '';
                    if (currentTabType === 'delivery') {
                        newContent = `
                            <div style="background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                    <strong style="font-size: 16px; color: #ff6b00;">GIAO HÀNG TẬN NƠI</strong>
                                    <button onclick="resetDeliverySection()" style="background: none; border: none; color: #ff6b00; cursor: pointer;">✏️ Chỉnh sửa</button>
                                </div>
                                <div style="display: flex; justify-content: space-between; gap: 20px;">
                                    <div style="flex: 1;">
                                        <label style="font-size: 13px; color: #666;">Địa chỉ giao hàng:</label>
                                        <p style="margin: 5px 0; font-weight: bold;">${displayAddress || 'Chưa có địa chỉ'}</p>
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="font-size: 13px; color: #666;">Giao từ cửa hàng:</label>
                                        <p style="margin: 5px 0; font-weight: bold;">${store.name}</p>
                                        <p style="margin: 5px 0; font-size: 13px; color: #555;">${store.address}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        // Phần ĐẶT ĐẾN LẤY (giữ nguyên)
                        newContent = `
                            <div style="background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                    <strong style="font-size: 16px; color: #ff6b00;">ĐẶT ĐẾN LẤY</strong>
                                    <button onclick="resetDeliverySection()" style="background: none; border: none; color: #ff6b00; cursor: pointer;">✏️ Chỉnh sửa</button>
                                </div>
                                <div>
                                    <label style="font-size: 13px; color: #666;">Nhận tại cửa hàng:</label>
                                    <p style="margin: 5px 0; font-weight: bold;">${store.name}</p>
                                    <p style="margin: 5px 0; font-size: 13px; color: #555;">${store.address}</p>
                                </div>
                            </div>
                        `;
                    }

                    deliverySection.innerHTML = newContent;
                    console.log('Section đã được thay thế!');

                    // Lưu store vào localStorage (chỉ khi chọn mới)
                    if (!isLoadFromStorage) {
                        localStorage.setItem('deliveryState', JSON.stringify({
                            tabType: currentTabType,
                            selectedStore: store
                        }));
                        console.log('Đã lưu cửa hàng vào localStorage:', store.name);
                    }
                }

                window.resetDeliverySection = function() {
                    console.log('resetDeliverySection được gọi'); // Debug để kiểm tra

                    // Xóa localStorage khi reset
                    localStorage.removeItem('deliveryState');

                    deliverySection.innerHTML = `
                        <div class="delivery-tabs">
                            <button class="tab-btn ${currentTabType === 'delivery' ? 'active' : ''}" data-type="delivery">
                                GIAO HÀNG TẬN NƠI
                            </button>
                            <button class="tab-btn ${currentTabType === 'pickup' ? 'active' : ''}" data-type="pickup">
                                ĐẶT ĐẾN LẤY
                            </button>
                        </div>

                        <div class="search-box" style="position: relative;">
                            <input type="text" id="address-input" placeholder="Nhập địa chỉ giao hàng">
                            <button class="search-btn">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="white">
                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                </svg>
                            </button>
                            <ul id="suggestions-list" class="suggestions-list" style="display: none;"></ul>
                        </div>
                    `;

                    // Re-init biến sau khi tạo lại HTML
                    input = document.getElementById('address-input');
                    suggestionsList = document.getElementById('suggestions-list');

                    // Gắn lại toàn bộ logic autocomplete
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

                                                const parts = label.split(', ');
                                                let province = parts[parts.length - 2] || '';
                                                if (province.includes('Tỉnh')) province = province.replace('Tỉnh ', '');
                                                province = province.trim();

                                                if (province) {
                                                    showStoresModal(province);
                                                } else {
                                                    alert('Không trích xuất được tỉnh từ địa chỉ.');
                                                }
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
                };
            });
            // Hàm cập nhật địa chỉ lên server
            function saveAddressToServer(address) {
                if (!address || address.trim() === '') return;

                fetch('update_user_address.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ address: address.trim() })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Lỗi server: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Địa chỉ đã lưu vào DB:', address);
                    } else {
                        console.error('Lưu địa chỉ thất bại:', data.message || 'Không rõ lý do');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi gửi địa chỉ lên server:', error);
                });
            }
        </script>

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
