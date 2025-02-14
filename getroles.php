<?php
require_once 'config.php';

// Allow cross-origin requests
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

$sql = "SELECT id, role_name FROM roles";
$result = $conn->query($sql);

$roles = array();

if ($result->num_rows > 0) {
    // Fetch all roles as an associative array
    while($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

echo json_encode($roles);

$conn->close();
?>
