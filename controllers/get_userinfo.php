<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
        $tagName = $_GET['tag_name'] ?? null;

        if (!$tagName) {
            echo json_encode(['error' => 'Tag name not provided']);
            exit;
        }

        $userInfo = $database->fetchUserInfo($tagName);

        if (empty($userInfo)) {
            echo json_encode(['error' => 'No user found with the given tag name']);
        } else {
            $socialLink = $database->fetchSocialLinks($userInfo['user_id']);
            $userInfo['socialLinks'] = $socialLink;

            echo json_encode($userInfo);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
