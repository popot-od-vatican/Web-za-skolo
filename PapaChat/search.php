<?php

    require "connect.php";

    $target = $_GET["target"];

    header("Content-Type: application/json");

    $res = $conn->query("SELECT * FROM Users WHERE Username LIKE '".$target."%';");
    $data = [];

    if($res->num_rows <= 0)
    {
        $data[0] = "No results found!";
    }
    else
    {
        for($row = 0; $row < $res->num_rows; $row++)
        {
            $data[$row] = $res->fetch_assoc()['Username'] ;
        }

        $data[$res->num_rows] = $res->num_rows;
    }

    echo json_encode($data);
?>