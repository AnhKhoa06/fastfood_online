<?php
require_once 'admin/config/db.php'
?>

<!DOCTYPE html>
<html lang = "vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="picture/logo.png">
        <title> FastFood Online </title>
        <link rel="stylesheet" href="././assets/css/style6.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    </head>
    <body>
        <div class="navb">
            <img type="image/webp" src="././assets/img/header/logo.jpg" alt="">
            <ul class="menu">                            
                <button class="active"><li><a href="./index.php">TRANG CHỦ</a></li></button>
                <button><li><a href="#ve-anh-hai">VỀ ANH HAI</a></li></button>

                <!-- MỤC THỰC ĐƠN CÓ DROPDOWN - PHIÊN BẢN ĐỘNG HOÀN CHỈNH -->
                <button class="has-dropdown">
                    <li><a href="./menu.php">THỰC ĐƠN</a></li>
                    <div class="mega-dropdown">
                        <?php
                        // Lấy 8 danh mục MỚI NHẤT (ID lớn nhất → mới thêm hiện đầu tiên)
                        $sql_menu = "SELECT category_id, category_name, image FROM categories ORDER BY category_id DESC LIMIT 8";
                        $query_menu = mysqli_query($connect, $sql_menu);

                        if (mysqli_num_rows($query_menu) > 0):
                            while ($row = mysqli_fetch_assoc($query_menu)):
                                $category_id   = $row['category_id'];
                                $category_name = htmlspecialchars($row['category_name']);
                                // Đường dẫn ảnh đúng cho frontend (không có "admin/")
                                $image_path    = './admin/img1/' . htmlspecialchars($row['image']);
                                // Link đến trang danh mục chi tiết (thay đổi nếu bạn có file khác)
                                $category_link = 'danh-muc.php?id=' . $category_id; 
                                // Hoặc nếu dùng slug: 'danh-muc/' . $category_id . '-' . create_slug($category_name) . '.html';
                        ?>
                                <a href="<?php echo $category_link; ?>" class="dropdown-item">
                                    <img src="<?php echo $image_path; ?>" alt="<?php echo $category_name; ?>">
                                    <span><?php echo $category_name; ?></span>
                                </a>
                        <?php
                            endwhile;
                        else:
                        ?>
                            <div class="dropdown-item text-center text-muted">
                                <span>Chưa có danh mục nào</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </button>
                <!-- HẾT DROPDOWN -->

                <button><li><a href="#khuyen-mai">KHUYẾN MÃI</a></li></button>
                <button><li><a href="#dich-vu">DỊCH VỤ</a></li></button>
                <button><li><a href="#tin-tuc">TIN TỨC</a></li></button>
                <button><li><a href="#cua-hang">CỬA HÀNG</a></li></button>
                <button><li><a href="#lien-he">LIÊN HỆ</a></li></button>
                <button><li><a href="#tuyen-dung">TUYỂN DỤNG</a></li></button>
            </ul>
            <div class="maumethoi"></div>
            <div class="overlay">
                <img type="img/png" src="./assets/img/header/flag-vn.png" style="height: 21px; width: 21px; margin-top: 10px;">
                <a href="#"><span style="color: red; font-size:15px;">VN</span></a>
                <span style="color: red ; margin-left: 0px; height: auto; margin-right: -35px;">|</span>
                <img type="img/png" src="./assets/img/header/flag-en.png" style="height: 18px; width: 18px; margin-top: 10px;">
                <a href="#" style="font-size:15px; margin-right: 100px;">EN</a>
                <img src="./assets/img/header/admin.png" alt="User" class="user-icon">

                <?php if(isset($_SESSION['username']) && !empty($_SESSION['username'])): 
                    $username = htmlspecialchars($_SESSION['username']);
                ?>
                    <!-- ĐÃ ĐĂNG NHẬP → HIỆN TÊN + MŨI TÊN + DROPDOWN -->
                    <div class="user-menu" onclick="toggleDropdown(event)">
                        <span style="color: black; font-weight: bold; font-size: 14px; margin-left: -4px; margin-right: 20px;">
                            Xin chào, <?php echo $username; ?>
                        </span>
                        <i class="fas fa-caret-down" id="dropdown-arrow" style="margin-left: 47px; color: #e31837;"></i>

                        <div class="dropdown-menu" id="user-dropdown">
                            <a href="profile.php">Tài khoản của tôi</a>
                            <hr style="margin: 6px 12px; border: none; border-top: 1px solid #eee;">
                            <a href="logout.php" 
                            onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')" 
                            style="color: #e31837; font-weight: 600;">
                                Đăng xuất
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- CHƯA ĐĂNG NHẬP -->
                    <a class="register" href="login-resigter.html?mode=signup">ĐĂNG KÝ</a>
                    <a>/</a>
                    <a class="login" href="login-resigter.html">ĐĂNG NHẬP</a>
                <?php endif; ?>

            </div>
            <script>
                function toggleDropdown(e) {
                    e.stopPropagation();
                    const menu = document.querySelector('.user-menu');
                    menu.classList.toggle('open');
                }

                // Đóng khi bấm ra ngoài
                document.addEventListener('click', function() {
                    document.querySelector('.user-menu')?.classList.remove('open');
                });
            </script>
        </div>

    </body>
</html>
<script src="././assets/js/header.js"></script>
<script src="././assets/js/index.js"></script>

