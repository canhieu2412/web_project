<?php
session_start();
include('db.php');

// Kiểm tra xem người dùng có phải là giảng viên không
if ($_SESSION['role'] != 'teacher') {
    echo "Bạn không có quyền truy cập!";
    exit();
}

// Kiểm tra ID người dùng cần chỉnh sửa, nếu không có, thì chỉnh sửa tài khoản của chính giảng viên
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_id']; 

// Lấy thông tin người dùng cần chỉnh sửa
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Không tìm thấy người dùng!";
    exit();
}

// Cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Cập nhật thông tin vào cơ sở dữ liệu
    $stmt = $pdo->prepare("UPDATE users SET username = ?, fullname = ?, email = ?, phone = ? WHERE id = ?");
    if ($stmt->execute([$username, $fullname, $email, $phone, $user_id])) {
        echo "Thông tin người dùng đã được cập nhật!";
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin.";
    }
}
?>

<h3>Chỉnh sửa thông tin người dùng</h3>
<form method="POST">
    Tên đăng nhập: <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
    Họ tên: <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>
    Số điện thoại: <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br>
    <button type="submit">Cập nhật</button>
</form>
