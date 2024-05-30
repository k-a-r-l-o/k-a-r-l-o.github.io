<?php
// Establishing a connection to the database
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "Voting_System"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set session timeout to 30 minutes (1800 seconds)
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();

// If user is logged in, update last heartbeat
if (isset($_SESSION['usep_ID'])) {
    $userId = $_SESSION['usep_ID'];
    $stmt = $conn->prepare("UPDATE users SET last_heartbeat = NOW() WHERE 
    usep_ID  = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// Check for users who haven't sent a heartbeat in the last 10 minutes
$timeout = 600; // 10 minutes in seconds
$stmt = $conn->prepare("UPDATE users SET User_status = 'Offline' WHERE last_heartbeat < NOW() - INTERVAL ? SECOND");
$stmt->bind_param("i", $timeout);
$stmt->execute();
$stmt->close();

// Check if session variables are set
if (!isset($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    // If session variables are not set, redirect to the login page
    header("Location: indexAdmin.php");
    exit();
}

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Update user status to 'Offline'
    $sqlUserEdit = "UPDATE users SET User_status = 'Offline' WHERE usep_ID = ?";
    $stmtUpdate = $conn->prepare($sqlUserEdit);
    $stmtUpdate->bind_param("i", $_SESSION['usep_ID']);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page
    header("Location: indexAdmin.php");
    exit();
}
?>

