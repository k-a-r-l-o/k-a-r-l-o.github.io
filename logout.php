<?php
include 'DBSession.php';

if (isset($_SESSION['usep_ID'])) {
    // Update user status to 'Offline' and set logged_out to 1
    $sqlUserEdit = "UPDATE users SET User_status = 'Offline', logged_out = 1 WHERE usep_ID = ?";
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
