<?php
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';
$database = new Database($pdo);

try {
    $savedPosts = $database->getAllSavedPosts();


    echo json_encode($savedPosts);
} catch (PDOException $e) {
    echo json_encode(["error " . $e->getMessage()]);
}
