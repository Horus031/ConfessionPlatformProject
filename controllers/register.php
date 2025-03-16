<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username)) {
        echo json_encode(['error' => 'Please enter a username']);
    } elseif (empty($password)) {
        echo json_encode(['error' => 'Please enter a password']);
    } else {
        $count = $database->checkUsernameExists($username);
        if ($count > 0) {
            echo json_encode(['error' => 'Username already exists, please choose another name']);
        } else {
            $database->registerUser($username, $password);
            echo json_encode(['success' => 'User is registered!']);
            header("Location: ../views/login.html.php");
            exit();
        }
    }
}
