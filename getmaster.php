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

// Check if the request is to get master data
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // SQL query to select all data from the "master" table
    $sql = "SELECT * FROM master";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $masterData = array();
        while ($row = $result->fetch_assoc()) {
            $masterData[] = $row;
        }

        // Send the master data as JSON response
        echo json_encode($masterData);
    } else {
        // Send an empty array if no data is found
        echo json_encode([]);
    }
}

// Close connection
$conn->close();
?>
