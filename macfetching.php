<?php
// Use shell_exec to run the getmac command and capture the output
$output = shell_exec('getmac');

// Use a regular expression to find the MAC address (format: xx-xx-xx-xx-xx-xx or xx:xx:xx:xx:xx:xx)
preg_match('/([a-fA-F0-9]{2}[-:]){5}[a-fA-F0-9]{2}/', $output, $matches);

// Prepare the response data
if (isset($matches[0])) {
    $response = [
        'status' => 'success',
        'macAddress' => $matches[0],
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'MAC Address not found',
    ];
}

// Set the content type to JSON and send the response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');  // Ensure CORS is allowed
echo json_encode($response);
exit();  // Ensure no additional output is sent
?>
