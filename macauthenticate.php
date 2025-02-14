<?php
require_once 'config.php'; // Include your database connection configuration


// Set the response header to return JSON
header('Content-Type: application/json');

// Get the raw POST data from the request body
$input = file_get_contents('php://input');

// Decode the JSON data to a PHP array
$data = json_decode($input, true);

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL query to retrieve all MAC addresses
$sql = "SELECT macAddress FROM macaddress";
$result = $conn->query($sql);



// Check if there are any results
if ($result->num_rows > 0) {
    // Create an array to hold all MAC addresses
    $macAddresses = [];

    // Fetch each row and push the MAC address to the array
    while ($row = $result->fetch_assoc()) {
        $macAddresses[] = $row['macAddress'];

    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No MAC addresses Found']);
}

// Check if the request method is POST

    // Check if macAddress is set in the POST request
    if (isset($data['macAddress'])) {
        $macAddress = $data['macAddress'];

        //to check the $matches is present in array or not
        if (in_array($macAddress, $macAddresses)) {
            // Return the MAC addresses as a JSON response
            echo json_encode(['status' => 'success', 'message' => ' MAC addresses valid']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No MAC addresses not valid']);
        }
    }else {
        echo json_encode(['status' => 'error', 'message' => 'MAC address is missing']);
    }





// Close the connection
$conn->close();
?>