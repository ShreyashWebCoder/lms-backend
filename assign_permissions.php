<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once 'config.php';
require_once 'permissions.php';

// Ensure the user has permission to manage roles
protectRoute('manage_roles');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $roleId = sanitizeInput($_POST["roleId"]);
    $permissions = $_POST["permissions"]; // Expecting an array of permission IDs

    foreach ($permissions as $permissionId) {
        $stmt = $conn->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $roleId, $permissionId);

        if (!$stmt->execute()) {
            echo json_encode(["status" => "error", "message" => "Error assigning permission: " . $stmt->error]);
            $stmt->close();
            $conn->close();
            exit();
        }
    }

    echo json_encode(["status" => "success", "message" => "Permissions assigned successfully"]);
    $stmt->close();
    $conn->close();
}
?>
