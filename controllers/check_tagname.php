<?php
// filepath: d:\xampp\htdocs\mywebsite\controllers\check_tagname.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $tagName = isset($data['tagName']) ? trim($data['tagName']) : '';

    if (empty($tagName)) {
        echo json_encode(['exists' => false, 'error' => 'Tag name is required.']);
        exit;
    }

    try {
        $sql = "SELECT COUNT(*) AS count FROM users WHERE tag_name = :tag_name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['tag_name' => $tagName]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
    } catch (PDOException $e) {
        echo json_encode(['exists' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['exists' => false, 'error' => 'Invalid request method.']);
}
