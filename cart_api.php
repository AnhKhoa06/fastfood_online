<?php
session_start();
require_once 'admin/config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
    exit;
}

// Lấy user_id (thay bằng cách lấy thực tế của bạn, ví dụ từ session)
$user_id = $_SESSION['user_id'] ?? 0; // ← Sửa thành $_SESSION['id'] hoặc tương tự nếu bạn lưu khác

// Lấy action từ GET hoặc POST
$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        $product_id = intval($_POST['product_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);

        if ($product_id <= 0 || $quantity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }

        // Kiểm tra món đã có chưa
        $sql = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $new_qty = $row['quantity'] + $quantity;
            $sql_update = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt_update = mysqli_prepare($connect, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "iii", $new_qty, $user_id, $product_id);
            mysqli_stmt_execute($stmt_update);
        } else {
            $sql_insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($connect, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "iii", $user_id, $product_id, $quantity);
            mysqli_stmt_execute($stmt_insert);
        }
        echo json_encode(['success' => true]);
        break;

    case 'update':
        $product_id = intval($_POST['product_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 0);

        if ($quantity <= 0) {
            $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        } else {
            $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "iii", $quantity, $user_id, $product_id);
        }
        mysqli_stmt_execute($stmt);
        echo json_encode(['success' => true]);
        break;

    case 'delete':
        $product_id = intval($_POST['product_id'] ?? 0);
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($stmt);
        echo json_encode(['success' => true]);
        break;

    case 'get':
        $sql = "SELECT c.*, p.prd_name AS name, p.image, p.price 
                FROM cart c 
                JOIN products p ON c.product_id = p.prd_id 
                WHERE c.user_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $cart = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$row['image'] = 'admin/img/' . $row['image']; // Thêm tiền tố đường dẫn
			$cart[] = $row;
		}

        // Đảm bảo luôn trả mảng []
        echo json_encode($cart);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Hành động không hợp lệ']);
}
?>