<?php
require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the JSON body data
    $data = json_decode(file_get_contents("php://input"), true);
    $roleId = $data["roleId"];
    $roleName = $data["roleName"];

    // Check if roleId and roleName are provided
    if (empty($roleId) || empty($roleName)) {
        echo json_encode(array("status" => "error", "message" => "Role ID and Role Name are required"));
        exit;
    }

    // Prepare and execute the update query
    $sql = "UPDATE roles SET role_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $roleName, $roleId);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Role updated successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error updating role: " . $conn->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}

$conn->close();
?>
