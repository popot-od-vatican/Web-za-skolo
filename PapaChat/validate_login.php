<?php

    session_start();

    if(empty($_POST['Username']) || empty($_POST['Password']))
    {
        header("Location: /login.php");
        exit();
    }

    require 'connect.php';

    $res = $conn->query('SELECT * FROM Users WHERE Username="'.$_POST['Username'].'";');

    if($res->num_rows <= 0)
    {
        header("Location: /login.php?error=INVALID_USERNAME");
        exit();
    }

    $pswd = $res->fetch_assoc()['Password'];

    if($_POST['Password'] != $pswd)
    {
        header("Location: /login.php?error=INVALID_PASSWORD");
        exit();

    }

    $_SESSION['Username'] = $_POST['Username'];
    header("Location: /dashboard.php");
?>