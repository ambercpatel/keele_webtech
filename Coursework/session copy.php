<?php
session_start();
    if (isset($_SESSION["loggedin"])) header ("Location: secret.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title> Log-in page </title>
    <link rel="stylesheet" href= "session.css">
</head>
<body>
    Welcome to the private message service <br>
    <form action = "login.php" method = "POST">
        Login name: <input type = "text" name = "username"><br>
        Password: <input type = "password" name = "password"><br>
        <input type = "submit">
    </form>
</body>
</html>
