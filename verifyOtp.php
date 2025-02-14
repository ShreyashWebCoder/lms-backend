<?php
session_start();
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");  // Adjust the origin as necessary
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");  // Allow POST, GET, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Authorization");  // Allow headers you need
header("Content-Type: application/json");  // Set content type as JSON

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);  // No content for OPTIONS request
    exit;
}


//$otp = $_SESSION["otp"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $enterOtp = $data['enterOtp'];
    $otp = $data['otp'];

    if ($otp === $enterOtp) {
        echo json_encode(['success' => true, 'message' => 'OTP verified successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
    }
}
?>
