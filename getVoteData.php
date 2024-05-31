<?php
// getVoteData.php

include 'DBSession.php';

// Query to get the count of votes
$resultVotes = $conn->query("SELECT COUNT(*) as voteCount FROM tsc_votes");
$rowVotes = $resultVotes->fetch_assoc();
$voteCount = $rowVotes['voteCount'];

// Query to get the count of candidates
$resultCandidates = $conn->query("SELECT COUNT(*) as votersCount FROM voters");
$rowCandidates = $resultCandidates->fetch_assoc();
$votersCount = $rowCandidates['votersCount'];

// Assuming you have a table for total voters
$resultVoters = $conn->query("SELECT COUNT(*) as voterCount FROM voters");
$rowVoters = $resultVoters->fetch_assoc();
$voterCount = $rowVoters['voterCount'];

// Calculate the number of students who haven't voted
$notVotedCount = $votersCount - $voteCount;

// Return the data as JSON
echo json_encode([
    'voteCount' => $voteCount,
    'notVotedCount' => $notVotedCount,
    'voterCount' => $voterCount
]);

$conn->close();
?>
