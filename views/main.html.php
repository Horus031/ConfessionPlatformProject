<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Knowledge Nexus</title>
    <link rel="stylesheet" href="/mywebsite/src/css/output.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


</head>

<body class="dark:bg-gray-900">
    <div class="dark:bg-gray-900  relative flex h-full w-full overflow-x-hidden overflow-y-auto transition-all scroll ">
        <!-- Check if page is not admin page -->
        <?php if ($page !== 'admin') : ?>
            <?php include '../includes/overlay.php' ?>
            <?php include '../includes/header.php' ?>

            <?php include "./" . $page . ".html.php"; ?>
        <?php else : ?>
            <?php include "./" . $page . ".html.php"; ?>
        <?php endif; ?>
    </div>


</body>

</html>