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
    $stmt = $conn->prepare("UPDATE users SET last_heartbeat = NOW(), logged_out = 0 WHERE usep_ID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// Check for users who haven't sent a heartbeat in the last 5 minutes
$timeout = 300; // 5 minutes in seconds

// Update users to Offline where heartbeat hasn't been sent in the last 5 minutes and they are not logged out
$stmtOffline = $conn->prepare("UPDATE users SET User_status = 'Offline' WHERE last_heartbeat < NOW() - INTERVAL ? SECOND AND logged_out = 0");
$stmtOffline->bind_param("i", $timeout);
$stmtOffline->execute();
$stmtOffline->close();

// Update users to Active where heartbeat has been sent in the last 5 minutes and they are not logged out
$stmtActive = $conn->prepare("UPDATE users SET User_status = 'Active' WHERE last_heartbeat >= NOW() - INTERVAL ? SECOND AND logged_out = 0");
$stmtActive->bind_param("i", $timeout);
$stmtActive->execute();
$stmtActive->close();

// Check if session variables are set
if (!isset($_SESSION['username']) || !isset($_SESSION['usertype']) || !isset($_SESSION['usep_ID'])) {
    // If session variables are not set, redirect to the login page
    header("Location: indexWatcher.php");
    exit();
}

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Update user status to 'Offline' and set logged_out to 1
    $sqlUserEdit = "UPDATE users SET User_status = 'Offline', logged_out = 1 WHERE usep_ID = ?";
    $stmtUpdate = $conn->prepare($sqlUserEdit);
    $stmtUpdate->bind_param("i", $_SESSION['usep_ID']);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    // Log the login activity
    $usepID = $_SESSION["usep_ID"];
    $logAction = 'Logged out';
    $sqlInsertLog = "INSERT INTO Activity_Logs (usep_ID, logs_date, logs_time, logs_action) VALUES (?, CURRENT_DATE, CURRENT_TIME, ?)";
    $stmt = $conn->prepare($sqlInsertLog);
    if ($stmt) {
        $stmt->bind_param("is", $usepID, $logAction);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page
    header("Location: indexWatcher.php");
    exit();
}
?>
