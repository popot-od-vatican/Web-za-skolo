<?php

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {

        if(empty($_POST['EmailAddress']))
        {
            header("Location: /register.php?error=INVALID_EMAIL");
            exit();
        }

        if(empty($_POST['Username']))
        {
            header("Location: /register.php?error=INVALID_USERNAME&EmailAddress=".$_POST['EmailAddress']);
            exit();
        }

        if(empty($_POST["Password"]))
        {
            header("Location: /register.php?error=INVALID_PASSWORD&EmailAddress=".$_POST['EmailAddress']."&Username=".$_POST['Username']);
            exit();
        }

        if(empty($_POST["ConfirmPassword"]))
        {
            header("Location: /register.php?error=INVALID_CONFIRMPASSWORD&EmailAddress=".$_POST['EmailAddress']."&Username=".$_POST['Username']);
            exit();
        }

        if($_POST["Password"] != $_POST["ConfirmPassword"])
        {
            header("Location: /register.php?error=PASSWORDS_NOT_MATCHING&EmailAddress=".$_POST['EmailAddress']."&Username=".$_POST['Username']);
            exit();
        }

        require 'connect.php';
        
        $input_name = $_POST['Username'];
        $input_email = $_POST['EmailAddress'];
        $input_password = $_POST['Password'];

        $res = $conn->query('SELECT * FROM Users WHERE Username="'.$input_name.'";');

        if($res->num_rows >= 1)
        {
            header("Location: /register.php?error=USERNAME_TAKEN&EmailAddress=".$_POST['EmailAddress']."&Username=".$_POST['Username']);
            exit();
        }

        $res = $conn->query('SELECT * FROM Users WHERE Email="'.$input_email.'"');

        if($res->num_rows >= 1)
        {
            header("Location: /register.php?error=EMAIL_TAKEN&EmailAddress=".$_POST['EmailAddress']."&Username=".$_POST['Username']);
            exit();
        }

        try
        {
            $conn->query('INSERT INTO Users (Username, Email, Password) VALUES ("'.$input_name.'", "'.$input_email.'", "'.$input_password.'");');
        } catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    else
    {
        header("Location: /register.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Successful Registration</title>
    </head>
    <body>
        <div class="register-content">
            <img src="images/green_tick_icon.png" alt="Green Tick Icon" width=250 height=250>
            <h1>You have successfully registered</h1>
            <p>You may now log in</p>
            <a href="login.php">Log In</a>
        </div>
    </body>
</html>