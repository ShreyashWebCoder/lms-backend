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

    // SQL query to delete the project from the "project" table
    $sql = "DELETE FROM project WHERE id = '$projectId'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Project deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

// Close connection
$conn->close();
?>
