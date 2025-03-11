<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';

    $database = new Database($pdo);

    try {
        if (isset($_GET['id'])) {
            $post_id = $_GET['id'];
            $commentInfo = $database->fetchComments($post_id);
            echo json_encode($commentInfo);
        } else {
            echo json_encode(['error' => 'Post ID not provided']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>