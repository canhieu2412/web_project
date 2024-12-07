<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng là giáo viên
if ($_SESSION['role'] != 'teacher') {
    echo "Bạn không có quyền truy cập!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $created_by = $_SESSION['user_id'];

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
        $file_path = NULL;  // Nếu không tải file thì để là NULL
    }

    // Lưu bài tập vào cơ sở dữ liệu
    $stmt = $pdo->prepare("INSERT INTO assignments (title, description, due_date, created_by, file_path) 
                           VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$title, $description, $due_date, $created_by, $file_path])) {
        echo "Bài tập đã được tạo thành công!";
    } else {
        echo "Có lỗi xảy ra khi tạo bài tập.";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    Tiêu đề bài tập: <input type="text" name="title" required><br>
    Mô tả: <textarea name="description"></textarea><br>
    Ngày hết hạn: <input type="date" name="due_date" required><br>
    
    <!-- Tải lên file -->
    Tải lên tài liệu (PDF, DOC, DOCX): <input type="file" name="file" accept=".pdf, .doc, .docx"><br>
    
    <button type="submit">Tạo Bài Tập</button>
</form>
