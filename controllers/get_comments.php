<?php
    include '../includes/dbconnection.php';

    try {
        if (isset($_GET['id'])) {
            $post_id = $_GET['id'];

            $sql = 'SELECT comments.comment_id, comments.user_id, comments.post_id, comments.content, users.username, users.avatar
                    FROM ((comments
                    INNER JOIN posts ON comments.post_id = posts.post_id)
                    INNER JOIN users ON comments.user_id = users.user_id)
                    WHERE posts.post_id = :post_id';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':post_id', $post_id);
            $stmt->execute();
            $commentInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($commentInfo);
        }
    } catch (PDOException $e) {
        echo json_encode(['Error' . $e->getMessage()]);
    }

?>