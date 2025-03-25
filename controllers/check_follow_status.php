<?php
// filepath: d:\xampp\htdocs\mywebsite\controllers\check_follow_status.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $followerId = isset($_GET['follower_id']) ? $_GET['follower_id'] : '';
        $followingId = isset($_GET['following_id']) ? $_GET['following_id'] : '';

        if (empty($followerId) || empty($followingId)) {
            echo json_encode(['error' => 'User IDs not provided']);
            exit;
        }

        $isFollowing = $database->isFollowing($followerId, $followingId);

        echo json_encode(['is_following' => $isFollowing]);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
