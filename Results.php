<?php
include "DBSession.php";

$usertype = $_SESSION['usertype'];
$username = $_SESSION['username'];

$sql = "SELECT Fname, LName FROM users WHERE username = ? AND usertype = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $usertype);
$stmt->execute();
$stmt->bind_result($Fname, $LName);
$stmt->fetch();
$stmt->close();
$firstLetterFirstName = substr($Fname, 0, 1);
$firstLetterLastName = substr($LName, 0, 1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>U-Vote Admin | Results</title>
    <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
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

        #selected,
        .buttonContainer button:hover {
            background-color: rgb(66, 165, 245, 0.5);
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

            .dropdown select,
            table,
            .content button,
            h2 {
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

            .dropdown select,
            .content button,
            h2,
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
        }

        .titlecontainer {
            display: flex;
            width: auto;
            height: auto;
            color: white;
            align-items: center;
            gap: 20px;
        }

        .yellowBG {
            display: flex;
            height: 40px;
            background-color: #F6C90E;
            /* Same background color as the select */
            color: #222E50;
            border: none;
            border-radius: 5px;
            align-items: center;
            padding: 0 10px;
            width: auto;
            max-width: 200px;
        }

        .dropdown {
            display: flex;
            justify-content: right;
            align-items: center;
        }

        .tableandnav {
            width: 100%;
            overflow: hidden;
        }

        .navTable {
            display: flex;
            width: 100%;
            height: auto;
            color: white;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin: 10px 0px;
        }

        .prevcontainer {
            display: flex;
            width: 100%;
            justify-content: left;
            align-items: center;
        }

        .nextcontainer {
            display: flex;
            width: 100%;
            justify-content: right;
            align-items: center;
        }

        .bottomcontent {
            display: flex;
            width: 100%;
            height: auto;
            color: white;
            justify-content: right;
            align-items: center;
            gap: 20px;
            margin: 10px 0px;
        }

        .tablecontainer {
            width: 100%;
            height: auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 600px;
            height: auto;
            border-spacing: 0 7px;
        }

        th {
            background: linear-gradient(to bottom, #28579E, #222E50);
            height: 63px;
        }

        .trheader {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.30);
            border-top-right-radius: 12px;
            border-top-left-radius: 12px;
        }

        .data-row.hidden {
            display: none;
        }

        .thfirst {
            border-top-left-radius: 12px;
        }

        .thlast {
            border-top-right-radius: 12px;
        }

        td {
            background-color: rgba(150, 191, 245, 0.25);
            height: 63px;
            text-align: center;
            align-items: center;
        }

        .tdfirst {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .tdlast {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .tdlast img {
            margin: 10px 10px;
        }

        /* Adjust column widths */
        th:nth-child(1),
        td:nth-child(1) {
            width: 20%;
            /* Adjust width of the first column */
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 20%;
            /* Adjust width of the second column */
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 20%;
            /* Adjust width of the third column */
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 20%;
            /* Adjust width of the third column */
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 20%;
            /* Adjust width of the third column */
        }

        .trheadergap {
            height: 8px;
        }

        select {
            height: 40px;
            width: 100%;
            max-width: 200px;
            font-size: 20px;
            font-weight: bold;
            background-color: #F6C90E;
            color: #222E50;
            border-radius: 5px;
            border: none;
            padding: 5px 40px 5px 20px;
            /* Increased padding to accommodate the larger dropdown symbol */
            cursor: pointer;
            background-image: url('arrow-down.png');
            /* Replace 'path_to_your_arrow_image.png' with the path to your custom dropdown symbol */
            background-repeat: no-repeat;
            background-position: right 10px center;
            /* Adjusted position of the dropdown symbol */
            /* Hide the default dropdown arrow */
            -webkit-appearance: none;
            /* Safari and Chrome */
            -moz-appearance: none;
            /* Firefox */
            appearance: none;
            /* All other browsers */
        }

        .content button {
            display: flex;
            height: 40px;
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

        .popup-content-inner {
            display: grid;
            height: auto;
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

        #exportpop .popup-content .save-button {
            color: black;
            background-color: #F6C90E;
        }

        #exportpop .popup-content .save-button:hover {
            color: black;
            background-color: #ffe270;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <div class="searchspace">
            <div class="searchicon">
                <img src="search.png" alt="search icon">
                <input type="text" id="searchInput" placeholder="Search" alt="Search" onchange="searchTable()">
            </div>
        </div>
    </header>
    <div class="bodycontainer">
        <div class="menu">
            <div class="accounttag">
                <h2 class="username1"><?php echo $firstLetterFirstName . "" . $firstLetterLastName ?></h2>
                <h2 class="username"><?php echo $Fname . " " . $LName ?></h2>
                <h3 class="usertype"><?php echo $usertype ?></h3>
            </div>
            <div class="buttonContainer">
                <button onclick="switchHTML('Dashboard.php')">
                    <div><img src="dashboard.svg" alt="dashboard icon"></div>
                    <div>Dashboard</div>
                </button>
                <button id="selected">
                    <div><img src="result.svg" alt="result icon"></div>
                    <div>Results</div>
                </button>
                <button id="CANDIDATES" onclick="switchHTML('Candidate.php')">
                    <div><img src="candidates.svg" alt="candidate icon"></div>
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
                <button id="SCHEDULE" onclick="switchHTML('Schedule.php')">
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
                <div>
                    <h2>Results</h2>
                </div>
                <div class="dropdown">
                    <select name="council" id="Council">
                        <option value="TSC">TSC</option>
                        <option value="SABES">SABES</option>
                        <option value="OFEE">OFEE</option>
                        <option value="AECES">AECES</option>
                        <option value="OFSET">OFSET</option>
                        <option value="AFSET">AFSET</option>
                        <option value="SITS">SITS</option>
                        <option value="FTVETTS">FTVETTS</option>
                    </select>
                </div>
            </div>
            <div class="tableandnav">
                <div class="tablecontainer">
                    <table id="Results">
                        <tr class='trheader'>
                            <th class='thfirst'>NAME</th>
                            <th>POSITION</th>
                            <th class='thlast'>NO. OF VOTES</th>
                        </tr>
                        <?php
                        // Query to retrieve all data from the table
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

                        $result = $conn->query($sql);

                        $allData = [];
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                $allData[] = $row;
                        ?>
                                <tr>
                                    <td class='tdfirst'><?php echo $row["Pname"] ?></td>
                                    <td><?php echo $row["position"] ?></td>
                                    <td class='tdlast'><?php echo $row["votes"] ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <div class="navTable">
                    <div class="prevcontainer">
                        <button id="prevButton" onclick="navigateRows(-1)">Previous</button>
                    </div>
                    <div class="nextcontainer">
                        <button id="nextButton" onclick="navigateRows(1)">Next</button>
                    </div>
                </div>
                <div class="bottomcontent">
                    <div class="prevcontainer">

                    </div>
                    <div class="nextcontainer">
                        <button onclick="exportAllDataToExcel()" id="export" type="button">Export</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="exportpop" class="popup">
        <div class="head">
            <h3>EXPORTED SUCCESSFULLY</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <div style="text-align: center;">
                    <p>The result successfully exported!</p>
                </div>
                <br>
                <button class="save-button">Okay</button>
            </div>
        </div>
    </div>
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
        var allData = <?php echo json_encode($allData); ?>;
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

        function searchTable() {
            // Get the input value and convert to uppercase for case-insensitive search
            let input = document.getElementById('searchInput').value.toUpperCase();
            // Get the table
            let table = document.getElementById('Results');
            // Get all the rows in the table
            let tr = table.getElementsByTagName('tr');

            // Loop through all table rows, starting from the second row (index 1)
            for (let i = 1; i < tr.length; i++) {
                let tds = tr[i].getElementsByTagName('td');
                let matchFound = false;

                // Loop through all cells in the row
                for (let j = 0; j < tds.length; j++) {
                    if (tds[j]) {
                        // Get the text content of the cell
                        let txtValue = tds[j].textContent || tds[j].innerText;
                        // Check if the text content matches the input value
                        if (txtValue.toUpperCase().indexOf(input) > -1) {
                            matchFound = true;
                            break;
                        }
                    }
                }

                // Display the row if a match is found, else hide it
                if (matchFound) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }

            if(input===""){
                navigateRows(-1);
            }
        }


        // JavaScript code for navigation
        var currentPage = 0;
        var rowsPerPage = 10; // Change this value as needed

        function showPage(page) {
            var table = document.getElementById('Results');
            var rows = table.rows;

            // Calculate the start and end indices of the rows to display
            var startIndex = page * rowsPerPage + 1; // Skip header row
            var endIndex = Math.min(startIndex + rowsPerPage, rows.length);

            // Hide all rows
            for (var i = 1; i < rows.length; i++) {
                rows[i].style.display = 'none';
            }

            // Show rows for the current page
            for (var i = startIndex; i < endIndex; i++) {
                rows[i].style.display = '';
            }
        }

        function navigateRows(direction) {
            currentPage += direction;
            var table = document.getElementById('Results');
            var maxPage = Math.ceil((table.rows.length - 1) / rowsPerPage);

            // Check if currentPage is within bounds
            if (currentPage < 0) {
                currentPage = 0;
            } else if (currentPage >= maxPage) {
                currentPage = maxPage - 1;
            }

            showPage(currentPage);

        }

        // Show the initial page
        showPage(currentPage);

        $(document).ready(function() {
            $('#Council').change(function() {
                var selectedCouncil = $(this).val();
                $.post('fetch_results.php', {
                    council: selectedCouncil
                }, function(response) {
                    var parsedResponse = JSON.parse(response);
                    allData = parsedResponse.allData; // Update allData with the new data

                    // Update the #Results element with the HTML table rows
                    $('#Results').html(parsedResponse.output);

                    currentPage = 0; // Reset to the first page
                    showPage(currentPage); // Call the pagination function after updating results
                });
            });

            var currentPage = 0;
            var rowsPerPage = 10; // Change this value as needed

            function showPage(page) {
                var table = document.getElementById('Results');
                var rows = table.rows;

                // Calculate the start and end indices of the rows to display
                var startIndex = page * rowsPerPage + 1; // Skip header row
                var endIndex = Math.min(startIndex + rowsPerPage, rows.length);

                // Hide all rows
                for (var i = 1; i < rows.length; i++) {
                    rows[i].style.display = 'none';
                }

                // Show rows for the current page
                for (var i = startIndex; i < endIndex; i++) {
                    rows[i].style.display = '';
                }
            }

            function navigateRows(direction) {
                currentPage += direction;
                var table = document.getElementById('Results');
                var maxPage = Math.ceil((table.rows.length - 1) / rowsPerPage);

                // Check if currentPage is within bounds
                if (currentPage < 0) {
                    currentPage = 0;
                } else if (currentPage >= maxPage) {
                    currentPage = maxPage - 1;
                }

                showPage(currentPage);



            }
        });

        function exportAllDataToExcel() {
            var tableHTML = '<table><thead><tr><th>NAME</th><th>POSITION</th><th>NO. OF VOTES</th></tr></thead><tbody>';
            allData.forEach(function(row) {
                tableHTML += '<tr>';
                tableHTML += '<td>' + row.Pname + '</td>';
                tableHTML += '<td>' + row.position + '</td>';
                tableHTML += '<td>' + row.votes + '</td>';
                tableHTML += '</tr>';
            });
            tableHTML += '</tbody></table>';

            var downloadLink;
            var dataType = 'application/vnd.ms-excel';

            // Get current date and time
            var currentDate = new Date();
            var date = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1).toString().padStart(2, '0') + "-" + currentDate.getDate().toString().padStart(2, '0');
            var time = currentDate.getHours().toString().padStart(2, '0') + "-" + currentDate.getMinutes().toString().padStart(2, '0') + "-" + currentDate.getSeconds().toString().padStart(2, '0');

            var filenameInput = document.getElementById("Council").value;
            var filename = filenameInput ? filenameInput + ' results ' + date + ' ' + time + '.xls' : 'tableData ' + date + ' ' + time + '.xls';

            downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
                document.getElementById("exportpop").style.display = "flex";
            } else {
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                downloadLink.download = filename;
                downloadLink.click();
                document.getElementById("exportpop").style.display = "flex";
            }

            // Log the export activity
            $.post('log_export.php', { council: filenameInput }, function(response) {
                var parsedResponse = JSON.parse(response);
                if (parsedResponse.status !== "success") {
                    console.error("Logging export activity failed: " + parsedResponse.message);
                }
            });
        }


        document.querySelector("#exportpop .save-button").addEventListener("click", function() {
            document.getElementById("exportpop").style.display = "none";
        });

        /*log out*/
        document.getElementById("logout").addEventListener("click", function() {
            document.getElementById("logoutpop").style.display = "flex";
        });

        document.querySelector("#logoutpop .cancel-button").addEventListener("click", function() {
            document.getElementById("logoutpop").style.display = "none";
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
    echo "<script>document.getElementById('SCHEDULE').style.display = 'none';</script>";
    echo "<script>document.getElementById('LOGS').style.display = 'none';</script>";
} else if ($usertype === 'Admin-Technical') {
    echo "<script>document.getElementById('CANDIDATES').style.display = 'none';</script>";
    echo "<script>document.getElementById('VOTERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('PARTYLIST').style.display = 'none';</script>";
    echo "<script>document.getElementById('USERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('COUNCIL').style.display = 'none';</script>";
}

?>