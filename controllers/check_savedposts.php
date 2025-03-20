<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $postId = isset($data['post_id']) ? $data['post_id'] : null;

    if (empty($postId)) {
        echo json_encode(['error' => 'Post ID not provided']);
        exit;
    }

    try {
        $savedStatus = $database->checkSavedPosts($postId);
        echo json_encode(['status' => $savedStatus ? 'yes' : 'no']);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
