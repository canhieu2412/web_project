<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra username trong cơ sở dữ liệu
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Chuyển hướng đến dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Sai tên đăng nhập hoặc mật khẩu.";
    }
}
?>

<h3>Đăng nhập</h3>
<form method="POST">
    Tên đăng nhập: <input type="text" name="username" required><br>
    Mật khẩu: <input type="password" name="password" required><br>
    <button type="submit">Đăng nhập</button>
</form>

<p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
