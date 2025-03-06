<?php
    session_start();
    include '../includes/dbconnection.php';

    try {
        include './upload_images.php';

        $sql = 'INSERT INTO posts SET
                user_id = :user_id,
                title = :title,
                content = :content,
                module_id = :module_id,
                imageURL = :imageURL,
                status = "approved"
        ';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->bindParam(':title', $_POST['titleValue']);
        $stmt->bindParam(':content', $_POST['contentValue']);
        $stmt->bindParam(':module_id', $_POST['moduleValues']);
        $stmt->bindParam(':imageURL', $imageUrl);
        $stmt->execute();

        header('Location: ../views/main.html.php');
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>