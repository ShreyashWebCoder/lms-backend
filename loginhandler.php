<?php
require_once 'config.php';

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE userEmail = ?");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // echo $password;
        // echo $user['password'];
    // $passwordcheck=password_verify($password, $user['password']);
        if ($password==$user['password']) {
            echo "true";

            // Set the user as active
            $updateStmt = $conn->prepare("UPDATE user SET isActive = 1 WHERE userEmail = ?");
            $updateStmt->bind_param("s", $email);
            $updateStmt->execute();
            $updateStmt->close();

            // Assign role to session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            // $_SESSION['role_id'] = $user['role_id'];
        } else {
            echo "false";
        }
    } else {
        echo "false";
    }

    $stmt->close();
    $conn->close();
}
?>
