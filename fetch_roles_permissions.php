<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once 'config.php';
require_once 'permissions.php';

// Ensure the user has permission to view roles and permissions

protectRoute('view_roles_permissions');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die(json_encode([
            "status" => "error",
            "message" => "Connection failed: " . $conn->connect_error
        ]));
    }

    // Fetch roles
    $rolesResult = $conn->query("SELECT * FROM roles");
    $roles = $rolesResult->fetch_all(MYSQLI_ASSOC);

    // Fetch permissions
    $permissionsResult = $conn->query("SELECT * FROM permissions");
    $permissions = $permissionsResult->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        "roles" => $roles,
        "permissions" => $permissions
    ]);

    $rolesResult->free();
    $permissionsResult->free();
    $conn->close();
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
}
?>
