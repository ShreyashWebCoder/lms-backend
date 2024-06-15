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

// Check if the request is to get user data
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Specify the columns you need
    $sql = "SELECT userId, userName, userEmail, userRights, userContact, userAddress, userCity, userState FROM user";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        // Send the users data as JSON response
        echo json_encode($users);
    } else {
        // Send an empty array if no users are found
        echo json_encode([]);
    }
}

// Close connection
$conn->close();
?>
