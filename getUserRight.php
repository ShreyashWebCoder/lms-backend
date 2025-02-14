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
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Getting form data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($email) || empty($password)) {
        echo json_encode(["error" => "Email and password are required"]);
        exit;
    }

    // Query to fetch user role
    $query = "SELECT userRights FROM user WHERE userEmail = ? AND password= ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email,$password); // "s" means string type

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    
            echo json_encode(["userRight" => $row['userRights']]);
    } else {
        echo json_encode(["error" => "Invalid email or password"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>
