<?php
    include '../includes/dbconnection.php';
    include '../includes/dbfunctions.php';
    $database = new Database($pdo);

    try {
        $modules = $database->fetchAllModules($pdo);
        echo json_encode($modules);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }

?>