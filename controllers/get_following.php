<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);


try {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = json_decode(file_get_contents("php://input"), true);
        $following_id = isset($data['followerId']) ? intval($data['followerId']) : null;

        $followingList = $database->getAllFollowing($following_id);

        echo json_encode($followingList);
    }
} catch (PDOException $e) {
    echo json_encode(['error' . $e->getMessage()]);
}
