<?php

// Establishing a connection to the database
DD

// Retrieve selected council from the form
$selected_council = $_GET['council'];

// Query to fetch positions based on the selected council
$sql = "SELECT council_name, position_name FROM positions WHERE council_name = '$selected_council'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output options for the position select menu
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['position_name'] . "'>" . $row['position_name'] . "</option>";
    }
} else {
    echo "<option value=''>No Positions Available.</option>";
}


// Close database connection if needed
$conn->close();
?>
