<?php
    session_start();
    include '../includes/dbconnection.php';

    if (isset($_POST['submit'])) {
        try {
            $pdo->beginTransaction();
            
            include '../includes/upload_images.php';
    
            $sql1 = 'INSERT INTO posts SET
                    user_id = :user_id,
                    post_title = :post_title,
                    post_content = :post_content,
                    module_id = :module_id,
                    imageURL = :imageURL,
                    status = "approved"
            ';
            $stmt = $pdo->prepare($sql1);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->bindParam(':post_title', $_POST['titleValue']);
            $stmt->bindParam(':post_content', $_POST['contentValue']);
            $stmt->bindParam(':module_id', $_POST['moduleValues']);
            $stmt->bindParam(':imageURL', $imageUrl);
            $stmt->execute();

            $post_id = $pdo->lastInsertId();

            $tagArray = array_map('trim', explode(',', $_POST['tagInput']));
            $tagArray = array_filter($tagArray);

            if (!empty($tagArray)) {
                $placeholders = implode(',', array_fill(0, count($tagArray), '?'));
                $sql2 = "SELECT tag_id FROM tags WHERE tag_name IN ($placeholders)";
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute($tagArray);
                $tagIds = $stmt2->fetchAll(PDO::FETCH_COLUMN);
            }


            $sql3 = "INSERT INTO posttags (post_id, tag_id) VALUES (:post_id, :tag_id)";
            $stmt3 = $pdo->prepare($sql3);
            foreach ($tagIds as $tag_id) {
                $stmt3->execute([':post_id' => $post_id, ':tag_id' => $tag_id]);
            }

            $pdo->commit();

            
            header('Location: ../views/main.html.php');

        } catch (PDOException $e) {
            $pdo->rollBack();
            echo 'Error:' . $e->getMessage();
        }
    }
?>