<?php
// getVoteData.php

include 'DBSession.php';

// Query to get the count of votes for each program
$resultVotes = $conn->query("SELECT COUNT(*) as voteCount FROM sabes_votes");
$rowVotes = $resultVotes->fetch_assoc();
$voteCount = $rowVotes['voteCount'];

$resultVotes1 = $conn->query("SELECT COUNT(*) as voteCount1 FROM ofee_votes");
$rowVotes1 = $resultVotes1->fetch_assoc();
$voteCount1 = $rowVotes1['voteCount1'];

$resultVotes2 = $conn->query("SELECT COUNT(*) as voteCount2 FROM aeces_votes");
$rowVotes2 = $resultVotes2->fetch_assoc();
$voteCount2 = $rowVotes2['voteCount2'];

$resultVotes3 = $conn->query("SELECT COUNT(*) as voteCount3 FROM ofset_votes");
$rowVotes3 = $resultVotes3->fetch_assoc();
$voteCount3 = $rowVotes3['voteCount3'];

$resultVotes4 = $conn->query("SELECT COUNT(*) as voteCount4 FROM afset_votes");
$rowVotes4 = $resultVotes4->fetch_assoc();
$voteCount4 = $rowVotes4['voteCount4'];

$resultVotes5 = $conn->query("SELECT COUNT(*) as voteCount5 FROM sits_votes");
$rowVotes5 = $resultVotes5->fetch_assoc();
$voteCount5 = $rowVotes5['voteCount5'];

$resultVotes6 = $conn->query("SELECT COUNT(*) as voteCount6 FROM ftvets_votes");
$rowVotes6 = $resultVotes6->fetch_assoc();
$voteCount6 = $rowVotes6['voteCount6'];

$resultVotes7 = $conn->query("SELECT COUNT(*) as voteCount7 FROM tsc_votes");
$rowVotes7 = $resultVotes7->fetch_assoc();
$voteCount7 = $rowVotes7['voteCount7'];

$resultVotes8 = $conn->query("SELECT COUNT(*) as voteCount8 FROM sm_votes");
$rowVotes8 = $resultVotes7->fetch_assoc();
$voteCount8 = $rowVotes7['voteCount8'];

// Fetch voter counts for each program
$programs = [
    'BSABE',
    'BEEd',
    'BECEd',
    'BSNEd',
    'BSEd',
    'BSIT',
    'BTVTEd',
    'ALL',
    'SOM'
];

$voterCounts = [];

foreach ($programs as $program) {
    if ($program === 'ALL') {
        $resultVoters = $conn->query("SELECT COUNT(*) as voterCount FROM voters");
    } else {
        $resultVoters = $conn->query("SELECT COUNT(*) as voterCount FROM voters WHERE program = '$program'");
    }
    $rowVoters = $resultVoters->fetch_assoc();
    $voterCounts[$program] = $rowVoters['voterCount'];
}

// Return the data as JSON
echo json_encode([
    'voteCount' => $voteCount,
    'voteCount1' => $voteCount1,
    'voteCount2' => $voteCount2,
    'voteCount3' => $voteCount3,
    'voteCount4' => $voteCount4,
    'voteCount5' => $voteCount5,
    'voteCount6' => $voteCount6,
    'voteCount7' => $voteCount7,
    'voteCount8' => $voteCount8,
    'voterCounts' => $voterCounts
]);

$conn->close();
