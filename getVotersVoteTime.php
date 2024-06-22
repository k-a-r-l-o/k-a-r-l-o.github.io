<?php
include "DBSession.php";

header('Content-Type: application/json');

$unit = isset($_GET['unit']) ? $_GET['unit'] : 'day';

$dateFormat = $unit === 'hour' ? '%Y-%m-%d %H' : '%Y-%m-%d';
$interval = $unit === 'hour' ? '1 HOUR' : '1 DAY';

$sql = "SELECT DATE_FORMAT(DATE_ADD(VotedDT, INTERVAL 1 $unit), '$dateFormat') as date, COUNT(*) as count 
        FROM voters 
        WHERE VotedDT IS NOT NULL 
        GROUP BY DATE_FORMAT(DATE_ADD(VotedDT, INTERVAL 1 $unit), '$dateFormat')
        ORDER BY VotedDT";
$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(["error" => "Query Error"]);
    exit;
}

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = [];
}

$conn->close();

echo json_encode($data);
