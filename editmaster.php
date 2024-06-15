<?php

require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, PUT, POST, OPTIONS");
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
    try {
        // Retrieve form data (validate and sanitize as needed)
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $projectName = isset($_POST['projectName']) ? $_POST['projectName'] : '';
        $guideline = isset($_POST['guideline']) ? $_POST['guideline'] : '';
        $registryMalePercent = isset($_POST['registryMalePercent']) ? $_POST['registryMalePercent'] : '';
        $registryFemalePercent = isset($_POST['registryFemalePercent']) ? $_POST['registryFemalePercent'] : '';
        $serviceType = isset($_POST['serviceType']) ? $_POST['serviceType'] : '';
        $serviceValue = isset($_POST['serviceValue']) ? $_POST['serviceValue'] : '';
        $maintenanceType = isset($_POST['maintenanceType']) ? $_POST['maintenanceType'] : '';
        $maintenanceValue = isset($_POST['maintenanceValue']) ? $_POST['maintenanceValue'] : '';
        $miscType = isset($_POST['miscType']) ? $_POST['miscType'] : '';
        $miscValue = isset($_POST['miscValue']) ? $_POST['miscValue'] : '';
        $brokerageValue = isset($_POST['brokerageValue']) ? $_POST['brokerageValue'] : '';

        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE master SET 
                                projectName=?, guideline=?, registryMalePercent=?, registryFemalePercent=?, 
                                serviceType=?, serviceValue=?,  
                                maintenanceType=?, maintenanceValue=?,  
                                miscType=?, miscValue=?,  
                                brokerageValue=?
                                WHERE id=?");
        $stmt->bind_param("sssssssssssi", 
                          $projectName, $guideline, $registryMalePercent, $registryFemalePercent, 
                          $serviceType, $serviceValue,  
                          $maintenanceType, $maintenanceValue,  
                          $miscType, $miscValue,  
                          $brokerageValue, $id);

        // Check if the statement executed successfully
        if ($stmt->execute()) {
            // Return success status and message
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Master data updated successfully"]);
        } else {
            // Log the detailed error message and return a generic error response
            error_log("Error updating master data: " . $stmt->error);
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to update master data"]);
        }

        // Close the prepared statement
        $stmt->close();
    } catch (Exception $e) {
        // Log any exceptions
        error_log("Exception: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Internal Server Error"]);
    }
}

// Close connection
$conn->close();

?>
