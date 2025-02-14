<?php
require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Extract the roleId from the query string
    if (isset($_GET['roleId'])) {
        $roleId = $_GET['roleId'];
    } else {
        echo json_encode(array("status" => "error", "message" => "Role ID is required"));
        exit;
    }

    $sql = "DELETE FROM roles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roleId);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Role deleted successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error deleting role: " . $conn->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}

$conn->close();
?>
