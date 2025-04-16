<?php

include '../../includes/dbconnection.php';
include '../../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $module_name = isset($data['module_name']) ? $data['module_name'] : null;
    try {
        $moduleLists = $database->getModulesFromAdmin($module_name);

        if ($moduleLists) {
            echo json_encode($moduleLists);
        } else {
            echo json_encode(['error' => 'Error']);
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}
