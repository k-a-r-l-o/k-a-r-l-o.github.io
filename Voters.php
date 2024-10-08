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
    <title>U-Vote Admin | Voters</title>
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
            .dropdown {
                flex-direction: column;
                justify-self: right;
            }

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
            .contenthead select,
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

            .content button,
            h2,
            .contenthead select,
            .yellowBG {
                scale: 0.8;
            }

        }

        @media (max-width: 500px) {

            #add,
            #importbutton {
                font-size: 0;
                padding: 10px;
                width: auto;
                gap: 0;
            }

            #add img,
            #importbutton img {
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
            grid-template-rows: .5fr .5fr 5fr;
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

        #importbutton {
            background-color: white;
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
            gap: 5%;

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
            justify-content: right;
            align-items: center;
            margin: 10px 0px;
        }

        .pageIndicator {
            display: flex;
            max-width: 100%;
            height: 70px;
            align-items: center;
            margin: 0 10px;
            padding: 0 10px;
            overflow-y: auto;
        }

        .pageIndicator span {
            margin: 0 5px;
            padding: 10px 15px;
            box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.25);
            border-radius: 5px;
            background-color: transparent;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .pageIndicator span:hover {
            background-color: rgb(66, 165, 245, 0.25);
        }

        .pageIndicator .active {
            background-color: rgb(66, 165, 245, 0.5);
            padding: 10px 25px;
            color: white;
        }

        .tablecontainer {
            width: 100%;
            height: auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1000px;
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
            font-size: 20px;
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

        select:focus {
            outline: none;
        }

        .contenthead select {
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

        p {
            font-size: 20px;
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


        /*pop up*/
        .popup {
            color: white;
            display: none;
            flex-direction: column;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #222E50;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
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
            overflow: scroll;
            padding: 5%;
            box-sizing: border-box;
        }

        #logoutpop .popup-content,
        #deletepop .popup-content {
            overflow: auto;
        }

        .popup-content-inner,
        .buttons {
            display: grid;
            height: auto;
            gap: 10px;
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

        .input-form::placeholder {
            color: inherit;
        }

        select option {
            width: 100%;
            padding: 1% 1%;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            color: black;
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

        #deletepop .popup-content .save-button {
            color: white;
            background-color: #F34235;
        }

        #deletepop .popup-content .save-button:hover {
            color: white;
            background-color: #ff746a;
        }

        #editpop .popup-content .save-button {
            color: black;
            background-color: #F6C90E;
        }

        #editpop .popup-content .save-button:hover {
            color: black;
            background-color: #ffe47a;
        }

        @media (max-width: 1000px) {

            #editpop,
            #popup,
            #viewpop {
                height: 80vh;
            }

        }

        @media (max-width: 500px) {
            .popup {
                width: 100vw;
            }

            #deletepop {
                height: auto;
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
    <script>
        // Save the selected value to session storage and apply the filter
        function saveSelectionAndFilter(selectId) {
            const selectElement = document.getElementById(selectId);
            sessionStorage.setItem(selectId + "Selected", selectElement.value);
            filterVoters(); // Apply the filter without reloading the page
        }

        // Load the selected value from session storage
        function loadSelection(selectId) {
            const savedValue = sessionStorage.getItem(selectId + "Selected");
            if (savedValue) {
                document.getElementById(selectId).value = savedValue;
            }
        }

        // Filter voters function
        function filterVoters() {
            var status = document.getElementById("Status").value;
            var program = document.getElementById("Tprogram").value;
            var year = document.getElementById("Tyear").value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "filter_voters.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    document.getElementById("Results").innerHTML = this.responseText;
                    currentPage = 0; // Reset to the first page
                    showPage(currentPage); // Call the pagination function after updating results
                }
            };
            xhr.send("status=" + status + "&program=" + program + "&year=" + year);
        }

        // Event listener to save the selection and apply the filter when it changes
        document.addEventListener("DOMContentLoaded", function() {
            // For Status select
            const statusSelect = document.getElementById("Status");
            statusSelect.addEventListener("change", function() {
                saveSelectionAndFilter("Status");
            });

            // For Tprogram select
            const tprogramSelect = document.getElementById("Tprogram");
            tprogramSelect.addEventListener("change", function() {
                saveSelectionAndFilter("Tprogram");
            });

            // For Tyear select
            const tyearSelect = document.getElementById("Tyear");
            tyearSelect.addEventListener("change", function() {
                saveSelectionAndFilter("Tyear");
            });

            // Load the selections and apply the filter when the page loads
            loadSelection("Status");
            loadSelection("Tprogram");
            loadSelection("Tyear");
            filterVoters();
        });
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
                    <div><img src="candidates.svg" alt="candidate icon"></div>
                    <div>Candidate</div>
                </button>
                <button id="selected">
                    <div><img src="voters.svg" alt="dashboard icon"></div>
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
                <div class="titlecontainer">
                    <div>
                        <h2>Total Voters</h2>
                    </div>
                    <div class="yellowBG">
                        <?php
                        $resultVotes = $conn->query("SELECT COUNT(*) as totvot FROM voters");
                        $rowVotes = $resultVotes->fetch_assoc();
                        $totvot = $rowVotes['totvot'];
                        ?>
                        <h2><?php echo $totvot ?></h2>
                    </div>
                </div>
                <div class="dropdown">
                    <button id="importbutton"><img src="plus.png" alt="plus icon">Import</button>
                    <button id="add"><img src="plus.png" alt="plus icon">Add new</button>
                </div>
            </div>
            <div class="contenthead">
                <div class="titlecontainer">
                    <div>
                        <h3>Sort by:</h3>
                    </div>
                </div>
                <div class="dropdown">
                    <select name="Status" id="Status">
                        <option value="">All Voters</option>
                        <option value="Not Voted">Not Yet Voted</option>
                        <option value="Verifying">OTP Verifying</option>
                        <option value="Voting">Voting</option>
                        <option value="Voted">Voted</option>

                    </select>
                    <select id="Tyear" name="Tyear">
                        <option value="">All Year Level</option>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                        <option value="5th Year">5th Year</option>
                    </select>
                    <select id="Tprogram" name="Tprogram">
                        <option value="">All Program</option>
                        <?php

                        // Query to fetch programs
                        $query1 = "SELECT * FROM programs";
                        $result = $conn->query($query1);

                        // Check if the query returned any results
                        if ($result->num_rows > 0) {
                            // Fetch each row and create an option element
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['Program'] . '">' . $row['Program'] . "</option>";
                            }
                        } else {
                            // No programs found
                            echo '<option value="">No programs available</option>';
                        }

                        ?>
                    </select>
                </div>
            </div>
            <div class="tableandnav">
                <div class="tablecontainer">
                    <table id="Results">
                        <tr class="trheader">
                            <th class="thfirst">USEP ID</th>
                            <th>NAME</th>
                            <th>YEAR LEVEL</th>
                            <th>PROGRAM</th>
                            <th class="thlast"></th>
                        </tr>
                        <!-- initialized below by filter voters -->
                    </table>
                </div>
                <div class="navTable">
                    <div class="prevcontainer">
                        <button id="prevButton" onclick="navigateRows(-1)">Prev</button>
                    </div>
                    <div class="pageIndicator" id="pageNumbers">
                        <!-- Page numbers will be dynamically generated here -->
                    </div>
                    <div class="nextcontainer">
                        <button id="nextButton" onclick="navigateRows(1)">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup" id="popup">
        <div class="head">
            <h3>ADD VOTER</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form method="post">
                    <div class="form-group">
                        <label for="usepID">USeP ID:</label>
                        <input type="text" id="usepID1" name="usepID" class="input-form" maxlength="10" onchange="validateUsepID(this)">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" id="Email1" name="Email" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="FName">First Name:</label>
                        <input type="text" id="FName1" name="FName" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="LName">Last Name:</label>
                        <input type="text" id="LName1" name="LName" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select id="gender1" class="input-form" name="gender" required>
                            <option value="" disabled selected hidden>Select here</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="yearLevel">Year Level:</label>
                        <select id="yearlevel1" class="input-form" name="YearLvl" required>
                            <option value="" disabled selected hidden>Select here</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                            <option value="5th Year">5th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="program">Program:</label>
                        <select id="program" name="program" class="input-form">
                            <option value="" disabled selected hidden>Select here</option>
                            <?php

                            // Query to fetch programs
                            $query1 = "SELECT * FROM programs";
                            $result = $conn->query($query1);

                            // Check if the query returned any results
                            if ($result->num_rows > 0) {
                                // Fetch each row and create an option element
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['Program'] . '">' . $row['Program'] . "</option>";
                                }
                            } else {
                                // No programs found
                                echo '<option value="">No programs available</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="major">Major:</label>
                        <select id="major" name="major" class="input-form" required>
                            <option value="" disabled selected hidden>Select here</option>
                            <option value="English">English</option>
                            <option value="Filipino">Filipino</option>
                            <option value="Math">Math</option>
                            <option value="None">None of the Above</option>
                        </select>
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
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['save'])) {

            // Get the user input
            $input_usep_ID = $_POST["usepID"];

            // Remove any dashes from the input
            $clean_usep_ID = str_replace('-', '', $input_usep_ID);

            // Retrieve data from form
            $usepID = $clean_usep_ID;

            $sqlsearch = "SELECT * FROM voters WHERE usep_ID = '$usepID'";
            $result = $conn->query($sqlsearch);

            if ($result->num_rows > 0) {
                echo "<script>alert('Voter already exists!');</script>";
            } else {

                // Get the user input
                $input_usep_ID = $_POST["usepID"];

                // Remove any dashes from the input
                $clean_usep_ID = str_replace('-', '', $input_usep_ID);

                // Retrieve data from form
                $usepID = $clean_usep_ID;
                $email = $_POST['Email'];
                $lname = $_POST['LName'];
                $fname = $_POST['FName'];
                $gender = $_POST['gender'];
                $yearlvl = $_POST['YearLvl'];
                $Program = $_POST['program'];
                $major = $_POST['major'];
                $voted = 'Not Voted';

                // Insert data into Users table
                $sqlVoterInsert = "INSERT INTO voters (usep_ID, Email, LName, FName, gender, yearLvl, program, major, voted ) 
                                VALUES ('$usepID', '$email', '$lname', '$fname', '$gender', '$yearlvl','$Program' ,'$major' ,'$voted')";

                if ($conn->query($sqlVoterInsert) === TRUE) {
                    // Log the login activity
                    $usepID = $_SESSION["usep_ID"];
                    $logAction = 'Added Voter';
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
                    echo "<script>alert('New record created successfully');</script>";
                    echo "<script>window.location.href = 'Voters.php';</script>";
                } else {
                    echo "<script>alert('Error: " .   $sqlVoterInsert . "<br>" . $conn->error . "');</script>";
                    echo "<script>window.location.href = 'Voters.php';</script>";
                }
            }
        }
    }
    ?>
    <div class="popup" id="importpop">
        <div class="head">
            <h3>IMPORT VOTERS</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Choose CSV file:</label>
                        <input type="file" id="file" name="file" accept=".csv" class="input-form" required>
                    </div>
                    <br>
                    <div class="buttons">
                        <button type="button" class="cancel-button">Cancel</button>
                        <button type="submit" class="save-button" name="import">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST["import"])) {
        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $fileName = $_FILES["file"]["tmp_name"];

            // Check file MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $fileName);
            finfo_close($finfo);

            if ($mime !== 'text/csv' && $mime !== 'text/plain') {
                echo "<script>alert('Invalid File: Please upload a CSV file.');</script>";
                echo "<script>window.location.href = 'Voters.php';</script>";
                exit();
            }

            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($fileName, "r");

                // Skip the first row if it contains headers
                fgetcsv($file);

                while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                    // Get the user input
                    $input_usep_ID = mysqli_real_escape_string($conn, $column[0]);
                    // Remove any dashes from the input
                    $clean_usep_ID = str_replace('-', '', $input_usep_ID);
                    // Retrieve data from
                    $usepID = $clean_usep_ID;
                    $email = mysqli_real_escape_string($conn, $column[1]);
                    $lname = mysqli_real_escape_string($conn, $column[2]);
                    $fname = mysqli_real_escape_string($conn, $column[3]);
                    $gender = mysqli_real_escape_string($conn, $column[4]);
                    $yearlvl = mysqli_real_escape_string($conn, $column[5]);
                    $program = mysqli_real_escape_string($conn, $column[6]);
                    $major = mysqli_real_escape_string($conn, $column[7]);
                    $voted = 'Not Voted';

                    // Check if voter already exists
                    $sqlsearch = "SELECT * FROM voters WHERE usep_ID = '$usepID'";
                    $result = $conn->query($sqlsearch);

                    if ($result->num_rows == 0) {
                        // Insert data into Voters table
                        $sqlVoterInsert = "INSERT INTO voters (usep_ID, Email, LName, FName, gender, yearLvl, program, major, voted ) 
                                VALUES ('$usepID', '$email', '$lname', '$fname', '$gender', '$yearlvl', '$program' ,'$major' ,'$voted')";

                        if ($conn->query($sqlVoterInsert) === TRUE) {
                            echo "New record created successfully for $usepID<br>";
                        } else {
                            echo "Error: " . $sqlVoterInsert . "<br>" . $conn->error . "<br>";
                        }
                    } else {
                        echo "Voter with USeP ID $usepID already exists!<br>";
                    }
                }

                // Log the login activity
                $usepID = $_SESSION["usep_ID"];
                $logAction = 'Imported Voters';
                $sqlInsertLog = "INSERT INTO activity_logs (usep_ID, logs_date, logs_time, logs_action) VALUES (?, CURRENT_DATE, CURRENT_TIME, ?)";
                $stmt = $conn->prepare($sqlInsertLog);
                if ($stmt) {
                    $stmt->bind_param("is", $usepID, $logAction);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $conn->error;
                    exit();
                }
                fclose($file);
                echo "<script>alert('CSV File has been successfully imported.');</script>";
                echo "<script>window.location.href = 'Voters.php';</script>";
            } else {
                echo "<script>alert('Invalid File: Please upload a CSV file.');</script>";
                echo "<script>window.location.href = 'Voters.php';</script>";
            }
        } else {
            echo "<script>alert('File upload failed. Please try again.');</script>";
            echo "<script>window.location.href = 'Voters.php';</script>";
        }
    }

    ?>




    <div class="popup" id="viewpop">
        <div class="head">
            <h3>VOTER INFORMATION</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form>
                    <div class="form-group">
                        <label for="usepID2">USeP ID:</label>
                        <input type="text" id="usepID2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" id="Email2" name="Email2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fullName2">Full Name:</label>
                        <input type="text" id="fullName2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="gender2">Gender:</label>
                        <input id="gender2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="yearLevel">Year Level:</label>
                        <input id="yearlevel2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="program2">Program:</label>
                        <input id="program2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="major2">Major:</label>
                        <input id="major2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="voted2">Vote Status:</label>
                        <input type="text" id="voted2" class="input-form" readonly>
                    </div>
                </form>
                <br>
                <button type="button" class="save-button" onclick="closeViewpop()">Back</button>
            </div>
        </div>
    </div>
    <div class="popup" id="editpop">
        <div class="head">
            <h3>EDIT VOTER</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form method="post">
                    <div class="form-group">
                        <label for="usepID3">USeP ID(readonly):</label>
                        <input type="text" id="usepID3" name="usepID3" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Email3">Email:</label>
                        <input type="email" id="Email3" name="Email3" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="FName3">First Name:</label>
                        <input type="text" id="FName3" name="FName3" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="LName3">Last Name:</label>
                        <input type="text" id="LName3" name="LName3" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="gender3">Gender:</label>
                        <select id="gender3" class="input-form" name="gender3" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="yearLevel3">Year Level:</label>
                        <select id="yearlevel3" class="input-form" name="yearlevel3" required>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                            <option value="5th Year">5th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="program3">Program:</label>
                        <select id="program3" class="input-form" name="program3" required>
                            <?php

                            // Query to fetch programs
                            $query = "SELECT * FROM programs";
                            $result = $conn->query($query);

                            // Check if the query returned any results
                            if ($result->num_rows > 0) {
                                // Fetch each row and create an option element
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['Program'] . '">' . $row['Program'] . "</option>";
                                }
                            } else {
                                // No programs found
                                echo '<option value="">No programs available</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="major3">Major:</label>
                        <select id="major3" name="major3" class="input-form" required>
                            <option value="English">English</option>
                            <option value="Filipino">Filipino</option>
                            <option value="Math">Math</option>
                            <option value="None">None of the Above</option>
                        </select>
                    </div>
            </div>
            <br>
            <div class="buttons">
                <button type="button" class="cancel-button">Cancel</button>
                <button type="submit" class="save-button" name="edit">Save</button>
            </div>
            </form>
        </div>
    </div>
    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['edit'])) {

            // Get the user input
            $input_usep_ID = $_POST["usepID3"];

            // Remove any dashes from the input
            $clean_usep_ID = str_replace('-', '', $input_usep_ID);

            // Retrieve data from form
            $usepID = $clean_usep_ID;
            $email = $_POST['Email3'];
            $lname = $_POST['LName3'];
            $fname = $_POST['FName3'];
            $gender = $_POST['gender3'];
            $yearlvl = $_POST['yearlevel3'];
            $Program = $_POST['program3'];
            $major = $_POST['major3'];

            // Insert data into Users table
            $sqlVoterEdit = "UPDATE voters SET Email = '$email', LName = '$lname', FName = '$fname', gender = '$gender', yearLvl = '$yearlvl', program = '$Program', major = '$major' WHERE usep_ID = '$usepID'";

            if ($conn->query($sqlVoterEdit) === TRUE) {
                // Log the login activity
                $usepID = $_SESSION["usep_ID"];
                $logAction = 'Edited Voter';
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
                echo "<script>alert('Record updated successfully');</script>";
                echo "<script>window.location.href = 'Voters.php';</script>";
            } else {
                echo "<script>alert('Error: " .   $sqlVoterEdit . "<br>" . $conn->error . "');</script>";
                echo "<script>window.location.href = 'Voters.php';</script>";
            }
        }
    }
    ?>




    <div id="deletepop" class="popup">
        <div class="head">
            <h3>DELETE VOTER</h3>
        </div>
        <div class="popup-content">
            <form method="post">
                <div class="input-wrapper">
                    <input type="hidden" id="usepID4" name="usepID4" class="input-form">
                    <input type="hidden" id="voted4" class="input-form" name="voted4">
                    <input type="hidden" id="program4" class="input-form" name="program4">
                </div>
                <br>
                <div class="popup-content-inner">
                    <div style="text-align: center;">
                        <p>
                            Are you sure you want to delete this voter?<br>
                        </p>
                        <p style="color: yellow;">
                            [Their votes will also be deleted.]
                        </p>
                        <p>
                            This action cannot be undone.
                        </p>
                    </div>
                    <br>
                    <button type="button" class="cancel-button">Cancel</button>
                    <button type="submit" class="save-button" name="delete">Delete</button>
                </div>
            </form>
        </div>
    </div>


    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['delete'])) {

            $Voted = $_POST["voted4"];
            if ($Voted == 'Not Voted' || $Voted == 'Verifying') {
                // Get the user input
                $input_usep_ID = $_POST["usepID4"];

                // Remove any dashes from the input
                $clean_usep_ID = str_replace('-', '', $input_usep_ID);

                // Retrieve data from form
                $usepID = $clean_usep_ID;

                // Insert data into Users table
                $sqlVoterDelete = "DELETE FROM voters WHERE usep_ID = '$usepID'";

                if ($conn->query($sqlVoterDelete) === TRUE) {
                    // Log the login activity
                    $usepID = $_SESSION["usep_ID"];
                    $logAction = 'Deleted Voter';
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
                    echo "<script>alert('Record Deleted successfully');</script>";
                    echo "<script>window.location.href = 'Voters.php';</script>";
                } else {
                    echo "<script>alert('Error: " .   $sqlVoterDelete . "<br>" . $conn->error . "');</script>";
                    echo "<script>window.location.href = 'Voters.php';</script>";
                }
            } else {
                $program = $_POST["program4"];
                $input_usep_ID = $_POST["usepID4"];

                // Remove any dashes from the input
                $clean_usep_ID = str_replace('-', '', $input_usep_ID);

                // Retrieve data from form
                $usepID = $clean_usep_ID;

                // Delete vote records from tsc_votes table
                $sqlVoteDelete1 = "DELETE FROM tsc_votes WHERE usep_ID = '$usepID'";
                if ($conn->query($sqlVoteDelete1) !== TRUE) {
                    echo "<script>alert('Error deleting votes from tsc_votes table: " . $conn->error . "');</script>";
                    echo "<script>window.location.href = 'Voters.php';</script>";
                    exit();
                }

                // Retrieve the council name for the given program
                $sqlsearchCouncil = "SELECT council_name FROM list_councils WHERE program = '$program'";
                $result = $conn->query($sqlsearchCouncil);

                if ($result->num_rows > 0) {
                    // Council name exists for the given program
                    $row = $result->fetch_assoc();
                    $council_name = strtolower($row['council_name']);

                    // Delete vote records from the specific council votes table
                    $sqlVoteDelete2 = "DELETE FROM " . $council_name . "_votes WHERE usep_ID = '$usepID'";
                    if ($conn->query($sqlVoteDelete2) !== TRUE) {
                        echo "<script>alert('Error deleting votes from council table: " . $conn->error . "');</script>";
                        echo "<script>window.location.href = 'Voters.php';</script>";
                        exit();
                    }
                }

                // Delete the voter record from the Voters table
                $sqlVoterDelete = "DELETE FROM voters WHERE usep_ID = '$usepID'";
                if ($conn->query($sqlVoterDelete) === TRUE) {
                    // Log the login activity
                    $usepID = $_SESSION["usep_ID"];
                    $logAction = 'Deleted Voter';
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
                    echo "<script>alert('Record Deleted successfully');</script>";
                    echo "<script>window.location.href = 'Voters.php';</script>";
                } else {
                    echo "<script>alert('Error: " . $sqlVoterDelete . "<br>" . $conn->error . "');</script>";
                    echo "<script>window.location.href = 'Voters.php';</script>";
                }
            }
        }
    }
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

            if (input === "") {
                showPage(0);
            }
        }

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

            // Update the page numbers
            updatePageNumbers(page);

        }

        function updatePageNumbers(currentPage) {
            var table = document.getElementById('Results');
            var totalRows = table.rows.length - 1; // Exclude header row
            var totalPages = Math.ceil(totalRows / rowsPerPage);
            var pageNumbersContainer = document.getElementById('pageNumbers');

            // Clear existing page numbers
            pageNumbersContainer.innerHTML = '';

            // Generate page numbers dynamically
            for (var i = 0; i < totalPages; i++) {
                var pageNumber = document.createElement('span');
                pageNumber.innerText = i + 1;
                pageNumber.onclick = (function(page) {
                    return function() {
                        currentPage = page;
                        showPage(page);
                    };
                })(i);

                if (i === currentPage) {
                    pageNumber.classList.add('active');
                }

                pageNumbersContainer.appendChild(pageNumber);
            }

            var searchin = document.getElementById('searchInput');
            searchin.value = '';

            // Disable the Previous button if on the first page
            document.getElementById('prevButton').disabled = currentPage === 0;

            // Disable the Next button if on the last page
            document.getElementById('nextButton').disabled = currentPage === totalPages - 1;
        }

        function navigateRows(direction) {

            var searchin = document.getElementById('searchInput');
            searchin.value = '';
            searchTable();

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

            // Update the row number display
            document.getElementById('rowNumber').textContent = currentPage * rowsPerPage;
        }

        // Show the initial page
        showPage(currentPage);

        /*add pop up*/
        document.getElementById("add").addEventListener("click", function() {
            document.getElementById("popup").style.display = "flex";
        });

        document.querySelector(".cancel-button").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
        });

        /*import pop up*/
        document.getElementById("importbutton").addEventListener("click", function() {
            document.getElementById("importpop").style.display = "flex";
        });

        document.querySelector("#importpop .cancel-button").addEventListener("click", function() {
            document.getElementById("importpop").style.display = "none";
        });

        /*view pop up*/


        function viewpop(usepID) {
            // AJAX request to PHP script to retrieve voter data based on usepID
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        try {
                            var rowData = JSON.parse(this.responseText);
                            console.log(rowData); // Log the response for debugging

                            var formattedUsepID = formatUsepID(rowData.usep_ID);

                            document.getElementById("usepID2").value = formattedUsepID;
                            document.getElementById("Email2").value = rowData.Email;
                            document.getElementById("fullName2").value = rowData.FName + " " + rowData.LName;
                            document.getElementById("gender2").value = rowData.gender;
                            document.getElementById("yearlevel2").value = rowData.yearLvl;
                            document.getElementById("program2").value = rowData.program;
                            document.getElementById("major2").value = rowData.major;
                            // Assuming rowData.VotedDT is a valid Date object, a date string that can be parsed by Date, or null
                            let date = rowData.VotedDT ? new Date(rowData.VotedDT) : null;

                            // Initialize ondate as an empty string
                            let ondate = "";

                            if (date) {
                                // Define an array of month names
                                let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                                // Extract the individual components of the date
                                let month = months[date.getMonth()];
                                let day = date.getDate();
                                let year = date.getFullYear();
                                let hours = date.getHours();
                                let am_pm = hours >= 12 ? "pm" : "am"; // Determine AM or PM
                                hours = (hours % 12) || 12; // Convert 24-hour format to 12-hour format
                                let minutes = date.getMinutes().toString().padStart(2, '0');
                                let seconds = date.getSeconds().toString().padStart(2, '0');

                                // Format the date string
                                let formattedDate = `${month} ${day}, ${year} ${hours}:${minutes}:${seconds} ${am_pm}`;

                                // Assign the formatted date string to ondate
                                ondate = "on " + formattedDate;
                            }

                            // Assign the combined string to the value of the HTML element
                            document.getElementById("voted2").value = rowData.voted + " " + ondate;


                            // Show the popup
                            var popup = document.getElementById("viewpop");
                            popup.style.display = "flex";
                        } catch (e) {
                            console.error("Error parsing JSON response: " + e.message);
                        }
                    } else {
                        console.error("AJAX request failed with status: " + this.status);
                    }
                }
            };
            xhttp.open("GET", "get_voter_data.php?usepID=" + usepID, true);
            xhttp.send();
        }


        function closeViewpop() {
            document.getElementById("viewpop").style.display = "none";
        }


        /*edit pop up*/
        function editpop(usepID) {
            // AJAX request to PHP script to retrieve voter data based on usepID
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        try {
                            var rowData = JSON.parse(this.responseText);
                            console.log(rowData); // Log the response for debugging\

                            var formattedUsepID = formatUsepID(rowData.usep_ID);

                            // Fill input fields with voter data
                            document.getElementById("usepID3").value = formattedUsepID;
                            document.getElementById("Email3").value = rowData.Email;
                            document.getElementById("FName3").value = rowData.FName;
                            document.getElementById("LName3").value = rowData.LName;
                            document.getElementById("gender3").value = rowData.gender;
                            document.getElementById("yearlevel3").value = rowData.yearLvl;
                            document.getElementById("program3").value = rowData.program;
                            document.getElementById("major3").value = rowData.major;

                            // Show the popup
                            var popup = document.getElementById("editpop");
                            popup.style.display = "flex";
                        } catch (e) {
                            console.error("Error parsing JSON response: " + e.message);
                        }
                    } else {
                        console.error("AJAX request failed with status: " + this.status);
                    }
                }
            };
            xhttp.open("GET", "get_voter_data.php?usepID=" + usepID, true);
            xhttp.send();
        };

        document.querySelector("#editpop .cancel-button").addEventListener("click", function() {
            document.getElementById("editpop").style.display = "none";
        });

        /*delete pop up*/
        function deletepop(usepID) {
            // AJAX request to PHP script to retrieve voter data based on usepID
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        try {
                            var rowData = JSON.parse(this.responseText);
                            console.log(rowData); // Log the response for debugging

                            // Fill input fields with voter data
                            document.getElementById("usepID4").value = rowData.usep_ID;
                            document.getElementById("voted4").value = rowData.Voted;
                            document.getElementById("program4").value = rowData.program;

                            // Show the popup
                            var popup = document.getElementById("deletepop");
                            popup.style.display = "flex";
                        } catch (e) {
                            console.error("Error parsing JSON response: " + e.message);
                        }
                    } else {
                        console.error("AJAX request failed with status: " + this.status);
                    }
                }
            };
            xhttp.open("GET", "get_voter_data.php?usepID=" + usepID, true);
            xhttp.send();
        };

        function formatUsepID(usepID) {
            // Remove any dashes if present
            var cleanUsepID = usepID.replace(/-/g, '');

            // Extract the year part
            var year = cleanUsepID.substring(0, 4);

            // Extract the remaining part and zero-pad it to 5 digits
            var numericPart = cleanUsepID.substring(4).padStart(5, '0');

            // Combine the parts with a dash
            return year + '-' + numericPart;
        }

        function validateUsepID(input) {
            // Remove all non-numeric characters except dash
            let value = input.value.replace(/[^0-9-]/g, '');

            // Validate the format
            let isValid = /^(\d{4}-?\d{0,5})$/.test(value);

            // If valid, set the formatted value back to the input
            if (isValid) {
                // Automatically add the dash if not present after the first 4 digits
                if (value.length > 4 && value[4] !== '-') {
                    value = value.slice(0, 4) + '-' + value.slice(4);
                }
                input.value = value;
            } else {
                // If not valid, remove the invalid characters
                input.value = value.slice(0, -1);
            }
        }

        document.querySelector("#deletepop .cancel-button").addEventListener("click", function() {
            document.getElementById("deletepop").style.display = "none";
        });

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
    echo "<script>document.getElementById('LOGS').style.display = 'none';</script>";
} else if ($usertype === 'Admin-Technical') {
    echo "<script>document.getElementById('CANDIDATES').style.display = 'none';</script>";
    echo "<script>document.getElementById('VOTERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('PARTYLIST').style.display = 'none';</script>";
    echo "<script>document.getElementById('USERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('COUNCIL').style.display = 'none';</script>";
} else if ($usertype === 'Watcher') {
    echo "<script>document.getElementById('CANDIDATES').style.display = 'none';</script>";
    echo "<script>document.getElementById('VOTERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('PARTYLIST').style.display = 'none';</script>";
    echo "<script>document.getElementById('USERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('COUNCIL').style.display = 'none';</script>";
    echo "<script>document.getElementById('LOGS').style.display = 'none';</script>";
}

?>