<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if (isset($_POST['submit'])) {
    try {
        $pdo->beginTransaction();

        include '../includes/upload_images.php';

        $user_id = $_SESSION['user_id'];
        $title = $_POST['titleValue'];
        $content = $_POST['contentValue'];
        $module_id = $_POST['moduleValues'];
        $imageURL = $imageUrl;

        $post_id = $database->insertPost($user_id, $title, $content, $module_id, $imageURL);

        $tagArray = array_map('trim', explode(',', $_POST['tagInput']));
        $tagArray = array_filter($tagArray);

        $tagIds = $database->fetchTagIds($tagArray);
        $database->insertPostTags($post_id, $tagIds);

        $pdo->commit();
        header('Location: ../views/main.html.php?page=home');
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
}
