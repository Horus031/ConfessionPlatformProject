<?php
    include '../includes/dbconnection.php';

    if (isset($_POST['type'])) {
        $selectedType = $_POST['type'];
        try {
            $sql = 'SELECT tag_name, tag_description
                    FROM tags
                    WHERE tag_type = :tag_type
                    ';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':tag_type', $selectedType);
            $stmt->execute();
            $tagLists = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($tagLists);
        } catch (PDOException $e) {
            echo json_encode(['Error' . $e->getMessage()]);
        }
    }

?>