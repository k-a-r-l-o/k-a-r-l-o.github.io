<?php
    include "DBSession.php"
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
            display: grid;
            grid-template-columns: 1fr;
            width: auto;
            max-width: 390px;
            padding: 2% 1%;
            gap: 10px;
            background-color: #222E50;
            box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.2);
            border-radius: 0px 10px 10px 0px;
            align-items: center;
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
            background-color: rgba(150, 191, 245, 0.5);
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
            min-width: 400px;
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

        #importpop .popup-content,
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
            .popup {
                height: 80vh;
            }

        }

        @media (max-width: 500px) {
            .popup {
                width: 100vw;
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
        <div class="searchspace">
            <div class="searchicon">
                <img src="search.png" alt="search icon">
                <input placeholder="Search" alt="Search">
            </div>
        </div>
    </header>
    <div class="bodycontainer">
        <div class="menu">
            <div class="buttonContainer">
                <button onclick="switchHTML('Dashboard.php')">
                    <div><img src="dashboard.svg" alt="dashboard icon"></div>
                    <div>Dashboard</div>
                </button>
                <button onclick="switchHTML('Results.php')">
                    <div><img src="result.svg" alt="result icon"></div>
                    <div>Results</div>
                </button>
                <button onclick="switchHTML('Candidate.php')">
                    <div><img src="candidates.svg" alt="candidate icon"></div>
                    <div>Candidate</div>
                </button>
                <button id="selected">
                    <div><img src="voters.svg" alt="dashboard icon"></div>
                    <div>Voters</div>
                </button>
                <button onclick="switchHTML('Partylist.php')">
                    <div><img src="partylist.svg" alt="partylist icon"></div>
                    <div>Partylist</div>
                </button>
                <button onclick="switchHTML('Users.php')">
                    <div><img src="user.svg" alt="user icon"></div>
                    <div>Users</div>
                </button>
                <button onclick="switchHTML('Council.php')">
                    <div><img src="council.svg" alt="council icon"></div>
                    <div>Council</div>
                </button>
                <button onclick="switchHTML('Schedule.php')">
                    <div><img src="schedule.svg" alt="calendar icon"></div>
                    <div>Voting Schedule</div>
                </button>
                <button onclick="switchHTML('Logs.php')">
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
                        <h2 id="rowNumbershow">0</h2>
                    </div>
                </div>
                <div class="dropdown">
                    <button id="importbutton"><img src="plus.png" alt="plus icon">Import</button>
                    <button id="add"><img src="plus.png" alt="plus icon">Add new</button>
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
                        <?php
                        // Query to retrieve all data from the Users table
                        $sql = "SELECT * FROM Voters";
                        $result = $conn->query($sql);

                        // Check if there are any rows returned
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {

                            // Assuming $row["usep_ID"] contains the ID like 202200294
                            $usep_ID = $row["usep_ID"];

                            // Extract the year part
                            $year = substr($usep_ID, 0, 4);

                            // Extract the remaining part and zero-pad it to 5 digits
                            $numeric_part = str_pad(substr($usep_ID, 4), 5, "0", STR_PAD_LEFT);

                            // Combine the parts with a dash
                            $formatted_usep_ID = $year . '-' . $numeric_part;
                        ?>
                                <tr>
                                    <td class="tdfirst"><?php echo $formatted_usep_ID; ?></td>
                                    <td><?php echo $row["FName"] . " " . $row["LName"] ?></td>
                                    <td><?php echo $row["yearLvl"] ?></td>
                                    <td><?php echo $row["program"] ?></td>
                                    <td class="tdlast">
                                        <!-- Pass row data to viewpop() function -->
                                        <img onclick="viewpop(<?php echo $row['usep_ID']; ?>)" src="view.png" alt="view icon">
                                        <img onclick="editpop(<?php echo $row['usep_ID']; ?>)" src="edit.png" alt="edit icon">
                                        <img onclick="deletepop(<?php echo $row['usep_ID']; ?>)" src="delete.png" alt="delete icon">
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "0 results";
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
                        <input type="text" id="usepID1" name="usepID" class="input-form" placeholder="Ex. 2020-00001" required onchange="validateUsepID(this)">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" id="Email1" name="Email" class="input-form" placeholder="Ex. juan00001@usep.edu.ph" required>
                    </div>
                    <div class="form-group">
                        <label for="FName">First Name:</label>
                        <input type="text" id="FName1" name="FName" class="input-form" placeholder="Ex. Juan" required>
                    </div>
                    <div class="form-group">
                        <label for="LName">Last Name:</label>
                        <input type="text" id="LName1" name="LName" class="input-form" placeholder="Ex. Dela Cruz" required>
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
                            $query = "SELECT * FROM Programs";
                            $result = $conn->query($query);

                            // Check if the query returned any results
                            if ($result->num_rows > 0) {
                                // Fetch each row and create an option element
                                while($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['Program'] . '">' . $row['Program'] . "</option>";
                                }
                            } else {
                                // No programs found
                                echo '<option value="">No programs available</option>';
                            }

                            // Close the database connection
                            $conn->close();
                            ?>
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

            $sqlsearch = "SELECT * FROM Voters WHERE usep_ID = '$usepID'";
            $result = $conn->query($sqlsearch);

            if ($result->num_rows > 0) {
                echo "<script>alert('Voter already exists!');</script>";
            } else {
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

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
                $voted = 'Not Voted';

                // Insert data into Users table
                $sqlVoterInsert = "INSERT INTO Voters (usep_ID, Email, LName, FName, gender, yearLvl, program, voted ) 
                                VALUES ('$usepID', '$email', '$lname', '$fname', '$gender', '$yearlvl','$Program' ,'$voted')";

                if ($conn->query($sqlVoterInsert) === TRUE) {
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
                    $voted = 'Not Voted';

                    // Check if voter already exists
                    $sqlsearch = "SELECT * FROM Voters WHERE usep_ID = '$usepID'";
                    $result = $conn->query($sqlsearch);

                    if ($result->num_rows == 0) {
                        // Insert data into Voters table
                        $sqlVoterInsert = "INSERT INTO Voters (usep_ID, Email, LName, FName, gender, yearLvl, program, voted) 
                                        VALUES ('$usepID', '$email', '$lname', '$fname', '$gender', '$yearlvl', '$program', '$voted')";

                        if ($conn->query($sqlVoterInsert) === TRUE) {
                            echo "New record created successfully for $usepID<br>";
                        } else {
                            echo "Error: " . $sqlVoterInsert . "<br>" . $conn->error . "<br>";
                        }
                    } else {
                        echo "Voter with USeP ID $usepID already exists!<br>";
                    }
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
                        <label for="usepID">USeP ID:</label>
                        <input type="text" id="usepID2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" id="Email2" name="Email2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fullName">Full Name:</label>
                        <input type="text" id="fullName2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <input id="gender2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="yearLevel">Year Level:</label>
                        <input id="yearlevel2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="program">Program:</label>
                        <input id="program2" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="voted">Vote Status:</label>
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
                        <label for="usepID">USeP ID(readonly):</label>
                        <input type="text" id="usepID3" name="usepID3" class="input-form" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" id="Email3" name="Email3" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="FName">First Name:</label>
                        <input type="text" id="FName3" name="FName3" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="LName">Last Name:</label>
                        <input type="text" id="LName3" name="LName3" class="input-form" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select id="gender3" class="input-form" name="gender3" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="yearLevel">Year Level:</label>
                        <select id="yearlevel3" class="input-form" name="yearlevel3" required>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                            <option value="5th Year">5th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="program">Program:</label>
                        <select id="program3" class="input-form" name="program3" required>
                            <option value="BSABE">BSABE</option>
                            <option value="BEED">BEED</option>
                            <option value="BECED">BECED</option>
                            <option value="BSNED">BSNED</option>
                            <option value="BSED">BSED</option>
                            <option value="BSIT">BSIT</option>
                            <option value="BTVTED">BTVTED</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="voted">Vote Status:</label>
                        <select id="voted3" class="input-form" class="input-form" name="voted3" required>
                            <option value="Voted">Voted</option>
                            <option value="Not Voted">Not Voted</option>
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


            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

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
            $voted = $_POST['voted3'];

            // Insert data into Users table
            $sqlVoterEdit = "UPDATE Voters SET Email = '$email', LName = '$lname', FName = '$fname', gender = '$gender', yearLvl = '$yearlvl', program = '$Program', voted = '$voted' WHERE usep_ID = '$usepID'";

            if ($conn->query($sqlVoterEdit) === TRUE) {
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
                </div>
                <br>
                <div class="popup-content-inner">
                    <div style="text-align: center;">
                        <p>Are you sure you want to delete this voter?
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
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['delete'])) {


            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the user input
            $input_usep_ID = $_POST["usepID4"];

            // Remove any dashes from the input
            $clean_usep_ID = str_replace('-', '', $input_usep_ID);

            // Retrieve data from form
            $usepID = $clean_usep_ID;

            // Insert data into Users table
            $sqlVoterDelete = "DELETE FROM Voters WHERE usep_ID = '$usepID'";

            if ($conn->query($sqlVoterDelete) === TRUE) {
                echo "<script>alert('Record Deleted successfully');</script>";
                echo "<script>window.location.href = 'Voters.php';</script>";
            } else {
                echo "<script>alert('Error: " .   $sqlVoterDelete . "<br>" . $conn->error . "');</script>";
                echo "<script>window.location.href = 'Voters.php';</script>";
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

        // Get the table element
        var table = document.getElementById('Results');

        // Get the number of rows in the table
        var rowCount = table.rows.length;

        // Get the <h2> element where you want to display the row count
        var rowNumberElement = document.getElementById('rowNumbershow');

        // Replace the content of the <h2> element with the row count
        rowNumberElement.textContent = rowCount - 1;

        // JavaScript code for navigation
        var currentPage = 0;
        var rowsPerPage = 5; // Change this value as needed

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
                            document.getElementById("voted2").value = rowData.voted;

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
                            document.getElementById("voted3").value = rowData.voted;

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
    </script>
</body>

</html>