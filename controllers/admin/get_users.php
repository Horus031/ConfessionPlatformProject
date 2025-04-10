<?php

include '../../includes/dbconnection.php';
include '../../includes/dbfunctions.php';

$database = new Database($pdo);
try {
    $users = $database->getUsersFromAdmin();

    if ($users) {
        echo json_encode($users);
    } else {
        echo json_encode(['error' => 'No users found']);
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
