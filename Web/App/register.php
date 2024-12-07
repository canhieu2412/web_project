<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Mã hóa mật khẩu
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = 'student';  // Mặc định là học sinh (có thể thay đổi nếu giảng viên)

    // Kiểm tra nếu username đã tồn tại
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo "Tên đăng nhập đã tồn tại!";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $stmt = $pdo->prepare("INSERT INTO users (username, password, fullname, email, phone, role) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$username, $password, $fullname, $email, $phone, $role])) {
            echo "Đăng ký thành công. Bạn có thể đăng nhập ngay.";
            header('Location: login.php'); // Chuyển hướng đến trang đăng nhập
            exit();
        } else {
            echo "Đăng ký thất bại.";
        }
    }
}
?>

<h3>Đăng ký tài khoản</h3>
<form method="POST">
    Tên đăng nhập: <input type="text" name="username" required><br>
    Mật khẩu: <input type="password" name="password" required><br>
    Họ tên: <input type="text" name="fullname" required><br>
    Email: <input type="email" name="email"><br>
    Số điện thoại: <input type="text" name="phone"><br>
    <button type="submit">Đăng ký</button>
</form>

<p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
