<?php

use function PHPSTORM_META\elementType;

    session_start();

    header("Content-Type: application/json");

    $file = file_get_contents("references/".$_SESSION['Username']."/info.txt");

    if($file == false)
    {
        mkdir("references/".$_SESSION['Username']);
        $file = fopen("references/".$_SESSION['Username']."/info.txt", 'w');
        fwrite($file, '{
                "direct": [],
                "groups": []
        }');
        fclose($file);
    }

    $json = file_get_contents("references/".$_SESSION['Username']."/info.txt");
    $json = json_decode($json);

    $obj = new stdClass();
    $obj = [];

    for($i = 0; $i < count($json->direct); $i++)
    {
        $name = $json->direct[$i];
        $element = new stdClass();
        $element->Name = $name;
        $element->Message = "";

        if(file_exists("chats/direct/".$name."-".$_SESSION['Username'].".txt"))
        {
            $data = file_get_contents("chats/direct/".$name."-".$_SESSION['Username'].".txt");
            $jsondata = json_decode($data);

            if($jsondata != [])
            {
                $element->Message = $jsondata[count($jsondata)-1]->Content;
            }
        }
        else if(file_exists("chats/direct/".$_SESSION["Username"]."-".$name.".txt"))
        {
            $data = file_get_contents("chats/direct/".$_SESSION['Username']."-".$name.".txt");
            $jsondata = json_decode($data);

            if($jsondata != [])
            {
                $element->Message = $jsondata[count($jsondata)-1]->Content;
            }
        }

        array_push($obj, $element);
    }

    $json->direct = $obj;

    echo json_encode($json);
?>