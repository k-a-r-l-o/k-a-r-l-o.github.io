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

$enteredOtp = $data['otp'];
$usep_ID = $_SESSION["usep_ID"]; // Assuming usep_ID is stored in session

// Fetch the correct OTP from the database
$correctOtp = '';
$stmt = $conn->prepare("SELECT VPassword FROM voters WHERE usep_ID = ?");
$stmt->bind_param("i", $usep_ID);
$stmt->execute();
$stmt->bind_result($correctOtp);
$stmt->fetch();
$stmt->close();

// Check if the entered OTP matches the correct OTP
$response = array();
if ($enteredOtp === $correctOtp) {
    $response['success'] = true;
    $_SESSION["otp"] = $correctOtp;
} else {
    $response['success'] = false;
}

echo json_encode($response);

// Close the database connection
$conn->close();
