<!DOCTYPE html>
<html lang = "vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="assets/img/header/logo.jpg">
        <title> Phở Anh Hai </title>
        <link rel="stylesheet" href="assets/css/style5.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="navb">
            <img type="image/webp" src="assets/img/header/logo.jpg" alt="">
            <ul class="menu">                            
                <button class="active"><li><a href="#trang-chu">TRANG CHỦ</a></li></button>
                <button><li><a href="#ve-anh-hai">VỀ ANH HAI</a></li></button>

                <!-- MỤC THỰC ĐƠN CÓ DROPDOWN -->
                <button class="has-dropdown">
                    <li><a href="">THỰC ĐƠN</a></li>
                    <div class="mega-dropdown">
                        <div class="dropdown-item">
                            <img src="assets/img/header/mon1.webp" alt="Combo">
                            <span>MÓN NGON PHẢI THỬ</span>
                        </div>
                        <div class="dropdown-item">
                            <img src="assets/img/header/mon2.webp" alt="Gà giòn">
                            <span>GÀ GIÒN VUI VẺ</span>
                        </div>
                        <div class="dropdown-item">
                            <img src="assets/img/header/mon3.webp" alt="Mỳ Jolly">
                            <span>MỲ JOLLY</span>
                        </div>
                        <div class="dropdown-item">
                            <img src="assets/img/header/mon4.webp" alt="Gà sốt cay">
                            <span>GÀ SỐT CAY</span>
                        </div>
                        <div class="dropdown-item">
                            <img src="assets/img/header/mon5.webp" alt="Burger">
                            <span>BURGER.COM</span>
                        </div>
                        <div class="dropdown-item">
                            <img src="assets/img/header/mon6.webp" alt="Phần ăn phụ">
                            <span>PHẦN ĂN PHỤ</span>
                        </div>
                        <div class="dropdown-item">
                            <img src="assets/img/header/mon7.webp" alt="Tráng miệng">
                            <span>MÓN TRÁNG MIỆNG</span>
                        </div>
                        <div class="dropdown-item">
                            <img src="assets/img/header/mon8.webp" alt="Thức uống">
                            <span>THỨC UỐNG</span>
                        </div>
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
                <img type="img/png" src="assets/img/header/flag-vn.png" style="height: 21px; width: 21px; margin-top: 10px;">
                <a href="#"><span style="color: red; font-size:15px;">VN</span></a>
                <span style="color: red ; margin-left: 0px; height: auto; margin-right: -35px;">|</span>
                <img type="img/png" src="assets/img/header/flag-en.png" style="height: 18px; width: 18px; margin-top: 10px;">
                <a href="#" style="font-size:15px; margin-right: 100px;">EN</a>
                <img src="assets/img/header/admin.png" alt="User" class="user-icon">
                <a class="register" href="login-resigter.html?mode=signup">ĐĂNG KÝ</a>
                <a>/</a>
                <a class="login" href="login-resigter.html">ĐĂNG NHẬP</a>
            </div>
        </div>
        <!-- Site banner slider (separate from navbar) -->

        <div class="slider-wrapper">
            <div class="slider">
                <div class="slide"><img src="uploads/banners/bn1.jpg" alt="Banner 1"></div>
                <div class="slide"><img src="uploads/banners/bn2.jpg" alt="Banner 2"></div>
                <div class="slide"><img src="uploads/banners/bn3.jpg" alt="Banner 3"></div>
                <div class="slide"><img src="uploads/banners/bn4.jpg" alt="Banner 4"></div>
                <div class="slide"><img src="uploads/banners/bn5.jpg" alt="Banner 5"></div>
                <div class="slide"><img src="uploads/banners/bn6.jpg" alt="Banner 6"></div>
                <div class="slide"><img src="uploads/banners/bn7.jpg" alt="Banner 7"></div>
                <div class="slide"><img src="uploads/banners/bn8.jpg" alt="Banner 8"></div>
                <div class="slide"><img src="uploads/banners/bn9.jpg" alt="Banner 9"></div>
            </div>

            <!-- Nút prev / next -->
            <button class="prev-btn">&#10094;</button>
            <button class="next-btn">&#10095;</button>

            <!-- Các thanh progress riêng của từng slide (ẩn, chỉ để animation) -->
            <div class="progress-bars"></div>
        </div>

        <!-- PHẦN GIAO HÀNG / ĐẾN LẤY -->
        <class="delivery-section">
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

        <div>    
            <div class="widget-today-menu-wrapper">
                <div class="today-menu-content">
                    <div class="intro-wrapper">
                        <div class="intro">
                            <div class="logo">
                                <img src="assets/img/header/logo.jpg" alt="">
                            </div>
                            <p class="title">ĂN GÌ</p>
                            <p class="title">HÔM NAY</p>
                            <p class="description">Thực đơn của Phở Anh Hai đa dạng và phong phú, có rất nhiều sự lựa chọn cho bạn, gia đình và bạn bè.</p>
                        </div>
                    </div>
                    <div class="main-menu-wrapper">
                        <div class="quad-menu">
                            <a href="/ga-gion-vui-ve.html" class="quad menu">
                                <div class="top-img-wrapper"><img src="https://jollibee.com.vn/media/wysiwyg/today/ga_gion_vui_ve.png" alt="">
                                </div>
                                <div class="bottom-img-wrapper">
                                    <img src="https://jollibee.com.vn/media/e17856b74b7a0e-titlegagionvuive.png" alt="">
                                    <button class="btn btn-orange text-uppercase btn-order">Đặt hàng                                </button>
                                </div>
                            </a>
                            <a href="/ga-sot-cay.html" class="quad menu">
                                <div class="top-img-wrapper"><img src="https://jollibee.com.vn/media/wysiwyg/today/ga_sot_cay.png" alt="">
                                </div>
                                <div class="bottom-img-wrapper">
                                    <img src="https://jollibee.com.vn/media/0a7c5c03bdcaaf-titlegasotcay.png" alt="">
                                    <button class="btn btn-orange text-uppercase btn-order">Đặt hàng                                </button>
                                </div>
                            </a>
                            <a href="/mi-y-sot-bo-bam.html" class="quad menu">
                                <div class="top-img-wrapper"><img src="https://jollibee.com.vn/media/wysiwyg/today/my_y_sot_bo_bam.png" alt="">
                                </div>
                                <div class="bottom-img-wrapper">
                                    <img src="https://jollibee.com.vn/media/870d84c56fb2b9-titlemiysotbobam.png" alt="">
                                    <button class="btn btn-orange text-uppercase btn-order">Đặt hàng                                </button>
                                </div>
                            </a>
                            <a href="/mon-trang-mieng.html" class="quad menu">
                                <div class="top-img-wrapper"><img src="https://jollibee.com.vn/media/wysiwyg/today/mon_trang_mieng.png" alt="">
                                </div>
                                <div class="bottom-img-wrapper">
                                    <img src="https://jollibee.com.vn/media/3c96f92fbe5bc3-montrangmieng01.png" alt="">
                                    <button class="btn btn-orange text-uppercase btn-order">Đặt hàng                                </button>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== PHẦN DỊCH VỤ - CHUẨN JOLLIBEE ==================== -->
        <section class="services-section">
            <div class="services-container">
                <div class="services-header">
                    <h2 class="services-title">DỊCH VỤ</h2>
                    <p class="services-subtitle">Tận hưởng những khoảnh khắc trọn vẹn cùng Jollibee</p>
                </div>

                <div class="services-grid">
                    <!-- Dịch vụ 1 -->
                    <div class="service-item">
                        <div class="service-icon">
                            <img src="https://jollibee.com.vn/media/3478848e-3b8f-45f8-bc64-32e112922a8b.png" alt="Đặt hàng online">
                        </div>
                        <h3>LẤY TẠI CỬA HÀNG</h3>
                        <a href="#" class="btn-service">XEM THÊM</a>
                    </div>

                    <!-- Dịch vụ 2 -->
                    <div class="service-item">
                        <div class="service-icon">
                            <img src="https://jollibee.com.vn/media/2_1.png" alt="Tiệc sinh nhật">
                        </div>
                        <h3>ĐẶT TIỆC SINH NHẬT</h3>
                        <a href="#" class="btn-service">XEM THÊM</a>
                    </div>

                    <!-- Dịch vụ 3 -->
                    <div class="service-item">
                        <div class="service-icon">
                            <img src="https://jollibee.com.vn/media/club.png" alt="Jollibee Kids Club">
                        </div>
                        <h3>JOLLIBEE KIDS CLUB</h3>
                        <a href="#" class="btn-service">XEM THÊM</a>
                    </div>

                    <!-- Dịch vụ 4 -->
                    <div class="service-item">
                        <div class="service-icon">
                            <img src="https://jollibee.com.vn/media/4_1.png" alt="Đơn hàng lớn">
                        </div>
                        <h3>ĐƠN HÀNG LỚN</h3>
                        <a href="#" class="btn-service">XEM THÊM</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== JOLLIBEE, XIN CHÀO – CHỈ LÀM NỀN CHO RIÊNG PHẦN NÀY ==================== -->
        <div class="welcome-hero-section">
            <div class="welcome-hero-content">
                <h1>JOLLIBEE, XIN CHÀO</h1>
                <p>
                    Chúng tôi là Jollibee Việt Nam với hơn 200 cửa hàng trên khắp cả nước, chúng tôi mong muốn đem đến niềm vui ẩm thực cho mọi gia đình Việt bằng những món ăn có chất lượng tốt, hương vị tuyệt hảo, dịch vụ chu đáo với một mức giá hợp lý. Hãy đến và thưởng thức nhé!
                </p>
                <a href="#" class="btn-dat-hang">ĐẶT HÀNG</a>
            </div>
        </div>

        <!-- TÌM CỬA HÀNG (nằm ngoài ảnh nền, không bị ảnh hưởng) -->
        <div class="store-finder">
            <h2>TÌM CỬA HÀNG</h2>
            <div class="store-form">
                <select class="select-city">
                    <option value="" disabled selected>Chọn tỉnh thành</option>
                    <option>TP. Hồ Chí Minh</option>
                    <option>Hà Nội</option>
                    <option>Đà Nẵng</option>
                    <option>Bình Dương</option>
                    <option>Cần Thơ</option>
                </select>
                <select class="select-district">
                    <option value="" disabled selected>Chọn quận huyện</option>
                </select>
                <button class="btn-search">TÌM KIẾM</button>
            </div>
        </div>

        
    </body>
</html>
<script src="assets/js/slider.js"></script>
<script src="assets/js/header.js"></script>
<script src="assets/js/index.js"></script>