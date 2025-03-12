<?php
    session_start();
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Document</title>
    <link rel="stylesheet" href="/mywebsite/src/css/output.css">
</head>
<body class="font-poppins">
    <div class="relative flex h-full w-full overflow-x-hidden transition-all">
        <?php include '../includes/overlay.php' ?>
        <?php include '../includes/header.php' ?>

        <?php include "./" . $page . ".html.php"; ?>
    </div> 

    <script type="module">
        import EventListener from '../src/js/events.js';
        const eventListener = new EventListener();
        eventListener.start();
    </script>
</body>
</html>