<?php
require_once 'config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is a DELETE request
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Retrieve project ID from the query parameters
    $projectId = isset($_GET['id']) ? $_GET['id'] : '';

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM block WHERE id = ?");
    $stmt->bind_param("s", $projectId);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Block deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
