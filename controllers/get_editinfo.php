<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $_SESSION['user_id']; // Get the user ID from the session

        if (!$userId) {
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $userInfo = $database->fetchEditingInfo($userId);

        if ($userInfo) {
            $socialLink = $database->fetchSocialLinks($userInfo['user_id']);
            $userInfo['socialLinks'] = $socialLink;

            echo json_encode($userInfo);
        } else {
            echo json_encode(['error' => 'User not found']);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
