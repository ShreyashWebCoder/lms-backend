<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(array("status" => "error", "message" => "Invalid Request"));
    exit;
}

if (!isset($_POST['updatedTransactionData'])) {
    echo json_encode(array("status" => "error", "data" => "No data received"));
    exit;
}
$actionAll = $_POST['actionAll'];
if (empty($actionAll)) {
    echo json_encode(array("status" => "error", "message" => "No valid data received"));
    exit;
}
echo "<pre>";
print_r($actionAll);
echo "</pre>";

$data = json_decode($_POST['updatedTransactionData'], true);

if (!is_array($data)) {
    echo json_encode(array("status" => "error", "message" => "Recieved data is not of valid type"));
    exit;
}
try {
    $conn->begin_transaction();
    $stmt = $conn->prepare("INSERT INTO transaction (CustName, IsActive, Status, TR, TallyStatus, amount,
    bankBalance, bankMode, bankName, bankReceived, blockName, cashBalance, cashReceived, cheqNo,
    date, paymentType, plotno, projectName, remarks, statusDate, totalBalance,
    totalReceived, transactionStatus) 
    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "sisssssssssssssssssssss",
        $CustName,
        $IsActive,
        $Status,
        $TR,
        $TallyStatus,
        $amount,
        $bankBalance,
        $bankMode,
        $bankName,
        $bankReceived,
        $blockName,
        $cashBalance,
        $cashReceived,
        $cheqNo,
        $date,
        $paymentType,
        $plotno,
        $projectName,
        $remarks,
        $statusDate,
        $totalBalance,
        $totalReceived,
        $transactionStatus
    );

    // Insert records
    foreach ($data as $item) {
        if (empty($item['action'])) {
            // echo "<pre>";
            // print_r($item);
            // echo "</pre>";
            $CustName = $item['CustName'];
            $IsActive = $item['IsActive'];
            $Status = $item['Status'];
            $TR = $_POST['TRAll'];
            $TallyStatus = $item['TallyStatus'];
            $amount = $item['amount'];
            // $action = $item['action'];
            $bankBalance = $item['bankBalance'];
            $bankMode = $item['bankMode'];
            $bankName = $item['bankName'];
            $bankReceived = $item['bankReceived'];
            $blockName = $item['blockName'];
            $cashBalance = $item['cashBalance'];
            $cashReceived = $item['cashReceived'];
            $cheqNo = $item['cheqNo'];
            $date = $item['date'];
            $paymentType = $item['paymentType'];
            $plotno = $item['plotno'];
            $projectName = $item['projectName'];
            $remarks = $item['remarks'];
            $statusDate = $item['statusDate'];
            $totalBalance = $item['totalBalance'];
            $totalReceived = $item['totalReceived'];
            $transactionStatus = $item['transactionStatus'];

            //Query to insert the updated transaction


            if (!$stmt->execute()) {
                $conn->rollback();
                echo json_encode(array("status" => "error", "message" => "Execute failed: " . $stmt->error));
                // $success = false;
                exit;
            }
        }
    }
    $stmt->close();
    $updateStmt = $conn->prepare("UPDATE transaction SET action = ? WHERE id = ?");

    if ($updateStmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    // echo "<pre>";
    // print_r($actionAll);
    // echo "</pre>";

    $updateStmt->bind_param("si", $actionAll, $id);

    // Update records
    foreach ($data as $item) {
        if (empty($item['action'])) {
            $id = $item['id'];
            if (!empty($id)) {
                if (!$updateStmt->execute()) {
                    throw new Exception("Update failed: " . $updateStmt->error);
                }
            }
        }
    }

    $conn->commit();
    $updateStmt->close();
    $conn->close();
    echo json_encode(array("status" => "success", "message" => "All transactions are transferred"));
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(array("status" => "error", "message" => $e->getMessage()));
    exit;
}
