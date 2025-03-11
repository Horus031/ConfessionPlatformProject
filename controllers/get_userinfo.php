<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';

    $database = new Database($pdo);

    try {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'User ID not set in session']);
            exit;
        }

        $userInfo = $database->fetchUserInfo($_SESSION['user_id']);

        if (empty($userInfo)) {
            echo json_encode(['error' => 'No user found with the given ID']);
        } else {
            echo json_encode($userInfo);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>