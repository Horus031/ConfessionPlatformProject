<?php
    session_start();
    include '../models/dbconnection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_NUMBER_INT);
        $remember = isset($_POST['remember_me']);

        // Query from database
        $sql = "SELECT user_id, password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $username;

                // Check xem người dùng có bật remember me không
                if ($remember) {
                    $token = bin2hex(random_bytes(32)); // Tạo token ngẫu nhiên
                    setcookie("remember_token", $token, time() + (30 * 24 * 60 * 60), "/"); // Lưu 30 ngày
    
                    // Lưu token vào database
                    $sql = "UPDATE users SET remember_token = :token WHERE user_id = :user_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':token', $token);
                    $stmt->bindParam(':user_id', $user['user_id']);
                    $stmt->execute();
                }

                header("Location: ../views/mainpage.html.php");
            } else {
                echo "Password is incorrect";
            }
        } else {
            echo "Username is not found, please try again";
        }
    }
?>