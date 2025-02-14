<?php
require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $permissionName = $_POST["permissionName"];

    if (empty($permissionName)) {
        echo json_encode(array("status" => "error", "message" => "Permission name is required"));
        exit;
    }

    $sql = "INSERT INTO permissions (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $permissionName);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Permission created successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error creating permission: " . $conn->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}

$conn->close();
?>
