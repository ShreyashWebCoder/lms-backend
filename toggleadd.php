<?php
// toggleUserPermission.php

require_once 'config.php';

// Set appropriate headers for CORS and JSON response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Check if the required POST parameters are set
if (isset($_POST['userId']) && isset($_POST['field'])) {
    $userId = $_POST['userId'];
    $field = $_POST['field']; // The field to toggle (Add, Delete, Edit, View)

    // Verify that the field to toggle is valid (optional, for security)
    $validFields = ['Add', 'Delete', 'Edit', 'View'];
    if (!in_array($field, $validFields)) {
        echo json_encode(["status" => "error", "message" => "Invalid field specified"]);
        exit;
    }

    // Fetch the current value of the field
    $query = "SELECT $field FROM users WHERE userId = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Toggle the field value
            $newValue = $row[$field] == 1 ? 0 : 1;

            // Update the field in the database
            $updateQuery = "UPDATE users SET $field = ? WHERE userId = ?";
            $updateStmt = $conn->prepare($updateQuery);
            if ($updateStmt) {
                $updateStmt->bind_param("ii", $newValue, $userId);

                if ($updateStmt->execute()) {
                    echo json_encode(["status" => "success", "newValue" => $newValue]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to update field"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to prepare update statement"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "User not found"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to prepare select statement"]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request, missing parameters"]);
}
?>
