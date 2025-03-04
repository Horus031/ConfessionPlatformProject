<?php
session_start();
include './models/dbconnection.php'; // Kết nối database

// Kiểm tra nếu đã đăng nhập bằng session
if (isset($_SESSION['user_id'])) {
    header("Location: views/mainpage.html.php");
    exit();
}

// Nếu có cookie "remember_token", kiểm tra trong database
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];

    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE remember_token = ?");
    $stmt->bindParam("s", $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        // Tạo session cho người dùng
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $username;

        // Chuyển hướng đến dashboard
        header("Location: views/mainpage.html.php");
        exit();
    }
}

// Nếu không có session hoặc cookie, hiển thị trang đăng nhập
header("Location: views/login.html.php");
exit();
?>