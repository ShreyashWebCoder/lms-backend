<?php
// Retrieve the raw POST data from the request
// $data = file_get_contents("php://input");

// // Decode the JSON into a PHP array
// $permissions = json_decode($data, true);
// print_r($permissions);

// if ($permissions) {
//     // Example of processing the data:
//     // You can loop through the permissions array and save it to a database, file, etc.
    
//     foreach ($permissions as $action => $roles) {
//         $manager = $roles['manager'] ? 'Yes' : 'No';
//         $user = $roles['user'] ? 'Yes' : 'No';
        
//         // You could insert this data into a database or process it as needed
//         echo "Action: $action, Manager Permission: $manager, User Permission: $user\n";
//     }
    
//     // Return a success response (you can modify this based on your needs)
//     echo json_encode(["status" => "success", "message" => "Permissions saved successfully!"]);
    
// } else {
//     // Return an error response if something goes wrong
//     echo json_encode(["status" => "error", "message" => "Failed to save permissions."]);
// }
// savepermissions.php

// Get the raw POST data
$postData = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$permissions = json_decode($postData, true);

// Check if decoding was successful
if ($permissions === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

// Example: Access specific permissions
$addProjectManagerPermission = $permissions['addProject']['manager'];
$addProjectUserPermission = $permissions['addProject']['user'];

// Process the data (e.g., save to the database)
// This is just an example of how to use the permissions values
// You can iterate through the permissions array and handle them as needed

// Respond with a success message
echo json_encode(['status' => 'success', 'message' => 'Permissions saved successfully']);
?>


