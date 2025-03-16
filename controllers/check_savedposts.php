<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';
$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $post_id = isset($data['post_id']) ? intval($data['post_id']) : null;
    if ($post_id) {
        try {
            $saved = $database->checkSavedPosts($post_id);

            if ($saved) {
                echo json_encode(["status" => "yes"]);
            } else {
                echo json_encode(["status" => "no"]);
            }
        } catch (PDOException $e) {
            echo json_encode(['error ' . $e->getMessage()]);
        }
    }
}
