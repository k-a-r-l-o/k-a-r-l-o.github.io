<?php
include "DBSessionVoter.php";

$username = $_SESSION["username"];
$program = $_SESSION["program"];
$usep_ID = $_SESSION["usep_ID"];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve all candidate IDs from the AJAX request
    $president = isset($_POST['PresidentCandidate']) ? $_POST['PresidentCandidate'] : null;
    $vpInternal = isset($_POST['VicePresidentInternalCandidate']) ? $_POST['VicePresidentInternalCandidate'] : null;
    $vpExternal = isset($_POST['VicePresidentExternalCandidate']) ? $_POST['VicePresidentExternalCandidate'] : null;
    $secretary = isset($_POST['GeneralSecretaryCandidate']) ? $_POST['GeneralSecretaryCandidate'] : null;
    $treasurer = isset($_POST['GeneralTreasurerCandidate']) ? $_POST['GeneralTreasurerCandidate'] : null;
    $auditor = isset($_POST['GeneralAuditorCandidate']) ? $_POST['GeneralAuditorCandidate'] : null;
    $pio = isset($_POST['PublicInformationOfficerCandidate']) ? $_POST['PublicInformationOfficerCandidate'] : null;

    // Validate and sanitize the data before insertion
    // For example, you can use mysqli_real_escape_string or prepared statements for security

    // Perform the database insertion
    $sqlInsertVote = "INSERT INTO tsc_votes (usep_ID, President, Vice_President_Internal_Affairs, Vice_President_External_Affairs, General_Secretary, General_Treasurer, General_Auditor, Public_Information_Officer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlInsertVote);
    $stmt->bind_param("ssssssss", $usep_ID, $president, $vpInternal, $vpExternal, $secretary, $treasurer, $auditor, $pio);
    
    if ($stmt->execute()) {
        echo "Vote saved successfully.";
    } else {
        echo "Error saving vote: " . $conn->error;
    }

    // Close the statement and the database connection
    $stmt->close();

} else {
    // Handle cases where the request method is not POST
    echo "Invalid request method.";
}
?>
