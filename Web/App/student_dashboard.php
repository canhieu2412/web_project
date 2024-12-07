<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng là học sinh
if ($_SESSION['role'] != 'student') {
    echo "Bạn không có quyền truy cập!";
    exit();
}

// Lấy danh sách bài tập của học sinh
$stmt = $pdo->prepare("SELECT * FROM assignments");
$stmt->execute();
$assignments = $stmt->fetchAll();

?>

<h2>Chào mừng, Học sinh</h2>

<h3>Danh sách bài tập</h3>
<table>
    <tr>
        <th>Tiêu đề</th>
        <th>Mô tả</th>
        <th>Ngày hết hạn</th>
        <th>File đính kèm</th>
        <th>Thao tác</th>
    </tr>
    <?php foreach ($assignments as $assignment): ?>
    <tr>
        <td><?php echo htmlspecialchars($assignment['title']); ?></td>
        <td><?php echo htmlspecialchars($assignment['description']); ?></td>
        <td><?php echo htmlspecialchars($assignment['due_date']); ?></td>
        <td>
            <?php if ($assignment['file_path']): ?>
                <a href="<?php echo $assignment['file_path']; ?>" target="_blank">Tải về</a>
            <?php else: ?>
                Không có file đính kèm
            <?php endif; ?>
        </td>
        <td><a href="submit_assignment.php?assignment_id=<?php echo $assignment['id']; ?>">Nộp bài</a></td>
    </tr>
    <?php endforeach; ?>
</table>
