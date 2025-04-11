<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';

$database = new Database($pdo);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['userId'] ?? $_SESSION['user_id'];
        $currentURL = $_POST['currentURL'] ?? null;
        $firstname = $_POST['firstnameValue'] ?? null;
        $lastname = $_POST['lastnameValue'] ?? null;
        $tag_name = $_POST['tagnameValue'] ?? null;
        $email = $_POST['emailValue'] ?? null;
        $bio = $_POST['bioValue'] ?? null;
        $social_links = isset($_POST['social_links']) ? json_decode($_POST['social_links'], true) : $_POST['social_links'];



        try {
            $pdo->beginTransaction();

            // Handle avatar upload
            $existingAvatarURL = $database->fetchExistingAvatarURL($userId);
            if (isset($_FILES['avatarURL']) && $_FILES['avatarURL']['tmp_name']) {
                include '../includes/upload_avatar.php';
            }

            if (isset($uploadData['error'])) {
                throw new Exception($uploadData['error']);
            }

            $avatarURL = $avatarURL ?? $existingAvatarURL;

            // Update user information
            $database->updateUser($userId, $firstname, $lastname, $tag_name, $email, $avatarURL, $bio);
            $database->updateUserSocialLinks($userId, $social_links);

            // Update session data
            if ($userId == $_SESSION['user_id']) {
                $_SESSION['fullname'] = $firstname . ' ' . $lastname;
                $_SESSION['tag_name'] = $tag_name;
                $_SESSION['avatarURL'] = $avatarURL;
            }

            $pdo->commit();

            if (str_contains($currentURL, 'admin')) {
                echo json_encode(['admin' => 'success']);
            } else {
                echo json_encode(['user' => 'success']);
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}