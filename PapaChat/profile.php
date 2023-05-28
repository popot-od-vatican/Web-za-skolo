<?php
    session_start();

    if(!isset($_SESSION['Username']))
    {
        header("Location: /login.php");
        exit();
    }

    require "connect.php";

    $res = $conn->query("SELECT Email FROM Users WHERE Username='".$_SESSION['Username']."';");

    if($res->num_rows <= 0)
    {
        $EMAIL = "None";
    }
    else
    {
        $EMAIL = $res->fetch_assoc()['Email'];
    }
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Profile</title>
    </head>
    <body>
        <div class="Container">
            <div class="header">
                <img src="images/person-icon.png" valign="bottom" class="item-image">
                <div class="userandemail">
                    <div class="username"> <?php echo $_SESSION['Username'] ?> </div>
                    <div class="email"> <?php echo $EMAIL ?> </div>
                </div>
            </div>
            <div class="Description">
                <textarea name="Description" id="DESCRIPTION_ID" rows="15" placeholder="Write something about you!" style="border-radius: 20px; padding: 5px;"></textarea>
            </div>
        </div>
    </body>
</html>