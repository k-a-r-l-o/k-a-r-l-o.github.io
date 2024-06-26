<?php
    include "DBSessionWatcher.php";

    $usertype = $_SESSION['usertype'];
    $username = $_SESSION['username'];
    $username1 = strtolower($_SESSION['username']);

    $sql = "SELECT Fname, LName FROM users WHERE username = ? AND usertype = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $usertype);
    $stmt->execute();
    $stmt->bind_result($Fname, $LName);
    $stmt->fetch();
    $stmt->close();
    $firstLetterFirstName = substr($Fname, 0, 1);
    $firstLetterLastName = substr($LName, 0, 1);

    // Fetch the vote count for the user's specific vote table
    $userVotesTable = $username1 . "_votes";
    $sqlUserVotes = "SELECT COUNT(*) as vote_count FROM $userVotesTable";
    $resultUserVotes = $conn->query($sqlUserVotes);
    $userVoteCount = $resultUserVotes->fetch_assoc()['vote_count'];

    // Fetch the program from list_councils where council_name is equal to the username
    $sqlProgram = "SELECT program FROM list_councils WHERE council_name = '$username'";
    $resultProgram = $conn->query($sqlProgram);
    $program = "";
    if ($resultProgram->num_rows > 0) {
        $program = $resultProgram->fetch_assoc()['program'];
    } else {
        $program = "Invalid";
    }
    // Fetch the total vote count from the voters table
    if($username==='TSC'){
        $sqlTotalVotes = "SELECT COUNT(*) as total_votes FROM voters";
        $resultTotalVotes = $conn->query($sqlTotalVotes);
        $totalVoteCount = $resultTotalVotes->fetch_assoc()['total_votes'];
    }else{
        $sqlTotalVotes = "SELECT COUNT(*) as total_votes FROM voters WHERE program = '$program'";
        $resultTotalVotes = $conn->query($sqlTotalVotes);
        $totalVoteCount = $resultTotalVotes->fetch_assoc()['total_votes'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>U-Vote Watcher|Result</title>
  <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>

    body {
        font-family: 'Inter', sans-serif;
        background-color: white;
        background-image: url('backgroundwatcher.svg');
        background-size: 76.5vh;
        background-repeat: no-repeat;
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
        background-color: #090088;
        background-image: url('backgroundwatcher.svg');
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

    .bodycontainer{
        display: flex;
        width: 100vw;
        height: 100vh;
        background-color: #E2EAFF;
        overflow: hidden;
        position: fixed;
        z-index: 1;
        animation: fadeIn 0.3s forwards;
    }

    /*Content*/
    .content {
      display: grid;
      grid-template-columns: 1fr;
      grid-template-rows: 1fr 5fr; 
      background-color: transparent;
      width: auto;
      color: black;
      justify-content: center;
      align-items: baseline;
      align-content: center;
      width: 100%;
      padding: 2%;
      flex: 1;
      z-index: 2; 
      overflow: auto;
    }

    .contenthead {
      display: grid;
      grid-template-columns: 2fr 1fr;
      width: 100%;
      max-width: 1000px;
      height: auto;
      color: black;
      justify-content: center;
      align-items: center;
      gap: 20px;
      justify-self: center;
    }

    .titlecontainer {
      display: flex;
      width: auto;
      height: auto;
      color: black;
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
        max-width: 1000px;
        justify-self: center;
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
      background: linear-gradient(to bottom, #2F80ED, #090088);
      
      height: 63px;
      color: white;
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

    @media (max-width: 1500px) {
        .titlecontainer{
            flex-direction: column;
            align-items: baseline;
            margin-bottom: 20px;
            gap: 10px;
        }

        .titlecontainer h2{
            margin: 0;
            scale: 0.9;
        }

    }

    @media (max-width: 1000px) {

        .logoName, .logoName img{
            scale: 0.9;
        }

        table, .content button, h2{
            scale: 0.9;
        }

        header{
            padding-left: 3%;
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

        .content button, h2, .yellowBG{
        scale: 0.8;
        }

        .yellowBG{
            height: auto;
            margin: 2%;
        }

    }

    @media (max-height: 800px) {

        .logoName, .logoName img, .searchspace{
            scale: 0.9;
        }

        header{
            padding-left: 3%;
        }

        table, .content button, .content h2{
            scale: 0.9;
        }

    }

    @media (max-height: 500px) {

        .logoName, .logoName img{
            scale: 0.8;
        }

        header{
            padding-left: 3%;
        }

        table, .content button, .content h2{
            scale: 0.8;
        }

        /* Width and Height of scrollbar */
      ::-webkit-scrollbar {
          width: 4px;
      }

    }

    /*add candidate pop up*/
    .popup {
        color: black;
        display: none;
        flex-direction: column;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #E2EAFF;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        height: auto;
        width: 60vh;
        border-radius: 5px;
        z-index: 9999;
    }



    .head {
        background: linear-gradient(to bottom, #2F80ED, #090088);
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
        background-color: rgba(150, 191, 245, 0.5);
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
        background-color: #090074;
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

</head>
<body>
    <header>
        <div class="logoName">
            <img id="Logo" src="U-Vote Logo.svg" alt="Logo">
            <img id="Name" src="U-Vote Name.svg" alt="Name">
        </div>
    </header>

    <div class="bodycontainer" >
        <div class="content" >
            <div class="contenthead">
                <div class="titlecontainer">
                    <div>
                        <h2><?php echo $username; ?> Partial/Unofficial Result</h2>
                    </div>
                    <div class="yellowBG">
                        <h2 id="votes">0/0 votes</h2>
                    </div>                 
                </div>
                <div class="dropdown">
                    <button id="logout" name="logout">Logout</button>
                </div>
            </div>
            <div class="tableandnav">
                <div class="tablecontainer">
                <table id="Results">
                    <tr class="trheader">
                    <th class="thfirst">NAME</th>
                    <th>POSITION</th>
                    <th class="thlast">NO. OF VOTES</th>
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
        
        // JavaScript code for navigation
        var currentPage = 0;
        var rowsPerPage = 8; // Change this value as needed

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

            document.querySelector("#logoutpop .cancel-button").addEventListener("click", function() {
                document.getElementById("logoutpop").style.display = "none";
            });


    $(document).ready(function() {

            var selectedCouncil = "<?php echo $username; ?>"; // Embed PHP variable into JavaScript
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


        var currentPage = 0;
        var rowsPerPage = 8; // Change this value as needed

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

    $(document).ready(function() {
        var userVoteCount = <?php echo $userVoteCount; ?>;
        var totalVoteCount = <?php echo $totalVoteCount; ?>;

        // Populate the votes count in the h2 element
        $('#votes').text(userVoteCount + " / " + totalVoteCount);
    });
    </script>

      

</body>
</html>