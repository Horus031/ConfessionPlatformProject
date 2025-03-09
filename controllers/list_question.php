<?php
    include '../includes/dbconnection.php';

    try {
        $sql = 'SELECT posts.post_id, posts.user_id, posts.title, posts.content, posts.created_at, posts.imageURL, users.avatar, users.username, COUNT(DISTINCT likes.like_id) as likes, COUNT(DISTINCT comments.comment_id) as comments, modules.name, modules.bg_class, modules.text_class 
                FROM ((((posts 
                INNER JOIN users ON posts.user_id = users.user_id)
                INNER JOIN modules ON posts.module_id = modules.module_id)
                LEFT JOIN likes ON posts.post_id = likes.post_id)
                LEFT JOIN comments ON posts.post_id = comments.post_id)
                GROUP BY post_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($questions);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>