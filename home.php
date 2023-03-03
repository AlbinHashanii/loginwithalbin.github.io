<?php
include("connect.php");
session_start();
if(isset($_COOKIE['is_logged_in']))
{
    if(isset($_COOKIE['username']))
    {
        echo '<a href="?action=logout">Logout</a>';
    }
}else{
    header("Location: login.php");
}

if(isset($_GET['action']))
{
    if($_GET['action'] === "logout")
    {
        // delete sessions
        unset($_SESSION['email']);
        unset($_SESSION['username']);
        unset($_SESSION['is_logged_in']);
        session_destroy();

        // delete cookies
        setcookie("email", null, -1);
        setcookie("username", null, -1);
        setcookie("is_logged_in", null, -1);

        header("Location: login.php"); 
    }
}

$email = $_COOKIE['email'];
$username = $_COOKIE['username'];



?>
<!Doctype html>
<html lang="en">
<head>
    <Title>Profile</Title>
</head>
<body>
    <nav>
    <?php

    echo "<h1>Email i userit : $email";
    echo "\n <p> Username : $username";

    ?>
    </nav>
</body>
</html>