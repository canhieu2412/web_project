<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng là giáo viên
if ($_SESSION['role'] != 'teacher') {
    echo "Bạn không có quyền truy cập!";
    exit();
}

// Lấy danh sách bài tập do giáo viên tạo
$stmt = $pdo->prepare("SELECT * FROM assignments WHERE created_by = ?");
$stmt->execute([$_SESSION['user_id']]);
$assignments = $stmt->fetchAll();

?>

<h2>Chào mừng, Giáo viên</h2>
<a href="create_assignment.php">Tạo Bài Tập Mới</a><br>

<h3>Danh sách bài tập</h3>
<table>
    <tr>
        <th>Tiêu đề</th>
        <th>Mô tả</th>
        <th>Ngày hết hạn</th>
        <th>Quản lý</th>
    </tr>
    <?php foreach ($assignments as $assignment): ?>
    <tr>
        <td><?php echo htmlspecialchars($assignment['title']); ?></td>
        <td><?php echo htmlspecialchars($assignment['description']); ?></td>
        <td><?php echo htmlspecialchars($assignment['due_date']); ?></td>
        <td><a href="view_submissions.php?assignment_id=<?php echo $assignment['id']; ?>">Xem bài nộp</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Quản lý thử thách</h3>
<a href="create_challenge.php">Tạo Thử Thách Mới</a>
