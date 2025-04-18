<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../../includes/dbconnection.php';
include '../../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        $module_id = isset($data['module_id']) ? intval($data['module_id']) : null;
        $module_post_count = isset($data['module_post_count']) ? intval($data['module_post_count']) : null;

        $database->deleteModulesFromAdmin($module_id, $module_post_count);

        echo json_encode(['admin' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
