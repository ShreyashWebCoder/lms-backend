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
        $date = isset($_POST['date']) ? $_POST['date'] : '';
        $paymentType = isset($_POST['paymentType']) ? $_POST['paymentType'] : '';
        $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
        $bankMode = isset($_POST['bankMode']) ? $_POST['bankMode'] : '';
        $cheqNo = isset($_POST['cheqNo']) ? $_POST['cheqNo'] : '';
        $bankName = isset($_POST['bankName']) ? $_POST['bankName'] : '';
        $transactionStatus = isset($_POST['transactionStatus']) ? $_POST['transactionStatus'] : '';
        $statusDate = isset($_POST['statusDate']) ? $_POST['statusDate'] : '';
        $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';

        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE transaction SET 
                                date=?, paymentType=?, amount=?, bankMode=?, 
                                cheqNo=?, bankName=?, transactionStatus=?, 
                                statusDate=?, remarks=?
                                WHERE id=?");
        $stmt->bind_param("sssssssssi", 
                          $date, $paymentType, $amount, $bankMode, 
                          $cheqNo, $bankName, $transactionStatus, 
                          $statusDate, $remarks, $id);

        // Check if the statement executed successfully
        if ($stmt->execute()) {
            // Return success status and message
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Transaction data updated successfully"]);
        } else {
            // Log the detailed error message and return a generic error response
            error_log("Error updating transaction data: " . $stmt->error);
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to update transaction data"]);
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
