<?php
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';
    $database = new Database($pdo);

    try {
        $pdo->beginTransaction();
    
        $post_id = $_POST['postValues'];
        $title = $_POST['titleValue'];
        $content = $_POST['contentValue'];
        $module_id = $_POST['moduleValues'];
        $tagValues = $_POST['tagInput'];
        $tagArray = array_map('trim', explode(',', $tagValues));
        $tagArray = array_filter($tagArray);
    
        $existingImageURL = $database->fetchExistingImageURL($post_id);
    
        include '../includes/upload_images.php';
    
        if (isset($uploadData['error'])) {
            throw new Exception($uploadData['error']);
        }
    
        $imageURL = $imageUrl ?? $existingImageURL;
    
        $database->updatePost($post_id, $title, $content, $module_id, $imageURL);
        $database->deleteExistingTags($post_id);
        $database->insertNewTags($post_id, $tagArray);
    
        $pdo->commit();
        header('Location: ../views/main.html.php?page=home');
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
?>