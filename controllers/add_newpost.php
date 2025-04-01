<?php
session_start();
header("Access-Control-Allow-Origin: *");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        $user_id = $_SESSION['user_id'];
        $title = $_POST['titleValue'];
        $content = $_POST['contentValue'];
        $module_id = $_POST['moduleValues'];

        // Check if the imageURL has value
        if (isset($_FILES['imageURL']['value'])) {
            // Include the upload_images.php file to handle the image upload
            include '../includes/upload_images.php';

            // Use the $imageUrl variable set by upload_images.php
            $imageURL = $imageUrl;
        } else {
            $imageURL = null; // Set to null if no image is uploaded
        }


        // Insert the post into the database
        $post_id = $database->insertPost($user_id, $title, $content, $module_id, $imageURL);

        $newPost = $database->fetchPostDetails($post_id);

        // Handle tags
        $tagArray = array_map('trim', explode(',', $_POST['tagInput']));
        $tagArray = array_filter($tagArray);

        $tagIds = $database->fetchTagIds($tagArray);
        $database->insertPostTags($post_id, $tagIds);

        echo json_encode($newPost);
        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
}
