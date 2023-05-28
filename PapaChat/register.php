
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Register</title>
    </head>
    <body>
        <div class="Container">
            <form method="POST" action="/validate_signup.php">
                <div class="FormSection">
                    <label for="EmailAddress">Email:</label>
                    <input name="EmailAddress" size=32 type="email" id="EMAIL_ID">
                </div>
                <div class="FormSection">
                    <label for="Username">Username:</label>
                    <input name="Username" size=32 id="USERNAME_ID">
                </div>
                <div class="FormSection">
                    <label for="Password">Password:</label>
                    <input name="Password" type="password" size=32 id="PASSWORD_ID">
                </div>
                <div class="FormSection">
                    <label for="ConfirmPassword">Confirm Password:</label>
                    <input name="ConfirmPassword" type="password" size=32 id="CONFIRMPASSWORD_ID">
                </div>
                <div class="FormSection" style="text-align:center">
                    <input type="submit" id="SubmitButton" value="Register" name="submit">
                </div>
                <div class="FormSection" style="text-align:center;">
                    <a href="login.php">Already have an account</a>
                </div>
            </form>
        </div>
        <?php

            function GetEmail()
            {
                if(!empty($_GET['EmailAddress']))
                {
                    $email = "\"".$_GET['EmailAddress']."\"";

                    echo
                    "
                        <script>
                            var email = {$email};
                            document.getElementById(\"EMAIL_ID\").value=email;
                        </script>
                    ";
                }
            }

            function GetUsername()
            {
                if(!empty($_GET['Username']))
                {
                    $username = "\"".$_GET['Username']."\"";

                    echo
                    "
                        <script>
                            var username = {$username};
                            document.getElementById(\"USERNAME_ID\").value=username;
                        </script>
                    ";
                }
            }

            if(empty($_GET['error']))
                exit();

            $error = $_GET["error"];

            switch($error)
            {
                case 'INVALID_EMAIL':
                    echo '
                        <script>
                            document.getElementById("EMAIL_ID").style.border="1px solid red";
                            document.getElementById("EMAIL_ID").placeholder="Enter your Email Address";
                        </script>
                    ';
                    break;
                case 'INVALID_USERNAME':
                     echo '
                        <script>
                            document.getElementById("USERNAME_ID").style.border="1px solid red";
                            document.getElementById("USERNAME_ID").placeholder="Enter your username";
                        </script>
                    ';
                    GetEmail();
                    break;
                case 'INVALID_PASSWORD':
                    echo '
                        <script>
                            document.getElementById("PASSWORD_ID").style.border="1px solid red";
                            document.getElementById("PASSWORD_ID").placeholder="Enter your password";
                        </script>
                    ';
                    GetEmail();
                    GetUsername();
                    break;
                case 'INVALID_CONFIRMPASSWORD':
                    echo '
                        <script>
                            document.getElementById("CONFIRMPASSWORD_ID").style.border="1px solid red";
                            document.getElementById("CONFIRMPASSWORD_ID").placeholder="Enter your password again";
                        </script>
                    ';
                    GetEmail();
                    GetUsername();
                    break;
                case 'PASSWORDS_NOT_MATCHING':
                    echo '
                        <script>
                            document.getElementById("CONFIRMPASSWORD_ID").style.border="1px solid red";
                            document.getElementById("CONFIRMPASSWORD_ID").placeholder="Passwords are not the same";
                            document.getElementById("PASSWORD_ID").placeholder="Passwords are not the same";
                            document.getElementById("PASSWORD_ID").style.border="1px solid red";
                        </script>
                    ';
                    GetEmail();
                    GetUsername();
                    break;
                case 'USERNAME_TAKEN':
                    echo '
                        <script>
                            document.getElementById("USERNAME_ID").placeholder="Username is already!";
                        </script>
                    ';

                    GetEmail();
                    break;
                case 'EMAIL_TAKEN':
                    echo '
                        <script>
                            document.getElementById("EMAIL_ID").placeholder="Email address is already used!";
                        </script>
                    ';

                    GetUsername();
                    break;
                default:
                    break;
            }

        ?>

    </body>
</html>