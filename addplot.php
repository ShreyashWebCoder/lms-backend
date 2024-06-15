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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $projectName = $_POST["projectName"];
    $blockName = $_POST["blockName"];
    $plotNo = $_POST["plotNo"];
    $areaSqft = $_POST["areaSqft"];
    $areaSqmt = $_POST["areaSqmt"];
    $ratePerSqft = $_POST["ratePerSqft"];
    $plotType = $_POST["plotType"];
    $plotStatus = $_POST["plotStatus"];

    // SQL query to insert data into the plot table
    $sql = "INSERT INTO plot (projectName, blockName, plotNo, areaSqft, areaSqmt, ratePerSqft, plotType, plotStatus)
            VALUES ('$projectName', '$blockName', '$plotNo', '$areaSqft', '$areaSqmt', '$ratePerSqft', '$plotType', '$plotStatus')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "Plot added successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $conn->error));
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the form is not submitted
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}

?>
