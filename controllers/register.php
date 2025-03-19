<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $firstName = isset($data['firstName']) ? $data['firstName'] : null;
    $lastName = isset($data['lastName']) ? $data['lastName'] : null;
    $username = isset($data['username']) ? $data['username'] : null;
    $tagName = isset($data['tagName']) ? $data['tagName'] : null;
    $email = isset($data['email']) ? $data['email'] : null;
    $password = isset($data['password']) ? $data['password'] : null;

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $result = $database->insertUser($firstName, $lastName, $username, $tagName, $email, $hashedPassword);

    if ($result) {
        echo json_encode(['success' => 'Registration successful']);
    } else {
        echo json_encode(['error' => 'Failed to register user']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
