<?php
include "DBSession.php";

$sql = "SELECT DATE_FORMAT(VotedDT, '%Y-%m-%d %H:00:00') as date, COUNT(*) as count 
        FROM voters 
        WHERE VotedDT IS NOT NULL 
        GROUP BY DATE_FORMAT(VotedDT, '%Y-%m-%d %H')
        ORDER BY date";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode([]);
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
