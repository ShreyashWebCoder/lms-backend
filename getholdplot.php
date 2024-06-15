<?php
require_once 'config.php';

// Set headers to allow cross-origin requests
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

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // SQL query to select all data from the "hold" table
    $sql = "SELECT * FROM hold";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $holdPlots = array();
        while ($row = $result->fetch_assoc()) {
            $holdPlots[] = $row;
        }

        // Send the data as a JSON response
        echo json_encode($holdPlots);
    } else {
        // Send an empty array if no data is found
        echo json_encode([]);
    }
}

// Close connection
$conn->close();
?>
