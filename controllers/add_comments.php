<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $user_id = isset($data['user_id']) ? intval($data['user_id']) : null;
    $post_id = isset($data['post_id']) ? intval($data['post_id']) : null;
    $content = isset($data['content']) ? urldecode($data['content']) : null;

    if ($user_id && $post_id && $content) {
        try {
            $pdo->beginTransaction();
            $comment_id = $database->postComment($user_id, $post_id, $content);

            $newComment = $database->fetchNewComment($comment_id);

            echo json_encode($newComment);
            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode(['$error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error: ' . 'Invalid Input']);
    }
} else {
    echo json_encode(['error ' . 'Invalid request method']);
}
