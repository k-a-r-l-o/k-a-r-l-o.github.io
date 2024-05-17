<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>U-Vote Admin | Voting Schedule</title>
  <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <style>

    body {
        font-family: 'Inter', sans-serif;
        background-color: #222E50;
        margin: 0;
        padding: 0;
    }

    img{
        -webkit-user-drag: none;
    }

    /* CSS animation for fading in */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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
    
    .searchicon{
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

    .bodycontainer{
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

    .menu{
        display: grid;
        grid-template-columns: 1fr;
        width: auto;
        max-width: 390px;
        padding: 2% 1%;  
        gap: 10px;
        background-color: #222E50;
        box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.2);
        border-radius:  0px 10px 10px 0px;
        align-items: center;
        justify-items: center;
        z-index: 5;
        overflow: auto;
    }

    .buttonContainer{
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
        font-weight:lighter;
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

    .buttonContainer button div:nth-child(1){
        display: flex;
        width: 75%;
        height: 100%;
        align-items: center;
        justify-content: right;
    }

    .buttonContainer button div:nth-child(2){
        display: flex;
        width: 100%;
        height: 100%;
        align-items: center;
        justify-content: left;
        white-space: nowrap;
    }

    #selected, .buttonContainer button:hover{
        background-color: rgb(66, 165, 245, 0.5);
    }

    .buttonContainer .Logoutbutton {
        display: flex;
        height: 60px;
        font-size: 20px;
        font-weight: bold;
        background-color: #F6C90E; /* Same background color as the select */
        color: #222E50;
        border: none;
        gap: 10px;
        border-radius: 5px;
        padding: 0 20px; /* Adjust padding as needed */
        cursor: pointer;
        width: 100%;
        max-width: 200px;
        align-items: center;
        justify-content: center;
    }

    .buttonContainer .Logoutbutton:hover{
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

        .logoName, .searchspace, .searchspace img, .logoName img{
            scale: 0.9;
        }

        table, .content button, h2, h3{
            scale: 0.9;
        }

        header{
            padding-left: 3%;
        }

        .buttonContainer button div:nth-child(2) {
            display: none;
        }

        .menu{
            width: auto;
            justify-items: center;
            grid-template-columns: 1fr;
        }

        .buttonContainer{
            width: auto;
            justify-items: center;
            grid-template-columns: 1fr;
        }

        .menu button{
            grid-template-columns: 1fr;
            width: 60px;
            height: 60px;
            justify-content: center;
            align-items: center;
            gap: 0;
            padding: 0;
        }

        .buttonContainer button div:nth-child(1){
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

        button div img{
            scale: 0.8;
            background-size: contain;
        }

    }


    @media (max-width: 700px) {

        header{
          grid-template-columns: 1fr;
        }

        .logoName, .searchspace{
            width: 100%;
            padding: 1.5% 5%;
        }

        .searchspace{
            justify-content: left;
        }

        .menu button{
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

        button div img{
            scale: 0.6;
        }

        .content button, h2, h3, .yellowBG{
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

    .dropdown{
      display: flex;
      justify-content: right;
      align-items: center;
    }

    .titlecontainer button, .dropdown button {
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

    .titlecontainer button{
        background-color: transparent;
        color: #ffffff;
    }

    .schedulecontainer{
        display: flex;
        flex-direction: column;
        width: 100%;
        height: auto;
    }

    .realTime-container, .startcontainer, .endcontainer{
        display: flex;
        justify-content: center;
        flex-direction: column;
        width: 100%;
        height: 264px;
        border-radius: 12px;
        background-color: rgb(150, 191, 245, 0.5);
        margin-bottom: 3%;
    }

    .startcontainer{
        width: 100%;
        height: 264px;
        margin-right: 1.5%;
        margin-bottom: 3%;
    }

    .endcontainer{
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
        background-image: linear-gradient(#28579E,#222E50);
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


    .timeclockcontainer h1{
        font-size: 60px;
        color: white;
        letter-spacing: 4px;
        margin: 0;
    }

    .timeclockcontainer h5{
        font-size: 24px;
        color: white;
        letter-spacing: 3px;
        text-transform: uppercase;
        white-space: nowrap;
        margin: 0;
    }

    .startendcontainer{
        display: flex;
    }

    @media (max-width: 1200px) {
        .titlecontainer{
            flex-direction: column;
            align-items: baseline;
            gap: 10px;
        }

        .titlecontainer h2{
            margin: 0;
        }
    }


    @media (max-width: 1000px) {
        .timeclockcontainer h1{
            font-size: 50px;
        }

        .timeclockcontainer h5{
            font-size: 20px;
        }

        .startendcontainer{
            display: flex;
            flex-direction: column;
        }

        .startcontainer{
            margin-right: 0;
        }

        .endcontainer{
            margin-left: 0;
        }

    }

    @media (max-width: 700px) {
        .schedulecontainer{
            scale: 0.95;
        }

        .timeclockcontainer h1{
            font-size: 40px;
        }

        .timeclockcontainer h5{
            font-size: 16px;
        }

    }

    @media (max-width: 500px) {
        .schedulecontainer{
            scale: 0.9;
        }

        .timeclockcontainer h1{
            font-size: 30px;
        }

        .timeclockcontainer h5{
            font-size: 12px;
        }

        .dropdown button {
            font-size: 0;
            padding: 10px;
            width: auto;
            gap: 0;
        }

        .titlecontainer{    
            margin-top: 20px;
            margin-bottom: 0;
            width: 200%;
        }

    }

    @media (max-height: 800px) {

        .logoName, .logoName img, .searchspace{
            scale: 0.9;
        }

        header{
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
        background-color: rgba(150, 191, 245, 0.5); /* Set the background color */
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

    .popup-content .cancel-button, .popup-content .save-button {
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
      .popup{
          height: auto;
      }

    }

    @media (max-width: 500px) {
      .popup{
            height: auto;
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
    </header>
    <div class="bodycontainer" >
        <div class="menu">
            <div class="buttonContainer">
                <button onclick="switchHTML('Dashboard.php')"><div><img src="dashboard.svg" alt="dashboard icon"></div><div>Dashboard</div></button>
                <button onclick="switchHTML('Results.php')"><div><img src="result.svg" alt="result icon"></div><div>Results</div></button>
                <button onclick="switchHTML('Candidate.php')"><div><img src="candidates.svg" alt="dashboard icon"></div><div>Candidate</div></button>
                <button onclick="switchHTML('Voters.php')"><div><img src="voters.svg" alt="voter icon"></div><div>Voters</div></button>
                <button onclick="switchHTML('Partylist.php')"><div><img src="partylist.svg" alt="partylist icon"></div><div>Partylist</div></button>
                <button onclick="switchHTML('Users.php')"><div><img src="user.svg" alt="user icon"></div><div>Users</div></button>
                <button onclick="switchHTML('Council.php')"><div><img src="council.svg" alt="council icon"></div><div>Council</div></button>
                <button id="selected"><div><img src="schedule.svg" alt="calendar icon"></div><div>Voting Schedule</div></button>
                <button onclick="switchHTML('Logs.php')"><div><img src="log.svg" alt="log icon"></div><div>Log</div></button>
                <br>
                <button id="logout" class="Logoutbutton"><div><img src="logout.svg" alt="log out icon"></div><div>Logout</div></button>
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
            <div class="schedulecontainer">
                <div class="realTime-container">
                    <div class="clocktitle">
                        <h3>CURRENT TIME AND DATE</h3>
                    </div>
                    <div class="timeclockcontainer">
                        <h1 id="current-time"></h1>
                        <h5 id ="current-date"></h5>
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
                            <h1 id="start-time"></h1>
                            <h5 id ="start-date"></h5>
                        </div>
                        <div class="clockfoot">
                            
                        </div>
                    </div>
                    <div class="endcontainer">
                        <div class="clocktitle">
                            <h3>VOTING CLOSES:</h3>
                        </div>
                        <div class="timeclockcontainer">
                            <h1 id="end-time"></h1>
                            <h5 id ="end-date"></h5>
                        </div>
                        <div class="clockfoot">
                            
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
        </div>
    </div>
    <div class="popup" id="popup">
        <div class="head">
          <h3>ADDING SCHEDULE</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form>
                    <div class="form-group">
                        <label for="Starts">Voting Starts:</label>
                        <input type="date" id="StartsDate" class="input-form">
                        <br>
                        <input type="time" id="StartsTime" class="input-form">
                    </div>
                    <div class="form-group">
                        <label for="Closes">Voting Closes:</label>
                        <input type="date" id="ClosesDate" class="input-form">
                        <br>
                        <input type="time" id="ClosesTime" class="input-form">
                    </div>                    
                </form>
                <br>
                <button class="cancel-button">Cancel</button>
                <button class="save-button">Save</button>
            </div>
        </div>
    </div>
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
                <button class="cancel-button">Cancel</button>
                <button class="save-button">Confirm</button>
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

        setInterval(() => {
            updateTime();
        }, 1000);

        function updateTime() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
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
                const startDate = new Date(startsDateInput.value + 'T' + startsTimeInput.value);
                const endDate = new Date(closesDateInput.value + 'T' + closesTimeInput.value);
                
                return endDate > startDate;
            }

            function updateTimeLeft() {
                const currentDate = new Date();
                const startDate = new Date(startsDateInput.value + 'T' + startsTimeInput.value);
                const endDate = new Date(closesDateInput.value + 'T' + closesTimeInput.value);
                
                // Check if current time is after start time
                if (currentDate >= startDate) {
                    const timeLeft = endDate - currentDate;
                    if (timeLeft > 0) {
                        const daysLeft = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hoursLeft = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutesLeft = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const secondsLeft = Math.floor((timeLeft % (1000 * 60)) / 1000);
                        timeLeftContainer.textContent = `${daysLeft}d ${hoursLeft}h ${minutesLeft}m ${secondsLeft}s`;
                        playPauseButton.textContent = "Ongoing";
                        playPauseButton.style.backgroundColor = "green";
                    } else {
                        timeLeftContainer.textContent = "Voting Closed.";
                        playPauseButton.textContent = "Closed";
                        playPauseButton.style.backgroundColor = "red";
                    }
                } else {
                    timeLeftContainer.textContent = "Voting not started yet.";
                    playPauseButton.textContent = "Not Started";
                    playPauseButton.style.backgroundColor = "gray";
                }
            }

            function updateStartEnd() {
                const startDate = new Date(startsDateInput.value + 'T' + startsTimeInput.value);
                const endDate = new Date(closesDateInput.value + 'T' + closesTimeInput.value);
                startTimeContainer.textContent = formatTime(startDate);
                startDateContainer.textContent = formatDate(startDate);
                endTimeContainer.textContent = formatTime(endDate);
                endDateContainer.textContent = formatDate(endDate);
            }

            function onSaveButtonClick() {
                if (validateClosesDateTime()) {
                    updateStartEnd();
                    updateTimeLeft();
                } else {
                    startsDateInput.value = '';
                    startsTimeInput.value = '';
                    closesDateInput.value = '';
                    closesTimeInput.value = '';
                    alert("Voting Closes date and time should be after Voting Starts date and time.");
                }
            }

            const saveButton = document.querySelector('.save-button');
            saveButton.addEventListener('click', onSaveButtonClick)
            // Update time left every second
            setInterval(updateTimeLeft, 1000);

            // Initial update
            updateStartEnd();
        });

    </script>

    
</body>
</html>
