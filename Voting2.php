<?php
include "DBSessionVoter.php";
include "SessionOTP.php";

$username = $_SESSION["username"];
$program = "ALL PROGRAMS";
$usep_ID = $_SESSION["usep_ID"];

// Prepare SQL statement to retrieve user from database
$sql = "SELECT * FROM voters WHERE Email = ? AND usep_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $usep_ID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    session_start();
    session_unset();
    session_destroy();

    // Redirect to index page or login page after session destruction
    header("Location: index.php");
    exit();
}

$sqlID = "SELECT council_id, council_name, cFullName FROM list_councils WHERE program = '$program'";
$resultID = $conn->query($sqlID);

if ($resultID->num_rows > 0) {
    $row = $resultID->fetch_assoc();
    $council_id = $row['council_id'];
    $council_name = $row['council_name'];
    $council_name1 = strtolower($row['council_name']);
    $cFullName = $row['cFullName'];
    $table_name = $conn->real_escape_string($council_name1 . "_votes");
} else {
    echo "No council found for the given program.";
    exit();
}

// Fetch positions from the positions table for the council_id
$sqlPositions = "SELECT position_name, position_slot FROM positions WHERE council_id = $council_id";
$resultPositions = $conn->query($sqlPositions);

// Initialize the positionNames array
$positionNames = [];

if ($resultPositions->num_rows > 0) {
    while ($row = $resultPositions->fetch_assoc()) {
        $position_name = $row['position_name'];
        $position_slot = $row['position_slot'];

        // Replace spaces with underscores in the position name
        $position_key_base = $council_name . '_' . str_replace(' ', '_', $position_name);

        // If position_slot is 1, add the position name directly
        if ($position_slot == 1) {
            $positionNames[$position_key_base] = $position_name;
        } else {
            // If position_slot is greater than 1, add the position name with a numeric suffix
            for ($i = 1; $i <= $position_slot; $i++) {
                $position_key = $position_key_base . $i;
                $positionNames[$position_key] = $position_name;
            }
        }
    }
} else {
    echo "No positions found for the given council.";
    exit();
}

$votes = $_GET;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            max-width: 715px;
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
            justify-content: center;
            box-sizing: border-box;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        .positiontitle h3 {
            font-size: 24px;
            font-weight: 400;
            margin: 0;
            text-align: center;
        }

        .cardcontent {
            width: 100%;
            display: flex;
            padding: 20px 10%;
            box-sizing: border-box;
            background-color: rgb(150, 191, 245, 0.5);
            height: auto;
            border-radius: 0 0 12px 12px;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .button {
            width: 100%;
            display: flex;
            justify-content: space-between;
            max-width: 715px;
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

        .pos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
        }

        .pos p {
            font-size: 20px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .CanName {
            color: #222E50;
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
            button,
            p {
                scale: 0.9;
            }

            .cardcontainer {
                padding-bottom: 10%;
            }

        }

        @media (max-width: 900px) {

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
            button,
            p {
                scale: 0.8;
            }

            .cardcontainer {
                padding-bottom: 15%;
            }

            .cardcontent {
                overflow: auto;
            }

        }

        .swal2-container {
            z-index: 9999;
            /* Ensure this value is higher than any other z-index on your page */
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
                <div class="stepper-item completed">
                    <div class="step-counter"></div>
                    <div class="step-name">Student Council</div>
                </div>

                <div class="stepper-item active">
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

                <div class="card">
                    <div class="positiontitle">
                        <h3><?php echo htmlspecialchars($cFullName); ?>(<?php echo htmlspecialchars($council_name); ?>) Summary</h3>
                    </div>
                    <div class="cardcontent">

                        <div class="pos">
                            <?php
                            // Display the votes
                            foreach ($votes as $position => $candidateId) {
                                if ($candidateId != '100010001') {
                                    // Query to get the candidate name using $candidateId
                                    $sql = "SELECT CONCAT(FName, ' ', LName) AS candidateName FROM candidates WHERE usep_ID = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('i', $candidateId);
                                    $stmt->execute();
                                    $stmt->bind_result($candidateName);
                                    $stmt->fetch();
                                    $stmt->close();
                                } else {
                                    $candidateName = 'Abstain';
                                }

                                echo '<p>  ' . $positionNames[$position] . '</p>';
                                echo '<p class="CanName">  ' . htmlspecialchars($candidateName) . '</p>';
                            }
                            ?>
                        </div>

                    </div>
                </div>

                <div class="button">
                    <button onclick="back()">Edit</button>
                    <button onclick="switchHTML('Voting3.php')">Confirm</button>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
        function back() {
            window.history.back();
        }

        function switchHTML(file) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Add fade-out animation to the body
                    document.body.classList.add('fade-out');

                    // Wait for the animation to finish, then switch to the new HTML file
                    setTimeout(function() {
                        window.location.href = file;
                    }, 500); // Delay should match the animation duration
                }
            });
        }

        // Add a listener for animation end to remove the fade-out class and add the fade-in class
        document.body.addEventListener('animationend', function() {
            document.body.classList.remove('fade-out');
            document.body.classList.add('fade-in');
        });
    </script>


</body>

</html>