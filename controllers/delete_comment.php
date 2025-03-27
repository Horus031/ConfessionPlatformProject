<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $comment_id = isset($data['comment_id']) ? intval($data['comment_id']) : null;

    if ($comment_id) {
        try {
            $database->deleteComment($comment_id);

            echo json_encode(['success' => 'Successfully delete']);
        } catch (PDOException $e) {
            echo json_encode(['error' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }

    // deleteComment
}
