<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    $postTags = $database->fetchAllPostTags();
    echo json_encode($postTags);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
