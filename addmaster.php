<?php
require_once 'config.php';

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

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the POST request
    $projectName = $_POST["projectName"];
    $guideline = $_POST["guideline"];
    $registryMalePercent = $_POST["registryMalePercent"];
    $registryFemalePercent = $_POST["registryFemalePercent"];
    $serviceType = $_POST["serviceType"];
    $servicePerSqmt = $_POST["servicePerSqmt"];
    $serviceLumpsumValue = $_POST["serviceLumpsumValue"];
    $maintenanceType = $_POST["maintenanceType"];
    $maintenancePerSqmt = $_POST["maintenancePerSqmt"];
    $maintenanceLumpsumValue = $_POST["maintenanceLumpsumValue"];
    $miscType = $_POST["miscType"];
    $miscPerSqmt = $_POST["miscPerSqmt"];
    $miscLumpsumValue = $_POST["miscLumpsumValue"];
    $brokerageValue = $_POST["brokerageValue"];

    // SQL query to insert a new record into the "master" table
    $sql = "INSERT INTO master (
        projectName, guideline, registryMalePercent, registryFemalePercent,
        serviceType, servicePerSqmt, serviceLumpsumValue,
        maintenanceType, maintenancePerSqmt, maintenanceLumpsumValue,
        miscType, miscPerSqmt, miscLumpsumValue, brokerageValue
    ) VALUES (
        '$projectName', '$guideline', $registryMalePercent, $registryFemalePercent,
        '$serviceType', $servicePerSqmt, $serviceLumpsumValue,
        '$maintenanceType', $maintenancePerSqmt, $maintenanceLumpsumValue,
        '$miscType', $miscPerSqmt, $miscLumpsumValue, $brokerageValue
    )";

    if ($conn->query($sql) === TRUE) {
        // Send a success message as JSON response
        echo json_encode(["status" => "success"]);
    } else {
        // Send an error message as JSON response
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

// Close connection
$conn->close();
?>
