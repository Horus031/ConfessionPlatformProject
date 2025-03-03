<?php
    include "models/dbconnection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h2>Welcome to Fakebook</h2>
        <label for="username">Username: </label><br>
        <input type="text" name="username" id=""><br>
        <label for="password">Password: </label><br>
        <input type="password" name="password" id=""><br>
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
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
            }
        }
    }


    $pdo = null;
    $sql = null;
    $stmt = null;
    $count = null;
?>