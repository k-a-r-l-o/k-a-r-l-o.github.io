<?php
// Assuming $conn is your database connection

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the candidate ID from the AJAX request
    $presidentCandidate = isset($_POST['PresidentCandidate']) ? $_POST['PresidentCandidate'] : null;

    // Validate and sanitize the data before insertion
    // For example, you can use mysqli_real_escape_string or prepared statements for security

    // Perform the database insertion
    $sqlInsertVote = "INSERT INTO TSC_VOTES (usep_ID, President) VALUES (?, ?)";
    $stmt = $conn->prepare($sqlInsertVote);
    $stmt->bind_param("ss", $usep_ID, $presidentCandidate); // Assuming $usep_ID is the ID of the voter
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
