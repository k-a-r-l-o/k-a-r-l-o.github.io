<?php
include "DBSession.php";

$usertype = $_SESSION['usertype'];
$username = $_SESSION['username'];

$sql = "SELECT FName, LName FROM users WHERE username = ? AND usertype = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $usertype);
$stmt->execute();
$stmt->bind_result($FName, $LName);
$stmt->fetch();
$stmt->close();
$firstLetterFirstName = substr($FName, 0, 1);
$firstLetterLastName = substr($LName, 0, 1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>U-Vote Admin | Voting Schedule</title>
    <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #222E50;
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
            grid-template-columns: 1fr 1fr;
            background-color: rgba(34, 46, 80, 0.5);
            background-image: url('background.svg');
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
        }

        .logoName {
            display: flex;
            align-items: center;
            width: 45vw;
            gap: 10px;
        }

        .searchspace {
            display: flex;
            justify-content: right;
            align-items: center;
            width: 45vw;
        }

        .searchicon {
            display: flex;
            background-color: rgba(84, 105, 163, 0.75);
            border-radius: 10px;
            height: 55px;
            width: 90%;
            max-width: 560px;
            align-items: center;
        }

        .searchspace input {
            position: relative;
            height: 55px;
            width: auto;
            font-size: 20px;
            font-weight: bold;
            background-color: transparent;
            color: white;
            font-weight: 100;
            border: none;
            flex: 1;
        }

        .searchspace input:focus {
            outline: none;
        }

        .searchspace input::placeholder {
            color: white;
            font-weight: 100;
        }

        .bodycontainer {
            display: flex;
            width: 100vw;
            height: 100vh;
            background-color: #222E50;
            overflow: hidden;
            position: fixed;
            z-index: 1;
            animation: fadeIn 0.3s forwards;
        }

        /*menu*/

        .menu {
            display: flex;
            flex-direction: column;
            width: auto;
            max-width: 390px;
            padding: 2% 1%;
            gap: 10px;
            background-color: #222E50;
            box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.2);
            border-radius: 0px 10px 10px 0px;
            align-items: baseline;
            justify-items: center;
            z-index: 5;
            overflow: auto;
        }

        .buttonContainer {
            display: grid;
            grid-template-columns: 1fr;
            width: auto;
            max-width: 390px;
            height: auto;
            gap: 3px;
            background-color: transparent;
            justify-items: center;
        }

        .buttonContainer button {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 70px;
            font-size: 20px;
            font-weight: lighter;
            background-color: #222E50;
            color: white;
            border: none;
            gap: 10px;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
            max-width: 340px;
            align-items: center;
            justify-content: center;
            transition: all 0.1s ease;
        }

        .buttonContainer button div:nth-child(1) {
            display: flex;
            width: 75%;
            height: 100%;
            align-items: center;
            justify-content: right;
        }

        .buttonContainer button div:nth-child(2) {
            display: flex;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: left;
            white-space: nowrap;
        }

        #selected {
            background-color: rgb(66, 165, 245, 0.5);
            box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.25);
        }

        .buttonContainer button:hover {
            background-color: rgb(66, 165, 245, 0.25);
            box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.25);
        }

        .buttonContainer .Logoutbutton {
            display: flex;
            height: 60px;
            font-size: 20px;
            font-weight: bold;
            background-color: #F6C90E;
            /* Same background color as the select */
            color: #222E50;
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

        .buttonContainer .Logoutbutton:hover {
            background-color: #ffe682;
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

            .logoName,
            .searchspace,
            .searchspace img,
            .logoName img {
                scale: 0.9;
            }

            table,
            .content button,
            h2,
            h3 {
                scale: 0.9;
            }

            header {
                padding-left: 3%;
            }

            .buttonContainer button div:nth-child(2) {
                display: none;
            }

            .menu {
                width: auto;
                justify-items: center;
                grid-template-columns: 1fr;
            }

            .buttonContainer {
                width: auto;
                justify-items: center;
                grid-template-columns: 1fr;
            }

            .menu button {
                grid-template-columns: 1fr;
                width: 60px;
                height: 60px;
                justify-content: center;
                align-items: center;
                gap: 0;
                padding: 0;
            }

            .buttonContainer button div:nth-child(1) {
                display: flex;
                width: auto;
                align-items: center;
                justify-content: center;
                padding: 0;
            }

            .buttonContainer .Logoutbutton {
                padding: 0;
                gap: 0;
                width: 60px;
                height: 60px;
            }

            button div img {
                scale: 0.8;
                background-size: contain;
            }

        }


        @media (max-width: 700px) {

            header {
                grid-template-columns: 1fr;
            }

            .logoName,
            .searchspace {
                width: 100%;
                padding: 1.5% 5%;
            }

            .searchspace {
                justify-content: left;
            }

            .menu button {
                grid-template-columns: 1fr;
                width: 50px;
                height: 50px;
                justify-content: center;
                align-items: center;
                gap: 0;
                padding: 0;
            }

            .buttonContainer .Logoutbutton {
                padding: 0;
                gap: 0;
                width: 50px;
                height: 50px;
            }

            button div img {
                scale: 0.6;
            }

            .content button,
            h2,
            h3,
            .yellowBG {
                scale: 0.8;
            }

        }

        @media (max-width: 500px) {
            .dropdown button {
                font-size: 0;
                padding: 10px;
                width: auto;
                gap: 0;
            }

            .dropdown button img {
                justify-content: center;
            }

            /* Width and Height of scrollbar */
            ::-webkit-scrollbar {
                width: 4px;
            }

        }

        /*Content*/
        .content {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 5fr;
            background-color: #222E50;
            width: auto;
            color: white;
            justify-content: center;
            align-items: baseline;
            padding: 2%;
            flex: 1;
            z-index: 2;
            overflow: scroll;
        }

        .contenthead {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            height: auto;
            color: white;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .titlecontainer {
            display: flex;
            width: auto;
            height: auto;
            color: white;
            align-items: center;
            gap: 20px;
        }

        .dropdown {
            display: flex;
            justify-content: right;
            align-items: center;
        }

        .titlecontainer button,
        .dropdown button {
            display: flex;
            height: 40px;
            font-size: 20px;
            font-weight: bold;
            background-color: #F6C90E;
            border: none;
            gap: 10px;
            border-radius: 5px;
            padding: 0 20px;
            cursor: pointer;
            width: auto;
            align-items: center;
            justify-content: center;
        }

        .dropdown button {
            background-color: #F6C90E;
            color: #222E50;
        }

        #clearSchedule {
            display: flex;
            height: 40px;
            font-size: 20px;
            font-weight: bold;
            border: none;
            gap: 10px;
            border-radius: 5px;
            padding: 0 20px;
            cursor: pointer;
            width: 100%;
            max-width: 200px;
            align-items: center;
            justify-content: center;
            background-color: #F34235;
            color: white;
        }

        .titlecontainer button {
            background-color: transparent;
            color: #ffffff;
        }

        .schedulecontainer {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: auto;
        }

        .realTime-container,
        .startcontainer,
        .endcontainer {
            display: flex;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            height: 264px;
            border-radius: 12px;
            background-color: rgba(150, 191, 245, 0.25);
            margin-bottom: 3%;
        }

        .startcontainer {
            width: 100%;
            height: 264px;
            margin-right: 1.5%;
            margin-bottom: 3%;
        }

        .endcontainer {
            width: 100%;
            height: 264px;
            margin-left: 1.5%;
            margin-bottom: 3%;
        }

        .timeclockcontainer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            align-items: center;
            height: 100%;
        }


        .clocktitle {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 20%;
            background-image: linear-gradient(#28579E, #222E50);
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .clockfoot {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 20%;
        }


        .timeclockcontainer h1 {
            font-size: 60px;
            color: white;
            letter-spacing: 4px;
            margin: 0;
        }

        .timeclockcontainer h5 {
            font-size: 24px;
            color: white;
            letter-spacing: 3px;
            text-transform: uppercase;
            white-space: nowrap;
            margin: 0;
        }

        .startendcontainer {
            display: flex;
        }

        @media (max-width: 1200px) {
            .titlecontainer {
                flex-direction: column;
                align-items: baseline;
                gap: 10px;
            }

            .titlecontainer h2 {
                margin: 0;
            }
        }


        @media (max-width: 1000px) {
            .timeclockcontainer h1 {
                font-size: 50px;
            }

            .timeclockcontainer h5 {
                font-size: 20px;
            }

            .startendcontainer {
                display: flex;
                flex-direction: column;
            }

            .startcontainer {
                margin-right: 0;
            }

            .endcontainer {
                margin-left: 0;
            }

        }

        @media (max-width: 700px) {
            .schedulecontainer {
                scale: 0.95;
            }

            .timeclockcontainer h1 {
                font-size: 40px;
            }

            .timeclockcontainer h5 {
                font-size: 16px;
            }

        }

        @media (max-width: 500px) {
            .schedulecontainer {
                scale: 0.9;
            }

            .timeclockcontainer h1 {
                font-size: 30px;
            }

            .timeclockcontainer h5 {
                font-size: 12px;
            }

            .dropdown button {
                font-size: 0;
                padding: 10px;
                width: auto;
                gap: 0;
            }

            .titlecontainer {
                margin-top: 20px;
                margin-bottom: 0;
                width: 200%;
            }

        }

        @media (max-height: 800px) {

            .logoName,
            .logoName img,
            .searchspace {
                scale: 0.9;
            }

            header {
                padding-left: 3%;
            }

        }

        /*pop ups*/
        .popup {
            color: white;
            display: none;
            flex-direction: column;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #222E50;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
            height: auto;
            width: 60vh;
            min-width: fit-content;
            border-radius: 5px;
            z-index: 9999;
        }



        .head {
            background: linear-gradient(to bottom, #28579E, #222E50);
            width: 100%;
            height: 6vh;
            border-radius: 5px 5px 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        }

        .popup-content {
            flex: 1;
            overflow: hidden;
            padding: 5%;
            box-sizing: border-box;
        }

        .popup-content-inner,
        .buttons {
            display: grid;
            height: auto;
            gap: 10px;
        }

        .buttons1 {
            display: flex;
            width: 100%;
            height: auto;
            justify-content: right;
            gap: 10px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px;
            height: auto;
        }

        .form-group label {
            text-align: left;
            width: 100%;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .input-form {
            width: 100%;
            height: 40px;
            padding: 1% 1%;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            color: white;
            background-color: rgba(150, 191, 245, 0.5);
            outline: none;
            box-sizing: border-box;
        }

        /* Hide the up and down arrows */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .upload-btn {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .input-file {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .upload-btn span {
            display: inline-block;
            cursor: pointer;
            background-color: rgba(150, 191, 245, 0.5);
            /* Set the background color */
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            height: 40px;
            line-height: 40px;
            box-sizing: border-box;
            width: 100%;
            vertical-align: middle;
            text-align: center;
        }

        .popup-content .cancel-button,
        .popup-content .save-button {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40PX;
            width: 100%;
            font-size: large;
            font-weight: lighter;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup-content .cancel-button {
            background-color: #ffffff;
            color: #090074;
        }

        .popup-content .save-button {
            background-color: #4361EE;
            color: white;
        }

        .cancel-button:hover {
            color: white;
            background-color: #F34235;
        }

        .save-button:hover {
            background-color: #7790ff;
        }

        @media (max-width: 1000px) {
            .popup {
                height: auto;
            }

        }

        @media (max-width: 500px) {
            .popup {
                height: auto;
                width: 100vw;
            }

        }

        .accounttag {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 150px;
            width: 100%;
            border-radius: 10px;
            background-color: rgba(150, 191, 245, 0.25);
            box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.25);
            box-sizing: border-box;
            padding: 25px 0px 25px 0px;
        }

        .username1,
        .username,
        .usertype {
            color: white;
            margin: 0;
        }

        .username1 {
            display: none;
        }

        .usertype {
            font-weight: lighter;
        }

        @media (max-width: 1000px) {

            .username,
            .usertype {
                font-size: 0px;
            }

            .accounttag {
                height: auto;
                padding: 15px 0px 15px 0px;
            }

            .username1 {
                display: block;
            }

        }
    </style>

    <script>
        var headerHeight;

        function setHeight() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.menu').style.height = `calc(100vh - ${headerHeight}px - 10%)`;
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
    </script>
</head>

<body>
    <header>
        <div class="logoName">
            <img id="Logo" src="U-Vote Logo.svg" alt="Logo">
            <img id="Name" src="U-Vote Name.svg" alt="Name">
        </div>
    </header>
    <div class="bodycontainer">
        <div class="menu">
            <div class="accounttag">
                <h2 class="username1"><?php echo $firstLetterFirstName . "" . $firstLetterLastName ?></h2>
                <h2 class="username"><?php echo $FName . " " . $LName ?></h2>
                <h3 class="usertype"><?php echo $usertype ?></h3>
            </div>
            <div class="buttonContainer">
                <button onclick="switchHTML('Dashboard.php')">
                    <div><img src="dashboard.svg" alt="dashboard icon"></div>
                    <div>Dashboard</div>
                </button>
                <button id="RESULTS" onclick="switchHTML('Results.php')">
                    <div><img src="result.svg" alt="result icon"></div>
                    <div>Results</div>
                </button>
                <button id="CANDIDATES" onclick="switchHTML('Candidate.php')">
                    <div><img src="candidates.svg" alt="dashboard icon"></div>
                    <div>Candidate</div>
                </button>
                <button id="VOTERS" onclick="switchHTML('Voters.php')">
                    <div><img src="voters.svg" alt="voter icon"></div>
                    <div>Voters</div>
                </button>
                <button id="PARTYLIST" onclick="switchHTML('Partylist.php')">
                    <div><img src="partylist.svg" alt="partylist icon"></div>
                    <div>Partylist</div>
                </button>
                <button id="USERS" onclick="switchHTML('Users.php')">
                    <div><img src="user.svg" alt="user icon"></div>
                    <div>Users</div>
                </button>
                <button id="COUNCIL" onclick="switchHTML('Council.php')">
                    <div><img src="council.svg" alt="council icon"></div>
                    <div>Council</div>
                </button>
                <button id="selected">
                    <div><img src="schedule.svg" alt="calendar icon"></div>
                    <div>Voting Schedule</div>
                </button>
                <button id="LOGS" onclick="switchHTML('Logs.php')">
                    <div><img src="log.svg" alt="log icon"></div>
                    <div>Log</div>
                </button>
                <br>
                <button id="logout" class="Logoutbutton">
                    <div><img src="logout.svg" alt="log out icon"></div>
                    <div>Logout</div>
                </button>
            </div>
        </div>
        <div class="content">
            <div class="contenthead">
                <div class="titlecontainer">
                    <div>
                        <h2>Voting Schedule</h2>
                    </div>
                    <div>
                        <button id="playpause"></button>
                    </div>
                </div>
                <div class="dropdown">
                    <button id="addschedule"><img src="plus.png" alt="plus icon">Add schedule</button>
                </div>
            </div>
            <?php
            $startDate = $startTime = $endDate = $endTime = "";

            $sql = "SELECT startDate, startTime, endDate, endTime FROM voting_schedule LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Fetch the data
                $row = $result->fetch_assoc();
                $startDate = $row['startDate'];
                $startTime = $row['startTime'];
                $endDate = $row['endDate'];
                $endTime = $row['endTime'];
            } else {
                // Set default values if no schedule is found
                $startDate = $startTime = $endDate = $endTime = "";
            }

            function formatTime($date)
            {
                return $date->format('h:i A');
            }

            function formatDate($date)
            {
                return $date->format('F j, Y');
            }
            ?>

            <div class="schedulecontainer">
                <div class="realTime-container">
                    <div class="clocktitle">
                        <h3>CURRENT TIME AND DATE</h3>
                    </div>
                    <div class="timeclockcontainer">
                        <h1 id="current-time"></h1>
                        <h5 id="current-date"></h5>
                    </div>
                    <div class="clockfoot">

                    </div>
                </div>
                <div class="startendcontainer">
                    <div class="startcontainer">
                        <div class="clocktitle">
                            <h3>VOTING STARTS:</h3>
                        </div>
                        <div class="timeclockcontainer">
                            <h1 id="start-time"><?php echo !empty($startTime) ? htmlspecialchars(formatTime(new DateTime($startTime))) : ''; ?></h1>
                            <h5 id="start-date"><?php echo !empty($startDate) ? htmlspecialchars(formatDate(new DateTime($startDate))) : ''; ?></h5>
                        </div>
                        <div class="clockfoot">
                            <!-- Additional content can be added here -->
                        </div>
                    </div>
                    <div class="endcontainer">
                        <div class="clocktitle">
                            <h3>VOTING CLOSES:</h3>
                        </div>
                        <div class="timeclockcontainer">
                            <h1 id="end-time"><?php echo !empty($endTime) ? htmlspecialchars(formatTime(new DateTime($endTime))) : ''; ?></h1>
                            <h5 id="end-date"><?php echo !empty($endDate) ? htmlspecialchars(formatDate(new DateTime($endDate))) : ''; ?></h5>
                        </div>
                        <div class="clockfoot">
                            <!-- Additional content can be added here -->
                        </div>
                    </div>
                </div>
                <div class="realTime-container">
                    <div class="clocktitle">
                        <h3>TIME LEFT:</h3>
                    </div>
                    <div class="timeclockcontainer">
                        <h1 id="left-time"></h1>
                    </div>
                    <div class="clockfoot">

                    </div>
                </div>
            </div>
            <div class="buttons1">
                <button id="clearSchedule">Clear schedule</button>
                <input type="hidden" id="username" value="<?php echo $_SESSION['username']; ?>">
            </div>
        </div>
    </div>
    <div class="popup" id="popup">
        <div class="head">
            <h3>ADDING SCHEDULE</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="Starts">Voting Starts:</label>
                        <input type="date" id="StartsDate" name="startDate" class="input-form" value="<?php echo htmlspecialchars($startDate); ?>" required>
                        <br>
                        <input type="time" id="StartsTime" name="startTime" class="input-form" value="<?php echo htmlspecialchars($startTime); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Closes">Voting Closes:</label>
                        <input type="date" id="ClosesDate" name="endDate" class="input-form" value="<?php echo htmlspecialchars($endDate); ?>" required>
                        <br>
                        <input type="time" id="ClosesTime" name="endTime" class="input-form" value="<?php echo htmlspecialchars($endTime); ?>" required>
                    </div>
                    <br>
                    <div class="buttons">
                        <button type="button" class="cancel-button">Cancel</button>
                        <button type="submit" class="save-button" name="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    // Check if form is submitted
    if (isset($_POST['save'])) {
        // Retrieve data from form
        $startDate = $_POST['startDate'];
        $startTime = $_POST['startTime'];
        $endDate = $_POST['endDate'];
        $endTime = $_POST['endTime'];

        // Convert date and time to DateTime objects for comparison
        $startDateTime = new DateTime("$startDate $startTime");
        $endDateTime = new DateTime("$endDate $endTime");

        // Validate that start date and time are before end date and time
        if ($startDateTime < $endDateTime) {
            // SQL statement to truncate the table
            $sqlClear = "TRUNCATE TABLE voting_schedule";

            // Execute the statement and check if the truncation was successful
            if ($conn->query($sqlClear) === TRUE) {
                // Prepare SQL statement to insert data into voting_schedule
                $sql = "INSERT INTO voting_schedule (startDate, startTime, endDate, endTime) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $startDate, $startTime, $endDate, $endTime);

                // Execute the statement and check if the insertion was successful
                if ($stmt->execute()) {
                    // Log the login activity
                    $usepID = $_SESSION["usep_ID"];
                    $logAction = 'Added/Edited Schedule';
                    date_default_timezone_set('Asia/Manila');
                    $date = date("Y-m-d");
                    $time = date("H:i:s");
                    $sqlInsertLog = "INSERT INTO activity_logs (usep_ID, logs_date, logs_time, logs_action) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sqlInsertLog);
                    if ($stmt) {
                        $stmt->bind_param("ssss", $usepID, $date, $time, $logAction);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        echo "Error preparing statement: " . $conn->error;
                        exit();
                    }
                    echo "<script>alert('Voting schedule saved successfully');</script>";
                    echo "<script>window.location.href = 'Schedule.php';</script>";
                } else {
                    echo "<script>alert('Error saving voting schedule: " . $conn->error . "');</script>";
                    echo "<script>window.location.href = 'Schedule.php';</script>";
                }

                // Close the statement
                $stmt->close();
            } else {
                echo "<script>alert('Error updating voting schedule: " . $conn->error . "');</script>";
                echo "<script>window.location.href = 'Schedule.php';</script>";
            }
        } else {
            echo "<script>alert('Start date and time must be before end date and time.');</script>";
            echo "<script>window.location.href = 'Schedule.php';</script>";
        }
    }

    // Close the connection
    $conn->close();
    ?>


    <div id="logoutpop" class="popup">
        <div class="head">
            <h3>LOGOUT</h3>
        </div>
        <div class="popup-content">
            <form method="post">
                <div class="popup-content-inner">
                    <div style="text-align: center;">
                        <p>Are you sure you want to logout?</p>
                    </div>
                    <br>
                    <button type="button" class="cancel-button">Cancel</button>
                    <button type="submit" class="save-button" name="logout">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('clearSchedule').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Enter Password',
                        input: 'password',
                        inputLabel: 'Password',
                        inputPlaceholder: 'Enter your password',
                        inputAttributes: {
                            maxlength: 100,
                            autocapitalize: 'off',
                            autocorrect: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Submit'
                    }).then((passwordResult) => {
                        if (passwordResult.isConfirmed) {
                            // Get the username from a hidden field or another source
                            const username = document.getElementById('username').value;

                            // Send AJAX request to clear schedule
                            fetch('clear_schedule.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        username: username,
                                        password: passwordResult.value
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: data.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            window.location.href = 'Schedule.php';
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: data.message,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                })
                                .catch(error => {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'An unexpected error occurred.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                });
                        }
                    });
                }
            });
        });
    </script>
    <script>
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

        setInterval(() => {
            updateTime();
        }, 1000);

        function updateTime() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("current-time").innerHTML = response.time;
                    document.getElementById("current-date").innerHTML = response.date;
                }
            };
            xhr.open("GET", "get_time.php", true);
            xhr.send();
        }

        /*log out*/
        document.getElementById("logout").addEventListener("click", function() {
            document.getElementById("logoutpop").style.display = "flex";
        });

        document.querySelector("#logoutpop .save-button").addEventListener("click", function() {
            switchHTML('indexAdmin.php');
        });

        document.querySelector("#logoutpop .cancel-button").addEventListener("click", function() {
            document.getElementById("logoutpop").style.display = "none";
        });

        /*pop up*/
        document.getElementById("addschedule").addEventListener("click", function() {
            document.getElementById("popup").style.display = "flex";
        });

        document.querySelector(".save-button").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
        });

        document.querySelector(".cancel-button").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
        });

        document.addEventListener("DOMContentLoaded", function() {
            const startsDateInput = document.getElementById('StartsDate');
            const startsTimeInput = document.getElementById('StartsTime');
            const closesDateInput = document.getElementById('ClosesDate');
            const closesTimeInput = document.getElementById('ClosesTime');
            const playPauseButton = document.getElementById('playpause');

            const startTimeContainer = document.getElementById('start-time');
            const startDateContainer = document.getElementById('start-date');
            const endTimeContainer = document.getElementById('end-time');
            const endDateContainer = document.getElementById('end-date');
            const timeLeftContainer = document.getElementById('left-time');
            const dateLeftContainer = document.getElementById('left-date');

            function formatTime(date) {
                if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
                    return "";
                }
                const hours = date.getHours();
                const minutes = date.getMinutes();
                const ampm = hours >= 12 ? 'PM' : 'AM';
                const formattedHours = (hours % 12 || 12).toString().padStart(2, '0');
                const formattedMinutes = minutes.toString().padStart(2, '0');
                return `${formattedHours}:${formattedMinutes} ${ampm}`;
            }

            function formatDate(date) {
                if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
                    return "";
                }
                const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE",
                    "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"
                ];
                const month = monthNames[date.getMonth()];
                const day = date.getDate();
                const year = date.getFullYear();
                return `${month} ${day}, ${year}`;
            }

            function validateClosesDateTime() {
                const startDate = new Date("<?php echo $startDate . ' ' . $startTime; ?>");
                const endDate = new Date("<?php echo $endDate . ' ' . $endTime; ?>");

                return endDate > startDate;
            }

            function updateTimeLeft() {
                const addscheduleButton = document.getElementById('addschedule');
                const currentDate = new Date();
                const startDate = new Date("<?php echo $startDate . ' ' . $startTime; ?>");
                const endDate = new Date("<?php echo $endDate . ' ' . $endTime; ?>");

                // Check if current time is within the voting period
                if (currentDate > startDate && currentDate < endDate) {
                    const timeLeft = endDate - currentDate;
                    if (timeLeft > 0) {
                        const daysLeft = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hoursLeft = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutesLeft = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const secondsLeft = Math.floor((timeLeft % (1000 * 60)) / 1000);
                        timeLeftContainer.textContent = `${daysLeft}d ${hoursLeft}h ${minutesLeft}m ${secondsLeft}s`;
                        playPauseButton.textContent = "Ongoing";
                        playPauseButton.style.backgroundColor = "green";
                        addscheduleButton.innerHTML = '<img src="edit2.png" alt="edit icon"> Edit Schedule';
                        addscheduleButton.style.backgroundColor = 'green';
                        addscheduleButton.style.color = 'white';
                    } else {
                        timeLeftContainer.textContent = "Voting Closed.";
                        playPauseButton.textContent = "Closed";
                        playPauseButton.style.backgroundColor = "red";
                        addscheduleButton.textContent = 'Add Schedule';
                        addscheduleButton.style.backgroundColor = '';
                        addscheduleButton.style.color = '';
                    }
                } else if (currentDate < startDate) {
                    timeLeftContainer.textContent = "Voting not started yet.";
                    playPauseButton.textContent = "Not Started";
                    playPauseButton.style.backgroundColor = "gray";
                    addscheduleButton.innerHTML = '<img src="edit2.png" alt="edit icon"> Edit Schedule';
                    addscheduleButton.style.backgroundColor = 'green';
                    addscheduleButton.style.color = 'white';
                } else if (currentDate > endDate) {
                    // The voting period has ended
                    timeLeftContainer.textContent = "Voting Closed.";
                    playPauseButton.textContent = "Closed";
                    playPauseButton.style.backgroundColor = "red";
                } else {
                    timeLeftContainer.textContent = "Voting not started yet.";
                    playPauseButton.textContent = "No Schedule Added";
                    playPauseButton.style.backgroundColor = "gray";
                }
            }

            // Update time left every second
            setInterval(updateTimeLeft, 1000);

            // Initial update
            updateStartEnd();
        });

        // Send heartbeat every 5 minutes
        setInterval(function() {
            fetch('heartbeat.php', {
                method: 'POST',
                credentials: 'same-origin'
            });
        }, 300000); // 300000 ms = 5 minutes
    </script>


