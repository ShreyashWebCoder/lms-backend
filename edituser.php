<?php
require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, PUT, POST, OPTIONS");
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
    // Check if 'userId' exists in the $_POST array
    if (!isset($_POST["userId"])) {
        echo json_encode(array("status" => "error", "message" => "'userId' not provided in the request"));
        exit; // Exit the script
    }

    // Get the user ID to be updated
    $userId = $_POST["userId"];

    // Get updated user data from the request
    $updatedUserName = $_POST["userName"];
    $updatedUserEmail = $_POST["userEmail"];
    $updatedUserAddress = $_POST["userAddress"];
    $updatedUserCity = $_POST["userCity"];
    $updatedUserState = $_POST["userState"];
    // Add more fields as needed

    // SQL query to update user data based on the user ID
    $stmt = $conn->prepare("UPDATE user SET userName = ?, userEmail = ?, userAddress = ?, userCity = ?, userState = ? WHERE userId = ?");
    $stmt->bind_param("sssssi", $updatedUserName, $updatedUserEmail, $updatedUserAddress, $updatedUserCity, $updatedUserState, $userId);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "User updated successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $stmt->error));
    }

    // Close the prepared statement
    $stmt->close();
    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the request method is not POST
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}
?>
