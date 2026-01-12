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
        <link rel="stylesheet" href="./assets/css/header14.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
        
    </head>
    <body>
        <div class="navb">
            <img type="image/webp" src="././assets/img/header/logo.jpg" alt="">
            <ul class="menu">                            
                <?php
                $current_page = basename($_SERVER['PHP_SELF']); // lấy tên file hiện tại
                ?>
                <!-- TRANG CHỦ -->
                <button class="<?php echo ($current_page === 'index.php') ? 'active' : ''; ?>" onclick="window.location.href='./index.php'">
                    <li><a href="./index.php">TRANG CHỦ</a></li>
                </button>

                <!-- VỀ ANH HAI -->
                <button onclick="window.location.href='#ve-anh-hai'">
                    <li><a href="#ve-anh-hai">VỀ ANH HAI</a></li>
                </button>

                <!-- THỰC ĐƠN CÓ DROPDOWN -->
                <button class="has-dropdown <?php echo ($current_page === 'menu.php') ? 'active' : ''; ?>" onclick="window.location.href='./menu.php'">
                    <li><a href="./menu.php">THỰC ĐƠN</a></li>
                    <div class="mega-dropdown">
                        <?php
                        $sql_menu = "SELECT category_id, category_name, image FROM categories ORDER BY category_id DESC LIMIT 8";
                        $query_menu = mysqli_query($connect, $sql_menu);

                        if (mysqli_num_rows($query_menu) > 0):
                            while ($row = mysqli_fetch_assoc($query_menu)):
                                $category_id   = $row['category_id'];
                                $category_name = htmlspecialchars($row['category_name']);
                                $image_path    = './admin/img1/' . htmlspecialchars($row['image']);
                                $category_link = './menu.php?category=' . $category_id;
                                
                                $is_active = (isset($_GET['category']) && (int)$_GET['category'] === $category_id) ? 'active' : '';
                        ?>
                                <a href="<?php echo $category_link; ?>" class="dropdown-item <?php echo $is_active; ?>">
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

                <!-- KHUYẾN MÃI -->
                <button onclick="window.location.href='#khuyen-mai'">
                    <li><a href="#khuyen-mai">KHUYẾN MÃI</a></li>
                </button>

                <!-- TIN TỨC -->
                <button onclick="window.location.href='#tin-tuc'">
                    <li><a href="#tin-tuc">TIN TỨC</a></li>
                </button>

                <!-- CỬA HÀNG -->
                <button onclick="window.location.href='#cua-hang'">
                    <li><a href="#cua-hang">CỬA HÀNG</a></li>
                </button>

                <!-- LIÊN HỆ -->
                <button onclick="window.location.href='#lien-he'">
                    <li><a href="#lien-he">LIÊN HỆ</a></li>
                </button>
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
<script src="././assets/js/header6.js"></script>


