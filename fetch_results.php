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

// Prepare the SQL query based on the selected council
$sql = "";
switch ($council) {
    case 'TSC':
        $sql = "SELECT subquery.Pname, subquery.position, subquery.votes 
        FROM (
            SELECT CONCAT(c_President.FName, ' ', c_President.LName) AS Pname, 'President' AS position, COUNT(tv.President) AS votes 
            FROM tsc_votes tv
            INNER JOIN candidates c_President ON tv.President = c_President.usep_ID
            GROUP BY tv.President
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_President_Internal.FName, ' ', c_Vice_President_Internal.LName) AS Pname, 'Vice President Internal Affairs' AS position, COUNT(tv.Vice_President_Internal_Affairs) AS votes 
            FROM tsc_votes tv
            INNER JOIN candidates c_Vice_President_Internal ON tv.Vice_President_Internal_Affairs = c_Vice_President_Internal.usep_ID
            GROUP BY tv.Vice_President_Internal_Affairs
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_President_External.FName, ' ', c_Vice_President_External.LName) AS Pname, 'Vice President External Affairs' AS position, COUNT(tv.Vice_President_External_Affairs) AS votes 
            FROM tsc_votes tv
            INNER JOIN candidates c_Vice_President_External ON tv.Vice_President_External_Affairs = c_Vice_President_External.usep_ID
            GROUP BY tv.Vice_President_External_Affairs
            
            UNION ALL
            
            SELECT CONCAT(c_General_Secretary.FName, ' ', c_General_Secretary.LName) AS Pname, 'General Secretary' AS position, COUNT(tv.General_Secretary) AS votes 
            FROM tsc_votes tv
            INNER JOIN candidates c_General_Secretary ON tv.General_Secretary = c_General_Secretary.usep_ID
            GROUP BY tv.General_Secretary
            
            UNION ALL
            
            SELECT CONCAT(c_General_Treasurer.FName, ' ', c_General_Treasurer.LName) AS Pname, 'General Treasurer' AS position, COUNT(tv.General_Treasurer) AS votes 
            FROM tsc_votes tv
            INNER JOIN candidates c_General_Treasurer ON tv.General_Treasurer = c_General_Treasurer.usep_ID
            GROUP BY tv.General_Treasurer
            
            UNION ALL
            
            SELECT CONCAT(c_General_Auditor.FName, ' ', c_General_Auditor.LName) AS Pname, 'General Auditor' AS position, COUNT(tv.General_Auditor) AS votes 
            FROM tsc_votes tv
            INNER JOIN candidates c_General_Auditor ON tv.General_Auditor = c_General_Auditor.usep_ID
            GROUP BY tv.General_Auditor
            
            UNION ALL
            
            SELECT CONCAT(c_Public_Information_Officer.FName, ' ', c_Public_Information_Officer.LName) AS Pname, 'Public Information Officer' AS position, COUNT(tv.Public_Information_Officer) AS votes 
            FROM tsc_votes tv
            INNER JOIN candidates c_Public_Information_Officer ON tv.Public_Information_Officer = c_Public_Information_Officer.usep_ID
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
        $sql = "SELECT subquery.Pname, subquery.position, subquery.votes 
        FROM (
            SELECT CONCAT(c_LC_Governor.FName, ' ', c_LC_Governor.LName) AS Pname, 'LC Governor' AS position, COUNT(tv.LC_Governor) AS votes 
            FROM sabes_votes tv
            INNER JOIN candidates c_LC_Governor ON tv.LC_Governor = c_LC_Governor.usep_ID
            GROUP BY tv.LC_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_Governor.FName, ' ', c_Vice_Governor.LName) AS Pname, 'Vice Governor' AS position, COUNT(tv.Vice_Governor) AS votes 
            FROM sabes_votes tv
            INNER JOIN candidates c_Vice_Governor ON tv.Vice_Governor = c_Vice_Governor.usep_ID
            GROUP BY tv.Vice_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Secretary.FName, ' ', c_Secretary.LName) AS Pname, 'Secretary' AS position, COUNT(tv.Secretary) AS votes 
            FROM sabes_votes tv
            INNER JOIN candidates c_Secretary ON tv.Secretary = c_Secretary.usep_ID
            GROUP BY tv.Secretary
            
            UNION ALL
            
            SELECT CONCAT(c_Treasurer.FName, ' ', c_Treasurer.LName) AS Pname, 'Treasurer' AS position, COUNT(tv.Treasurer) AS votes 
            FROM sabes_votes tv
            INNER JOIN candidates c_Treasurer ON tv.Treasurer = c_Treasurer.usep_ID
            GROUP BY tv.Treasurer
            
            UNION ALL
            
            SELECT CONCAT(c_Senator1.FName, ' ', c_Senator1.LName) AS Pname, 'Senator1' AS position, COUNT(tv.Senator1) AS votes 
            FROM sabes_votes tv
            INNER JOIN candidates c_Senator1 ON tv.Senator1 = c_Senator1.usep_ID
            GROUP BY tv.Senator1
            
            UNION ALL
            
            SELECT CONCAT(c_Senator2.FName, ' ', c_Senator2.LName) AS Pname, 'Senator2' AS position, COUNT(tv.Senator2) AS votes 
            FROM sabes_votes tv
            INNER JOIN candidates c_Senator2 ON tv.Senator2 = c_Senator2.usep_ID
            GROUP BY tv.Senator2
            
            UNION ALL
            
            SELECT CONCAT(c_Senator3.FName, ' ', c_Senator3.LName) AS Pname, 'Senator3' AS position, COUNT(tv.Senator3) AS votes 
            FROM sabes_votes tv
            INNER JOIN candidates c_Senator3 ON tv.Senator3 = c_Senator3.usep_ID
            GROUP BY tv.Senator3
            
            UNION ALL
            
            SELECT CONCAT(c_Auditor.FName, ' ', c_Auditor.LName) AS Pname, 'Auditor' AS position, COUNT(tv.Auditor) AS votes 
            FROM sabes_votes tv
            INNER JOIN candidates c_Auditor ON tv.Auditor = c_Auditor.usep_ID
            GROUP BY tv.Auditor
            
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN subquery.position = 'LC Governor' THEN 1 
                WHEN subquery.position = 'Vice Governor' THEN 2 
                WHEN subquery.position = 'Secretary' THEN 3 
                WHEN subquery.position = 'Treasurer' THEN 4 
                WHEN subquery.position = 'Senator1' THEN 5 
                WHEN subquery.position = 'Senator2' THEN 6 
                WHEN subquery.position = 'Senator3' THEN 7 
                WHEN subquery.position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            subquery.votes DESC, 
            subquery.Pname ASC";
        break;

    case 'OFEE':
        $sql = "SELECT subquery.Pname, subquery.position, subquery.votes 
        FROM (
            SELECT CONCAT(c_LC_Governor.FName, ' ', c_LC_Governor.LName) AS Pname, 'LC Governor' AS position, COUNT(tv.LC_Governor) AS votes 
            FROM ofee_votes tv
            INNER JOIN candidates c_LC_Governor ON tv.LC_Governor = c_LC_Governor.usep_ID
            GROUP BY tv.LC_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_Governor.FName, ' ', c_Vice_Governor.LName) AS Pname, 'Vice Governor' AS position, COUNT(tv.Vice_Governor) AS votes 
            FROM ofee_votes tv
            INNER JOIN candidates c_Vice_Governor ON tv.Vice_Governor = c_Vice_Governor.usep_ID
            GROUP BY tv.Vice_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Secretary.FName, ' ', c_Secretary.LName) AS Pname, 'Secretary' AS position, COUNT(tv.Secretary) AS votes 
            FROM ofee_votes tv
            INNER JOIN candidates c_Secretary ON tv.Secretary = c_Secretary.usep_ID
            GROUP BY tv.Secretary
            
            UNION ALL
            
            SELECT CONCAT(c_Treasurer.FName, ' ', c_Treasurer.LName) AS Pname, 'Treasurer' AS position, COUNT(tv.Treasurer) AS votes 
            FROM ofee_votes tv
            INNER JOIN candidates c_Treasurer ON tv.Treasurer = c_Treasurer.usep_ID
            GROUP BY tv.Treasurer
            
            UNION ALL
            
            SELECT CONCAT(c_Senator1.FName, ' ', c_Senator1.LName) AS Pname, 'Senator1' AS position, COUNT(tv.Senator1) AS votes 
            FROM ofee_votes tv
            INNER JOIN candidates c_Senator1 ON tv.Senator1 = c_Senator1.usep_ID
            GROUP BY tv.Senator1
            
            UNION ALL
            
            SELECT CONCAT(c_Senator2.FName, ' ', c_Senator2.LName) AS Pname, 'Senator2' AS position, COUNT(tv.Senator2) AS votes 
            FROM ofee_votes tv
            INNER JOIN candidates c_Senator2 ON tv.Senator2 = c_Senator2.usep_ID
            GROUP BY tv.Senator2
            
            UNION ALL
            
            SELECT CONCAT(c_Senator3.FName, ' ', c_Senator3.LName) AS Pname, 'Senator3' AS position, COUNT(tv.Senator3) AS votes 
            FROM ofee_votes tv
            INNER JOIN candidates c_Senator3 ON tv.Senator3 = c_Senator3.usep_ID
            GROUP BY tv.Senator3
            
            UNION ALL
            
            SELECT CONCAT(c_Auditor.FName, ' ', c_Auditor.LName) AS Pname, 'Auditor' AS position, COUNT(tv.Auditor) AS votes 
            FROM ofee_votes tv
            INNER JOIN candidates c_Auditor ON tv.Auditor = c_Auditor.usep_ID
            GROUP BY tv.Auditor
            
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN subquery.position = 'LC Governor' THEN 1 
                WHEN subquery.position = 'Vice Governor' THEN 2 
                WHEN subquery.position = 'Secretary' THEN 3 
                WHEN subquery.position = 'Treasurer' THEN 4 
                WHEN subquery.position = 'Senator1' THEN 5 
                WHEN subquery.position = 'Senator2' THEN 6 
                WHEN subquery.position = 'Senator3' THEN 7 
                WHEN subquery.position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            subquery.votes DESC, 
            subquery.Pname ASC";
        break;

    case 'AECES':
        $sql =  "SELECT subquery.Pname, subquery.position, subquery.votes 
        FROM (
            SELECT CONCAT(c_LC_Governor.FName, ' ', c_LC_Governor.LName) AS Pname, 'LC Governor' AS position, COUNT(tv.LC_Governor) AS votes 
            FROM aeces_votes tv
            INNER JOIN candidates c_LC_Governor ON tv.LC_Governor = c_LC_Governor.usep_ID
            GROUP BY tv.LC_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_Governor.FName, ' ', c_Vice_Governor.LName) AS Pname, 'Vice Governor' AS position, COUNT(tv.Vice_Governor) AS votes 
            FROM aeces_votes tv
            INNER JOIN candidates c_Vice_Governor ON tv.Vice_Governor = c_Vice_Governor.usep_ID
            GROUP BY tv.Vice_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Secretary.FName, ' ', c_Secretary.LName) AS Pname, 'Secretary' AS position, COUNT(tv.Secretary) AS votes 
            FROM aeces_votes tv
            INNER JOIN candidates c_Secretary ON tv.Secretary = c_Secretary.usep_ID
            GROUP BY tv.Secretary
            
            UNION ALL
            
            SELECT CONCAT(c_Treasurer.FName, ' ', c_Treasurer.LName) AS Pname, 'Treasurer' AS position, COUNT(tv.Treasurer) AS votes 
            FROM aeces_votes tv
            INNER JOIN candidates c_Treasurer ON tv.Treasurer = c_Treasurer.usep_ID
            GROUP BY tv.Treasurer
            
            UNION ALL
            
            SELECT CONCAT(c_Senator1.FName, ' ', c_Senator1.LName) AS Pname, 'Senator1' AS position, COUNT(tv.Senator1) AS votes 
            FROM aeces_votes tv
            INNER JOIN candidates c_Senator1 ON tv.Senator1 = c_Senator1.usep_ID
            GROUP BY tv.Senator1
            
            UNION ALL
            
            SELECT CONCAT(c_Senator2.FName, ' ', c_Senator2.LName) AS Pname, 'Senator2' AS position, COUNT(tv.Senator2) AS votes 
            FROM aeces_votes tv
            INNER JOIN candidates c_Senator2 ON tv.Senator2 = c_Senator2.usep_ID
            GROUP BY tv.Senator2
            
            UNION ALL
            
            SELECT CONCAT(c_Senator3.FName, ' ', c_Senator3.LName) AS Pname, 'Senator3' AS position, COUNT(tv.Senator3) AS votes 
            FROM aeces_votes tv
            INNER JOIN candidates c_Senator3 ON tv.Senator3 = c_Senator3.usep_ID
            GROUP BY tv.Senator3
            
            UNION ALL
            
            SELECT CONCAT(c_Auditor.FName, ' ', c_Auditor.LName) AS Pname, 'Auditor' AS position, COUNT(tv.Auditor) AS votes 
            FROM aeces_votes tv
            INNER JOIN candidates c_Auditor ON tv.Auditor = c_Auditor.usep_ID
            GROUP BY tv.Auditor
            
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN subquery.position = 'LC Governor' THEN 1 
                WHEN subquery.position = 'Vice Governor' THEN 2 
                WHEN subquery.position = 'Secretary' THEN 3 
                WHEN subquery.position = 'Treasurer' THEN 4 
                WHEN subquery.position = 'Senator1' THEN 5 
                WHEN subquery.position = 'Senator2' THEN 6 
                WHEN subquery.position = 'Senator3' THEN 7 
                WHEN subquery.position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            subquery.votes DESC, 
            subquery.Pname ASC";
        break;

    case 'OFSET':
        $sql = "SELECT subquery.Pname, subquery.position, subquery.votes 
        FROM (
            SELECT CONCAT(c_LC_Governor.FName, ' ', c_LC_Governor.LName) AS Pname, 'LC Governor' AS position, COUNT(tv.LC_Governor) AS votes 
            FROM ofset_votes tv
            INNER JOIN candidates c_LC_Governor ON tv.LC_Governor = c_LC_Governor.usep_ID
            GROUP BY tv.LC_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_Governor.FName, ' ', c_Vice_Governor.LName) AS Pname, 'Vice Governor' AS position, COUNT(tv.Vice_Governor) AS votes 
            FROM ofset_votes tv
            INNER JOIN candidates c_Vice_Governor ON tv.Vice_Governor = c_Vice_Governor.usep_ID
            GROUP BY tv.Vice_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Secretary.FName, ' ', c_Secretary.LName) AS Pname, 'Secretary' AS position, COUNT(tv.Secretary) AS votes 
            FROM ofset_votes tv
            INNER JOIN candidates c_Secretary ON tv.Secretary = c_Secretary.usep_ID
            GROUP BY tv.Secretary
            
            UNION ALL
            
            SELECT CONCAT(c_Treasurer.FName, ' ', c_Treasurer.LName) AS Pname, 'Treasurer' AS position, COUNT(tv.Treasurer) AS votes 
            FROM ofset_votes tv
            INNER JOIN candidates c_Treasurer ON tv.Treasurer = c_Treasurer.usep_ID
            GROUP BY tv.Treasurer
            
            UNION ALL
            
            SELECT CONCAT(c_Senator1.FName, ' ', c_Senator1.LName) AS Pname, 'Senator1' AS position, COUNT(tv.Senator1) AS votes 
            FROM ofset_votes tv
            INNER JOIN candidates c_Senator1 ON tv.Senator1 = c_Senator1.usep_ID
            GROUP BY tv.Senator1
            
            UNION ALL
            
            SELECT CONCAT(c_Senator2.FName, ' ', c_Senator2.LName) AS Pname, 'Senator2' AS position, COUNT(tv.Senator2) AS votes 
            FROM ofset_votes tv
            INNER JOIN candidates c_Senator2 ON tv.Senator2 = c_Senator2.usep_ID
            GROUP BY tv.Senator2
            
            UNION ALL
            
            SELECT CONCAT(c_Senator3.FName, ' ', c_Senator3.LName) AS Pname, 'Senator3' AS position, COUNT(tv.Senator3) AS votes 
            FROM ofset_votes tv
            INNER JOIN candidates c_Senator3 ON tv.Senator3 = c_Senator3.usep_ID
            GROUP BY tv.Senator3
            
            UNION ALL
            
            SELECT CONCAT(c_Auditor.FName, ' ', c_Auditor.LName) AS Pname, 'Auditor' AS position, COUNT(tv.Auditor) AS votes 
            FROM ofset_votes tv
            INNER JOIN candidates c_Auditor ON tv.Auditor = c_Auditor.usep_ID
            GROUP BY tv.Auditor
            
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN subquery.position = 'LC Governor' THEN 1 
                WHEN subquery.position = 'Vice Governor' THEN 2 
                WHEN subquery.position = 'Secretary' THEN 3 
                WHEN subquery.position = 'Treasurer' THEN 4 
                WHEN subquery.position = 'Senator1' THEN 5 
                WHEN subquery.position = 'Senator2' THEN 6 
                WHEN subquery.position = 'Senator3' THEN 7 
                WHEN subquery.position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            subquery.votes DESC, 
            subquery.Pname ASC";
        break;

    case 'AFSET':
        $sql = "SELECT subquery.Pname, subquery.position, subquery.votes 
        FROM (
            SELECT CONCAT(c_LC_Governor.FName, ' ', c_LC_Governor.LName) AS Pname, 'LC Governor' AS position, COUNT(tv.LC_Governor) AS votes 
            FROM afset_votes tv
            INNER JOIN candidates c_LC_Governor ON tv.LC_Governor = c_LC_Governor.usep_ID
            GROUP BY tv.LC_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_Governor.FName, ' ', c_Vice_Governor.LName) AS Pname, 'Vice Governor' AS position, COUNT(tv.Vice_Governor) AS votes 
            FROM afset_votes tv
            INNER JOIN candidates c_Vice_Governor ON tv.Vice_Governor = c_Vice_Governor.usep_ID
            GROUP BY tv.Vice_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Secretary.FName, ' ', c_Secretary.LName) AS Pname, 'Secretary' AS position, COUNT(tv.Secretary) AS votes 
            FROM afset_votes tv
            INNER JOIN candidates c_Secretary ON tv.Secretary = c_Secretary.usep_ID
            GROUP BY tv.Secretary
            
            UNION ALL
            
            SELECT CONCAT(c_Treasurer.FName, ' ', c_Treasurer.LName) AS Pname, 'Treasurer' AS position, COUNT(tv.Treasurer) AS votes 
            FROM afset_votes tv
            INNER JOIN candidates c_Treasurer ON tv.Treasurer = c_Treasurer.usep_ID
            GROUP BY tv.Treasurer
            
            UNION ALL
            
            SELECT CONCAT(c_Math_Senator1.FName, ' ', c_MATH_Senator1.LName) AS Pname, 'MATH_Senator1' AS position, COUNT(tv.MATH_Senator1) AS votes 
            FROM afset_votes tv
            INNER JOIN candidates c_MATH_Senator1 ON tv.MATH_Senator1 = c_MATH_Senator1.usep_ID
            GROUP BY tv.MATH_Senator1
            
            UNION ALL
            
            SELECT CONCAT(c_MATH_Senator2.FName, ' ', c_MATH_Senator2.LName) AS Pname, 'MATH_Senator2' AS position, COUNT(tv.MATH_Senator2) AS votes 
            FROM afset_votes tv
            INNER JOIN candidates c_MATH_Senator2 ON tv.MATH_Senator2 = c_MATH_Senator2.usep_ID
            GROUP BY tv.MATH_Senator2
            
            UNION ALL
            
            SELECT CONCAT(c_MATH_Senator3.FName, ' ', c_MATH_Senator3.LName) AS Pname, 'MATH_Senator3' AS position, COUNT(tv.MATH_Senator3) AS votes 
            FROM afset_votes tv
            INNER JOIN candidates c_MATH_Senator1 ON tv.MATH_Senator3 = c_MATH_Senator3.usep_ID
            GROUP BY tv.MATH_Senator3
            
            UNION ALL
            
            SELECT CONCAT(c_Auditor.FName, ' ', c_Auditor.LName) AS Pname, 'Auditor' AS position, COUNT(tv.Auditor) AS votes 
            FROM afset_votes tv
            INNER JOIN candidates c_Auditor ON tv.Auditor = c_Auditor.usep_ID
            GROUP BY tv.Auditor
            
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN subquery.position = 'LC Governor' THEN 1 
                WHEN subquery.position = 'Vice Governor' THEN 2 
                WHEN subquery.position = 'Secretary' THEN 3 
                WHEN subquery.position = 'Treasurer' THEN 4 
                WHEN subquery.position = 'Math Senator1' THEN 5 
                WHEN subquery.position = 'Math Senator2' THEN 6 
                WHEN subquery.position = 'Math Senator3' THEN 7 
                WHEN subquery.position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            subquery.votes DESC, 
            subquery.Pname ASC";
        break;


    case 'SITS':
        $sql = "SELECT subquery.Pname, subquery.position, subquery.votes 
        FROM (
            SELECT CONCAT(c_LC_Governor.FName, ' ', c_LC_Governor.LName) AS Pname, 'LC Governor' AS position, COUNT(tv.LC_Governor) AS votes 
            FROM sits_votes tv
            INNER JOIN candidates c_LC_Governor ON tv.LC_Governor = c_LC_Governor.usep_ID
            GROUP BY tv.LC_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Vice_Governor.FName, ' ', c_Vice_Governor.LName) AS Pname, 'Vice Governor' AS position, COUNT(tv.Vice_Governor) AS votes 
            FROM sits_votes tv
            INNER JOIN candidates c_Vice_Governor ON tv.Vice_Governor = c_Vice_Governor.usep_ID
            GROUP BY tv.Vice_Governor
            
            UNION ALL
            
            SELECT CONCAT(c_Secretary.FName, ' ', c_Secretary.LName) AS Pname, 'Secretary' AS position, COUNT(tv.Secretary) AS votes 
            FROM sits_votes tv
            INNER JOIN candidates c_Secretary ON tv.Secretary = c_Secretary.usep_ID
            GROUP BY tv.Secretary
            
            UNION ALL
            
            SELECT CONCAT(c_Treasurer.FName, ' ', c_Treasurer.LName) AS Pname, 'Treasurer' AS position, COUNT(tv.Treasurer) AS votes 
            FROM sits_votes tv
            INNER JOIN candidates c_Treasurer ON tv.Treasurer = c_Treasurer.usep_ID
            GROUP BY tv.Treasurer
            
            UNION ALL
            
            SELECT CONCAT(c_Senator1.FName, ' ', c_Senator1.LName) AS Pname, 'Senator1' AS position, COUNT(tv.Senator1) AS votes 
            FROM sits_votes tv
            INNER JOIN candidates c_Senator1 ON tv.Senator1 = c_Senator1.usep_ID
            GROUP BY tv.Senator1
            
            UNION ALL
            
            SELECT CONCAT(c_Senator2.FName, ' ', c_Senator2.LName) AS Pname, 'Senator2' AS position, COUNT(tv.Senator2) AS votes 
            FROM sits_votes tv
            INNER JOIN candidates c_Senator2 ON tv.Senator2 = c_Senator2.usep_ID
            GROUP BY tv.Senator2
            
            UNION ALL
            
            SELECT CONCAT(c_Senator3.FName, ' ', c_Senator3.LName) AS Pname, 'Senator3' AS position, COUNT(tv.Senator3) AS votes 
            FROM sits_votes tv
            INNER JOIN candidates c_Senator3 ON tv.Senator3 = c_Senator3.usep_ID
            GROUP BY tv.Senator3
            
            UNION ALL
            
            SELECT CONCAT(c_Auditor.FName, ' ', c_Auditor.LName) AS Pname, 'Auditor' AS position, COUNT(tv.Auditor) AS votes 
            FROM sits_votes tv
            INNER JOIN candidates c_Auditor ON tv.Auditor = c_Auditor.usep_ID
            GROUP BY tv.Auditor
            
        ) AS subquery
        ORDER BY 
            CASE 
                WHEN subquery.position = 'LC Governor' THEN 1 
                WHEN subquery.position = 'Vice Governor' THEN 2 
                WHEN subquery.position = 'Secretary' THEN 3 
                WHEN subquery.position = 'Treasurer' THEN 4 
                WHEN subquery.position = 'Senator1' THEN 5 
                WHEN subquery.position = 'Senator2' THEN 6 
                WHEN subquery.position = 'Senator3' THEN 7 
                WHEN subquery.position = 'Auditor' THEN 8 
                ELSE 9 
            END,
            subquery.votes DESC, 
            subquery.Pname ASC";
        break;


    case 'FTVETS':
        $sql = "SELECT subquery.Pname, subquery.position, subquery.votes 
            FROM (
                SELECT CONCAT(c_LC_Governor.FName, ' ', c_LC_Governor.LName) AS Pname, 'LC Governor' AS position, COUNT(tv.LC_Governor) AS votes 
                FROM ftvets_votes tv
                INNER JOIN candidates c_LC_Governor ON tv.LC_Governor = c_LC_Governor.usep_ID
                GROUP BY tv.LC_Governor
                
                UNION ALL
                
                SELECT CONCAT(c_Vice_Governor.FName, ' ', c_Vice_Governor.LName) AS Pname, 'Vice Governor' AS position, COUNT(tv.Vice_Governor) AS votes 
                FROM ftvets_votes tv
                INNER JOIN candidates c_Vice_Governor ON tv.Vice_Governor = c_Vice_Governor.usep_ID
                GROUP BY tv.Vice_Governor
                
                UNION ALL
                
                SELECT CONCAT(c_Secretary.FName, ' ', c_Secretary.LName) AS Pname, 'Secretary' AS position, COUNT(tv.Secretary) AS votes 
                FROM ftvets_votes tv
                INNER JOIN candidates c_Secretary ON tv.Secretary = c_Secretary.usep_ID
                GROUP BY tv.Secretary
                
                UNION ALL
                
                SELECT CONCAT(c_Treasurer.FName, ' ', c_Treasurer.LName) AS Pname, 'Treasurer' AS position, COUNT(tv.Treasurer) AS votes 
                FROM ftvets_votes tv
                INNER JOIN candidates c_Treasurer ON tv.Treasurer = c_Treasurer.usep_ID
                GROUP BY tv.Treasurer
                
                UNION ALL
                
                SELECT CONCAT(c_Senator1.FName, ' ', c_Senator1.LName) AS Pname, 'Senator1' AS position, COUNT(tv.Senator1) AS votes 
                FROM ftvets_votes tv
                INNER JOIN candidates c_Senator1 ON tv.Senator1 = c_Senator1.usep_ID
                GROUP BY tv.Senator1
                
                UNION ALL
                
                SELECT CONCAT(c_Senator2.FName, ' ', c_Senator2.LName) AS Pname, 'Senator2' AS position, COUNT(tv.Senator2) AS votes 
                FROM ftvets_votes tv
                INNER JOIN candidates c_Senator2 ON tv.Senator2 = c_Senator2.usep_ID
                GROUP BY tv.Senator2
                
                UNION ALL
                
                SELECT CONCAT(c_Senator3.FName, ' ', c_Senator3.LName) AS Pname, 'Senator3' AS position, COUNT(tv.Senator3) AS votes 
                FROM ftvets_votes tv
                INNER JOIN candidates c_Senator3 ON tv.Senator3 = c_Senator3.usep_ID
                GROUP BY tv.Senator3
                
                UNION ALL
                
                SELECT CONCAT(c_Auditor.FName, ' ', c_Auditor.LName) AS Pname, 'Auditor' AS position, COUNT(tv.Auditor) AS votes 
                FROM ftvets_votes tv
                INNER JOIN candidates c_Auditor ON tv.Auditor = c_Auditor.usep_ID
                GROUP BY tv.Auditor
                
            ) AS subquery
            ORDER BY 
                CASE 
                    WHEN subquery.position = 'LC Governor' THEN 1 
                    WHEN subquery.position = 'Vice Governor' THEN 2 
                    WHEN subquery.position = 'Secretary' THEN 3 
                    WHEN subquery.position = 'Treasurer' THEN 4 
                    WHEN subquery.position = 'Senator1' THEN 5 
                    WHEN subquery.position = 'Senator2' THEN 6 
                    WHEN subquery.position = 'Senator3' THEN 7 
                    WHEN subquery.position = 'Auditor' THEN 8 
                    ELSE 9 
                END,
                subquery.votes DESC, 
                subquery.Pname ASC";
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
