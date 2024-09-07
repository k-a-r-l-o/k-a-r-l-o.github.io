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
                SELECT c.usep_ID AS UID, c.candPic AS pic, CONCAT(c.FName, ' ', c.LName) AS Pname, '$position_name' AS position, COALESCE(COUNT(tv.$column), 0) AS votes 
                FROM candidates c
                LEFT JOIN $votes_table tv ON tv.$column = c.usep_ID
                WHERE (c.position = '$position_name' OR c.LName = 'Abstain') AND (c.council = '$council_name' OR c.council = 'ALL')
                GROUP BY c.usep_ID, c.candPic, c.FName, c.LName, c.position";
        }
    } else {
        $column = $council_name_lower . '_' . $formattedPosition;
        $subqueries[] = "
            SELECT c.usep_ID AS UID, c.candPic AS pic, CONCAT(c.FName, ' ', c.LName) AS Pname, '$position_name' AS position, COALESCE(COUNT(tv.$column), 0) AS votes 
            FROM candidates c
            LEFT JOIN $votes_table tv ON tv.$column = c.usep_ID
            WHERE (c.position = '$position_name' OR c.LName = 'Abstain') AND (c.council = '$council_name' OR c.council = 'ALL')
            GROUP BY c.usep_ID, c.candPic, c.FName, c.LName, c.position";
    }

    $orderCases[] = "WHEN subquery.position = '$position_name' THEN $counter";
    $counter++;
}

$sql = "SELECT subquery.UID, subquery.pic, subquery.Pname, subquery.position, SUM(subquery.votes) AS votes 
    FROM (" . implode(" UNION ALL ", $subqueries) . ") AS subquery
    GROUP BY subquery.UID, subquery.pic, subquery.Pname, subquery.position
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
        <th class='thfirst'>USeP ID</th>
        <th>IMAGE</th>
        <th>NAME</th>
        <th>POSITION</th>
        <th class='thlast'>NO. OF VOTES</th>
    </tr>
</div>";

$allData = [];
// Fetch the results and build the table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allData[] = $row;
        $pic = htmlspecialchars($row['pic'] ? $row['pic'] : 'uploads/default.png');
        $picPath = file_exists($pic) ? htmlspecialchars($pic) : 'uploads/default.png';
        $output .= "
    <tr>
        <td class='tdfirst'>" . htmlspecialchars($row['UID']) . "</td>
        <td><img class='candPic' src='$picPath' alt='Candidate Pic'></td>
        <td>" . htmlspecialchars($row['Pname']) . "</td>
        <td>" . htmlspecialchars($row['position']) . "</td>
        <td class='tdlast'>" . htmlspecialchars($row['votes']) . "</td>
    </tr>";
    }
} else {
    echo "<tr><td class='tdfirst'></td><td colspan='3'>No candidates yet.</td><td class='tdlast'></td></tr>";
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
