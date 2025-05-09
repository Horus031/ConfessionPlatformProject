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

        if ($queryType[0]['type'] === 'tag') {
            $results = $database->searchPostByTags(substr($query, 1));
        } elseif ($queryType[0]['type'] === 'user') {
            $results = $database->searchPostByTagName(substr($query, 1));
        } else {
            $results = $database->searchPostsAndUsers($query);
        }

        echo json_encode($results);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
