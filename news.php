<?php
session_start();
include_once 'components/header.php';
require_once 'admin/config/db.php'; // hoặc '../db.php' tùy vị trí

// Kiểm tra ID hợp lệ
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php'); // Chuyển về trang chủ nếu sai
    exit;
}

$news_id = intval($_GET['id']);

// Lấy dữ liệu tin tức
$sql = "SELECT category, title, content, image, created_at 
        FROM news 
        WHERE news_id = $news_id";
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) == 0) {
    header('Location: index.php'); // Không tìm thấy -> về trang chủ
    exit;
}

$row = mysqli_fetch_assoc($result);
$title = htmlspecialchars($row['category']);
$content = $row['content']; // Nội dung đầy đủ (có HTML từ CKEditor)
$image = htmlspecialchars($row['image']);
$created_at = date('d/m/Y H:i', strtotime($row['created_at']));
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | Jollibee</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link CSS của bạn -->
    <style>
        .news-detail {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        .news-title-main {
            margin-top: 40px; /* Nhích xuống dưới một chút */
            margin-bottom: 20px;
            color: #000; /* Màu đen */
            font-size: 2.5em;
            font-weight: bold;
            text-align: center;
        }
        .news-date {
            text-align: center;
            color: #555;
            margin-bottom: 30px;
            font-style: italic;
        }
        .news-detail-img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 0 auto 30px; /* Khoảng cách đều trên/dưới */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .news-detail-content {
            line-height: 1.7; /* Khoảng cách dòng hợp lý */
            font-size: 1.1em;
            color: #333;
        }
        .news-detail-content h2, 
        .news-detail-content h3, 
        .news-detail-content h4,
        .news-detail-content strong,
        .news-detail-content b {
            font-style: italic; /* Chữ nghiêng */
            font-weight: bold;  /* Bôi đen */
            color: #000;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .news-detail-content p {
            margin: 15px 0; /* Khoảng cách giữa các đoạn văn đều đặn */
        }
        .btn-back {
            display: inline-block;
            margin-top: 40px;
            padding: 10px 20px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-back:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="news-detail container">
        <h1 class="news-title-main"><?php echo $title; ?></h1>
        <p class="news-date">Đăng ngày: <?php echo $created_at; ?></p>

        <?php if (!empty($image)): ?>
            <img src="admin/img2/<?php echo $image; ?>" alt="<?php echo $title; ?>" class="news-detail-img">
        <?php endif; ?>

        <div class="news-detail-content">
            <?php echo $content; ?> <!-- Nội dung đầy đủ từ CKEditor -->
        </div>

        <a href="index.php" class="btn-back">Quay lại trang chủ</a>
    </div>

    <?php include_once 'components/footer.php'; ?>
</body>
</html>