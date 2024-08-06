<?php
if (!isset($_SESSION['otp'])) {
    // If any session variable is not set, redirect to the login page
    header("Location: index.php");
    exit();
}
