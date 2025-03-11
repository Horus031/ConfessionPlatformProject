<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';

    $database = new Database($pdo);

    try {
        if (isset($_POST['post_id'])) {
            $post_id = $_POST['post_id'];
            $database->deletePost($post_id);
            header('Location: ../views/main.html.php?page=home');
        } else {
            echo json_encode(['error' => 'Post ID not provided']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>