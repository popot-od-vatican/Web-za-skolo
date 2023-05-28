<?php
    session_start();

    header("Content-Type: application/json");

    if(!isset($_SESSION['Current']))
    {
        $_SESSION['Current'] = $_SESSION['Username'];
    }

    if(file_exists("chats/direct/".$_SESSION['Username']."-".$_SESSION['Current'].".txt"))
    {
        $json = file_get_contents("chats/direct/".$_SESSION['Username']."-".$_SESSION['Current'].".txt");
        $arr = json_encode($json);
        echo $arr;
    }
    else if(file_exists("chats/direct/".$_SESSION['Current']."-".$_SESSION['Username'].".txt"))
    {
        $json = file_get_contents("chats/direct/".$_SESSION['Current']."-".$_SESSION['Username'].".txt");
        $arr = json_encode($json);
        echo $arr;
    }
    else
    {
        echo '[]';
    }
?>