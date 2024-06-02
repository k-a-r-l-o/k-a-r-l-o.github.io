<?php
// Assuming $conn is your database connection

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
    $sqlInsertVote = "INSERT INTO TSC_VOTES (usep_ID, President, Vice_President_Internal_Affairs, Vice_President_External_Affairs, General_Secretary, General_Treasurer, General_Auditor, Public_Information_Officer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlInsertVote);
    $stmt->bind_param("ssssssss", $usep_ID, $president, $vpInternal, $vpExternal, $secretary, $treasurer, $auditor, $pio); // Assuming $usep_ID is the ID of the voter
    $usep_ID = ""; // Set the voter's ID here
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo "Vote saved successfully.";
    } else {
        echo "Error saving vote: " . $conn->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle cases where the request method is not POST
    echo "Invalid request method.";
}
?>
