<?php
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';
$database = new Database($pdo);

try {
    $questions = $database->fetchAllPosts($pdo);


    echo json_encode($questions);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
