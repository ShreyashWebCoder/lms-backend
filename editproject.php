<?php
require_once 'config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if POST variables are set
    if (isset($_POST['id'], $_POST['projectName'], $_POST['location'], $_POST['city'], $_POST['state'], $_POST['projectType'], $_POST['totalLandArea'], $_POST['totalSalableArea'])) {
        // Get the project ID from the POST data
        $projectId = $_POST['id'];

        // Get other updated data from the POST data
        $projectName = $_POST['projectName'];
        $location = $_POST['location'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $projectType = $_POST['projectType'];
        $totalLandArea = $_POST['totalLandArea'];
        $totalSalableArea = $_POST['totalSalableArea'];

        // Check if the project with the given ID exists
        $stmt = $conn->prepare("SELECT * FROM project WHERE id = ?");
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the database with the new data
            try {
                $stmt = $conn->prepare("UPDATE project SET
                    projectName = ?,
                    location = ?,
                    city = ?,
                    state = ?,
                    projectType = ?,
                    totalLandArea = ?,
                    totalSalableArea = ?
                    WHERE id = ?");

                $stmt->bind_param('sssssdid', $projectName, $location, $city, $state, $projectType, $totalLandArea, $totalSalableArea, $projectId);
                $stmt->execute();

                // Respond with success
                echo json_encode(['status' => 'success']);
            } catch (PDOException $e) {
                // Handle database errors
                // Respond with error
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            // Respond with error - project not found
            echo json_encode(['status' => 'error', 'message' => 'Project not found']);
        }
    } else {
        // Respond with error - missing POST variables
        echo json_encode(['status' => 'error', 'message' => 'Missing POST variables']);
    }
} else {
    // Respond with an error if not a POST request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
