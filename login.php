<?php
include("connect.php");
session_start();
$errors = [];
if(isset($_POST['login_btn']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(isset($email) && !empty($email) && isset($password) && !empty($password))
    {
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            if($result = $mysqli->query($sql))
            {
                $row = $result->fetch_assoc();
                if($result->num_rows)
                {
                    if(password_verify($password,$row['password']))
                    {
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['is_logged_in'] = true;
                        setcookie("email",$_SESSION['email'],time()+100);
                        setcookie("username", $_SESSION['username'], time() + 100);
                        setcookie("is_logged_in", $_SESSION['is_logged_in'], time() + 100);

                        header("Location: home.php");
                    }else{
                        $errors[] = "Your password is wrong!";
                    }
                }else{
                    $errors[] = "There is not a user with those credentials!";
                }
            }else{
                $errors[] = "Login failed, please try again!";
            }
        }else
        {
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
    <h1>Login Form</h1>

    <form method="POST">
        <input type="text" name="email" placeholder="Enter your email"> <br><br>
        <input type="password" name="password" placeholder="Enter your password"> <br><br>
        <button name="login_btn" type="submit">Submit</button>
    </form> <br>
    <a href="register.php">I don't have an account!</a>
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