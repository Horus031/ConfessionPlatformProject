<?php
header("Access-Control-Allow-Origin: *");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $newPassword = $_POST['newPassword'];
    try {
        $database->changePassword($userId, $newPassword);

        echo json_encode(['success' => 'Validation complete']);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
