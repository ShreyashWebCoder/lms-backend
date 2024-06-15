<?php

require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204); // No Content
    exit();
}

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the POST request
    $input = json_decode(file_get_contents('php://input'), true);
    $ID = isset($input["id"]) ? $input["id"] : null;
    $HoldDate = isset($input["TodayDate"]) ? $input["TodayDate"] : null;
    $CustName = isset($input["customerName"]) ? $input["customerName"] : null;
    $CustNumber = isset($input["contactNo"]) ? $input["contactNo"] : null;
    $Address = isset($input["address"]) ? $input["address"] : null;
    $areaSqft = isset($input["areaSqft"]) ? $input["areaSqft"] : null;
    $areaSqmt = isset($input["areaSqmt"]) ? $input["areaSqmt"] : null;
    $blockName = isset($input["blockName"]) ? $input["blockName"] : null;
    $plotNo = isset($input["plotNo"]) ? $input["plotNo"] : null;
    $PlotStatus = isset($input["plotStatus"]) ? $input["plotStatus"] : null;
    $plotType = isset($input["plotType"]) ? $input["plotType"] : null;
    $projectName = isset($input["projectName"]) ? $input["projectName"] : null;
    $rate = isset($input["ratePerSqft"]) ? $input["ratePerSqft"] : null;
    $Remark = isset($input["remarks"]) ? $input["remarks"] : null;

    // Validate and sanitize the data before using it in a query

    // Check if all required fields are present
    if ($ID && $HoldDate && $CustName && $CustNumber && $Address && $areaSqft && $areaSqmt && $blockName && $plotNo && $PlotStatus && $plotType && $projectName && $rate && $Remark) {
        // Insert data into the block table
        $sql = "INSERT INTO `hold` (`ID`, `HoldDate`, `CustName`, `CustNumber`, `Address`, `ProjectName`, `BlockName`, `PlotNo`, `AreaSqft`, `AreaSqmt`, `PlotType`, `ratePerSqft`, `plotStatus`, `Remark`) 
                VALUES ('$ID', '$HoldDate', '$CustName', '$CustNumber', '$Address', '$projectName', '$blockName', '$plotNo', '$areaSqft', '$areaSqmt', '$plotType', '$rate', '$PlotStatus', '$Remark')";

        if ($conn->query($sql) === TRUE) {
            // Return success response
            $response = ["status" => "success", "message" => "Block added successfully"];
            echo json_encode($response);
        } else {
            // Return error response
            $response = ["status" => "error", "message" => "Error adding block: " . $conn->error];
            echo json_encode($response);
        }
    } else {
        // Return error response for missing fields
        $response = ["status" => "error", "message" => "Missing required fields"];
        echo json_encode($response);
    }
} else {
    // Return an error response if the request method is not POST
    $response = ["status" => "error", "message" => "Invalid request method"];
    echo json_encode($response);
}

// Close the database connection
$conn->close();

?>
