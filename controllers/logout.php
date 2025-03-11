<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';

    $database = new Database($pdo);

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Clear token in the database
        $database->clearRememberToken($user_id);
    }

    // Destroy session and clear cookie
    session_destroy();
    setcookie("remember_token", "", time() - 3600, "/"); // Clear cookie by setting expiration time in the past

    header("Location: ../views/login.html.php");
    exit();
?>