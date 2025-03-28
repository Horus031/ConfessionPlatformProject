<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = $data['user_id'];
    $tagName = $data['tag_name'];

    if ($userId && $tagName) {
        try {
            $sql = "INSERT INTO user_tags_history (user_id, tag_name, read_count)
                    VALUES (:user_id, :tag_name, 1)
                    ON DUPLICATE KEY UPDATE read_count = read_count + 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'tag_name' => $tagName]);

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
}
