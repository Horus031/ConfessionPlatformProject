<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = isset($data['username']) ? $data['username'] : null;
    $password = isset($data['password']) ? $data['password'] : null;
    $remember = isset($data['remember_me']) ? $data['remember_me'] : null;

    $user = $database->fetchUserByUsername($username);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['avatarURL'] = $user['avatar'];
            $_SESSION['tag_name'] = $user['tag_name'];

            if ($remember) {
                $token = bin2hex(random_bytes(32)); // Generate a random token
                setcookie("remember_token", $token, time() + (30 * 24 * 60 * 60), "/"); // Set cookie for 30 days

                $database->updateRememberToken($user['user_id'], $token);
            } else {
                setcookie("remember_token", "", time() - 3600, "/");
            }

            echo json_encode(['success' => 'Login successful']);
        } else {
            echo json_encode(['wrongPassword' => 'Password is incorrect']);
        }
    } else {
        echo json_encode(['userNotFound' => 'Username is not found, please try again']);
    }
}
