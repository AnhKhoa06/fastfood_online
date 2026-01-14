<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ./admin/login-resigter.html');
    exit();
}

// --- Tính toán dữ liệu cho Dashboard ---
// 1. Tổng số sản phẩm
$total_products = 0;
$result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM products");
if ($row = mysqli_fetch_assoc($result)) {
    $total_products = $row['total'];
}

// 2. Tổng số đơn hàng
$total_orders = 0;
$result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM orders");
if ($row = mysqli_fetch_assoc($result)) {
    $total_orders = $row['total'];
}

// 3. Tổng doanh thu (chỉ tính đơn có trạng thái "Đã giao" hoặc tương tự)
$total_revenue = 0;
$result = mysqli_query($connect, "SELECT SUM(total_amount) AS revenue FROM orders WHERE status = 'Đã giao'");
if ($row = mysqli_fetch_assoc($result)) {
    $total_revenue = $row['revenue'] ?? 0;
}

// 4. Số lượng người dùng đăng ký
$total_users = 0;
$result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM users");
if ($row = mysqli_fetch_assoc($result)) {
    $total_users = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/header/logo.jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/style1.css">
    <title>Domino's Fastfood | Admin Dashboard</title>
    <style>
        .dashboard-card {
            transition: transform 0.2s, box-shadow 0.2s;
            left: -20px;
            max-width: 290px; /* Rút ngắn chiều dài ngang, không lấn sang phải */
            margin: 0 auto; /* Căn giữa card trong cột */
        }
        .dashboard-card:hover {
            transform: scale(1.03); /* zoom ảnh giống hover */
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            cursor: pointer;
        }
        .card-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!-- Sidebar bên trái -->
    <div class="sidebar d-flex flex-column bg-dark text-white" style="width: 250px; height: 100vh; position: fixed;">
        <div class="text-center py-4 border-bottom">
            <div class="d-flex align-items-center justify-content-center">
                <i class="fas fa-user-circle fa-3x rounded-circle mb-2" style="background-color: #ccc; padding: 10px;"></i>
                <div class="ml-3">
                    <h5 class="mb-0">Admin</h5>
                    <small class="text-success">● Online</small>
                </div>
            </div>
        </div>

        <div class="p-1 border-bottom">
            <input type="text" class="form-control form-control-sm" placeholder="Search..." style="font-size: 12px; height: 25px; padding: 2px 8px;">
        </div>

        <div class="px-3 mt-2 mb-1 text-muted" style="font-size: 13px;">MAIN NAVIGATION</div>
        
        <nav class="nav flex-column px-2">
            <a href="index.php" class="nav-link text-white active">
                <i class="fas fa-tachometer-alt" style="margin-right: 7px;"></i> Dashboard
            </a>
            <a href="index.php?page_layout=danhsach" class="nav-link text-white">
                <i class="fas fa-box" style="margin-right: 7px;"></i> Quản lý Sản Phẩm
            </a>
            <a href="index.php?page_layout=danhmuc" class="nav-link text-white">
                <i class="fas fa-folder" style="margin-right: 7px;"></i> Quản lý Danh Mục
            </a>
            <a href="index.php?page_layout=donhang" class="nav-link text-white">
                <i class="fas fa-cart-plus" style="margin-right: 7px;"></i> Quản lý Đơn Hàng
            </a>
            <a href="index.php?page_layout=cuahang" class="nav-link text-white">
                <i class="fas fa-gift" style="margin-right: 7px;"></i> Quản lý Các Cửa Hàng
            </a>
            <a href="index.php?page_layout=tintuc" class="nav-link text-white">
                <i class="fas fa-newspaper" style="margin-right: 7px;"></i> Quản lý Tin Tức
            </a>
            <a href="index.php?page_layout=banner" class="nav-link text-white">
                <i class="fas fa-image" style="margin-right: 7px;"></i> Quản lý Banner
            </a>
            <a href="index.php?page_layout=quan_ly_nguoi_dung" class="nav-link text-white">
                <i class="fas fa-users" style="margin-right: 7px;"></i> Quản lý Người dùng
            </a>

            <a href="logout.php" class="btn btn-danger btn-sm mt-4" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">Đăng xuất</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" style="margin-left: 250px; padding: 20px;">
        <?php
        if (isset($_GET['page_layout'])) {
            $page = $_GET['page_layout'];
            switch ($page) {
                // --- Phần sản phẩm ---
                case 'danhsach':
                    require_once 'mon_an/danhsach.php';
                    break;

                case 'them':
                    require_once 'mon_an/them.php';
                    break;
                
                case 'sua':
                    require_once 'mon_an/sua.php';
                    break;

                case 'xoa':
                    require_once 'mon_an/xoa.php';
                    break;

                // --- Phần danh mục ---
                case 'danhmuc':
                    require_once 'danhmuc/danhsach.php';
                    break;

                case 'them_danhmuc':
                    require_once 'danhmuc/them.php';
                    break;

                case 'sua_danhmuc':
                    require_once 'danhmuc/sua.php';
                    break;

                case 'xoa_danhmuc':
                    require_once 'danhmuc/xoa.php';
                    break;

                // --- Phần đơn hàng ---
                case 'donhang':
                    require_once 'donhang/danhsach.php';
                    break;

                case 'chitiet_donhang':
                    require_once 'donhang/chitiet.php';
                    break;

                // --- Phần khuyến mãi ---
                case 'cuahang':
                    require_once 'cuahang/danhsach.php';
                    break;

                case 'them_cuahang':
                    require_once 'cuahang/them.php';
                    break;

                case 'sua_cuahang':
                    require_once 'cuahang/sua.php';
                    break;

                case 'xoa_cuahang':
                    require_once 'cuahang/xoa.php';
                    break;

                // --- Phần flashsale ---
                case 'flashsale':
                    require_once 'flashsale/danhsach.php';
                    break;

                case 'them_flashsale':
                    require_once 'flashsale/them.php';
                    break;

                case 'sua_flashsale':
                    require_once 'flashsale/sua.php';
                    break;

                case 'xoa_flashsale':
                    require_once 'flashsale/xoa.php';
                    break;
                
                // --- Phần tin tức ---
                case 'tintuc':
                    require_once 'tintuc/danhsach.php';
                    break;

                case 'them_tintuc':
                    require_once 'tintuc/them.php';
                    break;

                case 'sua_tintuc':
                    require_once 'tintuc/sua.php';
                    break;

                case 'xoa_tintuc':
                    require_once 'tintuc/xoa.php';
                    break;

                // --- Phần banner ---
                case 'banner':
                    require_once 'banner/danhsach.php';
                    break;

                case 'them_banner':
                    require_once 'banner/them.php';
                    break;

                case 'sua_banner':
                    require_once 'banner/sua.php';
                    break;

                case 'xoa_banner':
                    require_once 'banner/xoa.php';
                    break;

                // --- Phần quản lý người dùng ---
                case 'quan_ly_nguoi_dung':
                    require_once 'taikhoan/danhsach.php';
                    break;
                case 'them_nguoi_dung':
                    require_once 'taikhoan/them.php';
                    break;
                case 'sua_nguoi_dung':
                    require_once 'taikhoan/sua.php';
                    break;
                case 'xoa_nguoi_dung':
                    require_once 'taikhoan/xoa.php';
                    break;

                default:
                    // Dashboard làm fallback nếu page_layout lạ
                    ?>
                    <h2 class="mb-4">Dashboard - Tổng quan hệ thống</h2>
                    <div class="row">
                        <!-- Tổng sản phẩm -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card border-left-primary shadow h-100 py-2 bg-primary text-white">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Sản Phẩm</div>
                                            <div class="h5 mb-0 font-weight-bold"><?php echo number_format($total_products); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-box card-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tổng đơn hàng -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card border-left-success shadow h-100 py-2 bg-success text-white">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Đơn Hàng</div>
                                            <div class="h5 mb-0 font-weight-bold"><?php echo number_format($total_orders); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-cart card-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tổng doanh thu -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card border-left-info shadow h-100 py-2 bg-info text-white">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Doanh Thu</div>
                                            <div class="h5 mb-0 font-weight-bold"><?php echo number_format($total_revenue, 0, ',', '.'); ?> đ</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-money-bill-wave card-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tổng người dùng -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card border-left-warning shadow h-100 py-2 bg-warning text-white">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Người Dùng</div>
                                            <div class="h5 mb-0 font-weight-bold"><?php echo number_format($total_users); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users card-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Có thể thêm biểu đồ hoặc thông tin khác ở đây sau -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Hoạt động gần đây</h6>
                                </div>
                                <div class="card-body">
                                    <p>Chưa có dữ liệu hoạt động gần đây. (Bạn có thể thêm sau)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
            }
        } else {
            // Mặc định hiển thị Dashboard khi không có page_layout
            ?>
            <h2 class="mb-4">Dashboard - Tổng quan hệ thống</h2>
            <div class="row">
                <!-- Tổng sản phẩm -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-left-primary shadow h-100 py-2 bg-primary text-white">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Sản Phẩm</div>
                                    <div class="h5 mb-0 font-weight-bold"><?php echo number_format($total_products); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box card-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng đơn hàng -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-left-success shadow h-100 py-2 bg-success text-white">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Đơn Hàng</div>
                                    <div class="h5 mb-0 font-weight-bold"><?php echo number_format($total_orders); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-shopping-cart card-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng doanh thu -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-left-info shadow h-100 py-2 bg-info text-white">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Doanh Thu</div>
                                    <div class="h5 mb-0 font-weight-bold"><?php echo number_format($total_revenue, 0, ',', '.'); ?> đ</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave card-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng người dùng -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-left-warning shadow h-100 py-2 bg-warning text-white">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Người Dùng</div>
                                    <div class="h5 mb-0 font-weight-bold"><?php echo number_format($total_users); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users card-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Có thể thêm biểu đồ hoặc thông tin khác ở đây sau -->
            <div class="row">
                <div class="col-12" style="max-width: 98.5%; margin-left: -10px;"> <!-- Di chuyển nhẹ sang trái & rút ngắn chiều dài -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Hoạt động gần đây</h6>
                        </div>
                        <div class="card-body">
                            <p>Chưa có dữ liệu hoạt động gần đây.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
?>
    </div>

    <!-- Optional: Thêm script Bootstrap nếu cần JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>