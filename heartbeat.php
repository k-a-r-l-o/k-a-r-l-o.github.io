<?php
include 'DBSession.php';

if (isset($_SESSION['usep_ID'])) {
    $userId = $_SESSION['usep_ID'];
    $stmt = $conn->prepare("UPDATE users SET last_heartbeat = NOW() WHERE usep_ID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}
?>
