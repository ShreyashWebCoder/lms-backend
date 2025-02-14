<?php

session_start();  // Start the session
require_once __DIR__ . '/vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Allow cross-origin requests
header("Access-Control-Allow-Origin: https://lkgexcel.com:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle preflight (OPTIONS method)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['otpEmail'])) {
    $otpEmail = $input['otpEmail'];  // Retrieve otpEmail from the request body
}

// Generate a random 6-digit OTP
$otp = rand(100000, 999999);

$_SESSION["otp"]=$otp;
$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'akankshabawankure@gmail.com'; // Replace with your Gmail
    $mail->Password   = 'rayp mxtp nvwd nlrz';           // Replace with your App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    // Email settings
    $mail->setFrom('akankshabawankure@gmail.com', 'Akanksha Bawankure'); // Replace with your Gmail
    $mail->addAddress($otpEmail);                   // Replace with recipient's email
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = "Your OTP is: $otp. It is valid for 5 minutes.";

    // Attempt to send the email
    $mail->send();

    // Respond with success message
    echo json_encode([
        "success" => true,
        "otp"=>$otp,
        "message" => "OTP sent successfully."
    ]);
} catch (Exception $e) {
    // Respond with error message
    echo json_encode([
        "success" => false,
        "message" => "Failed to send OTP. Please try again.",
        "error" => $e->getMessage() // Include the error message for debugging purposes
    ]);
}

?>
