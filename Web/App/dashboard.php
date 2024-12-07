<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];  // 'teacher' hoặc 'student'

// Điều hướng đến dashboard của giáo viên hoặc học sinh
if ($role == 'teacher') {
    header("Location: teacher_dashboard.php");
} else {
    header("Location: student_dashboard.php");
}
?>
