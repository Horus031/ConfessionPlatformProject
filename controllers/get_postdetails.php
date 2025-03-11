<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';

    $database = new Database($pdo);

    try {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : "";

        if ($contentType === "application/json") {
            $data = json_decode(file_get_contents("php://input"), true);
            $post_id = isset($data['post_id']) ? intval($data['post_id']) : null;
        } else {
            $post_id = isset($_POST["post_id"]) ? intval($_POST["post_id"]) : (isset($_GET['id']) ? intval($_GET['id']) : null);
        }

        if ($post_id === null) {
            throw new Exception("Post ID not provided");
        }

        $post = $database->fetchPostDetails($post_id);

        if ($post) {
            $tags = $database->fetchPostTagsWithId($post_id);
            $post['tags'] = $tags;

            echo json_encode($post);
        } else {
            throw new Exception("Post not found");
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>