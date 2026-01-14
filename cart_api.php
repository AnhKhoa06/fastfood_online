<?php
session_start();
require_once 'admin/config/db.php';

header('Content-Type: application/json');
// Thêm ở đầu cart_api.php (sau header('Content-Type: application/json');)
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
    exit;
}

// Lấy user_id từ username trong session (đồng bộ với checkout.php)
$username = $_SESSION['username'] ?? '';
if (empty($username)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
    exit;
}

$user_query = "SELECT id FROM users WHERE username = ?";
$stmt_user = $connect->prepare($user_query);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_row = $result_user->fetch_assoc();
$user_id = $user_row['id'] ?? 0;
$stmt_user->close();

if ($user_id == 0) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy user']);
    exit;
}

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