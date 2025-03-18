<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['error' => 'Please fill out all information!']);
    } else {
        $count = $database->checkEmailExists($email);
        if ($count > 0) {
            echo json_encode(['error' => 'Username already exists, please choose another name']);
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);


            // Lưu vào session
            $_SESSION['register'] = [
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password
            ];
            header("Location: ../views/step2_register.html.php");
            exit();
        }
    }
}
