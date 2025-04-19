<?php
header("Access-Control-Allow-Origin: *");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId']; // Get user ID from session or form
    $currentPassword = $_POST['currentPassword'];

    $passwordResult = $database->verifyPassword($userId, $currentPassword);

    if ($passwordResult) {
        echo json_encode(['success' => 'Validation complete']);
    } else {
        echo json_encode(['wrongPassword' => "Current password is incorrect."]);
    }
}
