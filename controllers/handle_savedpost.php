<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';
$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $post_id = isset($data['post_id']) ? intval($data['post_id']) : null;
    if ($post_id) {
        try {
            $saved = $database->handleSavedPosts($database->checkSavedPosts($post_id), $post_id);

            if ($saved) {
                echo json_encode(["status" => "unsaved"]);
            } else {
                echo json_encode(["status" => "saved"]);
            }
        } catch (PDOException $e) {
            echo json_encode('error ' . $e->getMessage());
        }
    }
}
