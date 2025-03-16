<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if (isset($_POST['type'])) {
    $selectedType = $_POST['type'];
    try {
        $tagLists = $database->fetchTagsByType($selectedType);
        echo json_encode($tagLists);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
