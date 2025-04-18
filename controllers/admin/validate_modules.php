<?php
include '../../includes/dbconnection.php';
include '../../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $module_name = $_POST['newModuleName'] ?? $_POST['editModuleName'];

    try {
        $existingModule = $database->getModuleByName($module_name);
        if ($existingModule) {
            echo json_encode(['existingModule' => 'This module name is already taken, please try again']);
        } else {
            echo json_encode(['success' => 'Success']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
