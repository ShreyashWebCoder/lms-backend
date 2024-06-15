<?php
require_once 'config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if POST variables are set
    if (isset($_POST['id'], $_POST['projectName'], $_POST['blockName'], $_POST['areaSqft'], $_POST['areaSqmt'], $_POST['ratePerSqft'])) {
        // Get the block ID from the POST data
        $blockId = $_POST['id'];

        // Get other updated data from the POST data
        $projectName = $_POST['projectName'];
        $blockName = $_POST['blockName'];
        $areaSqft = $_POST['areaSqft'];
        $areaSqmt = $_POST['areaSqmt'];
        $ratePerSqft = $_POST['ratePerSqft'];

        // Check if the block with the given ID exists
        $stmt = $conn->prepare("SELECT * FROM block WHERE id = ?");
        $stmt->bind_param("i", $blockId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the database with the new data
            try {
                $stmt = $conn->prepare("UPDATE block SET
                    projectName = ?,
                    blockName = ?,
                    areaSqft = ?,
                    areaSqmt = ?,
                    ratePerSqft = ?
                    WHERE id = ?");

                $stmt->bind_param('ssdddi', $projectName, $blockName, $areaSqft, $areaSqmt, $ratePerSqft, $blockId);
                $stmt->execute();

                // Respond with success
                echo json_encode(['status' => 'success']);
            } catch (PDOException $e) {
                // Handle database errors
                // Respond with error
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            // Respond with error - block not found
            echo json_encode(['status' => 'error', 'message' => 'Block not found']);
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
