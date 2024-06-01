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

// Retrieve selected council from the form
$selected_council = $_GET['council'];

// Query to fetch positions based on the selected council
$sql = "SELECT council_id, position_name FROM positions WHERE council_id = '$selected_council'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output options for the position select menu
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['position_name'] . "'>" . $row['position_name'] . "</option>";
    }
} else {
    echo "<option value=''>No positions available</option>";
}


// Close database connection if needed
$conn->close();
?>
