<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username)) {
            echo "Please enter a username";
        } elseif (empty($password)) {
            echo "Please enter a password";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                echo 'Username already exists, please choose another name';
            } else {
                $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hash);
                $stmt->execute();
                echo "User is registered!";
                header("Location: ../views/login.html.php");
                exit();
            }
        }
    }


    $pdo = null;
    $sql = null;
    $stmt = null;
    $count = null;
?>