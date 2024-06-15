<?php
require_once 'config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is to add a new booking
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Retrieve form data
        $projectName = $_POST['projectName'] ?? '';
        $blockName = $_POST['blockName'] ?? '';
        $plotNo = $_POST['plotNo'] ?? '';
        $plotType = $_POST['plotType'] ?? '';
        $customerName = $_POST['customerName'] ?? '';
        $customerAddress = $_POST['customerAddress'] ?? '';
        $customerContact = $_POST['customerContact'] ?? '';
        $registryGender = $_POST['registryGender'] ?? '';
        $areaSqft = $_POST['areaSqft'] ?? '';
        $rateAreaSqft = $_POST['rateArearSqft'] ?? '';
        $totalAmount = $_POST['totalAmount'] ?? '';
        $discountApplicable = $_POST['discountApplicable'] ?? '';
        $discountPercent = $_POST['discountPercent'] ?? '';
        $netAmount = $_POST['netAmount'] ?? '';
        $registryAmount = $_POST['registryAmount'] ?? '';
        $serviceAmount = $_POST['serviceAmount'] ?? '';
        $maintenanceAmount = $_POST['maintenanceAmount'] ?? '';
        $miscAmount = $_POST['miscAmount'] ?? '';
        $grandTotal = $_POST['grandTotal'] ?? '';
        $constructionApplicable = $_POST['constructionApplicable'] ?? '';
        $constructionContractor = $_POST['constructionContractor'] ?? '';
        $totalAmountPayable = $_POST['totalAmountPayable'] ?? '';
        $guidelineAmount = $_POST['guidelineAmount'] ?? '';
        $registryPercent = $_POST['registryPercent'] ?? '';
        $bankAmountPayable = $_POST['bankAmountPayable'] ?? '';
        $cashAmountPayable = $_POST['cashAmountPayable'] ?? '';
        $bookingDate = $_POST['bookingDate'] ?? '';
        $constructionAmount = $_POST['constructionAmount'] ?? '';
        $remarks = $_POST['remarks'] ?? '';

        // Prepare the SQL statement
        $sql = "INSERT INTO booking (`id`, `projectName`, `blockName`, `plotNo`, `plotType`, `customerName`, `customerAddress`, `customerContact`, `registryGender`, `areaSqft`, `rateAreaSqft`, `totalAmount`, `discountApplicable`, `discountPercent`, `netAmount`, `registryAmount`, `serviceAmount`, `maintenanceAmount`, `miscAmount`, `grandTotal`, `constructionApplicable`, `constructionContractor`, `constructionAmount`, `totalAmountPayable`, `guidelineAmount`, `registryPercent`, `bankAmountPayable`, `cashAmountPayable`, `bookingDate`, `remarks`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error in SQL statement preparation: " . $conn->error);
        }

        // Bind parameters
      $stmt->bind_param("ssssssssssssssssssssssss", $projectName, $blockName, $plotNo, $plotType, $customerName, $customerAddress, $customerContact, $registryGender, $areaSqft, $rateAreaSqft, $totalAmount, $discountApplicable, $discountPercent, $netAmount, $registryAmount, $serviceAmount, $maintenanceAmount, $miscAmount, $grandTotal, $constructionApplicable, $constructionContractor, $constructionAmount, $totalAmountPayable, $guidelineAmount, $registryPercent, $bankAmountPayable, $bookingDate, $cashAmountPayable, $remarks);


        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Error in SQL statement execution: " . $stmt->error);
        }

        echo json_encode(["message" => "Booking added successfully"]);

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

// Close connection
$conn->close();
?>