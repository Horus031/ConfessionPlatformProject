<?php
// filepath: d:\xampp\htdocs\mywebsite\controllers\follow_user.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $followerId = $data['follower_id'];
    $followingId = $data['following_id'];

    if ($database->isFollowing($followerId, $followingId)) {
        $database->unfollowUser($followerId, $followingId);
        echo json_encode(['status' => 'unfollowed']);
    } else {
        $database->followUser($followerId, $followingId);
        echo json_encode(['status' => 'followed']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
