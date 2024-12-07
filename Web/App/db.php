<?php
$host = 'localhost';  // Địa chỉ máy chủ
$dbname = 'your_database_name';  // Tên cơ sở dữ liệu
$username = 'your_username';  // Tên người dùng
$password = 'your_password';  // Mật khẩu

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Kết nối không thành công: ' . $e->getMessage();
}

#kết nối database
?>

