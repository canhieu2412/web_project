<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng là học sinh
if ($_SESSION['role'] != 'student') {
    echo "Bạn không có quyền truy cập!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assignment_id = $_POST['assignment_id'];
    $user_id = $_SESSION['user_id'];

    // Kiểm tra nếu có file tải lên
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file'];
        $allowed_extensions = ['pdf', 'doc', 'docx'];  // Các file được phép tải lên
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            // Đặt tên file là ngẫu nhiên và di chuyển file đến thư mục uploads
            $file_name = uniqid() . '.' . $file_extension;
            $file_path = 'uploads/' . $file_name;
            move_uploaded_file($file['tmp_name'], $file_path);
        } else {
            echo "Chỉ cho phép tải lên các file PDF, DOC, DOCX.";
            exit();
        }
    } else {
        echo "Bạn cần tải lên file để nộp bài!";
        exit();
    }

    // Lưu bài nộp vào cơ sở dữ liệu
    $stmt = $pdo->prepare("INSERT INTO submissions (assignment_id, user_id, file_path) 
                           VALUES (?, ?, ?)");
    if ($stmt->execute([$assignment_id, $user_id, $file_path])) {
        echo "Nộp bài thành công!";
    } else {
        echo "Có lỗi xảy ra khi nộp bài!";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="assignment_id" value="<?php echo $_GET['assignment_id']; ?>">
    Tải lên file bài làm (PDF, DOC, DOCX): <input type="file" name="file" accept=".pdf, .doc, .docx" required><br>
    <button type="submit">Nộp Bài</button>
</form>
