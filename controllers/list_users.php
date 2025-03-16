<?php
session_start();
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';
$database = new Database($pdo);


try {
    $userId = $_SESSION['user_id'];
    $users = $database->fetchAllUsers($userId);

    echo json_encode($users);
} catch (PDOException $e) {
    echo json_encode(['error ' . $e->getMessage()]);
}
