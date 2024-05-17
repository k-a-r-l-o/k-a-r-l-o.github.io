<?php

// Establishing a connection to the database
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "Voting_System"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


session_start();

// Check if session variables are set
if (!isset($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    // If session variables are not set, redirect to the login page
    header("Location: indexAdmin.php");
    exit();
}

// If session variables are set, proceed with the protected content
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>U-Vote Admin | Candidates</title>
  <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
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

    ::-webkit-scrollbar-thumb {
        background: #28579E;
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #2F80ED;
        border-radius: 5px;
    }
    
    @media (max-width: 1000px) {

        .logoName, .searchspace, .searchspace img, .logoName img{
            scale: 0.9;
        }

        table, .content button, h2{
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

        .content button, h2, .yellowBG{
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

        .logoName, .logoName img, .searchspace{
            scale: 0.9;
        }

        header{
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
        background-color: #F6C90E; /* Same background color as the select */
        color: #222E50;
        border: none;
        border-radius: 5px;
        align-items: center;
        padding: 0 10px;
        width: auto;
        max-width: 200px;
    }

    .dropdown{
      display: flex;
      justify-content: right;
      align-items: center;
    }

    .tableandnav{
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

    .prevcontainer{
      display: flex;
      width: 100%;
      justify-content: left;
      align-items: center;
    }

    .nextcontainer{
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
      width: 20%; /* Adjust width of the first column */
    }

    th:nth-child(2),
    td:nth-child(2) {
      width: 20%; /* Adjust width of the second column */
    }

    th:nth-child(3),
    td:nth-child(3) {
      width: 20%; /* Adjust width of the third column */
    }

    th:nth-child(4),
    td:nth-child(4) {
      width: 20%; /* Adjust width of the third column */
    }

    th:nth-child(5),
    td:nth-child(5) {
      width: 20%; /* Adjust width of the third column */
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
      padding: 5px 40px 5px 20px; /* Increased padding to accommodate the larger dropdown symbol */
      cursor: pointer;
      background-image: url('arrow-down.png'); /* Replace 'path_to_your_arrow_image.png' with the path to your custom dropdown symbol */
      background-repeat: no-repeat;
      background-position: right 10px center; /* Adjusted position of the dropdown symbol */
      /* Hide the default dropdown arrow */
      -webkit-appearance: none; /* Safari and Chrome */
      -moz-appearance: none; /* Firefox */
      appearance: none; /* All other browsers */
    }

    .content button {
        display: flex;
        height: 40px;
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

    #logoutpop, #deletepop{
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

    #logoutpop .popup-content, #deletepop .popup-content{
        overflow: hidden;
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

    .input-form{
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
      popup{
          height: 80vh;
      }

    }

    @media (max-width: 500px) {
      #popup, #editpop, #viewpop{
            height: 95vh;
            width: 100vw;
            top: 0;
            left: 0;
            transform: translate(0, 0);
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
    <div class="bodycontainer" >
        <div class="menu">
            <div class="buttonContainer">
                <button onclick="switchHTML('Dashboard.php')"><div><img src="dashboard.svg" alt="dashboard icon"></div><div>Dashboard</div></button>
                <button onclick="switchHTML('Results.php')"><div><img src="result.svg" alt="result icon"></div><div>Results</div></button>
                <button id="selected"><div><img src="candidates.svg" alt="candidate icon"></div><div>Candidate</div></button>
                <button onclick="switchHTML('Voters.php')"><div><img src="voters.svg" alt="voter icon"></div><div>Voters</div></button>
                <button onclick="switchHTML('Partylist.php')"><div><img src="partylist.svg" alt="partylist icon"></div><div>Partylist</div></button>
                <button onclick="switchHTML('Users.php')"><div><img src="user.svg" alt="user icon"></div><div>Users</div></button>
                <button onclick="switchHTML('Council.php')"><div><img src="council.svg" alt="council icon"></div><div>Council</div></button>
                <button onclick="switchHTML('Schedule.php')"><div><img src="schedule.svg" alt="calendar icon"></div><div>Voting Schedule</div></button>
                <button onclick="switchHTML('Logs.php')"><div><img src="log.svg" alt="log icon"></div><div>Log</div></button>
                <br>
                <button id="logout" class="Logoutbutton"><div><img src="logout.svg" alt="log out icon"></div><div>Logout</div></button>
            </div>
        </div>
        <div class="content">
            <div class="contenthead">
                <div class="titlecontainer">
                    <div>
                        <h2>Total Candidates</h2>
                    </div>
                    <div class="yellowBG">
                      <h2 id="rowNumbershow">0</h2>
                  </div>  
                </div>
                <div class="dropdown">
                    <button id="addcandidate"><img src="plus.png" alt="plus icon">Add new</button>
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
            
                    <tr>
                      <td class="tdfirst">2022-00123</td>
                      <td>Maya Cartel</td>
                      <td>President</td>
                      <td>SITS</td>
                      <td class="tdlast">
                          <img onclick="viewpop()" src="view.png" alt="view icon">
                          <img onclick="editpop()" src="edit.png" alt="edit icon">
                          <img onclick="deletepop()" src="delete.png" alt="delete icon">
                      </td>
                  </tr>                  
                    
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
          <h3>ADD CANDIDATE</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form>
                <div class="form-group">
                    <label for="profile">Profile Photo:</label>
                    <div class="upload-btn">
                        <input type="file" id="profile-photo" accept="image/*" onchange="previewImage(event)" placeholder="Upload Photo" class="input-file">
                        <span>Upload Photo</span>
                    </div>
                    <img id="preview" src="#" alt="Preview" style="display: none; max-width: 50%; max-height: 50%; border-radius: 10px; margin-top: 10px;">
                </div>
                <div class="form-group">
                    <label for="usepID">USeP ID:</label>
                    <input type="number" id="usepID" class="input-form">
                </div>
                <div class="form-group">
                    <label for="fullName">Full Name:</label>
                    <input type="text" id="fullName" class="input-form">
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" class="input-form">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="yearLevel">Year Level:</label>
                    <select id="yearlevel" class="input-form">
                        <option value="2nd">2nd Year</option>
                        <option value="3rd">3rd Year</option>
                        <option value="4th">4th Year</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="program">Program:</label>
                    <select id="program" class="input-form">
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
                    <label for="Council">Council:</label>
                    <select id="Council" class="input-form">
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
                <div class="form-group">
                    <label for="position">Position:</label>
                    <select id="position" class="input-form">
                        <option value="president">President</option>
                        <option value="vice-president">Vice President</option>
                        <option value="secretary">Secretary</option>
                        <option value="treasurer">Treasurer</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="partyList">Party List:</label>
                    <select id="partyList" class="input-form">
                        <option value="YANO">YANO</option>
                        <option value="AGIla">AGIla</option>
                      </select>
                </div>
                </form>
                <br>
                <button class="cancel-button">Cancel</button>
                <button class="save-button">Save</button>
            </div>
        </div>    
    </div>
    
    <div class="popup" id="viewpop">
        <div class="head">
          <h3>CANDIDATE INFORMATION</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form>
                <div class="form-group">
                    <label for="profile">Profile Photo:</label>
                    <img id="preview" src="DefaultProfile.png" alt="Preview" style="display: flex; max-width: 50%; max-height: 50%; border-radius: 10px; margin-top: 10px;">
                </div>
                <div class="form-group">
                    <label for="usepID">USeP ID:</label>
                    <input type="number" id="usepID" class="input-form" placeholder="2022-00294" readonly>
                </div>
                <div class="form-group">
                    <label for="fullName">Full Name:</label>
                    <input type="text" id="fullName" class="input-form" placeholder="Karl Cornejo" readonly>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <input id="gender" class="input-form" placeholder="Male" readonly>
                </div>
                <div class="form-group">
                    <label for="yearLevel">Year Level:</label>
                    <input id="yearlevel" class="input-form" placeholder="2nd Year" readonly>
                </div>
                <div class="form-group">
                    <label for="program">Program:</label>
                    <input id="program" class="input-form" placeholder="BSIT" readonly>
                </div>
                <div class="form-group">
                    <label for="Council">Council:</label>
                    <input id="Council" class="input-form" placeholder="SITS" readonly>
                </div>
                <div class="form-group">
                    <label for="position">Position:</label>
                    <input id="position" class="input-form" placeholder="Vice-President" readonly>
                </div>
                <div class="form-group">
                    <label for="partyList">Party List:</label>
                    <input id="partyList" class="input-form" placeholder="YANO" readonly>
                </div>
                </form>
                <br>
                <button class="save-button">Back</button>
            </div>
        </div>    
    </div>
    <div class="popup" id="editpop">
        <div class="head">
          <h3>EDIT CANDIDATE</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <form>
                <div class="form-group">
                    <label for="profile">Profile Photo:</label>
                    <div class="upload-btn">
                        <input type="file" id="profile-photo" accept="image/*" onchange="previewImage(event)" placeholder="Upload New Photo" class="input-file">
                        <span>Upload New Photo</span>
                    </div>
                    <img id="preview2" src="DefaultProfile.png" alt="Preview" style="display: block; max-width: 50%; max-height: 50%; border-radius: 10px; margin-top: 10px;">
                </div>
                <div class="form-group">
                    <label for="usepID">USeP ID:</label>
                    <input type="number" id="usepID" class="input-form">
                </div>
                <div class="form-group">
                    <label for="fullName">Full Name:</label>
                    <input type="text" id="fullName" class="input-form">
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" class="input-form">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="yearLevel">Year Level:</label>
                    <select id="yearlevel" class="input-form">
                        <option value="2nd">2nd Year</option>
                        <option value="3rd">3rd Year</option>
                        <option value="4th">4th Year</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="program">Program:</label>
                    <select id="program" class="input-form">
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
                    <label for="Council">Council:</label>
                    <select id="Council" class="input-form">
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
                <div class="form-group">
                    <label for="position">Position:</label>
                    <select id="position" class="input-form">
                        <option value="president">President</option>
                        <option value="vice-president">Vice President</option>
                        <option value="secretary">Secretary</option>
                        <option value="treasurer">Treasurer</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="partyList">Party List:</label>
                    <select id="partyList" class="input-form">
                        <option value="YANO">YANO</option>
                        <option value="AGIla">AGIla</option>
                      </select>
                </div>
                </form>
                <br>
                <button class="cancel-button">Cancel</button>
                <button class="save-button">Save</button>
            </div>
        </div>    
    </div>
    <div id="deletepop" class="popup">
        <div class="head">
          <h3>DELETE CANDIDATE</h3>
        </div>
        <div class="popup-content">
            <div class="popup-content-inner">
                <div style="text-align: center;">
                    <p>Are you sure you want to delete this candidate?
                        This action cannot be undone.</p>
                </div>
                <br>
                <button class="cancel-button">Cancel</button>
                <button class="save-button">Delete</button>
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
            
        /*add pop up*/
        document.getElementById("addcandidate").addEventListener("click", function() {
            document.getElementById("popup").style.display = "flex";
        });
        
        document.querySelector(".cancel-button").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
        });

        /*view pop up*/
        function viewpop() {
            document.getElementById("viewpop").style.display = "flex";
        };
        
        document.querySelector("#viewpop .save-button").addEventListener("click", function() {
            document.getElementById("viewpop").style.display = "none";
        });

        /*edit pop up*/
        function editpop() {
            document.getElementById("editpop").style.display = "flex";
        };
        
        document.querySelector("#editpop .cancel-button").addEventListener("click", function() {
            document.getElementById("editpop").style.display = "none";
        });

         /*delete pop up*/
         function deletepop() {
            document.getElementById("deletepop").style.display = "flex";
        };
        
        document.querySelector("#deletepop .cancel-button").addEventListener("click", function() {
            document.getElementById("deletepop").style.display = "none";
        });

        function previewImage(event) {
            var input = event.target;
            var preview = document.getElementById('preview');
            var preview = document.getElementById('preview2');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        // Get the table element
        var table = document.getElementById('Results');

        // Get the number of rows in the table
        var rowCount = table.rows.length;

        // Get the <h2> element where you want to display the row count
        var rowNumberElement = document.getElementById('rowNumbershow');

        // Replace the content of the <h2> element with the row count
        rowNumberElement.textContent = rowCount-1;

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
        }

        // Show the initial page
        showPage(currentPage);

        /*log out*/
        document.getElementById("logout").addEventListener("click", function() {
                document.getElementById("logoutpop").style.display = "flex";
            });

            document.querySelector("#logoutpop .save-button").addEventListener("click", function() {
              <?php
                  session_start();
                  session_unset();
                  session_destroy();
                  header("Location: indexAdmin.php");
                  exit();
              ?>
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