<?php
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['otp_email'];
    $newPassword = $_POST['newPassword'];
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    $database->changePasswordByEmail($email, $hashedPassword);

    unset($_SESSION['otp_email']);

    echo json_encode(['success' => 'Password changed successfully']);
}
