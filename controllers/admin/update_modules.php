<?php
include '../../includes/dbconnection.php';
include '../../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $module_id = $_POST['moduleId'];
    $module_name = $_POST['editModuleName'];
    $bg_class = $_POST['editBackground'];
    $text_class = $_POST['editText'];

    try {
        $database->updateModulesFromAdmin($module_id, $module_name, $bg_class, $text_class);


        echo json_encode(['admin' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['error' . $e->getMessage()]);
    }
}
