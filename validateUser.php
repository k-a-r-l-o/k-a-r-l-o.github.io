<?php
// Define valid credentials
$validUsername = 'admin@example.com';
$validPassword = 'password123';

// Retrieve form data
$username = $_GET['username'];
$password = $_GET['password'];

// Check if credentials match
if ($username === $validUsername && $password === $validPassword) {
    // Credentials are valid, redirect to the dashboard page
    header('Location: Dashboard.html');
    exit(); // Ensure script stops executing after redirection
} else {
    // Credentials are invalid, display error message
    echo '<script>alert("Invalid username or password. Please try again.");</script>';
    header('Location: Dashboard.html');
    exit();
}
?>
