<?php
    session_start();
    include '../includes/dbconnection.php';

    try {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'User ID not set in session']);
            exit;
        }
    
        $sql = 'SELECT * FROM users WHERE user_id = :user_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $userInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (empty($userInfo)) {
            echo json_encode(['error' => 'No user found with the given ID']);
        } else {
            echo json_encode($userInfo[0]);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    
?>