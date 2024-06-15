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

// Check if the request is to get project data
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // SQL query to select all data from the "project" table
    $sql = "SELECT * FROM plot";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $block = array();
        while ($row = $result->fetch_assoc()) {
            $block[] = $row;
        }

        // Send the projects data as JSON response
        echo json_encode($block);
    } else {
        // Send an empty array if no projects are found
        echo json_encode([]);
    }
}

// Close connection
$conn->close();
?>

