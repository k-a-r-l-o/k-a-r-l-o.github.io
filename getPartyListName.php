<?php
include "DBSession.php";

// Retrieve the prty_ID from the request
$prty_ID = isset($_GET['prty_ID']) ? intval($_GET['prty_ID']) : 0;

// Query to retrieve the name_partylist corresponding to the prty_ID
$stmt = $conn->prepare("SELECT name_partylist FROM list_partylist WHERE prty_ID = ?");
$stmt->bind_param("i", $prty_ID);
$stmt->execute();
$result = $stmt->get_result();

$response = array();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['success'] = true;
    $response['name_partylist'] = $row['name_partylist'];
} else {
    $response['success'] = false;
    $response['message'] = 'Party list not found';
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
