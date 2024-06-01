<?php
header('Content-Type: application/json');
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


$council = $_POST['council'];
$results = [];

if ($council == 'TSC') {
    $results = fetchCouncilTSCVotes($conn, 'TSC_VOTES');
} elseif ($council == 'SABES') {
    $results = fetchCouncilVotes($conn, 'SABES_VOTES');
} elseif ($council == 'OFEE') {
    $results = fetchCouncilVotes($conn, 'OFEE_VOTES');
} elseif ($council == 'AECES') {
    $results = fetchCouncilVotes($conn, 'AECES_VOTES');
} elseif ($council == 'OFSET') {
    $results = fetchCouncilVotes($conn, 'OFSET_VOTES');
} elseif ($council == 'AFSET') {
    $results = fetchCouncilVotes($conn, 'AFSET_VOTES');
} elseif ($council == 'SITS') {
    $results = fetchCouncilVotes($conn, 'SITS_VOTES');
} elseif ($council == 'FTVETTS') {
    $results = fetchCouncilVotes($conn, 'FTVETTS_VOTES');
}

echo json_encode($results);



function fetchCouncilTSCVotes($conn, $table)
{
    $results = [];

    $sql = "
    SELECT 'President' AS position, President AS candidate, COUNT(*) AS vote_count FROM $table GROUP BY President
    UNION ALL
    SELECT 'Vice_President_Internal_Affairs', Vice_President_Internal_Affairs, COUNT(*) FROM $table GROUP BY Vice_President_Internal_Affairs
    UNION ALL
    SELECT 'Vice_President_External_Affairs', Vice_President_External_Affairs, COUNT(*) FROM $table GROUP BY Vice_President_External_Affairs
    UNION ALL
    SELECT 'General_Secretary', General_Secretary, COUNT(*) FROM $table GROUP BY General_Secretary
    UNION ALL
    SELECT 'General_Treasurer', General_Treasurer, COUNT(*) FROM $table GROUP BY General_Treasurer
    UNION ALL
    SELECT 'General_Auditor', General_Auditor, COUNT(*) FROM $table GROUP BY General_Auditor
    UNION ALL
    SELECT 'Public_Information_Officer', Public_Information_Officer, COUNT(*) FROM $table GROUP BY Public_Information_Officer
  ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }

    return $results;
}


function fetchCouncilVotes($conn, $table)
{
    $results = [];

    $sql = "
      SELECT 'LC_Governor' AS position, LC_Governor AS candidate, COUNT(*) AS vote_count FROM $table GROUP BY LC_Governor
      UNION ALL
      SELECT 'Vice_Governor_Internal_Affairs', Vice_Governor AS candidate, COUNT(*) FROM $table GROUP BY Vice_Governor
      UNION ALL
      SELECT 'Secretary', Secretary, COUNT(*) FROM $table GROUP BY Secretary
      UNION ALL
      SELECT 'Treasurer', Treasurer, COUNT(*) FROM $table GROUP BY Treasurer
      UNION ALL
      SELECT 'Senator1', Senator1, COUNT(*) FROM $table GROUP BY Senator1
      UNION ALL
      SELECT 'Senator2', Senator2, COUNT(*) FROM $table GROUP BY Senator2
      UNION ALL
      SELECT 'Senator3', Senator3, COUNT(*) FROM $table GROUP BY Senator3
      UNION ALL
      SELECT 'Auditor', Auditor, COUNT(*) FROM $table GROUP BY Auditor
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }

    return $results;
    $conn->close();
}
