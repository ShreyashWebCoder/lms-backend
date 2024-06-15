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
    $userId = $_POST["userId"];
    $password = $_POST["password"];
    $userRights = $_POST["userRights"];
    $userName = $_POST["userName"];
    $userContact = $_POST["userContact"];
    $userEmail = $_POST["userEmail"];
    $userAddress = $_POST["userAddress"];
    $userCity = $_POST["userCity"];
    $userState = $_POST["userState"];

    // SQL query to insert data into the user table
    $sql = "INSERT INTO user (userId, password, userRights, userName, userContact, userEmail, userAddress, userCity, userState)
            VALUES ('$userId', '$password', '$userRights', '$userName', '$userContact', '$userEmail', '$userAddress', '$userCity', '$userState')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "User added successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $conn->error));
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the form is not submitted
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
