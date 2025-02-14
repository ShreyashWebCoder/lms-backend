<?php
require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $userId = $_POST["userId"];
    $userRights = $_POST["userRights"];
    if($userRights=="Admin"){
     $addProject_add=1;
     $addProject_edit=1;
     $addProject_delete=1;
     $addProject_view=1;
    }else if($userRights=="Buyer"){
     $addProject_add=0;
     $addProject_edit=0;
     $addProject_delete=0;
     $addProject_view=1;
    }
    

    // SQL query to insert data into the user table
    $sql = "INSERT INTO `userpermissions`(`id`, `role`, `addProject_add`, `addProject_edit`, `addProject_delete`, `addProject_view`) VALUES ('$userId','$userRights','$addProject_add','$addProject_edit','{$addProject_delete}','$addProject_view')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "User added successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $conn->error));
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the form is not submitted
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
