<?php
include '../../includes/dbconnection.php';
include '../../includes/dbfunctions.php';

$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $module_name = $_POST['newModuleName'];
    $bg_class = $_POST['moduleBackground'];
    $text_class = $_POST['moduleTextColor'];

    try {
        $database->addModulesFromAdmin($module_name, $bg_class, $text_class);


        echo json_encode(['admin' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['error' . $e->getMessage()]);
    }
}
