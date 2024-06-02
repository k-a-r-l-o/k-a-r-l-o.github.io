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

$party_ID = $_GET['prtyID'];


$sql = "SELECT * FROM list_partylist WHERE prty_ID = $party_ID";
$result = $conn->query($sql);


if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(["error" => "No partylist found"]);
}

// Close statement and database connection
$conn->close();
?>
