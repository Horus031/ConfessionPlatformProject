<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="/mywebsite/src/css/output.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


</head>

<body class="h-screen">
    <div class="dark:bg-gray-900  relative flex h-full w-full overflow-x-hidden overflow-y-auto transition-all">
        <?php include '../includes/overlay.php' ?>
        <?php include '../includes/header.php' ?>

        <?php include "./" . $page . ".html.php"; ?>
    </div>
</body>




</html>