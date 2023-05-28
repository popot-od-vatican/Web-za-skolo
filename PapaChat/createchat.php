<?php

    session_start();

    require "connect.php";

    $res = $conn->query("SELECT * FROM Users WHERE Username='".$_GET['target']."';");

    if($res->num_rows <= 0)
    {
        exit();
    }

    header("Content-Type: application/json");

    $_SESSION['Current'] = $_GET['target'];

    if(file_exists("chats/direct/".$_GET['target']."-".$_GET['source'].".txt"))
    {
        $file = file_get_contents("chats/direct/".$_GET['target']."-".$_GET['source'].".txt");
        $json = json_encode($file);
        echo $json;
    }
    else if(file_exists("chats/direct/".$_GET['source']."-".$_GET['target'].".txt"))
    {
        $file = file_get_contents("chats/direct/".$_GET['source']."-".$_GET['target'].".txt");
        $json = json_encode($file);
        echo $json;
    }
    else
    {
        $file = fopen("chats/direct/".$_GET['source']."-".$_GET['target'].".txt", 'a');
        fwrite($file, "[]");

        if(!is_dir("references/".$_GET['source']))
        {
            mkdir("references/".$_GET['source']);
        }

        if(!is_dir("references/".$_GET['target']))
        {
            mkdir("references/".$_GET['target']);
        }

        $file = file_get_contents("references/".$_GET['target']."/info.txt");

        if($file == false)
        {
            $file = fopen("references/".$_GET['target']."/info.txt", 'w');
            fwrite($file, '{
                "direct": [],
                "groups": []
            }');
            fclose($file);
        }

        $json = file_get_contents("references/".$_GET['target']."/info.txt");
        $json = json_decode($json);

        if(!in_array($_GET['source'], $json->direct))
        {
            array_push($json->direct, $_GET['source']);
        }

        $json = json_encode($json);
        file_put_contents("references/".$_GET['target']."/info.txt", $json);

        

        $file = file_get_contents("references/".$_GET['source']."/info.txt");
        if($file == false)
        {
            $file = fopen("references/".$_GET['source']."/info.txt", 'w');
            fwrite($file, '{
                "direct": [],
                "groups": []
            }');
            fclose($file);
        }

        $json = file_get_contents("references/".$_GET['source']."/info.txt");
        $json = json_decode($json);

        if(!in_array($_GET['target'], $json->direct))
        {
            array_push($json->direct, $_GET['target']);
        }

        $json = json_encode($json);
        file_put_contents("references/".$_GET['source']."/info.txt", $json);
    }
?>