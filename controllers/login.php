<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_NUMBER_INT);
    $remember = isset($_POST['remember_me']);

    $user = $database->fetchUserByUsername($username);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['avatarURL'] = $user['avatar'];

            if ($remember) {
                $token = bin2hex(random_bytes(32)); // Generate a random token
                setcookie("remember_token", $token, time() + (30 * 24 * 60 * 60), "/"); // Set cookie for 30 days

                $database->updateRememberToken($user['user_id'], $token);
            } else {
                setcookie("remember_token", "", time() - 3600, "/");
            }

            header("Location: ../views/main.html.php?page=home");
        } else {
            echo json_encode(['error' => 'Password is incorrect']);
        }
    } else {
        echo json_encode(['error' => 'Username is not found, please try again']);
    }
}
