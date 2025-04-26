<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = isset($data['email']) ? trim($data['email']) : '';

    try {
        $emailResult = $database->checkEmailExists($email);

        if ($emailResult) {
            echo json_encode(['emailExists' => 'Email is already exists']);
        } else {
            echo json_encode(['success' => 'Validation done']);
        }
    } catch (PDOException $e) {
        echo json_encode(['exists' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['exists' => false, 'error' => 'Invalid request method.']);
}
