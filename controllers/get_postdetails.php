<?php
    include '../includes/dbconnection.php';

    try {
        if (isset($_GET['id'])) {
            $post_id = $_GET['id'];

            $sql = 'SELECT posts.post_id, posts.user_id, posts.title, posts.content, posts.created_at, posts.imageURL, users.avatar, users.username, modules.name, modules.bg_class, modules.text_class 
                    FROM (( posts 
                    INNER JOIN users ON posts.user_id = users.user_id)
                    INNER JOIN modules ON posts.module_id = modules.module_id)
                    WHERE posts.post_id = :post_id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':post_id', $post_id);
            $stmt->execute();
            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode($post);

        } else {
            echo json_encode(['error' => 'Post ID not provided']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>