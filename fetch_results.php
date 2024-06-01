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

// Get the selected council from the URL parameters
$council = $_POST['council'];

// Prepare the SQL query based on the selected council
$sql = "";
switch ($council) {
    case 'TSC':
        $sql = "SELECT President AS Pname, 'President' AS position, COUNT(President) AS votes FROM TSC_VOTES GROUP BY President
                UNION ALL
                SELECT Vice_President_Internal_Affairs AS Pname, 'Vice President Internal Affairs' AS position, COUNT(Vice_President_Internal_Affairs) AS votes FROM TSC_VOTES GROUP BY Vice_President_Internal_Affairs
                UNION ALL
                SELECT Vice_President_External_Affairs AS Pname, 'Vice President External Affairs' AS position, COUNT(Vice_President_External_Affairs) AS votes FROM TSC_VOTES GROUP BY Vice_President_External_Affairs
                UNION ALL
                SELECT General_Secretary AS Pname, 'General Secretary' AS position, COUNT(General_Secretary) AS votes FROM TSC_VOTES GROUP BY General_Secretary
                UNION ALL
                SELECT General_Treasurer AS Pname, 'General Treasurer' AS position, COUNT(General_Treasurer) AS votes FROM TSC_VOTES GROUP BY General_Treasurer
                UNION ALL
                SELECT General_Auditor AS Pname, 'General Auditor' AS position, COUNT(General_Auditor) AS votes FROM TSC_VOTES GROUP BY General_Auditor
                UNION ALL
                SELECT Public_Information_Officer AS Pname, 'Public Information Officer' AS position, COUNT(Public_Information_Officer) AS votes FROM TSC_VOTES GROUP BY Public_Information_Officer";
        break;
    case 'SABES':
        $sql = "SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM SABES_VOTES GROUP BY LC_Governor
                UNION ALL
                SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM SABES_VOTES GROUP BY Vice_Governor
                UNION ALL
                SELECT Secretary AS name, 'Secretary' AS position, COUNT(Secretary) AS votes FROM SABES_VOTES GROUP BY Secretary
                UNION ALL
                SELECT Treasurer AS name, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM SABES_VOTES GROUP BY Treasurer
                UNION ALL
                SELECT Senator1 AS name, 'Senator1' AS position, COUNT(Senator1) AS votes FROM SABES_VOTES GROUP BY Senator1
                UNION ALL
                SELECT Senator2 AS name, 'Senator2' AS position, COUNT(Senator2) AS votes FROM SABES_VOTES GROUP BY Senator2
                UNION ALL
                SELECT Senator3 AS name, 'Senator3' AS position, COUNT(Senator3) AS votes FROM SABES_VOTES GROUP BY Senator3
                UNION ALL
                SELECT Auditor AS name, 'Auditor' AS position, COUNT(Auditor) AS votes FROM SABES_VOTES GROUP BY Auditor";
        break;
    case 'OFEE':
        $sql = "SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM OFEE_VOTES GROUP BY LC_Governor
                    UNION ALL
                    SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM OFEE_VOTES GROUP BY Vice_Governor
                    UNION ALL
                    SELECT Secretary AS name, 'Secretary' AS position, COUNT(Secretary) AS votes FROM OFEE_VOTES GROUP BY Secretary
                    UNION ALL
                    SELECT Treasurer AS name, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM OFEE_VOTES GROUP BY Treasurer
                    UNION ALL
                    SELECT Senator1 AS name, 'Senator1' AS position, COUNT(Senator1) AS votes FROM OFEE_VOTES GROUP BY Senator1
                    UNION ALL
                    SELECT Senator2 AS name, 'Senator2' AS position, COUNT(Senator2) AS votes FROM OFEE_VOTES GROUP BY Senator2
                    UNION ALL
                    SELECT Senator3 AS name, 'Senator3' AS position, COUNT(Senator3) AS votes FROM OFEE_VOTES GROUP BY Senator3
                    UNION ALL
                    SELECT Auditor AS name, 'Auditor' AS position, COUNT(Auditor) AS votes FROM OFEE_VOTES GROUP BY Auditor";
        break;
    case 'AECES':
        $sql = "SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM OFEE_VOTES GROUP BY LC_Governor
                        UNION ALL
                        SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM OFEE_VOTES GROUP BY Vice_Governor
                        UNION ALL
                        SELECT Secretary AS name, 'Secretary' AS position, COUNT(Secretary) AS votes FROM OFEE_VOTES GROUP BY Secretary
                        UNION ALL
                        SELECT Treasurer AS name, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM OFEE_VOTES GROUP BY Treasurer
                        UNION ALL
                        SELECT Senator1 AS name, 'Senator1' AS position, COUNT(Senator1) AS votes FROM OFEE_VOTES GROUP BY Senator1
                        UNION ALL
                        SELECT Senator2 AS name, 'Senator2' AS position, COUNT(Senator2) AS votes FROM OFEE_VOTES GROUP BY Senator2
                        UNION ALL
                        SELECT Senator3 AS name, 'Senator3' AS position, COUNT(Senator3) AS votes FROM OFEE_VOTES GROUP BY Senator3
                        UNION ALL
                        SELECT Auditor AS name, 'Auditor' AS position, COUNT(Auditor) AS votes FROM OFEE_VOTES GROUP BY Auditor";
        break;
    case 'OFSET':
        $sql = "SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM OFSET_VOTES GROUP BY LC_Governor
                            UNION ALL
                            SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM OFSET_VOTES GROUP BY Vice_Governor
                            UNION ALL
                            SELECT Secretary AS name, 'Secretary' AS position, COUNT(Secretary) AS votes FROM OFSET_VOTES GROUP BY Secretary
                            UNION ALL
                            SELECT Treasurer AS name, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM OFSET_VOTES GROUP BY Treasurer
                            UNION ALL
                            SELECT Senator1 AS name, 'Senator1' AS position, COUNT(Senator1) AS votes FROM OFSET_VOTES GROUP BY Senator1
                            UNION ALL
                            SELECT Senator2 AS name, 'Senator2' AS position, COUNT(Senator2) AS votes FROM OFSET_VOTES GROUP BY Senator2
                            UNION ALL
                            SELECT Senator3 AS name, 'Senator3' AS position, COUNT(Senator3) AS votes FROM OFSET_VOTES GROUP BY Senator3
                            UNION ALL
                            SELECT Auditor AS name, 'Auditor' AS position, COUNT(Auditor) AS votes FROM OFSET_VOTES GROUP BY Auditor";
        break;
    case 'AFSET':
        $sql = "SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM AFSET_VOTES GROUP BY LC_Governor
                                UNION ALL
                                SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM AFSET_VOTES GROUP BY Vice_Governor
                                UNION ALL
                                SELECT Secretary AS name, 'Secretary' AS position, COUNT(Secretary) AS votes FROM AFSET_VOTES GROUP BY Secretary
                                UNION ALL
                                SELECT Treasurer AS name, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM AFSET_VOTES GROUP BY Treasurer
                                UNION ALL
                                SELECT Senator1 AS name, 'Senator1' AS position, COUNT(Senator1) AS votes FROM AFSET_VOTES GROUP BY Senator1
                                UNION ALL
                                SELECT Senator2 AS name, 'Senator2' AS position, COUNT(Senator2) AS votes FROM AFSET_VOTES GROUP BY Senator2
                                UNION ALL
                                SELECT Senator3 AS name, 'Senator3' AS position, COUNT(Senator3) AS votes FROM AFSET_VOTES GROUP BY Senator3
                                UNION ALL
                                SELECT Auditor AS name, 'Auditor' AS position, COUNT(Auditor) AS votes FROM AFSET_VOTES GROUP BY Auditor";
        break;

    case 'SITS':
        $sql = "SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM SITS_VOTES GROUP BY LC_Governor
                                    UNION ALL
                                    SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM SITS_VOTES GROUP BY Vice_Governor
                                    UNION ALL
                                    SELECT Secretary AS name, 'Secretary' AS position, COUNT(Secretary) AS votes FROM SITS_VOTES GROUP BY Secretary
                                    UNION ALL
                                    SELECT Treasurer AS name, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM SITS_VOTES GROUP BY Treasurer
                                    UNION ALL
                                    SELECT Senator1 AS name, 'Senator1' AS position, COUNT(Senator1) AS votes FROM SITS_VOTES GROUP BY Senator1
                                    UNION ALL
                                    SELECT Senator2 AS name, 'Senator2' AS position, COUNT(Senator2) AS votes FROM SITS_VOTES GROUP BY Senator2
                                    UNION ALL
                                    SELECT Senator3 AS name, 'Senator3' AS position, COUNT(Senator3) AS votes FROM SITS_VOTES GROUP BY Senator3
                                    UNION ALL
                                    SELECT Auditor AS name, 'Auditor' AS position, COUNT(Auditor) AS votes FROM SITS_VOTES GROUP BY Auditor";
        break;

    case 'FTVETTS':
        $sql = "SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM FTVETTS_VOTES GROUP BY LC_Governor
                                        UNION ALL
                                        SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM FTVETTS_VOTES GROUP BY Vice_Governor
                                        UNION ALL
                                        SELECT Secretary AS name, 'Secretary' AS position, COUNT(Secretary) AS votes FROM FTVETTS_VOTES GROUP BY Secretary
                                        UNION ALL
                                        SELECT Treasurer AS name, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM FTVETTS_VOTES GROUP BY Treasurer
                                        UNION ALL
                                        SELECT Senator1 AS name, 'Senator1' AS position, COUNT(Senator1) AS votes FROM FTVETTS_VOTES GROUP BY Senator1
                                        UNION ALL
                                        SELECT Senator2 AS name, 'Senator2' AS position, COUNT(Senator2) AS votes FROM FTVETTS_VOTES GROUP BY Senator2
                                        UNION ALL
                                        SELECT Senator3 AS name, 'Senator3' AS position, COUNT(Senator3) AS votes FROM FTVETTS_VOTES GROUP BY Senator3
                                        UNION ALL
                                        SELECT Auditor AS name, 'Auditor' AS position, COUNT(Auditor) AS votes FROM FTVETTS_VOTES GROUP BY Auditor";
        break;
    default:
        echo "Invalid council selected.";
        exit;
}

// Execute the query and fetch the results
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

// Fetch the results and build the table rows
while ($row = $result->fetch_assoc()) {
    $output .= "
    <tr>
        <td class='tdfirst'>{$row['Pname']}</td>
        <td>{$row['position']}</td>
        <td class='tdlast'>{$row['votes']}</td>
    </tr>";
}

// Close the connection
$conn->close();

// Output the table rows
echo $output;
