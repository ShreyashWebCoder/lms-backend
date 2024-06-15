<?php

    // $host = "localhost";
    // $username = "u990603908_lms";
    // $password = "Royals#2023";
    // $database = "u990603908_lms";
    // header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    // header("Access-Control-Allow-Headers: Content-Type");
    // header("Content-Type: application/json");
    
    // $conn = new mysqli($host, $username, $password, $database);

    
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "u990603908_lms";
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");
    // Create a connection to the MySQL database
    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>


