<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $post_id = isset($data['post_id']) ? intval($data['post_id']) : (isset($_POST['post_id']) ? $_POST['post_id'] : null);
    $currentURL = isset($data['currentURL']) ? $data['currentURL'] : null;
    try {
        $pdo->beginTransaction();


        $database->deletePost($post_id);
        $pdo->commit();

        if (str_contains($currentURL, 'admin')) {
            echo json_encode(['admin' => 'success']);
        } else {
            echo json_encode(['user' => 'success']);
            header('Location: ../views/main.html.php?page=home');
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
}
