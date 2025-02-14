<?php

require_once 'config.php';

header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and retrieve POST data
    $projectName = $conn->real_escape_string($_POST['projectName']);
    $blockName = $conn->real_escape_string($_POST['blockName']);
    $plotName = $conn->real_escape_string($_POST['plotName']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT date, paymentType, amount, bankMode, cheqNo, bankName FROM transaction WHERE projectName = ? AND blockName = ? AND plotno = ?");
    $stmt->bind_param("sss", $projectName, $blockName, $plotName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}

$conn->close();
?>
