<?php
require 'DBSession.php'; // Ensure you have the database connection setup

if (isset($_SESSION["usep_ID"]) && isset($_POST['council'])) {
    $usepID = $_SESSION["usep_ID"];
    $council = $_POST['council'];
    $logAction = 'Export Result for ' . $council;

    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $sqlInsertLog = "INSERT INTO activity_logs (usep_ID, logs_date, logs_time, logs_action) VALUES (?, ?, ?, ?)";
          

    if ($stmt) {
        $stmt->bind_param("is", $usepID, $logAction);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid session or input"]);
}
?>
