<?php
session_start();
include('db.php');

// Kiểm tra xem người dùng có phải là học sinh không
if ($_SESSION['role'] != 'student') {
    echo "Bạn không có quyền truy cập!";
    exit();
}

// Lấy thông tin của học sinh (dựa trên ID người dùng)
$user_id = $_SESSION['user_id'];  // ID của học sinh hiện tại
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Không tìm thấy người dùng!";
    exit();
}

// Cập nhật thông tin học sinh
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Cập nhật thông tin vào cơ sở dữ liệu (không cho phép thay đổi username)
    $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, phone = ? WHERE id = ?");
    if ($stmt->execute([$fullname, $email, $phone, $user_id])) {
        echo "Thông tin của bạn đã được cập nhật!";
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin.";
    }
}
?>

<h3>Chỉnh sửa thông tin cá nhân</h3>
<form method="POST">
    Họ tên: <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>
    Số điện thoại: <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br>
    <button type="submit">Cập nhật</button>
</form>
