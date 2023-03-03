<?php
include("connect.php");
session_start();
$errors = [];
if(isset($_POST['register_btn']))
{
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if(isset($email) && !empty($email) && isset($password) && !empty($password) && isset($confirm_password) && !empty($confirm_password))
    {
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            if($password == $confirm_password)
            {
                $password = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO users(email,username,password) VALUES('$email','$username','$password')";
                if($mysqli->query($sql))
                {
                    $_SESSION['username'] = $username;
                    $_SESSION['is_logged_in'] = true;
                    $_SESSION['email'] = $email;
                    setcookie("email", $_SESSION['email'], time() + 100);
                    setcookie("username", $_SESSION['username'], time() + 100);
                    setcookie("is_logged_in", $_SESSION['is_logged_in'], time() + 100);

                    header("Location: home.php");
                }
            }else{
                $errors[] = "Passwords don't match!";
            }
        }else{
            $errors[] = "Please type a valid email!";
        }
    }else{
        $errors[] = "Please fill all the fields!";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        *{
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        .reg{
            text-align: center;
            margin: 0 auto;
            padding : 25px;
            border: 1px solid #000;
        }

        .reg a{
            color: #000;
            background-color: salmon;
            text-decoration: none;
            border: 1px solid #000;
            padding: 2px;
        }
        
        .reg button{
            font-size: 25px;
            background-color: salmon;
            border: 1px solid #000;
            color: #000;
        }

        .reg button:hover{
            padding: 5px;
            background-color: #fff;
            border: 1px solid salmon;
            border-radius: 10%;
        }

        .errors{
            border: 1px solid #000;
            margin: 0 auto;
            padding: 25px;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="reg">
    <h1>Register Form</h1>

    <form method="POST">
        <input type="text" name="email" placeholder="Enter your email"> <br><br>
        <input type="text" name="username" placeholder="Enter your username"> <br> <br>
        <input type="password" name="password" placeholder="Enter your password"> <br><br>
        <input type="password" name="confirm_password" placeholder="Confirm password"><br><br>
        <button name="register_btn" type="submit">Submit</button>
    </form> <br>
    <a href="login.php">I already have an account!</a>
    </div>
    <div class="errors">
        <?php
        echo "<ul>";
        foreach($errors as $error)
        {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        ?>
    </div>
</body>
</html>