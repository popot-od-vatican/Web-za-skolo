<?php
    session_start();

    header("Content-Type: application/json");

    if(!isset($_SESSION['Current']))
    {
        $_SESSION['Current'] = $_SESSION['Username'];
    }

    $obj = new stdClass();
    $obj->Owner = $_SESSION['Username'];
    $obj->Content = $_GET['message'];

    if(file_exists("chats/direct/".$_SESSION['Username']."-".$_SESSION['Current'].".txt"))
    {
        $json = file_get_contents("chats/direct/".$_SESSION['Username']."-".$_SESSION['Current'].".txt");
        $arr = json_decode($json);
        array_push($arr, $obj);
        $arr = json_encode($arr);
        file_put_contents("chats/direct/".$_SESSION['Username']."-".$_SESSION['Current'].".txt", $arr);
        echo $arr;
    }
    else if(file_exists("chats/direct/".$_SESSION['Current']."-".$_SESSION['Username'].".txt"))
    {
        $json = file_get_contents("chats/direct/".$_SESSION['Current']."-".$_SESSION['Username'].".txt");
        $arr = json_decode($json);
        array_push($arr, $obj);
        $arr = json_encode($arr);
        file_put_contents("chats/direct/".$_SESSION['Current']."-".$_SESSION['Username'].".txt", $arr);
        echo $arr;
    }
?>