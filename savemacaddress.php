<?php
require_once 'config.php'; // Include your database connection configuration

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

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
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if macAddress is set in the POST request
    if (isset($_POST['macAddress'])) {
        $macAddress = $_POST['macAddress']; // Fetch the MAC address from the POST data


        if (in_array($macAddress, $macAddresses)) {
            echo json_encode(['status' => 'error', 'message' => 'Mac Address already present in Databse...']);
        } else {
            // Prepare an SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO macAddress (macAddress) VALUES (?)");
            $stmt->bind_param("s", $macAddress); // Bind the MAC address as a string

            // Execute the statement and check for errors
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'MAC address saved successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error saving MAC address: ' . $stmt->error]);
            }

            // Close the statement
            $stmt->close();
        }


    } else {
        echo json_encode(['status' => 'error', 'message' => 'MAC address is missing']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close the connection
$conn->close();
?>