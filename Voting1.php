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
        * {
            box-sizing: border-box;
        }

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
        }

        .cardcontainer {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: auto;
            padding-bottom: 3%;
        }

        .title {
            margin-bottom: 2%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .tname {
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: auto;
            max-width: 550px;
            border-radius: 12px;
            background-color: #001AFF;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        h2 {
            font-weight: 400;
            margin: 3%;
            text-transform: uppercase;
        }

        .card {
            height: auto;
            width: 100%;
            max-width: 1285px;
            display: flex;
            flex-direction: column;
            justify-self: center;
            border-radius: 12px;
            margin-bottom: 2%;
            background-color: transparent;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .positiontitle {
            position: relative;
            background-color: #001AFF;
            color: white;
            display: flex;
            width: 100%;
            height: auto;
            border-radius: 12px 12px 0 0;
            padding: 12px 10%;
            box-sizing: border-box;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        .positiontitle h3 {
            font-size: 24px;
            font-weight: 400;
            margin: 0;
            text-transform: uppercase;
        }

        .cardcontent {
            width: 100%;
            display: flex;
            padding: 20px 10%;
            box-sizing: border-box;
            background-color: rgb(150, 191, 245, 0.75);
            height: auto;
            border-radius: 0 0 12px 12px;
            align-items: center;
            justify-content: center;
        }

        input[type="radio"] {
            margin-bottom: 20px;
            width: 20px;
            height: 20px;
        }

        .candidateimage {
            display: flex;
            justify-content: right;
            align-items: center;
            width: 100%;
        }

        .candidateimage img {
            height: auto;
            width: auto;
            max-width: 250px;
            max-height: 250px;
            object-fit: cover;
            border-radius: 12px;
        }

        .candidateinfocontent {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .candidateinfocontent {
            display: flex;
            flex-direction: column;
        }

        .candidateinfocontent label {
            display: flex;
            align-items: center;
        }

        .candidateinfocontent input[type="radio"] {
            margin-top: 18px;
            margin-right: 10px;
        }

        .candidateinfocontent p {
            font-size: 20px;
        }

        .candidateinfocontent label {
            display: flex;
            align-items: center;
            color: #000000;
            /* Color of the candidate name */
            margin-bottom: 5px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .candidateinfocontent input[type="radio"] {
            margin-right: 10px;
            /* Hide the default radio button */
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            /* Define the size of the custom radio button */
            width: 20px;
            height: 20px;
            /* Style the border and background */
            border: none;
            /* Border color */
            border-radius: 50%;
            /* Makes it circular */
            background-color: #fff;
            /* Background color */
            /* Position the radio button relative to the label */
            position: relative;
            /* Center the custom radio button */
            display: inline-block;
            vertical-align: middle;
            cursor: pointer;
            /* Show cursor on hover */
        }

        /* Style the custom radio button when checked */
        .candidateinfocontent input[type="radio"]:checked::after {
            content: "";
            /* Position the dot inside the circle */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Define the size and appearance of the dot */
            width: 20.5px;
            height: 20.5px;
            border-radius: 50%;
            background-color: #FCCB06;
            /* Color of the dot when checked */
        }


        .button {
            width: 100%;
            display: flex;
            justify-content: space-between;
            max-width: 1285px;
        }

        .button button {
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
            max-width: 100px;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        .button button:hover {
            background-color: #FFD966;
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
            .tname,
            .card {
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

            .positiontitle h3,
            h2,
            label,
            button {
                scale: 0.9;
            }

            .cardcontainer {
                padding-bottom: 10%;
            }

        }

        @media (max-width: 900px) {
            .cardcontent {
                flex-direction: column;
            }

            .candidateimage {
                justify-content: center;
            }

            .title {
                margin-bottom: 0px;
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

        @media (max-width: 700px) {

            header {
                grid-template-columns: 1fr;
            }

            .logoName,
            .searchspace {
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

            .positiontitle h3,
            h2,
            label,
            button {
                scale: 0.8;
            }

            .cardcontainer {
                padding-bottom: 15%;
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
                <div class="stepper-item active">
                    <div class="step-counter"></div>
                    <div class="step-name">Student Council</div>
                </div>

                <div class="stepper-item">
                    <div class="step-counter"></div>
                    <div class="step-name">SC Summary</div>
                </div>

                <div class="stepper-item">
                    <div class="step-counter"></div>
                    <div class="step-name">Local Council</div>
                </div>

                <div class="stepper-item">
                    <div class="step-counter"></div>
                    <div class="step-name">LC Summary</div>
                </div>

                <div class="stepper-item">
                    <div class="step-counter"></div>
                    <div class="step-name">Finish Voting</div>
                </div>
            </div>
        </div>
    </header>

    <div class="bodycontainer">
        <div class="content">
            <div class="cardcontainer">
                <div class="title">
                    <div class="tname">
                        <h2>STUDENT COUNCIL</h2>
                    </div>
                </div>
                <?php
                // Assuming $conn is your database connection

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    // Initialize an array to hold vote values with default abstain values
                    $votes = [
                        'President' => '100010001',
                        'Vice_President_Internal_Affairs' => '100010001',
                        'Vice_President_External_Affairs' => '100010001',
                        'General_Secretary' => '100010001',
                        'General_Treasurer' => '100010001',
                        'General_Auditor' => '100010001',
                        'Public_Information_Officer' => '100010001'
                    ];

                    // Process each position from the form submission
                    foreach ($votes as $position => &$candidateId) {
                        if (isset($_POST[$position])) {
                            $candidateId = htmlspecialchars($_POST[$position]);
                        }
                    }

                    // Construct the SQL query to insert or update the vote
                    $sqlSaveVote = "
                        INSERT INTO tsc_votes (usep_ID, President, Vice_President_Internal_Affairs, Vice_President_External_Affairs, General_Secretary, General_Treasurer, General_Auditor, Public_Information_Officer)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE 
                            President = VALUES(President),
                            Vice_President_for_Internal_Affairs = VALUES(Vice_President_Internal_Affairs),
                            Vice_President_for_External_Affairs = VALUES(Vice_President_External_Affairs),
                            General_Secretary = VALUES(General_Secretary),
                            General_Treasurer = VALUES(General_Treasurer),
                            General_Auditor = VALUES(General_Auditor),
                            Public_Information_Officer = VALUES(Public_Information_Officer)";

                    // Prepare and execute the statement
                    $stmt = $conn->prepare($sqlSaveVote);
                    $stmt->bind_param(
                        'iiiiiiii', 
                        $usep_ID, 
                        $votes['President'], 
                        $votes['Vice_President_Internal_Affairs'], 
                        $votes['Vice_President_External_Affairs'], 
                        $votes['General_Secretary'], 
                        $votes['General_Treasurer'], 
                        $votes['General_Auditor'], 
                        $votes['Public_Information_Officer']
                    );

                    if ($stmt->execute()) {
                        echo "Votes recorded successfully.";
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                }
                ?>

                <form method="post">
                    <input type="hidden" name="usep_ID" value="<?php echo htmlspecialchars($userId); ?>">
                    <?php
                    // Fetch positions from the positions table for council_ID = 8
                    $sqlPositions = "SELECT position_name FROM positions WHERE council_id = 8";
                    $resultPositions = $conn->query($sqlPositions);

                    if ($resultPositions->num_rows > 0) {
                        // Loop through each position
                        while ($positionRow = $resultPositions->fetch_assoc()) {
                            $positionName = htmlspecialchars($positionRow['position_name']);

                            // Convert position names to match the keys used in the PHP votes array
                            $fieldName = str_replace(' ', '_', $positionName);
                            $fieldName = str_replace('for_', '_', $fieldName); // Special case for 'for'

                            // Fetch candidates for the current position
                            $sqlCandidates = "SELECT * FROM candidates WHERE position = '$positionName'";
                            $resultCandidates = $conn->query($sqlCandidates);

                            // Start the HTML output for the card
                            echo '<div class="card">
                            <div class="positiontitle">
                                <h3>' . $positionName . '</h3>
                            </div>
                            <div class="cardcontent">
                                <div class="candidateinfocontent">';

                            // Add the Abstain option
                            echo '<label for="' . $fieldName . 'Abstain">
                            <input type="radio" id="' . $fieldName . 'Abstain" name="' . $fieldName . '" value="100010001" checked onchange="updateCandidateImage(\'' . $fieldName . 'CandidateImage\', \'uploads/Abstain.png\')" data-image-id="' . $fieldName . 'CandidateImage" data-image-src="uploads/Abstain.png">Abstain
                        </label>';

                            // Check if any candidates were found
                            if ($resultCandidates->num_rows > 0) {
                                // Loop through the fetched candidates and add them to the card
                                $counter = 1;
                                while ($candidateRow = $resultCandidates->fetch_assoc()) {
                                    $candidateId = htmlspecialchars($candidateRow['usep_ID']);
                                    $candidateName = htmlspecialchars($candidateRow['FName'] . ' ' . $candidateRow['LName']);
                                    $candidateImage = htmlspecialchars($candidateRow['candPic']);

                                    echo '<label for="' . $fieldName . 'Candidate' . $counter . '">
                                    <input type="radio" id="' . $fieldName . 'Candidate' . $counter . '" name="' . $fieldName . '" value="' .  $candidateId . '" onchange="updateCandidateImage(\'' . $fieldName . 'CandidateImage\', \'' . $candidateImage . '\')" data-image-id="' . $fieldName . 'CandidateImage" data-image-src="' . $candidateImage . '">' . $candidateName . '
                                </label>';
                                    $counter++;
                                }
                            } else {
                                echo 'No candidates found for ' . $positionName . '.';
                            }

                            // Close the form and add the candidate image container
                            echo '</div>
                                <div class="candidateimage">
                                    <img id="' . $fieldName . 'CandidateImage" src="uploads/Abstain.png" alt="sub">
                                </div>
                            </div>
                        </div>';
                        }
                    } else {
                        echo 'No positions found for council_ID 8.';
                    }
                    ?>
                    <div class="button">
                        <div></div>
                        <button type="submit" name="next">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var headerHeight;

        function setHeight() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.content').style.height = `calc(100vh - ${headerHeight}px)`;
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


        // Function to update candidate image based on selected radio button
        function updateCandidateImage(imageId, newImageSrc) {
            // Get the candidate image element by ID
            var candidateImage = document.getElementById(imageId);
            // Update the image source
            candidateImage.src = newImageSrc;

            // Store the selected image source in sessionStorage
            sessionStorage.setItem(imageId, newImageSrc);
        }

        function getStoredImage(imageId) {
            return sessionStorage.getItem(imageId);
        }

        // Add event listeners to all candidate radio buttons
        var candidateRadios = document.querySelectorAll('input[type="radio"]');
        candidateRadios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Check if this radio button is selected
                if (radio.checked) {
                    // Update the image to the selected candidate's image
                    updateCandidateImage(radio.getAttribute('data-image-id'), radio.getAttribute('data-image-src'));
                }
            });
        });


        window.onload = function() {
            candidateRadios.forEach(function(radio) {
                var storedImageSrc = getStoredImage(radio.getAttribute('data-image-id'));
                if (storedImageSrc !== null) {
                    updateCandidateImage(radio.getAttribute('data-image-id'), storedImageSrc);
                }
            });
        };

        <?php
        $resultPositions->data_seek(0); // Reset result set pointer
        while ($positionRow = $resultPositions->fetch_assoc()) {
            $positionName = htmlspecialchars($positionRow['position_name']);
            echo 'updateCandidateImage("' . $positionName . '");';
        }
        ?>

        // Add event listeners to radio buttons to update image on selection change
        <?php
        $resultPositions->data_seek(0); // Reset result set pointer
        while ($positionRow = $resultPositions->fetch_assoc()) {
            $positionName = htmlspecialchars($positionRow['position_name']);
            echo 'document.querySelectorAll(\'input[name="' . $positionName . 'Candidate"]\').forEach(function(radio) {
                radio.addEventListener("change", function() {
                    updateCandidateImage("' . $positionName . '");
                });
            });';
        }
        ?>

        // Function to set a cookie
        function setCookie(cookieName, cookieValue, expirationDays) {
            var d = new Date();
            d.setTime(d.getTime() + (expirationHours * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
        }

        // Function to get the value of a cookie
        function getCookie(cookieName) {
            var name = cookieName + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var cookieArray = decodedCookie.split(';');
            for (var i = 0; i < cookieArray.length; i++) {
                var cookie = cookieArray[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(name) === 0) {
                    var cookieValue = cookie.substring(name.length, cookie.length);
                    // Check if the cookie value is an image URL or base64 data
                    if (isValidImageUrl(cookieValue)) {
                        // If it's a URL, you can directly use it
                        return cookieValue;
                    } else {
                        // If it's base64 data, you can create an image element and set its src
                        var img = new Image();
                        img.src = cookieValue;
                        return img;
                    }
                }
            }
            return "";
        }

    </script>

</body>
</html>
