<?php

require_once 'config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $TallyStatus = $_POST['TallyStatus'];

    // Debugging: log the received data
    error_log("Received data: ID=" . $id . ", TallyStatus=" . $TallyStatus);

    $stmt = $conn->prepare("UPDATE booking SET TalliedStatus=? WHERE id=?");
    $stmt->bind_param("si", $TallyStatus, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Status updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();

?>