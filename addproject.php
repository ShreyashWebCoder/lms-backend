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

// Check if the request is to add a new project
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $projectName = isset($_POST['projectName']) ? $_POST['projectName'] : '';
    $locationCity = isset($_POST['city']) ? $_POST['city'] : '';
    $locationState = isset($_POST['state']) ? $_POST['state'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $projectType = isset($_POST['projectType']) ? $_POST['projectType'] : '';
    $totalLandArea = isset($_POST['totalLandArea']) ? $_POST['totalLandArea'] : '';
    $totalSalableArea = isset($_POST['totalSalableArea']) ? $_POST['totalSalableArea'] : '';

    // SQL query to insert data into the "addproject" table
    $sql = "INSERT INTO project (projectName, City, location, State, projectType, totalLandArea, totalSalableArea) VALUES ('$projectName', '$locationCity', '$location', '$locationState', '$projectType', '$totalLandArea', '$totalSalableArea')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "New record created successfully"]);
    } else {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
    }
} 

// Close connection
$conn->close();
?>
