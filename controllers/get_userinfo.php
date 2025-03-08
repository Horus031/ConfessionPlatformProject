<?php
    session_start();
    include '../includes/dbconnection.php';

    try {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'User ID not set in session']);
            exit;
        }
    
        $sql = 'SELECT users.username, users.tag_name, users.email, users.bio, users.avatar, users.created_at, user_social_links.platform, user_social_links.url
                FROM users
                LEFT JOIN user_social_links ON users.user_id = user_social_links.user_id
                WHERE users.user_id = :user_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $userInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (empty($userInfo)) {
            echo json_encode(['error' => 'No user found with the given ID']);
        } else {
            echo json_encode($userInfo);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    
?>