<?php
    session_start();
    session_unset();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Log in</title>
    </head>
    <body>
        <div class="Container">
            <form method="POST" action="validate_login.php">
                <div class="FormSection">
                    <label for="Username">Username:</label>
                    <input type="text" name="Username" size=32 required id="USERNAME_ID">
                </div>
                <div class="FormSection">
                    <label for="Password">Password:</label>
                    <input type="password" name="Password" size=32 required id="PASSWORD_ID">
                </div>
                <div class="FormSection" style="text-align:center;">
                    <input type="submit" value="Log in" id="SubmitButton">
                </div>
                <div class="FormSection" style="text-align:center;">
                    <a href="register.php">Don't have an account</a>
                </div>
            </form>
        </div>
        <?php

            if(!empty($_GET['error']))
            {
                switch($_GET['error'])
                {
                    case 'INVALID_USERNAME':
                        echo '
                            <script>
                                document.getElementById("USERNAME_ID").style.border = "1px solid red";
                                document.getElementById("USERNAME_ID").placeholder = "That username doesn\'t exist!";
                            </script>
                        ';
                        break;
                    case 'INVALID_PASSWORD':
                        echo '
                            <script>
                                document.getElementById("PASSWORD_ID").style.border = "1px solid red";
                                document.getElementById("PASSWORD_ID").placeholder = "Incorrect Password!";
                            </script>
                        ';
                        break;
                    default:
                        break;
                }
            }
        ?>
    </body>
</html>