<?php
session_start();
include '../includes/dbconnection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Xóa token trong database
    $stmt = $pdo->prepare("UPDATE users SET remember_token = NULL WHERE user_id = :user_id");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
}

// Hủy session và xóa cookie
session_destroy();
setcookie("remember_token", "", time() - 3600, "/"); // Xóa cookie bằng cách đặt thời gian hết hạn trong quá khứ

header("Location: ../views/login.html.php");
exit();
?>