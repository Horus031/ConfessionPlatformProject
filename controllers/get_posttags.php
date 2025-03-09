<?php
    include '../includes/dbconnection.php';

    try {
        $sql = "SELECT posts.post_id, posts.post_title, tags.tag_id, tags.tag_name, tags.tag_description 
                FROM posts
                JOIN posttags ON posts.post_id = posttags.post_id
                JOIN tags ON tags.tag_id = posttags.tag_id
                ORDER BY tag_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $postTags = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($postTags);

    } catch (PDOException $e) {
        echo json_encode(['Error' . $e->getMessage()]);
    }

?>