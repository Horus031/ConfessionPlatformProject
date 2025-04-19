<?php
include '../includes/dbfunctions.php';
include '../includes/PHPMailer/PHPMailer.php';
include '../includes/PHPMailer/SMTP.php';
include '../includes/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$db = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $user = $db->checkEmailExists($email);
    if (!$user) {
        echo json_encode(['error' => 'Email not found']);
        exit;
    }

    // Generate a random OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;

    // Send the OTP via PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'mailsystemkn@gmail.com'; // Replace with your email
        $mail->Password = 'hjdk prmd ftvu zoho'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($user, 'Your Website');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body = "Your OTP is <b>$otp</b>. It is valid for 10 minutes.";

        $mail->send();
        echo json_encode(['success' => 'OTP sent to your email']);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Failed to send OTP. Please try again later.']);
    }
}
