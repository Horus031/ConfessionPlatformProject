<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';
$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = isset($data['userId']) ? intval($data['userId']) : null;
    try {
        $notifications = $database->getAllNotifications($userId);

        echo json_encode($notifications);
    } catch (PDOException $e) {
        echo json_encode(['error ' . $e->getMessage()]);
    }
}
