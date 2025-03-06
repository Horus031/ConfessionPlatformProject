<?php
    include '../includes/dbconnection.php';

    try {
        $sql = "SELECT * FROM modules";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($modules);
        
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }

?>