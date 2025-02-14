<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "u990603908_lms");

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}
$qry = "SELECT * FROM `macaddress`";
$_result = mysqli_query($conn, $qry);


if ($_result) {
    $num = mysqli_num_rows($_result);
    if ($num > 0) {
        // Fetch the result as an associative array
        for($i=1;$i<=$num;$i++){
            $row = mysqli_fetch_assoc($_result);
            echo $row['macAddress'] ."<br>";
        }
    }
}

?>