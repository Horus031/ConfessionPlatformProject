<?php
session_start();
header('Content-Type: application/json');

try {
    if (isset($_SESSION['user_id'])) {
        echo json_encode([
            'user_id' => $_SESSION['user_id'],
            'fullname' => $_SESSION['fullname'],
            'username' => $_SESSION['fullname'],
            'avatar' => $_SESSION['avatarURL'],
            'tag_name' => $_SESSION['tag_name'],
            'email' => $_SESSION['email'],
            'role_id' => $_SESSION['role_id'],
        ]);
    } else {
        echo json_encode(['sessionNotFound' => 'Session Not Found']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
