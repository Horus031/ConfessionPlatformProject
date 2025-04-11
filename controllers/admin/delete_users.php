<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../../includes/dbconnection.php';
include '../../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        $userId = isset($data['userId']) ? intval($data['userId']) : null;

        $database->deleteUsers($userId);

        echo json_encode(['admin' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
