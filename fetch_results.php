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

// Get the selected council from the URL parameters
$council = $_POST['council'];

// Prepare the SQL query based on the selected council using prepared statements
$stmtPositions = $conn->prepare("
    SELECT p.position_name, p.position_slot, p.council_name 
    FROM positions p 
    WHERE p.council_id = ?");
$stmtPositions->bind_param("i", $council);
$stmtPositions->execute();
$resultPositions = $stmtPositions->get_result();

$positions = [];
$council_name = ''; // Initialize council_name variable
while ($row = $resultPositions->fetch_assoc()) {
    $positions[] = $row;
    $council_name = $row['council_name']; // Get council_name from the result
}

$council_name_lower = strtolower($council_name);
$votes_table = $council_name_lower . '_votes';

$subqueries = [];
$orderCases = [];
$counter = 1;

foreach ($positions as $position) {
    $position_name = $position['position_name'];
    $position_slot = $position['position_slot'];
    $formattedPosition = str_replace(' ', '_', $position_name);

    if ($position_slot > 1) {
        for ($i = 1; $i <= $position_slot; $i++) {
            $column = $council_name_lower . '_' . $formattedPosition . $i;
            $subqueries[] = "
                SELECT CONCAT(c.FName, ' ', c.LName) AS Pname, '$position_name' AS position, COUNT(tv.$column) AS votes 
                FROM $votes_table tv
                INNER JOIN candidates c ON tv.$column = c.usep_ID
                GROUP BY tv.$column";
        }
    } else {
        $column = $council_name_lower . '_' . $formattedPosition;
        $subqueries[] = "
            SELECT CONCAT(c.FName, ' ', c.LName) AS Pname, '$position_name' AS position, COUNT(tv.$column) AS votes 
            FROM $votes_table tv
            INNER JOIN candidates c ON tv.$column = c.usep_ID
            GROUP BY tv.$column";
    }

    $orderCases[] = "WHEN subquery.position = '$position_name' THEN $counter";
    $counter++;
}

$sql = "SELECT subquery.Pname, subquery.position, SUM(subquery.votes) AS votes 
    FROM (" . implode(" UNION ALL ", $subqueries) . ") AS subquery
    GROUP BY subquery.Pname, subquery.position
    ORDER BY 
        CASE 
            " . implode(" ", $orderCases) . " 
            ELSE $counter 
        END,
        votes DESC, 
        Pname ASC";

$result = $conn->query($sql);

// Start building the table rows
$output = "
<div class='tablecontainer'>
    <tr class='trheader'>
        <th class='thfirst'>NAME</th>
        <th>POSITION</th>
        <th class='thlast'>NO. OF VOTES</th>
    </tr>
</div>";

$allData = [];
// Fetch the results and build the table rows
while ($row = $result->fetch_assoc()) {
    $allData[] = $row;
    $output .= "
    <tr>
        <td class='tdfirst'>" . htmlspecialchars($row['Pname']) . "</td>
        <td>" . htmlspecialchars($row['position']) . "</td>
        <td class='tdlast'>" . htmlspecialchars($row['votes']) . "</td>
    </tr>";
}

// Close the connection
$conn->close();

// Output the table rows
$response = [
    'output' => $output,
    'allData' => $allData
];

// Output the JSON encoded response
echo json_encode($response);
