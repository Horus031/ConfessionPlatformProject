<?php
// filepath: d:\xampp\htdocs\mywebsite\controllers\get_user_counts.php

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

        $viewCount = $database->getViewCount($userId);
        $likeCount = $database->getLikeCount($userId);

        echo json_encode(['view_count' => $viewCount, 'like_count' => $likeCount]);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
