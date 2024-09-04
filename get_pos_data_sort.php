<?php

// Establishing a connection to the database
$servername = "localhost"; // Replace with your server name
$username = "u753706103_uvote"; // Replace with your username
$password = "UV+;!!c#~p1"; // Replace with your password
$dbname = "u753706103_Voting_System"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve selected council from the form
$selected_council = $_GET['council'];

if ($selected_council == '') {
    echo "<option value=''>All Positions </option>";
    // Query to fetch positions based on the selected council
    $sql = "SELECT DISTINCT(position_name) FROM positions";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output options for the position select menu
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['position_name'] . "'>" . $row['position_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No Positions Available</option>";
    }
} else {
    echo "<option value=''>All Positions </option>";
    // Query to fetch positions based on the selected council
    $sql = "SELECT council_name, position_name FROM positions WHERE council_name = '$selected_council'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output options for the position select menu
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['position_name'] . "'>" . $row['position_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No Positions Available</option>";
    }
}



// Close database connection if needed
$conn->close();
