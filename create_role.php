<?php
// require_once 'config.php';


// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// $conn = new mysqli($host, $username, $password, $database);


// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $roleName = $_POST["roleName"];

//     if (empty($roleName)) {
//         echo json_encode(array("status" => "error", "message" => "Role name is required"));
//         exit;
//     }

//     $sql = "INSERT INTO `roles` (`name`) VALUES (?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("s", $roleName);

//     if ($stmt->execute()) {
//         echo json_encode(array("status" => "success", "message" => "Role created successfully"));
//     } else {
//         echo json_encode(array("status" => "error", "message" => "Error creating role: " . $conn->error));
//     }

//     $stmt->close();
// } else {
//     echo json_encode(array("status" => "error", "message" => "Invalid request method"));
// }

// $conn->close();
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Read the JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $roleName = $input["roleName"];

    if (empty($roleName)) {
        echo json_encode(array("status" => "error", "message" => "Role name is required"));
        exit;
    }

    $sql = "INSERT INTO `roles` (`role_name`) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $roleName);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Role created successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error creating role: " . $conn->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}

$conn->close();


?>
