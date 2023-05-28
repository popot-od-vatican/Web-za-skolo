<?php
    require 'connect.php';
    
    $target = "Filip";

    $res = is_dir("references/".$target);

    if($res)
    {
        echo "True";
        $json = file_get_contents("references/".$target."/direct.txt");

        $data = json_decode($json);
        $location = $data[0]->FileLocation;

        $data = file_get_contents($location);
        $data = json_decode($data);

        foreach($data as $obj)
        {
            echo $obj->Owner;
        }
    }
    else
    {
        echo "False";
    }
?>