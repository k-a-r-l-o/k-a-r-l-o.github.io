<?php
// Include your database connection file
include('DBSession.php');

// Initialize the base SQL query
$sql = "SELECT * FROM candidates WHERE 1=1";

// Apply filters based on the POST parameters
if (!empty($_POST['Tprogram'])) {
    $sql .= " AND Program = '" . $conn->real_escape_string($_POST['Tprogram']) . "'";
}
if (!empty($_POST['Tcouncil'])) {
    $sql .= " AND council = '" . $conn->real_escape_string($_POST['Tcouncil']) . "'";
}
if (!empty($_POST['Tposition'])) {
    $sql .= " AND position = '" . $conn->real_escape_string($_POST['Tposition']) . "'";
}

// Execute the query
$result = $conn->query($sql);

echo '<tr class="trheader">';
echo '<th class="thfirst">USEP ID</th>';
echo '<th>NAME</th>';
echo '<th>POSITION</th>';
echo '<th>COUNCIL</th>';
echo '<th class="thlast">NO. OF VOTER: ' . $result->num_rows . ' </th>';
echo '</tr>';

// Check if there are any rows returned
if ($result->num_rows > 1) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {

        // Assuming $row["usep_ID"] contains the ID like 202200294
        $usep_ID = $row["usep_ID"];

        // Skip displaying the entry with usep_ID equal to 100010001
        if ($usep_ID == '100010001') {
            continue;
        }

        // Extract the year part
        $year = substr($usep_ID, 0, 4);

        // Extract the remaining part and zero-pad it to 5 digits
        $numeric_part = str_pad(substr($usep_ID, 4), 5, "0", STR_PAD_LEFT);

        // Combine the parts with a dash
        $formatted_usep_ID = $year . '-' . $numeric_part;
?>
        <tr>
            <td class="tdfirst"><?php echo $formatted_usep_ID; ?></td>
            <td><?php echo $row["FName"] . " " . $row["LName"]; ?></td>
            <td><?php echo $row["position"]; ?></td>
            <td><?php echo $row["council"]; ?></td>
            <td class="tdlast">
                <img onclick="viewpop(<?php echo $row['usep_ID']; ?>)" src="view.png" alt="view icon">
                <img onclick="editpop('<?php echo $row['usep_ID']; ?>','<?php echo $row['council']; ?>')" src="edit.png" alt="edit icon">
                <img onclick="deletepop(<?php echo $row['usep_ID']; ?>)" src="delete.png" alt="delete icon">
            </td>
        </tr>
<?php
    }
} else {
    echo "<tr><td class='tdfirst'></td><td colspan='3'>No candidates found.</td><td class='tdlast'></td></tr>";
}

?>