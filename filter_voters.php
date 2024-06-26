<?php
include "DBSession.php";

// Get the status from the POST request
$status = $_POST['status'];

// Build the SQL query based on the selected status
if ($status == 'VOTED') {
    $sql = "SELECT * FROM voters WHERE voted = 'Voted'";
} else if ($status == 'NOT') {
    $sql = "SELECT * FROM voters WHERE voted = 'Not Voted'";
} else {
    $sql = "SELECT * FROM voters";
}
echo '<tr class="trheader">';
echo '<th class="thfirst">USEP ID</th>';
echo ' <th>NAME</th>';
echo '<th>YEAR LEVEL</th>';
echo '<th>PROGRAM</th>';
echo '<th class="thlast"></th>';
echo '</tr>';

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usep_ID = $row["usep_ID"];
        $year = substr($usep_ID, 0, 4);
        $numeric_part = str_pad(substr($usep_ID, 4), 5, "0", STR_PAD_LEFT);
        $formatted_usep_ID = $year . '-' . $numeric_part;
        echo '<tr>';
        echo '<td class="tdfirst">' . $formatted_usep_ID . '</td>';
        echo '<td>' . $row["FName"] . ' ' . $row["LName"] . '</td>';
        echo '<td>' . $row["yearLvl"] . '</td>';
        echo '<td>' . $row["program"] . '</td>';
        echo '<td class="tdlast">';
        echo '<img onclick="viewpop(' . $row['usep_ID'] . ')" src="view.png" alt="view icon">';
        echo '<img onclick="editpop(' . $row['usep_ID'] . ')" src="edit.png" alt="edit icon">';
        echo '<img onclick="deletepop(' . $row['usep_ID'] . ')" src="delete.png" alt="delete icon">';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr>';
    echo '<td class="tdfirst"></td>';
    echo '<td colspan="3">No Voters found.</td>';
    echo '<td class="tdlast"></td>';
    echo '</tr>';
}

$conn->close();
