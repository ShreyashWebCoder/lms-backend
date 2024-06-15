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
    $projectId = isset($_POST['id']) ? $_POST['id'] : '';
    $projectName = isset($_POST['projectName']) ? $_POST['projectName'] : '';
    $blockName = isset($_POST['blockName']) ? $_POST['blockName'] : '';
    $plotNo = isset($_POST['plotNo']) ? $_POST['plotNo'] : '';
    $areaSqft = isset($_POST['areaSqft']) ? $_POST['areaSqft'] : '';
    $areaSqmt = isset($_POST['areaSqmt']) ? $_POST['areaSqmt'] : '';
    $ratePerSqft = isset($_POST['ratePerSqft']) ? $_POST['ratePerSqft'] : '';
    $plotType = isset($_POST['plotType']) ? $_POST['plotType'] : '';
    $plotStatus = isset($_POST['plotStatus']) ? $_POST['plotStatus'] : '';

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE plot SET projectName=?, blockName=?, plotNo=?, areaSqft=?, areaSqmt=?, ratePerSqft=?, plotType=?, plotStatus=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $projectName, $blockName, $plotNo, $areaSqft, $areaSqmt, $ratePerSqft, $plotType, $plotStatus, $projectId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Plot updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
