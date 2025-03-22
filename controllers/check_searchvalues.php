<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $query = isset($_GET['query']) ? $_GET['query'] : '';

        if (empty($query)) {
            echo json_encode(['error' => 'Query not provided']);
            exit;
        }

        $queryType = $database->checkSearchValue($query);

        echo json_encode($queryType);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
