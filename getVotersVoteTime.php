<?php
include "DBSession.php";

header('Content-Type: application/json');

$start = isset($_GET['start']) ? $_GET['start'] : null;
$end = isset($_GET['end']) ? $_GET['end'] : null;
$unit = isset($_GET['unit']) ? $_GET['unit'] : 'day';

$dateFormat = $unit === 'hour' ? '%Y-%m-%d %H:00:00' : '%Y-%m-%d';

$sql = "SELECT DATE_FORMAT(VotedDT, '$dateFormat') as date, COUNT(*) as count 
        FROM voters 
        WHERE VotedDT IS NOT NULL 
        AND VotedDT BETWEEN FROM_UNIXTIME($start / 1000) AND FROM_UNIXTIME($end / 1000) 
        GROUP BY DATE_FORMAT(VotedDT, '$dateFormat')";
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
