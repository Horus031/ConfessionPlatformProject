<?php
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';
$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['postValues'];
    $currentURL = $_POST['currentURL'] ?? null;
    $title = $_POST['titleValue'];
    $content = $_POST['contentValue'];
    $module_id = $_POST['moduleValues'];
    $tagValues = $_POST['tagInput'];
    $tagArray = array_map('trim', explode(',', $tagValues));
    $tagArray = array_filter($tagArray);
    try {
        $pdo->beginTransaction();

        $existingImageURL = $database->fetchExistingImageURL($post_id);
        if (isset($_FILES['imageURL']) && $_FILES['imageURL']['tmp_name']) {
            include '../includes/upload_images.php';
        }

        if (isset($uploadData['error'])) {
            throw new Exception($uploadData['error']);
        }

        $imageURL = $imageUrl ?? $existingImageURL;

        $database->updatePost($post_id, $title, $content, $module_id, $imageURL);
        $database->deleteExistingTags($post_id);
        $database->insertNewTags($post_id, $tagArray);

        $pdo->commit();

        if (str_contains($currentURL, 'admin')) {
            echo json_encode(['admin' => 'success']);
        } else {
            echo json_encode(['user' => 'success']);
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
}
