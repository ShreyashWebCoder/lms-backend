<?php
session_start();  // Start the session
require_once 'config.php';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        $otpEmail = $user['otpEmail'];

        // Store otpEmail in the session
        $_SESSION['otpEmail'] = $otpEmail;

        echo json_encode(['otp' => $otpEmail]);
    } else {
        echo json_encode(['error' => false]);
    }

    $stmt->close();
    $conn->close();
}
?>
