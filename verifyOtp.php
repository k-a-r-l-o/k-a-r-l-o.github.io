<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection details
$servername = "localhost";
$username = "u753706103_uvote";
$password = "UV+;!!c#~p1";
$dbname = "u753706103_Voting_System";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set response header to JSON
header('Content-Type: application/json');

// Decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

// Ensure usep_ID is set in session
if (!isset($_SESSION["usep_ID"])) {
    echo json_encode(['success' => false, 'message' => 'Session expired.']);
    exit;
}

$enteredOtp = $data['otp'];
$usep_ID = $_SESSION["usep_ID"];

// Fetch the correct OTP from the database
$correctOtp = '';
$stmt = $conn->prepare("SELECT VPassword FROM voters WHERE usep_ID = ?");
if ($stmt) {
    $stmt->bind_param("i", $usep_ID);
    $stmt->execute();
    $stmt->bind_result($correctOtp);
    $stmt->fetch();
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: Unable to prepare statement.']);
    exit;
}

// Check if the entered OTP matches the correct OTP
$response = array();
if ($enteredOtp === $correctOtp) {
    $stmt = $conn->prepare("UPDATE voters SET VPassword = NULL WHERE usep_ID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $usep_ID);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $_SESSION["otp"] = $correctOtp;
        } else {
            $response['success'] = false;
            $response['message'] = 'No rows updated. Please check the usep_ID.';
        }
        $stmt->close();
    } else {
        $response['success'] = false;
        $response['message'] = 'Database error: Unable to prepare statement.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid OTP.';
}

echo json_encode($response);

// Close the database connection
$conn->close();
