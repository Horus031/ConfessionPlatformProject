<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
    'user_id' => $_SESSION['user_id'],
    'fullname' => $_SESSION['fullname'],
    'username' => $_SESSION['fullname'],
    'avatar' => $_SESSION['avatarURL'],
    'tag_name' => $_SESSION['tag_name'],
]);
