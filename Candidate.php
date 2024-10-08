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
    <title>U-Vote Admin | Candidates</title>
    <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

        ::-webkit-scrollbar-thumb {
            background: #28579E;
            border-radius: 5px;
        }

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

            .dropdown {
                flex-direction: column;
                justify-self: right;
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
            .contenthead select,
            h2,
            .yellowBG {
                scale: 0.8;
            }

        }

        @media (max-width: 500px) {
            #addcandidate {
                font-size: 0;
                padding: 10px;
                width: auto;
                gap: 0;
            }

            #addcandidate img {
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

        select:focus {
            outline: none;
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
            height: 90vh;
            width: 60vh;
            border-radius: 5px;
            z-index: 9999;
        }

        #logoutpop,
        #deletepop {
            height: auto;
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
            overflow: hidden;
        }

        .popup-content-inner,
        .buttons {
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
            popup {
                height: 80vh;
            }

        }

        @media (max-width: 500px) {

            #popup,
            #editpop,
            #viewpop {
                height: 95vh;
                width: 100vw;
                top: 0;
                left: 0;
                transform: translate(0, 0);
            }

            #deletepop,
            #logoutpop {
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        function saveSelectionAndFilter(selectId) {
            const selectElement = document.getElementById(selectId);
            sessionStorage.setItem(selectId + "Selected", selectElement.value);
            filterCandidates(); // Apply the filter without reloading the page
        }

        function loadSelection(selectId) {
            const savedValue = sessionStorage.getItem(selectId + "Selected");
            if (savedValue) {
                document.getElementById(selectId).value = savedValue;
            }
        }

        function reloadPosition() {
            var selectedCouncil = document.getElementById("Tcouncil").value;
            var positionSelect = document.getElementById('Tposition');

            // Clear previous options
            positionSelect.innerHTML = '';

            // Fetch positions from PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_pos_data_sort.php?council=' + encodeURIComponent(selectedCouncil), true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    positionSelect.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function filterCandidates() {
            var program = document.getElementById("Tprogram").value;
            var council = document.getElementById("Tcouncil").value;
            var position = document.getElementById("Tposition").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "sort_cand.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    document.getElementById("Results").innerHTML = this.responseText;
                    currentPage = 0; // Reset to the first page
                    showPage(currentPage); // Call the pagination function after updating results
                }
            };
            xhr.send("Tprogram=" + program + "&Tcouncil=" + council + "&Tposition=" + position);
        }

        document.addEventListener("DOMContentLoaded", function() {
            loadSelection("Tprogram");
            loadSelection("Tcouncil");
            reloadPosition();
            loadSelection("Tposition");
            filterCandidates();

            document.getElementById("Tprogram").addEventListener("change", function() {
                saveSelectionAndFilter("Tprogram");
            });

            document.getElementById("Tcouncil").addEventListener("change", function() {
                saveSelectionAndFilter("Tcouncil");
            });

            document.getElementById("Tposition").addEventListener("change", function() {
                saveSelectionAndFilter("Tposition");
            });
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
                <button id="selected">
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
                <div class="titlecontainer">
                    <div>
                        <h2>Total Candidates</h2>
                    </div>
                    <div class="yellowBG">
                        <?php
                        $resultcan = $conn->query("SELECT COUNT(*) as totcan FROM candidates");
                        $rowcan = $resultcan->fetch_assoc();
                        $totcan = $rowcan['totcan'];
                        ?>
                        <h2><?php echo $totcan ?></h2>
                    </div>
                </div>
                <div class="dropdown">
                    <button id="addcandidate"><img src="plus.png" alt="plus icon">Add new</button>
                </div>
            </div>
            <div class="contenthead">
                <div class="titlecontainer">
                    <div>
                        <h3>Sort by:</h3>
                    </div>
                </div>
                <div class="dropdown">
                    <select id="Tprogram" name="Tprogram">
                        <option value="">All Programs</option>
                        <?php
                        $query1 = "SELECT * FROM programs";
                        $result = $conn->query($query1);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['Program'] . '">' . $row['Program'] . "</option>";
                            }
                        } else {
                            echo '<option value="">No programs available</option>';
                        }
                        ?>
                    </select>

                    <select id="Tcouncil" name="Tcouncil">
                        <option value="">All Councils</option>
                        <?php
                        $query1 = "SELECT * FROM list_councils";
                        $result = $conn->query($query1);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['council_name'] . '">' . $row['council_name'] . "</option>";
                            }
                        } else {
                            echo '<option value="">No council available</option>';
                        }
                        ?>
                    </select>

                    <select id="Tposition" name="Tposition">
                        <option value="">All Positions</option>
                        <?php
                        $sql = "SELECT DISTINCT(position_name) FROM positions";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['position_name'] . "'>" . $row['position_name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No Positions Available</option>";
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
                            <th>POSITION</th>
                            <th>COUNCIL</th>
                            <th class="thlast"></th>
                        </tr>
                        <!-- initialized below by sort cand -->
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
            <h3>ADD CANDIDATE</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profile-photo">Profile Photo:</label>
                        <div class="upload-btn">
                            <input type="file" id="profile-photo" name="prof" accept=".jpg, .jpeg, .png" onchange="previewImage(event)" placeholder="Upload Photo" class="input-file" required>
                            <span>Upload Photo</span>
                        </div>
                        <img id="preview" src="#" alt="Preview" style="display: none; max-width: 50%; max-height: 50%; border-radius: 10px; margin-top: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="usepID">USeP ID:</label>
                        <input type="text" id="usepID" name="usepID" class="input-form" maxlength="10" onchange="validateUsepID(this)" required>
                    </div>
                    <div class="form-group">
                        <label for="Fname">First Name:</label>
                        <input type="text" id="Fname" name="Fname" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="Lname">Last Name:</label>
                        <input type="text" id="Lname" name="Lname" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" class="input-form" required>
                            <option value="" disabled selected hidden>Select here</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="yearlevel">Year Level:</label>
                        <select id="yearlevel" name="yearlevel" class="input-form" required>
                            <option value="" disabled selected hidden>Select here</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="program">Program:</label>
                        <select id="program" name="program" class="input-form" required>
                            <option value="" disabled selected hidden>Select here</option>
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
                        <label for="Council">Council:</label>
                        <select id="Council" name="council" class="input-form" required>
                            <option value="" disabled selected hidden>Select here</option>
                            <?php
                            // Query to fetch programs
                            $query = "SELECT council_name FROM list_councils";
                            $result = $conn->query($query);

                            // Check if the query returned any results
                            if ($result->num_rows > 0) {
                                // Fetch each row and create an option element
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['council_name'] . '">' . $row['council_name'] . "</option>";
                                }
                            } else {
                                // No programs found
                                echo '<option value="">No programs available</option>';
                            }


                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position">Position:</label>
                        <select id="position" name="position" class="input-form" required>
                            <option value="" disabled selected hidden>Select Council First</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="partyList">Party List:</label>
                        <select id="partyList" name="partylist" class="input-form" required>
                            <option value="" disabled selected hidden>Select here</option>
                            <?php
                            // Query to fetch programs
                            $query = "SELECT * FROM list_partylist";
                            $result = $conn->query($query);

                            // Check if the query returned any results
                            if ($result->num_rows > 0) {
                                // Fetch each row and create an option element
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['prty_ID'] . '">' . $row['name_partylist'] . "</option>";
                                }
                            } else {
                                // No programs found
                                echo '<option value="">No partylist available</option>';
                            }


                            ?>
                        </select>
                    </div>
                    <div class="buttons">
                        <button type="button" class="cancel-button" name="cancel">Cancel</button>
                        <button type="submit" class="save-button" name="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['save'])) {
            // Check if a file has been uploaded
            if (isset($_FILES['prof']) && $_FILES['prof']['error'] == 0) {
                // Get the user input
                $input_usep_ID = $_POST["usepID"];
                // Remove any dashes from the input
                $clean_usep_ID = str_replace('-', '', $input_usep_ID);
                // Retrieve data from form
                $usepID = $clean_usep_ID;
                $lname = $_POST['Lname'];
                $fname = $_POST['Fname'];
                $gender = $_POST['gender'];
                $yearlvl = $_POST['yearlevel'];
                $program = $_POST['program'];
                $council = $_POST['council'];
                $position = $_POST['position'];
                $partylist = $_POST['partylist'];

                // Handle file upload
                $target = "uploads/";
                $clean_fname = str_replace(' ', '_', $fname);
                $clean_lname = str_replace(' ', '_', $lname);
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d");
                $time = date("H-i-s");
                $fileName = $clean_usep_ID . "-" . $clean_fname . "_" . $clean_lname . "_" . $date . "_" . $time . ".jpeg";
                $targetFile = $target . $fileName;
                $upload_Done = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if image file is an actual image
                $check = getimagesize($_FILES["prof"]["tmp_name"]);
                if ($check !== false) {
                    $upload_Done = 1;
                } else {
                    echo "<script>Swal.fire('Error', 'File is not an image.', 'error');</script>";
                    $upload_Done = 0;
                }

                // Check if file already exists
                if (file_exists($targetFile)) {
                    echo "<script>Swal.fire('Error', 'Sorry, file already exists.', 'error');</script>";
                    $upload_Done = 0;
                }

                // Check file size
                if ($_FILES["prof"]["size"] > 2000000) {
                    echo "<script>Swal.fire('Error', 'Sorry, your file is too large.', 'error');</script>";
                    $upload_Done = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
                    echo "<script>Swal.fire('Error', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.', 'error');</script>";
                    $upload_Done = 0;
                }

                // Check if $upload_Done is set to 0 by an error
                if ($upload_Done == 0) {
                    echo "<script>Swal.fire('Error', 'Sorry, your file was not uploaded.', 'error');</script>";
                } else {
                    // Resize and crop the image to 1x1 aspect ratio and 1080x1080 pixels if necessary
                    $sourceImage = $_FILES["prof"]["tmp_name"];
                    list($width, $height) = getimagesize($sourceImage);

                    // If the image is not already 1080x1080, resize and crop it
                    if ($width != 1080 || $height != 1080) {
                        $newSize = min($width, $height); // The size of the smallest side
                        $srcX = ($width - $newSize) / 2;
                        $srcY = ($height - $newSize) / 2;

                        $image_p = imagecreatetruecolor(1080, 1080);
                        $image = null;

                        switch ($imageFileType) {
                            case 'jpg':
                            case 'jpeg':
                                $image = imagecreatefromjpeg($sourceImage);
                                break;
                            case 'png':
                                $image = imagecreatefrompng($sourceImage);
                                break;
                            case 'gif':
                                $image = imagecreatefromgif($sourceImage);
                                break;
                        }

                        if ($image) {
                            imagecopyresampled($image_p, $image, 0, 0, $srcX, $srcY, 1080, 1080, $newSize, $newSize);
                            imagejpeg($image_p, $targetFile, 100); // Save the cropped and resized image as JPEG
                        } else {
                            echo "<script>Swal.fire('Error', 'Sorry, there was an error processing your file.', 'error');</script>";
                        }
                    } else {
                        // If the image is already 1080x1080, move it directly to the target directory
                        if (!move_uploaded_file($_FILES["prof"]["tmp_name"], $targetFile)) {
                            echo "<script>Swal.fire('Error', 'Sorry, there was an error processing your file.', 'error');</script>";
                        }
                    }

                    // Insert data into Candidates table including the uploaded photo path
                    $sqlCandidateInsert = "INSERT INTO candidates (usep_ID, candPic, LName, FName, gender, yearLvl, program, council, position, prty_ID ) 
                    VALUES ('$usepID', '$targetFile', '$lname', '$fname', '$gender', '$yearlvl', '$program', '$council', '$position', '$partylist')";

                    if ($conn->query($sqlCandidateInsert) === TRUE) {
                        // Log the login activity
                        $usepID = $_SESSION["usep_ID"];
                        $logAction = 'Added Candidate';
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
                        echo "<script>Swal.fire('Success', 'New record created successfully.', 'success').then(() => { window.location.href = 'Candidate.php'; });</script>";
                    } else {
                        echo "<script>Swal.fire('Error', 'Error: " . $sqlCandidateInsert . "<br>" . $conn->error . "', 'error');</script>";
                    }
                }
            } else {
                echo "<script>Swal.fire('Error', 'Please select a profile photo to upload.', 'error');</script>";
            }
        }
    }
    ?>

    <div class="popup" id="viewpop">
        <div class="head">
            <h3>CANDIDATE INFORMATION</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form>
                    <div class="form-group">
                        <label>Profile Photo:</label>
                        <img id="preview2" src="#" alt="Preview" style="display: flex; max-width: 50%; max-height: 50%; border-radius: 10px; margin-top: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="usepID2">USeP ID:</label>
                        <input type="text" id="usepID2" class="input-form" readonly>
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
                        <label for="yearlevel2">Year Level:</label>
                        <input id="yearlevel2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="program2">Program:</label>
                        <input id="program2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Council2">Council:</label>
                        <input id="Council2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="position2">Position:</label>
                        <input id="position2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="partyList2">Party List:</label>
                        <input id="partyList2" name="partylist2" class="input-form" readonly>
                    </div>
                </form>
                <br>
                <button type="button" class="save-button" onclick="closeViewpop()">Back</button>
            </div>
        </div>
    </div>





    <div class="popup" id="editpop">
        <div class="head">
            <h3>EDIT CANDIDATE</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profile-photo3">Profile Photo:</label>
                        <div class="upload-btn">
                            <input type="file" id="profile-photo3" name="prof3" accept=".jpg, .jpeg, .png" onchange="preview3Image(event)" placeholder="Upload Photo" class="input-file">
                            <span>Upload Photo</span>
                        </div>
                        <img id="preview3" src="" alt="Preview" style="display: none; max-width: 50%; max-height: 50%; border-radius: 10px; margin-top: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="usepID3">USeP ID(readonly):</label>
                        <input type="text" id="usepID3" name="usepID3" class="input-form" readonly onchange="validateUsepID(this)">
                    </div>
                    <div class="form-group">
                        <label for="Fname3">First Name:</label>
                        <input type="text" id="Fname3" name="Fname3" class="input-form">
                    </div>
                    <div class="form-group">
                        <label for="Lname3">Last Name:</label>
                        <input type="text" id="Lname3" name="Lname3" class="input-form">
                    </div>
                    <div class="form-group">
                        <label for="gender3">Gender:</label>
                        <select id="gender3" name="gender3" class="input-form">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="yearlevel3">Year Level:</label>
                        <select id="yearlevel3" name="yearlevel3" class="input-form">
                            <option value="" disabled selected hidden>Select here</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="program3">Program:</label>
                        <select id="program3" name="program3" class="input-form">
                            <option value="" disabled selected hidden>Select here</option>
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
                        <label for="Council3">Council:</label>
                        <select id="Council3" name="Council3" class="input-form">
                            <option value="" disabled selected hidden>Select here</option>
                            <?php
                            // Query to fetch programs
                            $query = "SELECT council_name FROM list_councils";
                            $result = $conn->query($query);

                            // Check if the query returned any results
                            if ($result->num_rows > 0) {
                                // Fetch each row and create an option element
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['council_name'] . '">' . $row['council_name'] . "</option>";
                                }
                            } else {
                                // No programs found
                                echo '<option value="">No programs available</option>';
                            }


                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position3">Position:</label>
                        <select id="position3" name="position3" class="input-form">

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="partyList3">Party List:</label>
                        <select id="partyList3" name="partyList3" class="input-form">
                            <?php
                            // Query to fetch programs
                            $query = "SELECT * FROM list_partylist";
                            $result = $conn->query($query);

                            // Check if the query returned any results
                            if ($result->num_rows > 0) {
                                // Fetch each row and create an option element
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['prty_ID'] . '">' . $row['name_partylist'] . "</option>";
                                }
                            } else {
                                // No programs found
                                echo '<option value="">No partylist available</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="buttons">
                        <button type="button" class="cancel-button" name="cancel">Cancel</button>
                        <button type="submit" class="save-button" name="edit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['edit'])) {
            // Get the user input
            $input_usep_ID = $_POST["usepID3"];
            $clean_usep_ID = str_replace('-', '', $input_usep_ID);

            // Retrieve data from form
            $usepID = $clean_usep_ID;
            $lname = $_POST['Lname3'];
            $fname = $_POST['Fname3'];
            $gender = $_POST['gender3'];
            $yearlvl = $_POST['yearlevel3'];
            $program = $_POST['program3'];
            $council = $_POST['Council3'];
            $position = $_POST['position3'];
            $partylist = $_POST['partyList3'];

            $updatePhoto = false;
            $targetFile = '';

            // Check if a new file has been uploaded
            if (isset($_FILES['prof3']) && $_FILES['prof3']['error'] == 0) {
                // Retrieve the photo file path from the database
                $sqlGetPhoto = "SELECT candPic FROM candidates WHERE usep_ID = '$usepID'";
                $result = $conn->query($sqlGetPhoto);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $photoPath = $row['candPic'];

                    // Delete the existing photo file from the server, if it exists
                    if (file_exists($photoPath)) {
                        if (!unlink($photoPath)) {
                            echo "<script>Swal.fire('Error', 'Error deleting existing photo.', 'error');</script>";
                        }
                    }
                }

                // Handle file upload
                $target = "uploads/";
                $clean_fname = str_replace(' ', '_', $fname);
                $clean_lname = str_replace(' ', '_', $lname);
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d");
                $time = date("H-i-s");
                $fileName = $clean_usep_ID . "-" . $clean_fname . "_" . $clean_lname . "_" . $date . "_" . $time . ".jpeg";
                $targetFile = $target . $fileName;
                $uploadDone = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if the file is an actual image
                $check = getimagesize($_FILES["prof3"]["tmp_name"]);
                if ($check === false) {
                    echo "<script>Swal.fire('Error', 'File is not an image.', 'error');</script>";
                    $uploadDone = 0;
                } else {
                    // Check if the file already exists
                    if (file_exists($targetFile)) {
                        echo "<script>Swal.fire('Error', 'Sorry, file already exists.', 'error');</script>";
                        $uploadDone = 0;
                    } else {
                        // Check file size
                        if ($_FILES["prof3"]["size"] > 2000000) {
                            echo "<script>Swal.fire('Error', 'Sorry, your file is too large.', 'error');</script>";
                            $uploadDone = 0;
                        } else {
                            // Check if everything is okay for upload
                            if ($uploadDone == 1) {
                                // Resize and crop the image to 1080x1080 if necessary
                                $sourceImage = $_FILES["prof3"]["tmp_name"];
                                list($width, $height) = getimagesize($sourceImage);

                                if ($width != 1080 || $height != 1080) {
                                    $newWidth = 1080;
                                    $newHeight = 1080;

                                    // Calculate cropping coordinates and size
                                    if ($width > $height) {
                                        $cropSize = $height;
                                        $srcX = ($width - $cropSize) / 2;
                                        $srcY = 0;
                                    } else {
                                        $cropSize = $width;
                                        $srcX = 0;
                                        $srcY = ($height - $cropSize) / 2;
                                    }

                                    $image_p = imagecreatetruecolor($newWidth, $newHeight);
                                    $image = null;

                                    switch ($imageFileType) {
                                        case 'jpg':
                                        case 'jpeg':
                                            $image = imagecreatefromjpeg($sourceImage);
                                            break;
                                        case 'png':
                                            $image = imagecreatefrompng($sourceImage);
                                            break;
                                        case 'gif':
                                            $image = imagecreatefromgif($sourceImage);
                                            break;
                                    }

                                    if ($image) {
                                        imagecopyresampled($image_p, $image, 0, 0, $srcX, $srcY, $newWidth, $newHeight, $cropSize, $cropSize);
                                        imagejpeg($image_p, $targetFile, 100); // Save the cropped and resized image as JPEG

                                        $updatePhoto = true;
                                    } else {
                                        echo "<script>Swal.fire('Error', 'Sorry, there was an error processing your file.', 'error');</script>";
                                    }
                                } else {
                                    // If the image is already 1080x1080, move it directly to the target directory
                                    if (move_uploaded_file($_FILES["prof3"]["tmp_name"], $targetFile)) {
                                        $updatePhoto = true;
                                    } else {
                                        echo "<script>Swal.fire('Error', 'Sorry, there was an error processing your file.', 'error');</script>";
                                    }
                                }
                            } else {
                                echo "<script>Swal.fire('Error', 'Sorry, there was an error processing your file.', 'error');</script>";
                            }
                        }
                    }
                }
            }

            // Update data in Candidates table
            if ($updatePhoto) {
                // Update with new photo
                $sqlCandidateUpdate = "UPDATE candidates SET candPic = '$targetFile', usep_ID = '$usepID', LName = '$lname', FName = '$fname', gender = '$gender', yearLvl = '$yearlvl', program = '$program', council = '$council', position = '$position', prty_ID = '$partylist' WHERE usep_ID = '$usepID'";
            } else {
                // Update without changing photo
                $sqlCandidateUpdate = "UPDATE candidates SET usep_ID = '$usepID', LName = '$lname', FName = '$fname', gender = '$gender', yearLvl = '$yearlvl', program = '$program', council = '$council', position = '$position', prty_ID = '$partylist' WHERE usep_ID = '$usepID'";
            }

            if ($conn->query($sqlCandidateUpdate) === TRUE) {
                // Log the login activity
                $usepID = $_SESSION["usep_ID"];
                $logAction = 'Edited Candidate';
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
                echo "<script>Swal.fire('Success', 'Record updated successfully.', 'success').then(() => { window.location.href = 'Candidate.php'; });</script>";
            } else {
                echo "<script>Swal.fire('Error', 'Error: " . $sqlCandidateUpdate . "<br>" . $conn->error . "', 'error');</script>";
            }
        }
    }
    ?>



    <div id="deletepop" class="popup">
        <div class="head">
            <h3>DELETE CANDIDATE</h3>
        </div>
        <div class="popup-content">
            <form method="post">
                <div class="form-group">
                    <input type="hidden" id="usepID4" name="usepID4" class="input-form" onchange="validateUsepID(this)">
                </div>
                <div class="popup-content-inner">
                    <div style="text-align: center;">
                        <p>Are you sure you want to delete this candidate?
                            This action cannot be undone.</p>
                    </div>
                    <br>
                    <button type="button" class="cancel-button">Cancel</button>
                    <button type="submit" class="save-button" name="delete">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['delete'])) {

            $input_usep_ID = $_POST["usepID4"];
            // Remove any dashes from the input
            $clean_usep_ID = str_replace('-', '', $input_usep_ID);
            // Retrieve data from form
            $usepID = $clean_usep_ID;

            // Retrieve the photo file path from the database
            $sqlGetPhoto = "SELECT candPic FROM candidates WHERE usep_ID = '$usepID'";
            $result = $conn->query($sqlGetPhoto);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $photoPath = $row['candPic'];

                // Delete the photo file from the server
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }

                // Delete the record from the database
                $sqlCandDelete = "DELETE FROM candidates WHERE usep_ID = '$usepID'";
                if ($conn->query($sqlCandDelete) === TRUE) {
                    // Log the login activity
                    $usepID = $_SESSION["usep_ID"];
                    $logAction = 'Deleted Candidate';
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
                    echo "<script>Swal.fire('Success', 'Record deleted successfully.', 'success').then(() => { window.location.href = 'Candidate.php'; });</script>";
                } else {
                    echo "<script>Swal.fire('Error', 'Error deleting record: " . $conn->error . "', 'error');</script>";
                }
            } else {
                echo "<script>Swal.fire('Error', 'Record not found.', 'error');</script>";
            }
        }
    }
    ?>

    <div id="logoutpop" class="popup">
        <div class="head">
            <h3>LOGOUT</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <div style="text-align: center;">
                    <p>Are you sure you want to logout?</p>
                </div>
                <br>
                <button type="button" class="cancel-button">Cancel</button>
                <button type="submit" class="save-button" name="logout">Confirm</button>
            </div>

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

        /*add pop up*/
        document.getElementById("addcandidate").addEventListener("click", function() {
            document.getElementById("popup").style.display = "flex";
        });

        document.querySelector(".cancel-button").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
        });


        /// add dropdown council
        document.getElementById('Council').addEventListener('change', function() {
            var selectedCouncil = this.value;
            var positionSelect = document.getElementById('position');

            // Clear previous options
            positionSelect.innerHTML = '';

            // Fetch positions from PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_pos_data.php?council=' + selectedCouncil, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    positionSelect.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });

        /// edit dropdown council
        document.getElementById('Council3').addEventListener('change', function() {
            var selectedCouncil = this.value;
            var positionSelect = document.getElementById('position3');

            // Clear previous options
            positionSelect.innerHTML = '';

            // Fetch positions from PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_pos_data.php?council=' + selectedCouncil, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    positionSelect.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });

        document.getElementById('Tcouncil').addEventListener('change', function() {
            var selectedCouncil = this.value;
            var positionSelect = document.getElementById('Tposition');

            // Clear previous options
            positionSelect.innerHTML = '';

            // Fetch positions from PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_pos_data_sort.php?council=' + encodeURIComponent(selectedCouncil), true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    positionSelect.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });

        function getpos(council) {
            var selectedCouncil = council;
            var positionSelect = document.getElementById('position3');

            // Clear previous options
            positionSelect.innerHTML = '';

            // Fetch positions from PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_pos_data.php?council=' + selectedCouncil, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    positionSelect.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }


        async function viewpop(usepID) {
            // AJAX request to PHP script to retrieve voter data based on usepID
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = async function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        try {
                            var rowData = JSON.parse(this.responseText);
                            console.log(rowData); // Log the response for debugging

                            var formattedUsepID = formatUsepID(rowData.usep_ID);

                            const imageSrc = rowData.candPic || 'default.png';
                            try {
                                const image = await loadImage(imageSrc);
                                const croppedImageSrc = cropToSquare(image);
                                document.getElementById("preview2").src = croppedImageSrc;
                                document.getElementById("preview2").style.display = 'block';
                            } catch (error) {
                                console.error('Error loading image:', error);
                            }

                            document.getElementById("usepID2").value = formattedUsepID;
                            document.getElementById("fullName2").value = rowData.FName + " " + rowData.LName;
                            document.getElementById("gender2").value = rowData.gender;
                            document.getElementById("yearlevel2").value = rowData.yearLvl;
                            document.getElementById("program2").value = rowData.program;
                            document.getElementById("Council2").value = rowData.council;
                            document.getElementById("position2").value = rowData.position;

                            // AJAX request to fetch the name_partylist based on prty_ID
                            var prty_ID = rowData.prty_ID;
                            var partyListRequest = new XMLHttpRequest();
                            partyListRequest.onreadystatechange = function() {
                                if (this.readyState == 4) {
                                    if (this.status == 200) {
                                        try {
                                            var partyListData = JSON.parse(this.responseText);
                                            console.log(partyListData); // Log the response for debugging

                                            // Set the value of the partyList2 element to the fetched name_partylist
                                            document.getElementById("partyList2").value = partyListData.name_partylist;

                                            // Show the popup
                                            var popup = document.getElementById("viewpop");
                                            popup.style.display = "flex";
                                        } catch (e) {
                                            console.error("Error parsing JSON response for party list: " + e.message);
                                        }
                                    } else {
                                        console.error("AJAX request for party list failed with status: " + this.status);
                                    }
                                }
                            };
                            partyListRequest.open("GET", "getPartyListName.php?prty_ID=" + prty_ID, true);
                            partyListRequest.send();

                        } catch (e) {
                            console.error("Error parsing JSON response for candidate data: " + e.message);
                        }
                    } else {
                        console.error("AJAX request for candidate data failed with status: " + this.status);
                    }
                }
            };
            xhttp.open("GET", "get_cand_data.php?usepID=" + usepID, true);
            xhttp.send();
        }


        function closeViewpop() {
            document.getElementById("viewpop").style.display = "none";
            document.getElementById("preview2").src = "#";
            document.getElementById("usepID2").value = '';
            document.getElementById("fullName2").value = '';
            document.getElementById("gender2").value = '';
            document.getElementById("yearlevel2").value = '';
            document.getElementById("program2").value = '';
            document.getElementById("Council2").value = '';
            document.getElementById("position2").value = '';
        }

        async function editpop(usepID, council) {
            // AJAX request to PHP script to retrieve voter data based on usepID
            getpos(council);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = async function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        try {
                            var rowData = JSON.parse(this.responseText);
                            console.log(rowData); // Log the response for debugging

                            var formattedUsepID = formatUsepID(rowData.usep_ID);

                            const imageSrc = rowData.candPic || 'default.png';
                            try {
                                const image = await loadImage(imageSrc);
                                const croppedImageSrc = cropToSquare(image);
                                document.getElementById("preview3").src = croppedImageSrc;
                                document.getElementById("preview3").style.display = 'block';
                            } catch (error) {
                                console.error('Error loading image:', error);
                            }

                            document.getElementById("usepID3").value = formattedUsepID;
                            document.getElementById("Fname3").value = rowData.FName;
                            document.getElementById("Lname3").value = rowData.LName;
                            document.getElementById("gender3").value = rowData.gender;
                            document.getElementById("yearlevel3").value = rowData.yearLvl;
                            document.getElementById("program3").value = rowData.program;
                            document.getElementById("Council3").value = rowData.council;
                            document.getElementById("position3").value = rowData.position;
                            document.getElementById("partyList3").value = rowData.prty_ID;

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
            xhttp.open("GET", "get_cand_data.php?usepID=" + usepID, true);
            xhttp.send();
        }

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
            xhttp.open("GET", "get_cand_data.php?usepID=" + usepID, true);
            xhttp.send();
        };

        document.querySelector("#deletepop .cancel-button").addEventListener("click", function() {
            document.getElementById("deletepop").style.display = "none";
        });

        function loadImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = src;
            });
        }

        function cropToSquare(image) {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            const size = Math.min(image.width, image.height);
            const xOffset = (image.width - size) / 2;
            const yOffset = (image.height - size) / 2;

            canvas.width = size;
            canvas.height = size;

            ctx.drawImage(image, xOffset, yOffset, size, size, 0, 0, size, size);

            return canvas.toDataURL();
        }

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var img = new Image();
                img.onload = function() {
                    var output = document.getElementById('preview');
                    output.src = cropToSquare(img);
                    output.style.display = 'block';
                }
                img.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function preview3Image(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var img = new Image();
                img.onload = function() {
                    var output = document.getElementById('preview3');
                    output.src = cropToSquare(img);
                    output.style.display = 'block';
                }
                img.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

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

        // Get the table element
        var table = document.getElementById('Results');

        // Get the number of rows in the table
        var rowCount = table.rows.length;

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

// Set the desired timezone
date_default_timezone_set('Asia/Manila');

// Get the current date and time in the specified timezone
$currentDateTime = date('Y-m-d H:i:s');

// Proceed with your existing code to check the voting schedule
// Query to retrieve the voting schedule
$sql1 = "SELECT * FROM voting_schedule";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
    // There should be only one row in the result, assuming there's only one voting schedule
    $row = $result1->fetch_assoc();

    // Combine start date and time
    $startDateTime = $row["startDate"] . ' ' . $row["startTime"];
    // Combine end date and time
    $endDateTime = $row["endDate"] . ' ' . $row["endTime"];

    // Check if the current date and time fall within the range
    if ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {
        // Current date and time are within the range
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Voting in Progress',
                text: 'Candidates cannot be modified during the voting period.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'Schedule.php';
                }
            });
        </script>";
        exit(); // Stop further execution
    } else {
        // Current date and time are not within the range
        // Proceed with the login process
    }
}


?>