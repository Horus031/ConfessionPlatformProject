<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = $data['user_id'];
    $darkMode = $data['dark_mode'];

    $database->updateDarkModePreference($userId, $darkMode);

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
