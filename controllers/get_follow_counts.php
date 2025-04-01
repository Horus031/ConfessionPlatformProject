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

        $followerCount = $database->getFollowerCount($userId);
        $followingCount = $database->getFollowingCount($userId);

        echo json_encode(['follower_count' => $followerCount, 'following_count' => $followingCount]);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
