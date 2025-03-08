<?php
    include '../includes/dbconnection.php';

    try {
        $sql = 'DELETE FROM posts WHERE post_id = :post_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':post_id', $_POST['post_id']);
        $stmt->execute();

        header('Location: ../views/main.html.php?page=home');
    } catch (PDOException $e) {
        echo json_encode(['Error' => $e->getMessage()]);
    }


?>