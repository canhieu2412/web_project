<?php
// Cấu hình cơ sở dữ liệu
define('DB_HOST', 'localhost');     // Địa chỉ máy chủ
define('DB_USER', 'root');          // Tên tài khoản MySQL
define('DB_PASSWORD', '');          // Mật khẩu MySQL
define('DB_NAME', 'class_management'); // Tên cơ sở dữ liệu

// Kết nối cơ sở dữ liệu
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Thiết lập múi giờ mặc định (tùy chỉnh nếu cần)
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Khởi động session cho toàn bộ hệ thống
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
