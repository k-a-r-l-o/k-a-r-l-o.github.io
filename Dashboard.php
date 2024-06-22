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
    <title>U-Vote Admin | Dashboard</title>
    <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@1.2.1/dist/chartjs-plugin-zoom.min.js"></script>
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
            grid-template-columns: 1fr;
            width: 100%;
            height: auto;
            color: white;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .titlecontainer {
            width: auto;
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
            max-width: 230px;
        }

        .dashboards {
            display: flex;
            width: 100%;
            height: auto;
        }

        .perprogramcontainer,
        .allvoterscontainer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            height: 500px;
            border-radius: 12px;
            background-color: rgba(150, 191, 245, 0.25);
            margin-bottom: 3%;
            color: white;
        }

        .perprogramcontainer {
            margin-right: 1.5%;
            margin-bottom: 3%;
        }

        .allvoterscontainer {
            margin-left: 1.5%;
            margin-bottom: 3%;
        }

        .piecontainer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 90%;
            flex: 1;
        }

        .resulttitle {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 63px;
            background-image: linear-gradient(#28579E, #222E50);
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        @media (max-width: 1200px) {
            .titlecontainer {
                flex-direction: column;
                align-items: baseline;
                margin-bottom: 20px;
                gap: 10px;
            }

            .titlecontainer h2 {
                margin: 0;
            }
        }

        @media (max-width: 1400px) {

            .dashboards {
                display: flex;
                flex-direction: column;
            }

            .perprogramcontainer {
                margin-right: 0%;
            }

            .allvoterscontainer {
                margin-left: 0%;
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
            h3 {
                scale: 0.8;
            }

            .yellowBG {
                scale: 0.9;
                padding: 0 0;
            }

        }

        @media (max-width: 500px) {

            .dropdown button {
                font-size: 0;
                padding: 10px;
                width: auto;
                gap: 0;
            }


            .titlecontainer {
                margin-top: 20px;
                margin-bottom: 0;
            }

            /* Width and Height of scrollbar */
            ::-webkit-scrollbar {
                width: 4px;
            }
        }

        @media (max-height: 800px) {

            .logoName,
            .logoName img {
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
                <button id="selected">
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
                        <h2>Dashboard</h2>
                    </div>
                    <div class="yellowBG">
                        <h2 id="votes">0/0 votes</h2>
                    </div>
                </div>
            </div>
            <div class="dashboards">
                <div class="perprogramcontainer">
                    <div class="resulttitle">
                        <h3>NO. OF VOTE PER COUNCIL</h3>
                    </div>
                    <div class="piecontainer">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
                <div class="allvoterscontainer">
                    <div class="resulttitle">
                        <h3>OVERALL NO. OF VOTE</h3>
                    </div>
                    <div class="piecontainer">
                        <canvas id="myPieChart2"></canvas>
                    </div>
                </div>
            </div>
            <div class="dashboards">
                <div class="perprogramcontainer">
                    <div class="resulttitle">
                        <h3>PERCENTAGE OF VOTE PER COUNCIL</h3>
                    </div>
                    <div class="piecontainer">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="dashboards">
                <div class="perprogramcontainer">
                    <div class="resulttitle">
                        <h3>NO. OF VOTER PER COUNCIL</h3>
                    </div>
                    <div class="piecontainer">
                        <canvas id="myBarChart2"></canvas>
                    </div>
                </div>
            </div>
            <div class="dashboards">
                <div class="perprogramcontainer">
                    <div class="resulttitle">
                        <h3>VOTE TURNOUT</h3>
                    </div>
                    <div class="piecontainer">
                        <canvas id="myLineChart"></canvas>
                    </div>
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
            // Function to create or update a pie chart
            function createOrUpdatePieChart(chartId, chartData, chartOptions) {
                var ctx = document.getElementById(chartId).getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'pie',
                    data: chartData,
                    options: chartOptions
                });
                return chart;
            }

            // JavaScript code to switch HTML files with animation
            function switchHTML(file) {
                document.body.classList.add('fade-out');
                setTimeout(function() {
                    window.location.href = file;
                }, 500);
            }

            document.body.addEventListener('animationend', function() {
                document.body.classList.remove('fade-out');
                document.body.classList.add('fade-in');
            });

            // Sample data for the first pie chart
            var data = {
                labels: ['SABES', 'OFEE', 'AECES', 'OFSET', 'AFSET', 'SITS', 'FTVETTS'],
                datasets: [{
                    data: [0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: [
                        '#D8031C',
                        '#F6C90E',
                        '#090088',
                        '#E76615',
                        '#009D23',
                        '#9F00A3',
                        '#008AC6'
                    ],
                    hoverOffset: 4,
                    borderWidth: 0,
                    shadowOffsetX: 0,
                    shadowOffsetY: 4,
                    shadowBlur: 8,
                    shadowColor: 'rgba(0, 0, 0, 0.75)'
                }]
            };

            function updateChartData1() {
                fetch('getVoteData1.php')
                    .then(response => response.json())
                    .then(data => {
                        myPieChart.data.datasets[0].data[0] = data.voteCount;
                        myPieChart.data.datasets[0].data[1] = data.voteCount1;
                        myPieChart.data.datasets[0].data[2] = data.voteCount2;
                        myPieChart.data.datasets[0].data[3] = data.voteCount3;
                        myPieChart.data.datasets[0].data[4] = data.voteCount4;
                        myPieChart.data.datasets[0].data[5] = data.voteCount5;
                        myPieChart.data.datasets[0].data[6] = data.voteCount6;
                        myPieChart.update();

                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initial data fetch
            updateChartData1();

            // Update data every 1 seconds
            setInterval(updateChartData1, 1000);

            // Configuration options for the first pie chart
            var options = {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 40,
                        right: 40,
                        top: 40,
                        bottom: 40
                    }
                },
                color: 'white'
            };

            // Sample data for the second pie chart
            var data2 = {
                labels: ['Voted Students', 'Students Not Yet Voted'],
                datasets: [{
                    data: [0, 0],
                    backgroundColor: [
                        '#D8031C',
                        '#090088'
                    ],
                    hoverOffset: 4,
                    borderWidth: 0,
                    shadowOffsetX: 0,
                    shadowOffsetY: 4,
                    shadowBlur: 8,
                    shadowColor: 'rgba(0, 0, 0, 0.75)'
                }]
            };

            function updateChartData() {
                fetch('getVoteData.php')
                    .then(response => response.json())
                    .then(data => {
                        myPieChart2.data.datasets[0].data[0] = data.voteCount;
                        myPieChart2.data.datasets[0].data[1] = data.notVotedCount;
                        myPieChart2.update();

                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initial data fetch
            updateChartData();

            // Update data every 1 seconds
            setInterval(updateChartData, 1000);

            // Configuration options for the second pie chart
            var options2 = {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 40,
                        right: 40,
                        top: 40,
                        bottom: 40
                    }
                },
                color: 'white'
            };

            // Initial creation of the pie charts
            var myPieChart = createOrUpdatePieChart('myPieChart', data, options);
            var myPieChart2 = createOrUpdatePieChart('myPieChart2', data2, options2);

            // Event listener for window resize
            window.addEventListener('resize', function() {
                // Destroy the existing charts
                myPieChart.destroy();
                myPieChart2.destroy();
                // Recreate the charts with updated data and options
                myPieChart = createOrUpdatePieChart('myPieChart', data, options);
                myPieChart2 = createOrUpdatePieChart('myPieChart2', data2, options2);
            });

            let isPercentage = false;

            function updateDash() {
                fetch('getVoteData.php')
                    .then(response => response.json())
                    .then(data => {
                        let textContent;
                        if (isPercentage) {
                            const percentage = (data.voteCount / data.voterCount) * 100;
                            textContent = `${percentage.toFixed(2)}% votes`;
                        } else {
                            textContent = `${data.voteCount}/${data.voterCount} votes`;
                        }
                        // Update vote count text
                        document.getElementById('votes').textContent = textContent;
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initial data fetch
            updateDash();

            setInterval(updateDash, 1000);

            // Update data every 10 seconds
            setInterval(() => {
                isPercentage = !isPercentage; // Toggle between percentage and vote count
                updateDash();
            }, 10000);

            // Function to create or update a bar chart
            function createOrUpdateBarChart(chartId, chartData, chartOptions) {
                var ctx = document.getElementById(chartId).getContext('2d');
                return new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: chartOptions
                });
            }

            var barChartData = {
                labels: ['SABES', 'OFEE', 'AECES', 'OFSET', 'AFSET', 'SITS', 'FTVETTS', 'TSC'],
                datasets: [{
                    label: 'Percentage',
                    data: [0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: [
                        '#D8031C',
                        '#F6C90E',
                        '#090088',
                        '#E76615',
                        '#009D23',
                        '#9F00A3',
                        '#008AC6',
                        '#70FF00'
                    ],
                    borderWidth: 0
                }]
            };

            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 40,
                        right: 40,
                        top: 40,
                        bottom: 40
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                indexAxis: 'y', // Rotate the chart to display horizontally
                scales: {
                    x: {
                        ticks: {
                            color: 'white' // Set the x-axis labels to white
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Set the x-axis grid lines to a light white
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white' // Set the y-axis labels to white
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Set the y-axis grid lines to a light white
                        }
                    }
                }
            };


            function updateBarData() {
                fetch('getVoteData1.php')
                    .then(response => response.json())
                    .then(data => {
                        // Extract voter counts for each program from the received data
                        const voterCounts = data.voterCounts;

                        // Compute percentages for each program's vote count
                        const percentages = [
                            (data.voteCount / voterCounts.BSABE) * 100,
                            (data.voteCount1 / voterCounts.BEEd) * 100,
                            (data.voteCount2 / voterCounts.BECEd) * 100,
                            (data.voteCount3 / voterCounts.BSNEd) * 100,
                            (data.voteCount4 / voterCounts.BSEd) * 100,
                            (data.voteCount5 / voterCounts.BSIT) * 100,
                            (data.voteCount6 / voterCounts.BTVTEd) * 100,
                            (data.voteCount7 / voterCounts.ALL) * 100
                        ];

                        // Update chart data with percentages
                        barChartData.datasets[0].data = percentages;

                        // Update the bar chart
                        myBarChart.update();
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }


            // Initial data fetch
            updateBarData();

            // Update data every 1 second
            setInterval(updateBarData, 1000);

            var myBarChart = createOrUpdateBarChart('myBarChart', barChartData, chartOptions);

            var barChartData2 = {
                labels: ['SABES', 'OFEE', 'AECES', 'OFSET', 'AFSET', 'SITS', 'FTVETTS', 'TSC'],
                datasets: [{
                    label: 'No. of Voter',
                    data: [0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: [
                        '#D8031C',
                        '#F6C90E',
                        '#090088',
                        '#E76615',
                        '#009D23',
                        '#9F00A3',
                        '#008AC6',
                        '#70FF00'
                    ],
                    borderWidth: 0
                }]
            };

            var chartOptions2 = {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 40,
                        right: 40,
                        top: 40,
                        bottom: 40
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                indexAxis: 'y', // Rotate the chart to display horizontally
                scales: {
                    x: {
                        ticks: {
                            color: 'white', // Set the x-axis labels to white
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Set the x-axis grid lines to a light white
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white' // Set the y-axis labels to white
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Set the y-axis grid lines to a light white
                        }
                    }
                }
            };


            function updateBarData2() {
                fetch('getVoteData1.php')
                    .then(response => response.json())
                    .then(data => {
                        // Extract voter counts for each program from the received data
                        const voterCounts = data.voterCounts;

                        // Compute percentages for each program's vote count
                        const percentages = [
                            voterCounts.BSABE,
                            voterCounts.BEEd,
                            voterCounts.BECEd,
                            voterCounts.BSNEd,
                            voterCounts.BSEd,
                            voterCounts.BSIT,
                            voterCounts.BTVTEd,
                            voterCounts.ALL
                        ];

                        // Update chart data with percentages
                        barChartData2.datasets[0].data = percentages;

                        // Update the bar chart
                        myBarChart2.update();
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }


            // Initial data fetch
            updateBarData2();

            // Update data every 1 second
            setInterval(updateBarData2, 1000);

            var myBarChart2 = createOrUpdateBarChart('myBarChart2', barChartData2, chartOptions2);


            // Create or update line chart
            function createOrUpdateLineChart(chartId, chartData, chartOptions) {
                var ctx = document.getElementById(chartId).getContext('2d');
                return new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: chartOptions
                });
            }

            var lineChartData = {
                labels: [], // Will be filled with dates
                datasets: [{
                    label: 'Number of Votes',
                    data: [], // Will be filled with voter counts
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            };

            // Get the current time
            var now = new Date();
            var startTime = new Date(now.getTime() - 3 * 60 * 60 * 1000); // 4 hours before
            var endTime = new Date(now.getTime() + 1 * 60 * 60 * 1000); // 0 hours after

            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'time',
                        min: startTime,
                        max: endTime,
                        time: {
                            unit: 'day', // Initial unit
                            tooltipFormat: 'PPp' // Display date and time in tooltip
                        },
                        title: {
                            display: true,
                            text: 'Date/Time(Hours)',
                            color: 'white'
                        },
                        ticks: {
                            color: 'white' // Set x-axis labels color
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Set x-axis grid lines color
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Number of Votes',
                            color: 'white'
                        },
                        ticks: {
                            color: 'white', // Set y-axis labels color
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Set y-axis grid lines color
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    zoom: {
                        pan: {
                            enabled: true,
                            mode: 'x',
                            speed: 0.1 // Adjust the panning speed
                        },
                        zoom: {
                            wheel: {
                                enabled: true,
                                speed: 0.1
                            },
                            pinch: {
                                enabled: true,
                                speed: 0.1
                            },
                            mode: 'x',
                            onZoom: ({
                                chart
                            }) => handleZoom(chart)
                        }
                    }
                }
            };

            function handleZoom(chart) {
                const start = chart.scales.x.min;
                const end = chart.scales.x.max;
                const duration = end - start;

                let timeUnit;
                if (duration <= 1000 * 60 * 60 * 24) { // 1 day or less
                    timeUnit = 'hour';
                    chart.options.scales.x.time.unit = 'hour';
                    chart.options.plugins.title.text = 'Time (Hours)';
                } else {
                    timeUnit = 'day';
                    chart.options.scales.x.time.unit = 'day';
                }

                fetch('getVotersVoteTime.php?&unit=' + timeUnit)
                    .then(response => response.json())
                    .then(data => {
                        const dates = data.map(entry => entry.date);
                        const voterCounts = data.map(entry => entry.count);

                        lineChartData.labels = dates;
                        lineChartData.datasets[0].data = voterCounts;

                        chart.update();
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            var myLineChart = createOrUpdateLineChart('myLineChart', lineChartData, chartOptions);

            // Initial data fetch
            handleZoom(myLineChart);


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
    echo "<script>document.getElementById('LOGS').style.display = 'none';</script>";
} else if ($usertype === 'Admin-Technical') {
    echo "<script>document.getElementById('CANDIDATES').style.display = 'none';</script>";
    echo "<script>document.getElementById('VOTERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('PARTYLIST').style.display = 'none';</script>";
    echo "<script>document.getElementById('USERS').style.display = 'none';</script>";
    echo "<script>document.getElementById('COUNCIL').style.display = 'none';</script>";
}

?>