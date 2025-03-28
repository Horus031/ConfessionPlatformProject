<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET['user_id'];

    if ($userId) {
        try {
            $sql = "SELECT tag_name, read_count, 
                           (read_count / (SELECT SUM(read_count) FROM user_tags_history WHERE user_id = :user_id)) * 100 AS percentage
                    FROM user_tags_history
                    WHERE user_id = :user_id
                    ORDER BY percentage DESC
                    LIMIT 3";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($tags);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid user ID']);
    }
}
