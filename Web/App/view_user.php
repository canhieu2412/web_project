<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Bạn cần đăng nhập để xem thông tin!";
    exit();
}

$user_id = $_GET['user_id'];  // ID người dùng cần xem thông tin

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "Tên đăng nhập: " . $user['username'] . "<br>";
    echo "Họ và tên: " . $user['fullname'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
    echo "Số điện thoại: " . $user['phone'] . "<br>";
} else {
    echo "Không tìm thấy người dùng!";
}
?>
