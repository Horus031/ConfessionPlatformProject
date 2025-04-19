<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../includes/dbconnection.php';
include '../includes/dbfunctions.php';


$database = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $otp = isset($data['otp']) ? intval($data['otp']) : null;

    if (!isset($_SESSION['otp']) || $_SESSION['otp'] != $otp) {
        echo json_encode(['wrongOTP' => 'Invalid OTP']);
        exit;
    }

    unset($_SESSION['otp']);

    echo json_encode(['success' => "OTP Validation Done"]);
}
