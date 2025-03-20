<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = isset($_GET['query']) ? $_GET['query'] : '';

    if (empty($query)) {
        echo json_encode(['error' => 'Query not provided']);
        exit;
    }

    if ($query[0] === '#') {
        $results = $database->searchTags(substr($query, 1));
    } elseif ($query[0] === '@') {
        $results = $database->searchUsersByTagName(substr($query, 1));
    } else {
        $results = $database->searchPostsAndUsers($query);
    }

    echo json_encode($results);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
