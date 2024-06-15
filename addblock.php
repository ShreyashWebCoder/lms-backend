<?php

require_once 'config.php';

// Allow cross-origin requests
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the POST request
    $projectName = $_POST["projectName"];
    $blockName = $_POST["blockName"];
    $areaSqft = $_POST["areaSqft"];
    $areaSqmt = $_POST["areaSqmt"];
    $ratePerSqft = $_POST["ratePerSqft"];

    // You should validate and sanitize the data before using it in a query

    // Insert data into the block table
    $sql = "INSERT INTO block (projectName, blockName, areaSqft, areaSqmt, ratePerSqft) 
            VALUES ('$projectName', '$blockName', '$areaSqft', '$areaSqmt', '$ratePerSqft')";

    if ($conn->query($sql) === TRUE) {
        // Return success response
        $response = ["status" => "success", "message" => "Block added successfully"];
        echo json_encode($response);
    } else {
        // Return error response
        $response = ["status" => "error", "message" => "Error adding block: " . $conn->error];
        echo json_encode($response);
    }
} else {
    // Return an error response if the request method is not POST
    $response = ["status" => "error", "message" => "Invalid request method"];
    echo json_encode($response);
}

// Close the database connection
$conn->close();

?>
