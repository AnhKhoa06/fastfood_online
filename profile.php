<?php
session_start();
require_once 'admin/config/db.php'; // hoặc '../db.php' tùy vị trí

// Kiểm tra đăng nhập
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login-resigter.html");
    exit();
}

$mode = 'view'; // mặc định
if (isset($_GET['mode'])) {
    if ($_GET['mode'] === 'edit') $mode = 'edit';
    if ($_GET['mode'] === 'address') $mode = 'address';
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
    <link rel="stylesheet" href="assets/css/profile3.css"> <!-- File CSS riêng -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
<body>
    <?php include_once 'components/header.php'; ?>

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
                <li><a href="#">Đơn hàng của tôi</a></li>
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
            <div id="view-mode" style="<?php echo $mode === 'view' ? 'display: block;' : 'display: none;'; ?>">
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

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Tỉnh / Thành phố *</label>
                                <select id="province" class="form-control" required>
                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label class="form-label">Quận / Huyện *</label>
                                <select id="district" class="form-control" required disabled>
                                    <option value="">-- Chọn Quận/Huyện --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Phường / Thị trấn *</label>
                                <select id="ward" class="form-control" required disabled>
                                    <option value="">-- Chọn Phường/Thị trấn --</option>
                                </select>
                            </div>
                        
                            <div class="form-group full-width">
                                <label class="form-label">Số nhà / đường</label>
                                <input type="text" id="street" class="form-control1" placeholder="Nhập số nhà, tên đường">
                            </div>
                        </div>

                        <!-- Hidden input để lưu địa chỉ đầy đủ -->
                        <input type="hidden" name="address" id="full-address">
                        
                        <div class="form-buttons" style="margin-top: 30px; justify-content: flex-start;">
                            <a href="profile.php" class="btn-cancel">QUAY LẠI</a>
                            <button type="submit" class="btn-update">LƯU ĐỊA CHỈ</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <?php include_once 'components/footer.php'; ?>
</body>
</html>

<script>
// Dữ liệu địa chỉ
const addressData = {
    provinces: [],
    districts: {},
    wards: {}
};

fetch('https://provinces.open-api.vn/api/?depth=3')
    .then(response => response.json())
    .then(data => {
        // Xử lý dữ liệu
        addressData.provinces = data.map(p => ({ code: p.code, name: p.name }));

        data.forEach(province => {
            addressData.districts[province.code] = province.districts.map(d => ({
                code: d.code,
                name: d.name
            }));

            province.districts.forEach(district => {
                addressData.wards[district.code] = district.wards.map(w => ({
                    code: w.code,
                    name: w.name
                }));
            });
        });

        // Load tỉnh
        const provinceSelect = document.getElementById('province');
        provinceSelect.innerHTML = '<option value="">-- Chọn Tỉnh/Thành phố --</option>';
        addressData.provinces.forEach(p => {
            const option = document.createElement('option');
            option.value = p.code;
            option.textContent = p.name;
            provinceSelect.appendChild(option);
        });
    })
    .catch(err => {
        console.error('Lỗi load dữ liệu địa chỉ:', err);
        alert('Không thể tải dữ liệu địa chỉ. Vui lòng kiểm tra kết nối mạng.');
    });

// Event khi chọn tỉnh
document.getElementById('province').addEventListener('change', function() {
    const provinceCode = this.value;
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Thị trấn --</option>';
    wardSelect.disabled = true;

    if (!provinceCode) {
        districtSelect.disabled = true;
        return;
    }

    const districts = addressData.districts[provinceCode] || [];
    districts.forEach(d => {
        const option = document.createElement('option');
        option.value = d.code;
        option.textContent = d.name;
        districtSelect.appendChild(option);
    });

    districtSelect.disabled = false;
});

// Event khi chọn quận
document.getElementById('district').addEventListener('change', function() {
    const districtCode = this.value;
    const wardSelect = document.getElementById('ward');

    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Thị trấn --</option>';

    if (!districtCode) {
        wardSelect.disabled = true;
        return;
    }

    const wards = addressData.wards[districtCode] || [];
    wards.forEach(w => {
        const option = document.createElement('option');
        option.value = w.code;
        option.textContent = w.name;
        wardSelect.appendChild(option);
    });

    wardSelect.disabled = false;
});

// Khi submit form → gộp địa chỉ đầy đủ
document.querySelector('.address-form').addEventListener('submit', function() {
    const province = document.getElementById('province').selectedOptions[0]?.textContent || '';
    const district = document.getElementById('district').selectedOptions[0]?.textContent || '';
    const ward = document.getElementById('ward').selectedOptions[0]?.textContent || '';
    const street = document.getElementById('street').value.trim();

    const fullAddress = [street, ward, district, province].filter(Boolean).join(', ');
    document.getElementById('full-address').value = fullAddress;
});

// Tự động điền địa chỉ từ DB vào 4 ô khi vào phần chỉnh sửa
document.addEventListener('DOMContentLoaded', function() {
    const fullAddress = "<?php echo addslashes($address_db); ?>".trim();
    if (!fullAddress) return;

    // Tách địa chỉ: "123 Nguyễn Trãi, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh (Ghi chú: ...)"
    let cleanAddress = fullAddress.replace(/\s*\(Ghi chú:.*\)$/, '').trim(); // bỏ ghi chú nếu có
    const parts = cleanAddress.split(', ').reverse(); // đảo ngược để dễ lấy tỉnh trước

    if (parts.length < 4) return;

    const provinceName = parts[0].trim(); // tỉnh
    const districtName = parts[1].trim(); // quận
    const wardName = parts[2].trim(); // phường
    const street = parts.slice(3).reverse().join(', ').trim(); // số nhà + đường

    // Điền số nhà ngay
    document.getElementById('street').value = street;

    // Chờ dữ liệu tỉnh load xong
    const checkData = setInterval(() => {
        if (addressData.provinces.length > 0) {
            clearInterval(checkData);

            // Chọn tỉnh
            const provinceSelect = document.getElementById('province');
            const provinceOption = Array.from(provinceSelect.options).find(opt => opt.textContent.trim() === provinceName);
            if (provinceOption) {
                provinceSelect.value = provinceOption.value;
                provinceSelect.dispatchEvent(new Event('change')); // trigger load quận

                // Chờ quận load
                setTimeout(() => {
                    const districtSelect = document.getElementById('district');
                    const districtOption = Array.from(districtSelect.options).find(opt => opt.textContent.trim() === districtName);
                    if (districtOption) {
                        districtSelect.value = districtOption.value;
                        districtSelect.dispatchEvent(new Event('change')); // trigger load phường

                        // Chờ phường load
                        setTimeout(() => {
                            const wardSelect = document.getElementById('ward');
                            const wardOption = Array.from(wardSelect.options).find(opt => opt.textContent.trim() === wardName);
                            if (wardOption) {
                                wardSelect.value = wardOption.value;
                            }
                        }, 400);
                    }
                }, 400);
            }
        }
    }, 100);
});

</script>


<!---------------------------------------->


<script>
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

// Tick thay đổi mật khẩu
document.getElementById('change-password-toggle').addEventListener('change', function() {
    document.getElementById('password-fields').style.display = this.checked ? 'block' : 'none';
});

// Tự động hiển thị 2 ô mật khẩu nếu checkbox được checked từ server
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('change-password-toggle');
    const fields = document.getElementById('password-fields');
    
    if (toggle && fields) {
        if (toggle.checked) {
            fields.style.display = 'block';
        }
    }
});
</script>