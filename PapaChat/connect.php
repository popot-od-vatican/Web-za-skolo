<?php

    $server = "localhost";
    $username = "root";
    $password = "1234";
    $database = "maindatabase";

    $conn = new mysqli($server, $username, $password, $database);

    if($conn->connect_error)
    {
        die("Failed to connect to database!");
    }