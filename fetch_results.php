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
        $sql = "SELECT subquery.Pname, subquery.position, subquery.votes 
        FROM (
            SELECT CONCAT(c_President.FName, ' ', c_President.LName) AS Pname, 'President' AS position, COUNT(tv.President) AS votes 
            FROM TSC_VOTES tv
            INNER JOIN Candidates c_President ON tv.President = c_President.usep_ID
            GROUP BY tv.President
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_President_Internal.FName, ' ', c_Vice_President_Internal.LName) AS Pname, 'Vice President Internal Affairs' AS position, COUNT(tv.Vice_President_Internal_Affairs) AS votes 
            FROM TSC_VOTES tv
            INNER JOIN Candidates c_Vice_President_Internal ON tv.Vice_President_Internal_Affairs = c_Vice_President_Internal.usep_ID
            GROUP BY tv.Vice_President_Internal_Affairs
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_President_External.FName, ' ', c_Vice_President_External.LName) AS Pname, 'Vice President External Affairs' AS position, COUNT(tv.Vice_President_External_Affairs) AS votes 
            FROM TSC_VOTES tv
            INNER JOIN Candidates c_Vice_President_External ON tv.Vice_President_External_Affairs = c_Vice_President_External.usep_ID
            GROUP BY tv.Vice_President_External_Affairs
            
            UNION ALL
            
            SELECT CONCAT(c_General_Secretary.FName, ' ', c_General_Secretary.LName) AS Pname, 'General Secretary' AS position, COUNT(tv.General_Secretary) AS votes 
            FROM TSC_VOTES tv
            INNER JOIN Candidates c_General_Secretary ON tv.General_Secretary = c_General_Secretary.usep_ID
            GROUP BY tv.General_Secretary
            
            UNION ALL
            
            SELECT CONCAT(c_General_Treasurer.FName, ' ', c_General_Treasurer.LName) AS Pname, 'General Treasurer' AS position, COUNT(tv.General_Treasurer) AS votes 
            FROM TSC_VOTES tv
            INNER JOIN Candidates c_General_Treasurer ON tv.General_Treasurer = c_General_Treasurer.usep_ID
            GROUP BY tv.General_Treasurer
            
            UNION ALL
            
            SELECT CONCAT(c_General_Auditor.FName, ' ', c_General_Auditor.LName) AS Pname, 'General Auditor' AS position, COUNT(tv.General_Auditor) AS votes 
            FROM TSC_VOTES tv
            INNER JOIN Candidates c_General_Auditor ON tv.General_Auditor = c_General_Auditor.usep_ID
            GROUP BY tv.General_Auditor
            
            UNION ALL
            
            SELECT CONCAT(c_Public_Information_Officer.FName, ' ', c_Public_Information_Officer.LName) AS Pname, 'Public Information Officer' AS position, COUNT(tv.Public_Information_Officer) AS votes 
            FROM TSC_VOTES tv
            INNER JOIN Candidates c_Public_Information_Officer ON tv.Public_Information_Officer = c_Public_Information_Officer.usep_ID
            GROUP BY tv.Public_Information_Officer
            
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN subquery.position = 'President' THEN 1 
                WHEN subquery.position = 'Vice President Internal Affairs' THEN 2 
                WHEN subquery.position = 'Vice President External Affairs' THEN 3 
                WHEN subquery.position = 'General Secretary' THEN 4 
                WHEN subquery.position = 'General Treasurer' THEN 5 
                WHEN subquery.position = 'General Auditor' THEN 6 
                WHEN subquery.position = 'Public Information Officer' THEN 7 
                ELSE 8 
            END,
            subquery.votes DESC, 
            subquery.Pname ASC";


        break;

    case 'SABES':
        $sql = "SELECT Pname, position, votes FROM (
            SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM SABES_VOTES GROUP BY LC_Governor
            UNION ALL
            SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM SABES_VOTES GROUP BY Vice_Governor
            UNION ALL
            SELECT Secretary AS Pname, 'Secretary' AS position, COUNT(Secretary) AS votes FROM SABES_VOTES GROUP BY Secretary
            UNION ALL
            SELECT Treasurer AS Pname, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM SABES_VOTES GROUP BY Treasurer
            UNION ALL
            SELECT Senator1 AS Pname, 'Senator1' AS position, COUNT(Senator1) AS votes FROM SABES_VOTES GROUP BY Senator1
            UNION ALL
            SELECT Senator2 AS Pname, 'Senator2' AS position, COUNT(Senator2) AS votes FROM SABES_VOTES GROUP BY Senator2
            UNION ALL
            SELECT Senator3 AS Pname, 'Senator3' AS position, COUNT(Senator3) AS votes FROM SABES_VOTES GROUP BY Senator3
            UNION ALL
            SELECT Auditor AS Pname, 'Auditor' AS position, COUNT(Auditor) AS votes FROM SABES_VOTES GROUP BY Auditor
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN position = 'LC Governor' THEN 1 
                WHEN position = 'Vice Governor' THEN 2 
                WHEN position = 'Secretary' THEN 3 
                WHEN position = 'Treasurer' THEN 4 
                WHEN position = 'Senator1' THEN 5 
                WHEN position = 'Senator2' THEN 6 
                WHEN position = 'Senator3' THEN 7 
                WHEN position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            votes DESC, 
            Pname ASC";

    case 'OFEE':
        $sql = "SELECT Pname, position, votes FROM (
            SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM OFEE_VOTES GROUP BY LC_Governor
            UNION ALL
            SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM OFEE_VOTES GROUP BY Vice_Governor
            UNION ALL
            SELECT Secretary AS Pname, 'Secretary' AS position, COUNT(Secretary) AS votes FROM OFEE_VOTES GROUP BY Secretary
            UNION ALL
            SELECT Treasurer AS Pname, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM OFEE_VOTES GROUP BY Treasurer
            UNION ALL
            SELECT Senator1 AS Pname, 'Senator1' AS position, COUNT(Senator1) AS votes FROM OFEE_VOTES GROUP BY Senator1
            UNION ALL
            SELECT Senator2 AS Pname, 'Senator2' AS position, COUNT(Senator2) AS votes FROM OFEE_VOTES GROUP BY Senator2
            UNION ALL
            SELECT Senator3 AS Pname, 'Senator3' AS position, COUNT(Senator3) AS votes FROM OFEE_VOTES GROUP BY Senator3
            UNION ALL
            SELECT Auditor AS Pname, 'Auditor' AS position, COUNT(Auditor) AS votes FROM OFEE_VOTES GROUP BY Auditor
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN position = 'LC Governor' THEN 1 
                WHEN position = 'Vice Governor' THEN 2 
                WHEN position = 'Secretary' THEN 3 
                WHEN position = 'Treasurer' THEN 4 
                WHEN position = 'Senator1' THEN 5 
                WHEN position = 'Senator2' THEN 6 
                WHEN position = 'Senator3' THEN 7 
                WHEN position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            votes DESC, 
            Pname ASC";
        break;
    case 'AECES':
        $sql = "SELECT Pname, position, votes FROM (
            SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM AECES_VOTES GROUP BY LC_Governor
            UNION ALL
            SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM AECES_VOTES GROUP BY Vice_Governor
            UNION ALL
            SELECT Secretary AS Pname, 'Secretary' AS position, COUNT(Secretary) AS votes FROM AECES_VOTES GROUP BY Secretary
            UNION ALL
            SELECT Treasurer AS Pname, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM AECES_VOTES GROUP BY Treasurer
            UNION ALL
            SELECT Senator1 AS Pname, 'Senator1' AS position, COUNT(Senator1) AS votes FROM AECES_VOTES GROUP BY Senator1
            UNION ALL
            SELECT Senator2 AS Pname, 'Senator2' AS position, COUNT(Senator2) AS votes FROM AECES_VOTES GROUP BY Senator2
            UNION ALL
            SELECT Senator3 AS Pname, 'Senator3' AS position, COUNT(Senator3) AS votes FROM AECES_VOTES GROUP BY Senator3
            UNION ALL
            SELECT Auditor AS Pname, 'Auditor' AS position, COUNT(Auditor) AS votes FROM AECES_VOTES GROUP BY Auditor
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN position = 'LC Governor' THEN 1 
                WHEN position = 'Vice Governor' THEN 2 
                WHEN position = 'Secretary' THEN 3 
                WHEN position = 'Treasurer' THEN 4 
                WHEN position = 'Senator1' THEN 5 
                WHEN position = 'Senator2' THEN 6 
                WHEN position = 'Senator3' THEN 7 
                WHEN position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            votes DESC, 
            Pname ASC";
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
        $sql = "SELECT Pname, position, votes FROM (
            SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM AFSET_VOTES GROUP BY LC_Governor
            UNION ALL
            SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM AFSET_VOTES GROUP BY Vice_Governor
            UNION ALL
            SELECT Secretary AS Pname, 'Secretary' AS position, COUNT(Secretary) AS votes FROM AFSET_VOTES GROUP BY Secretary
            UNION ALL
            SELECT Treasurer AS Pname, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM AFSET_VOTES GROUP BY Treasurer
            UNION ALL
            SELECT Senator1 AS Pname, 'Senator1' AS position, COUNT(Senator1) AS votes FROM AFSET_VOTES GROUP BY Senator1
            UNION ALL
            SELECT Senator2 AS Pname, 'Senator2' AS position, COUNT(Senator2) AS votes FROM AFSET_VOTES GROUP BY Senator2
            UNION ALL
            SELECT Senator3 AS Pname, 'Senator3' AS position, COUNT(Senator3) AS votes FROM AFSET_VOTES GROUP BY Senator3
            UNION ALL
            SELECT Auditor AS Pname, 'Auditor' AS position, COUNT(Auditor) AS votes FROM AFSET_VOTES GROUP BY Auditor
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN position = 'LC Governor' THEN 1 
                WHEN position = 'Vice Governor' THEN 2 
                WHEN position = 'Secretary' THEN 3 
                WHEN position = 'Treasurer' THEN 4 
                WHEN position = 'Senator1' THEN 5 
                WHEN position = 'Senator2' THEN 6 
                WHEN position = 'Senator3' THEN 7 
                WHEN position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            votes DESC, 
            Pname ASC";
        break;


    case 'SITS':
        $sql = "SELECT Pname, position, votes FROM (
            SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM SITS_VOTES GROUP BY LC_Governor
            UNION ALL
            SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM SITS_VOTES GROUP BY Vice_Governor
            UNION ALL
            SELECT Secretary AS Pname, 'Secretary' AS position, COUNT(Secretary) AS votes FROM SITS_VOTES GROUP BY Secretary
            UNION ALL
            SELECT Treasurer AS Pname, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM SITS_VOTES GROUP BY Treasurer
            UNION ALL
            SELECT Senator1 AS Pname, 'Senator1' AS position, COUNT(Senator1) AS votes FROM SITS_VOTES GROUP BY Senator1
            UNION ALL
            SELECT Senator2 AS Pname, 'Senator2' AS position, COUNT(Senator2) AS votes FROM SITS_VOTES GROUP BY Senator2
            UNION ALL
            SELECT Senator3 AS Pname, 'Senator3' AS position, COUNT(Senator3) AS votes FROM SITS_VOTES GROUP BY Senator3
            UNION ALL
            SELECT Auditor AS Pname, 'Auditor' AS position, COUNT(Auditor) AS votes FROM SITS_VOTES GROUP BY Auditor
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN position = 'LC Governor' THEN 1 
                WHEN position = 'Vice Governor' THEN 2 
                WHEN position = 'Secretary' THEN 3 
                WHEN position = 'Treasurer' THEN 4 
                WHEN position = 'Senator1' THEN 5 
                WHEN position = 'Senator2' THEN 6 
                WHEN position = 'Senator3' THEN 7 
                WHEN position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            votes DESC, 
            Pname ASC";
        break;


    case 'FTVETTS':
        $sql = "SELECT Pname, position, votes FROM (
            SELECT LC_Governor AS Pname, 'LC Governor' AS position, COUNT(LC_Governor) AS votes FROM FTVETTS_VOTES GROUP BY LC_Governor
            UNION ALL
            SELECT Vice_Governor AS Pname, 'Vice Governor' AS position, COUNT(Vice_Governor) AS votes FROM FTVETTS_VOTES GROUP BY Vice_Governor
            UNION ALL
            SELECT Secretary AS Pname, 'Secretary' AS position, COUNT(Secretary) AS votes FROM FTVETTS_VOTES GROUP BY Secretary
            UNION ALL
            SELECT Treasurer AS Pname, 'Treasurer' AS position, COUNT(Treasurer) AS votes FROM FTVETTS_VOTES GROUP BY Treasurer
            UNION ALL
            SELECT Senator1 AS Pname, 'Senator1' AS position, COUNT(Senator1) AS votes FROM FTVETTS_VOTES GROUP BY Senator1
            UNION ALL
            SELECT Senator2 AS Pname, 'Senator2' AS position, COUNT(Senator2) AS votes FROM FTVETTS_VOTES GROUP BY Senator2
            UNION ALL
            SELECT Senator3 AS Pname, 'Senator3' AS position, COUNT(Senator3) AS votes FROM FTVETTS_VOTES GROUP BY Senator3
            UNION ALL
            SELECT Auditor AS Pname, 'Auditor' AS position, COUNT(Auditor) AS votes FROM FTVETTS_VOTES GROUP BY Auditor
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN position = 'LC Governor' THEN 1 
                WHEN position = 'Vice Governor' THEN 2 
                WHEN position = 'Secretary' THEN 3 
                WHEN position = 'Treasurer' THEN 4 
                WHEN position = 'Senator1' THEN 5 
                WHEN position = 'Senator2' THEN 6 
                WHEN position = 'Senator3' THEN 7 
                WHEN position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            votes DESC, 
            Pname ASC";
        break;

    default:
    
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

$allData = [];
// Fetch the results and build the table rows
while ($row = $result->fetch_assoc()) {
    $allData[] = $row;
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
$response = [
    'output' => $output,
    'allData' => $allData
];

// Output the JSON encoded response
echo json_encode($response);
