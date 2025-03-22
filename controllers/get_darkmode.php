<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $userId = isset($_GET['user_id']) ? $_GET['user_id'] : '';

        if (empty($userId)) {
            echo json_encode(['error' => 'User ID not provided']);
            exit;
        }

        $darkMode = $database->getDarkModePreference($userId);

        echo json_encode(['dark_mode' => $darkMode]);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