</body>

</html>
<?php

if ($usertype === 'Admin-Front') {
    echo "<script>document.getElementById('RESULTS').style.display = 'none';</script>";
    echo "<script>document.getElementById('USERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('addschedule').style.display = 'none';</script>";
    echo "<script>document.getElementById('clearSchedule').style.display = 'none';</script>";
    echo "<script>document.getElementById('LOGS').style.display = 'none';</script>";
} else if ($usertype === 'Admin-Technical') {
    echo "<script>document.getElementById('CANDIDATES').style.display = 'none';</script>";
    echo "<script>document.getElementById('VOTERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('PARTYLIST').style.display = 'none';</script>";
    echo "<script>document.getElementById('USERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('COUNCIL').style.display = 'none';</script>";
    echo "<script>document.getElementById('addschedule').style.display = 'none';</script>";
    echo "<script>document.getElementById('clearSchedule').style.display = 'none';</script>";
} else if ($usertype === 'Watcher') {
    echo "<script>document.getElementById('CANDIDATES').style.display = 'none';</script>";
    echo "<script>document.getElementById('VOTERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('PARTYLIST').style.display = 'none';</script>";
    echo "<script>document.getElementById('USERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('COUNCIL').style.display = 'none';</script>";
    echo "<script>document.getElementById('addschedule').style.display = 'none';</script>";
    echo "<script>document.getElementById('clearSchedule').style.display = 'none';</script>";
    echo "<script>document.getElementById('LOGS').style.display = 'none';</script>";
}

?>