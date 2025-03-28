<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $user_id = isset($data['user_id']) ? intval($data['user_id']) : null;

        $database->deleteAllNotification($user_id);

        echo json_encode(['success' => 'Successfully delete']);
    } else {
        echo json_encode(['Invalid value']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' . $e->getMessage()]);
}
