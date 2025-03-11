<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';

    $database = new Database($pdo);

    try {
        if (isset($_POST['Edit'])) {
            $action = $_POST['Edit'];

            if ($action == "Save") {
                try {
                    $pdo->beginTransaction();

                    $user_id = $_SESSION['user_id'];
                    $username = $_POST['usernameValue'];
                    $tag_name = $_POST['tagnameValue'];
                    $email = $_POST['emailValue'];
                    $bio = $_POST['bioValue'];
                    $social_links = $_POST['social_links'];

                    $existingAvatarURL = $database->fetchExistingAvatarURL($user_id);

                    include '../includes/upload_avatar.php';

                    if (isset($uploadData['error'])) {
                        throw new Exception($uploadData['error']);
                    }

                    $avatarURL = $avatarURL ?? $existingAvatarURL;

                    $database->updateUser($user_id, $username, $tag_name, $email, $avatarURL, $bio);
                    $database->updateUserSocialLinks($user_id, $social_links);

                    $_SESSION['username'] = $username;
                    $_SESSION['avatarURL'] = $avatarURL;

                    $pdo->commit();
                    header('Location: ../views/main.html.php?page=profile');
                } catch (Exception $e) {
                    $pdo->rollBack();
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else if ($action == "Cancel") {
                header('Location: ../views/main.html.php?page=profile');
            }
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>