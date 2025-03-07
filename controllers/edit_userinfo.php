<?php
session_start();
include '../includes/dbconnection.php';

try {
    if (isset($_POST['Edit'])) {
        $action = $_POST['Edit'];

        if ($action == "Save") {
            try {
                $pdo->beginTransaction();

                // Fetch the existing avatar URL from the database
                $sql = "SELECT avatar FROM users WHERE user_id = :user_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->execute();
                $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
                $existingAvatarURL = $existingUser['avatar'];

                // Include the upload_avatar.php file and capture the output
                include '../includes/upload_avatar.php';

                if (isset($uploadData['error'])) {
                    throw new Exception($uploadData['error']);
                }

                // Use the new avatar URL if a new image is uploaded, otherwise use the existing avatar URL
                $avatarURL = $avatarURL ?? $existingAvatarURL;


                $sql1 = "UPDATE users SET
                        username = :username,
                        tag_name = :tag_name,
                        email = :email,
                        avatar = :avatar,
                        bio = :bio
                        WHERE user_id = :user_id
                ";
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->bindParam(':username', $_POST['usernameValue']);
                $stmt1->bindParam(':tag_name', $_POST['tagnameValue']);
                $stmt1->bindParam(':email', $_POST['emailValue']);
                $stmt1->bindParam(':avatar', $avatarURL);
                $stmt1->bindParam(':bio', $_POST['bioValue']);
                $stmt1->bindParam(':user_id', $_SESSION['user_id']);
                $stmt1->execute();

                $_SESSION['username'] = $_POST['usernameValue'];
                $_SESSION['avatarURL'] = $avatarURL;

                $social_links = $_POST['social_links'];

                foreach ($social_links as $platform => $url) {
                    if (!empty($url)) {
                        $sql = "SELECT id FROM user_social_links WHERE user_id = :user_id AND platform = :platform";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(":user_id", $_SESSION['user_id']);
                        $stmt->bindParam(":platform", $platform);
                        $stmt->execute();
                        $existing = $stmt->fetch();

                        if ($existing) {
                            $sql = "UPDATE user_social_links SET url = :url WHERE user_id = :user_id AND platform = :platform";
                            $stmt = $pdo->prepare($sql);
                        } else {
                            $sql = "INSERT INTO user_social_links (user_id, platform, url) VALUES (:user_id, :platform, :url)";
                            $stmt = $pdo->prepare($sql);
                        }

                        $stmt->bindParam(":user_id", $_SESSION['user_id']);
                        $stmt->bindParam(":platform", $platform);
                        $stmt->bindParam(":url", $url);
                        $stmt->execute();
                    }
                }

                $pdo->commit();
                header('Location: ../views/main.html.php?page=profile');
            } catch (Exception $e) {
                $pdo->rollBack();
                echo "Error: " . $e->getMessage();
            }
        } else if ($action == "Cancel") {
            header('Location: ../views/main.html.php?page=profile');
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>