<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once 'config.php';




function getPermissionsByRoleId($roleId) {
    global $conn;

    $stmt = $conn->prepare("
        SELECT p.permission_name 
        FROM permissions p
        JOIN role_permissions rp ON p.id = rp.permission_id
        WHERE rp.role_id = ?
    ");
    $stmt->bind_param("i", $roleId);
    $stmt->execute();
    $result = $stmt->get_result();

    $permissions = [];
    while ($row = $result->fetch_assoc()) {
        $permissions[] = $row['permission_name'];
    }
    return $permissions;
}

function hasPermission($requiredPermission) {
    session_start();

    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
        return false;
    }

    $roleId = $_SESSION['role_id'];
    $permissions = getPermissionsByRoleId($roleId);

    return in_array($requiredPermission, $permissions);
}

function protectRoute($requiredPermission) {
    if (hasPermission($requiredPermission)) {
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(["status" => "error", "message" => "You do not have permission to access this resource."]);
        exit();
    }
}
?>
