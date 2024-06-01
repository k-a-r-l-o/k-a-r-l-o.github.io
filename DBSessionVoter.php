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

// Check if session variables are set
if (!isset($_SESSION['username']) && !isset($_SESSION['program']) && !isset($_SESSION['usep_ID'])) {
    // If any session variable is not set, redirect to the login page
    header("Location: index.php");
    exit();
}


?>