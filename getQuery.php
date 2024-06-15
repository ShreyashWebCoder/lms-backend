<?php

    require_once 'config.php';

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = $_POST['query'];
    $mysqli = mysqli_query($conn,$sql);
    $json_data = array();

    while($row = mysqli_fetch_assoc($mysqli))
    {
        $json_data[] = $row;
    }
    echo json_encode(['phpresult'=>$json_data]);

?>  