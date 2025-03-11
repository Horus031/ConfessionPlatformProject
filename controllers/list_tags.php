<?php
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';
    $database = new Database($pdo);

    try {
        $tagList = $database->fetchAllTags();
        echo json_encode($tagList);
    } catch (PDOException $e) {
        echo json_encode(['error: ' . $e->getMessage()]);
    }

?>