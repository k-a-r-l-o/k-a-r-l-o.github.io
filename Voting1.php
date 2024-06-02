<?php
include "DBSessionVoter.php";

// Fetch user details from session
$username = $_SESSION["username"];
$program = $_SESSION["program"];
$usep_ID = $_SESSION["usep_ID"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>U-Vote</title>
    <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            background-image: url('backgroundVoter.svg');
            background-size: 76.5vh;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }
        img {
            -webkit-user-drag: none;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        header {
            display: grid;
            grid-template-columns: 25% 55% 20%;
            background-color: #2F80ED;
            background-image: url('backgroundVoter.svg');
            background-size: 76.5vh;
            background-repeat: no-repeat;
            height: auto;
            width: 100vw;
            text-align: center;
            padding: 0.8% 3%;
            position: fixed;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
            background-blend-mode: multiply;
            z-index: 10;
            box-sizing: border-box;
        }
        .logoName {
            display: flex;
            align-items: center;
            gap: 10px;
            box-sizing: border-box;
        }
        .tracker {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 50px;
        }
        .stepper-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        .stepper-item::before {
            position: absolute;
            content: "";
            border-bottom: 1px solid #FFFFFF;
            width: 100%;
            top: 25%;
            left: -50%;
            z-index: 2;
        }
        .stepper-item::after {
            position: absolute;
            content: "";
            border-bottom: 1px solid #FFFFFF;
            width: 100%;
            top: 25%;
            left: 50%;
            z-index: 2;
        }
        .stepper-item .step-counter {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #FFFFFF;
            margin-bottom: .4vw;
        }
        .stepper-item.active .step-counter {
            font-weight: bold;
            background-color: #FCCB06;
        }
        .stepper-item.completed .step-counter {
            background-color: #090074;
        }
        .stepper-item.completed::after {
            position: absolute;
            content: "";
            border-bottom: 1px solid #FFFFFF;
            width: 100%;
            top: 25%;
            left: 50%;
            z-index: 3;
        }
        .stepper-item:first-child::before {
            content: none;
        }
        .stepper-item:last-child::after {
            content: none;
        }
        .step-name {
            font-family: 'Inter', sans-serif;
            color: white;
            font-weight: 400;
            font-size: 13px;
        }
        .bodycontainer {
            display: flex;
            justify-content: center;
            width: 100vw;
            height: 100vh;
            background-color: transparent;
            position: fixed;
            z-index: 9999;
            animation: fadeIn 0.3s forwards;
        }
        .content {
            width: 100%;
            display: flex;
            flex-direction: column;
            padding: 2%;
            overflow: auto;
        }
        .cardcontainer {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: auto;
            padding-bottom: 3%;
        }
        .title {
            margin-bottom: 2%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }
        .tname {
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: auto;
            max-width: 550px;
            border-radius: 12px;
            background-color: #001AFF;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }
        h2 {
            font-weight: 400;
            margin: 3%;
            text-transform: uppercase;
        }
        .card {
            height: auto;
            width: 100%;
            max-width: 1285px;
            display: flex;
            flex-direction: column;
            justify-self: center;
            border-radius: 12px;
            margin-bottom: 2%;
            background-color: transparent;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .positiontitle {
            position: relative;
            background-color: #001AFF;
            color: white;
            display: flex;
            width: 100%;
            height: auto;
            border-radius: 12px 12px 0 0;
            padding: 12px 10%;
            box-sizing: border-box;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }
        .positiontitle h3 {
            font-size: 24px;
            font-weight: 400;
            margin: 0;
            text-transform: uppercase;
        }
        .cardcontent {
            width: 100%;
            display: flex;
            padding: 20px 10%;
            box-sizing: border-box;
            background-color: rgb(150, 191, 245, 0.75);
            height: auto;
            border-radius: 0 0 12px 12px;
            align-items: center;
            justify-content: center;
        }
        input[type="radio"] {
            margin-bottom: 20px;
            width: 20px;
            height: 20px;
        }
        .candidateimage {
            display: flex;
            justify-content: right;
            align-items: center;
            width: 100%;
        }
        .candidateimage img {
            height: auto;
            width: auto;
            max-width: 250px;
            max-height: 250px;
            object-fit: cover;
            border-radius: 12px;
        }
        .candidateinfocontent {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .candidateinfocontent {
            display: flex;
            flex-direction: column;
        }
        .candidateinfocontent label {
            display: flex;
            align-items: center;
        }
        .candidateinfocontent input[type="radio"] {
            margin-top: 18px;
            margin-right: 10px;
        }
        .candidateinfocontent p {
            font-size: 20px;
        }
        .candidateinfocontent label {
            display: flex;
            align-items: center;
            color: #000000;
            margin-bottom: 5px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .candidateinfocontent input[type="radio"] {
            margin-right: 10px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 20px;
            height: 20px;
            border: none;
            border-radius: 50%;
            background-color: #fff;
            position: relative;
            display: inline-block;
            vertical-align: middle;
            cursor: pointer;
        }
        .candidateinfocontent input[type="radio"]:checked::after {
            content: "";
            display: block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #000;
            position: absolute;
            top: 4px;
            left: 4px;
        }
        input[type="radio"]:checked {
            background-color: #FCCB06;
        }
        input[type="radio"]:checked ~ .custom-radio-label {
            color: #FCCB06;
        }
        input[type="radio"]:checked::before {
            background-color: #090074;
        }
    </style>
</head>
<body>
    <header>
        <div class="logoName">
            <img id="Logo" src="U-Vote Logo.svg" alt="Logo">
            <img id="Name" src="U-Vote Name.svg" alt="Name">
        </div>
        <div class="tracker">
            <div class="stepper-wrapper">
                <div class="stepper-item active">
                    <div class="step-counter"></div>
                    <div class="step-name">Student Council</div>
                </div>
                <div class="stepper-item">
                    <div class="step-counter"></div>
                    <div class="step-name">Program Council</div>
                </div>
                <div class="stepper-item">
                    <div class="step-counter"></div>
                    <div class="step-name">SSG Officers</div>
                </div>
            </div>
        </div>
    </header>
    <div class="bodycontainer">
        <div class="content">
            <div class="cardcontainer">
                <div class="title">
                    <div class="tname">
                        <h2>STUDENT COUNCIL</h2>
                    </div>
                </div>
                <form action="voterPage2.php" method="post">
                    <?php
                    $sqlPositions = "SELECT position_name FROM positions WHERE council_id = 8";
                    $resultPositions = $conn->query($sqlPositions);

                    if ($resultPositions->num_rows > 0) {
                        while ($positionRow = $resultPositions->fetch_assoc()) {
                            $positionName = htmlspecialchars($positionRow['position_name']);
                            $sqlCandidates = "SELECT * FROM candidates WHERE position = '$positionName'";
                            $resultCandidates = $conn->query($sqlCandidates);

                            echo '<div class="card">
                                <div class="positiontitle">
                                    <h3>' . $positionName . '</h3>
                                </div>
                                <div class="cardcontent">
                                    <div class="candidateinfocontent">';
                            echo '<label for="' . $positionName . 'Abstain">
                                <input type="radio" id="' . $positionName . 'Abstain" name="' . $positionName . '" value="100010001" checked onchange="updateCandidateImage(\'' . $positionName . 'CandidateImage\', \'uploads/Abstain.png\')" data-image-id="' . $positionName . 'CandidateImage" data-image-src="uploads/Abstain.png">Abstain
                            </label>';
                            
                            if ($resultCandidates->num_rows > 0) {
                                $counter = 1;
                                while ($candidateRow = $resultCandidates->fetch_assoc()) {
                                    $candidateId = htmlspecialchars($candidateRow['usep_ID']);
                                    $candidateName = htmlspecialchars($candidateRow['FName'] . ' ' . $candidateRow['LName']);
                                    $candidateImage = htmlspecialchars($candidateRow['candPic']);

                                    echo '<label for="' . $positionName . 'Candidate' . $counter . '">
                                        <input type="radio" id="' . $positionName . 'Candidate' . $counter . '" name="' . $positionName . '" value="' .  $candidateId . '" onchange="updateCandidateImage(\'' . $positionName . 'CandidateImage\', \'' . $candidateImage . '\')" data-image-id="' . $positionName . 'CandidateImage" data-image-src="' . $candidateImage . '">' . $candidateName . '
                                    </label>';
                                    $counter++;
                                }
                            } else {
                                echo 'No candidates found for ' . $positionName . '.';
                            }

                            echo '</div>
                                <div class="candidateimage">
                                    <img id="' . $positionName . 'CandidateImage" src="uploads/Abstain.png" alt="sub">
                                </div>
                            </div>';
                        }
                    } else {
                        echo 'No positions found for council_ID 8.';
                    }
                    ?>
                    <div>
                        <button type="submit">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function setHeight() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.content').style.height = `calc(100vh - ${headerHeight}px)`;
        }
        window.addEventListener('load', setHeight);
        window.addEventListener('resize', setHeight);

        function setPaddingTop() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.bodycontainer').style.paddingTop = headerHeight + 'px';
        }
        window.addEventListener('load', setPaddingTop);
        window.addEventListener('resize', setPaddingTop);

        function updateCandidateImage(imageId, newImageSrc) {
            var candidateImage = document.getElementById(imageId);
            candidateImage.src = newImageSrc;
            sessionStorage.setItem(imageId, newImageSrc);
        }
        window.onload = function() {
            var candidateRadios = document.querySelectorAll('input[type="radio"]');
            candidateRadios.forEach(function(radio) {
                var storedImageSrc = sessionStorage.getItem(radio.getAttribute('data-image-id'));
                if (storedImageSrc !== null) {
                    updateCandidateImage(radio.getAttribute('data-image-id'), storedImageSrc);
                }
            });
        };
    </script>
</body>
</html>
