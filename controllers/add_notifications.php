<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = isset($data['receiverId']) ? intval($data['receiverId']) : null;
    $senderId = isset($data['senderId']) ? intval($data['senderId']) : null;
    $type = isset($data['type']) ? $data['type'] : null;
    $message = isset($data['message']) ? $data['message'] : null;
    $message_content = isset($data['message_content']) ? $data['message_content'] : null;
    $url = isset($data['url']) ? $data['url'] : null;

    if ($userId && $senderId && $type && $message && $url) {
        try {
            $pdo->beginTransaction();

            $database->sendNotifications($userId, $senderId, $type, $message, $message_content, $url);


            echo json_encode(['success' => 'Successfully create notification']);
            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode(['error' . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(['error ' . 'Invalid request method']);
}
