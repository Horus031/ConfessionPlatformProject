<?php
// filepath: d:\xampp\htdocs\mywebsite\controllers\send_message.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mailsystemkn@gmail.com';
        $mail->Password = 'hjdk prmd ftvu zoho';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Debugging
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('vominhnghia1878@gmail.com');

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'New Message From Server';
        $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message\n";

        $mail->send();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Failed to send email.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
