<?php
include "DBSessionVoter.php";

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

        /* CSS animation for fading in */
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
            justify-content: center;
            align-items: center;
        }

        .cont {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 70px;
            height: max-content;
            width: max-content;
            background-color: white;
            border-radius: 10px;
            box-sizing: border-box;
            box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.15);
            gap: 5%;
        }

        h2 {
            margin: 0;
            text-align: center;
            font-size: 35px;
        }

        .rec {
            margin: 0;
            font-weight: 500;
            text-align: center;
            font-size: 20px;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        button {
            display: flex;
            height: 40px;
            font-size: 20px;
            font-weight: bold;
            margin-left: auto;
            margin-right: auto;
            background-color: #2F80ED;
            /* Same background color as the select */
            color: white;
            border: none;
            gap: 10px;
            border-radius: 5px;
            padding: 0 20px;
            /* Adjust padding as needed */
            cursor: pointer;
            width: 100%;
            max-width: 200px;
            align-items: center;
            justify-content: center;
        }

        button:hover {
            background-color: #2F80ED;
        }

        /*all scrollbar design*/
        /* Width and Height of scrollbar */
        ::-webkit-scrollbar {
            background: transparent;
            width: 7px;
            height: 0px;
            border-radius: 10px;
        }

        /* Track (background of the scrollbar) */
        ::-webkit-scrollbar-track {
            background: transparent;
        }

        /* Handle (thumb) of the scrollbar */
        ::-webkit-scrollbar-thumb {
            background: #28579E;
            border-radius: 5px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #2F80ED;
            border-radius: 5px;
        }

        @media (max-width: 1000px) {

            header {
                grid-template-columns: 35% 65%;
            }

            .logoName,
            .logoName img,
            .cont {
                scale: 0.9;
            }

            header {
                padding-left: 3%;
            }

            .step-name {
                font-size: 10px;
            }

            .stepper-item .step-counter {
                width: 15px;
                height: 15px;
            }

        }

        @media (max-height: 800px) {

            .logoName,
            .logoName img,
            .cont {
                scale: 0.9;
            }

            header {
                padding-left: 3%;
            }
        }

        @media (max-width: 700px) {

            header {
                grid-template-columns: 1fr;
            }

            .logoName {
                width: 100%;
                padding: 1.5% 5%;
            }

            .step-name {
                font-size: 8px;
            }

            .stepper-item .step-counter {
                width: 13px;
                height: 13px;
            }

            .cont {
                scale: 0.8;
            }

        }

        @media (max-width: 500px) {
            .cont {
                scale: 0.7;
            }
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
                <div class="stepper-item completed">
                    <div class="step-counter"></div>
                    <div class="step-name">Student Council</div>
                </div>

                <div class="stepper-item completed">
                    <div class="step-counter"></div>
                    <div class="step-name">SC Summary</div>
                </div>

                <div class="stepper-item completed">
                    <div class="step-counter"></div>
                    <div class="step-name">Local Council</div>
                </div>

                <div class="stepper-item completed">
                    <div class="step-counter"></div>
                    <div class="step-name">LC Summary</div>
                </div>

                <div class="stepper-item active">
                    <div class="step-counter"></div>
                    <div class="step-name">Finish Voting</div>
                </div>
            </div>
        </div>
    </header>

    <div class="bodycontainer">
        <div class="content">
            <div class="cont">
                <h2>Congratulations!</h2>
                <p class="rec">Vote Recorded.</p>
                <img src="finishVote_icon.png" alt="finish" class="center">
                <button onclick="switchHTML('index.php')">Done</button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('keydown', function(event) {
            // Check if Ctrl (or Cmd on Mac), Y, and U keys are pressed
            if ((event.ctrlKey || event.metaKey) && event.key === 'y') {
                // Prevent default browser behavior
                event.preventDefault();

                // Your custom action here
                window.open('index.html', '_self');
            }
        });

        var headerHeight;

        function setHeight() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.content').style.height = `calc(100vh - ${headerHeight}px - 10%)`;
        }

        window.addEventListener('load', setHeight);
        window.addEventListener('resize', setHeight);

        function setPaddingTop() {
            headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.bodycontainer').style.paddingTop = headerHeight + 'px';
        }

        window.addEventListener('load', setPaddingTop);
        window.addEventListener('resize', setPaddingTop);

        // JavaScript code to switch HTML files with animation
        function switchHTML(file) {
            // Add fade-out animation to the body
            document.body.classList.add('fade-out');

            // Wait for the animation to finish, then switch to the new HTML file
            setTimeout(function() {
                window.location.href = file;
            }, 500); // Delay should match the animation duration
        }

        // Add a listener for animation end to remove the fade-out class and add the fade-in class
        document.body.addEventListener('animationend', function() {
            document.body.classList.remove('fade-out');
            document.body.classList.add('fade-in');
        });
    </script>


</body>

</html>
<?php

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d");
$time = date("H:i:s");
$datetime = $date . ' ' . $time;

$sqlvote = "UPDATE voters SET voted = 'Voted', VotedDT = ? WHERE usep_ID = ?";
$stmtUpdate = $conn->prepare($sqlvote);

if ($stmtUpdate) {
    $stmtUpdate->bind_param("si", $datetime, $_SESSION["usep_ID"]);
    $stmtUpdate->execute();
    $stmtUpdate->close();
    session_unset();
    session_destroy();
} else {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

?>