<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = isset($data['username']) ? $data['username'] : null;
    $email = isset($data['email']) ? $data['email'] : null;
    $password = isset($data['password']) ? $data['password'] : null;
    $confirmPassword = isset($data['confirm_password']) ? $data['confirm_password'] : null;


    $user = $database->fetchUserByUsername($username);
    $count = $database->checkEmailExists($email);


    $errors = $database->validateRegistration($data, $user, $count);

    if (!empty($errors)) {
        echo json_encode(['errors' => $errors]);
    } else {
        echo json_encode(['success' => 'Valid!']);
    }
}
