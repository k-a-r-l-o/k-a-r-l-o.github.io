<?php
include 'DBSession.php';

if (isset($_SESSION['usep_ID'])) {
    // Update user status to 'Offline'
    $sqlUserEdit = "UPDATE users SET status = 'Offline' WHERE usep_ID = ?";
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
