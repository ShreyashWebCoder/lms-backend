<?php
require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
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
    $query = $_POST["query"];

    // SQL query to insert data into the user table
    $sql = $query;

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "Query executed successfully"));
    } else {
        $error_message = "Error executing query: " . $sql . " - Error: " . $conn->error;
        error_log($error_message,);

        // Output the error message in the response
        echo json_encode(array("status" => "error", "message" => $error_message));
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the form is not submitted
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
