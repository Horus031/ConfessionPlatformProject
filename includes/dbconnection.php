<?php
    try {
        $pdo = new PDO("mysql:host=localhost; dbname=confessiondb; charset=utf8mb4", "root", "Horusnee@!0312");
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>