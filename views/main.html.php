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

    <style>
        .material-symbols-outlined {
            font-size: 30px;
        }

        .custom-icon {
            font-size: inherit !important;
            display: inherit !important;
            font-weight: inherit !important;
        }
    </style>
</head>

<body>
    <div class="relative flex h-full w-full overflow-x-hidden transition-all">
        <?php include '../includes/overlay.php' ?>
        <?php include '../includes/header.php' ?>

        <?php include "./" . $page . ".html.php"; ?>
    </div>
</body>

</html>