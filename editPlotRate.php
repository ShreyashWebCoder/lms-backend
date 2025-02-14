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

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $projectName = isset($_POST['projectName']) ? $_POST['projectName'] : '';
    $blockName = isset($_POST['blockName']) ? $_POST['blockName'] : '';
    $ratePerSqft = isset($_POST['ratePerSqft']) ? $_POST['ratePerSqft'] : '';

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE plot SET ratePerSqft=? WHERE plotStatus='Available' AND projectName=? AND blockName=?");

    // Bind parameters: 'd' for double, 'i' for integer, 's' for string, 'b' for blob
    $stmt->bind_param("dss", $ratePerSqft, $projectName, $blockName);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Plot Rate Per Square Feet Updated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
