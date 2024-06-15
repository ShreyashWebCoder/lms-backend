<?php
require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is a DELETE request
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Retrieve ID from the query parameters
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM master WHERE id = ?");
    $stmt->bind_param("s", $id); // Use "s" for string, adjust if needed

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Record deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
