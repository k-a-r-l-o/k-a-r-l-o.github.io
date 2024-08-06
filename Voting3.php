<?php
include "DBSessionVoter.php";
include "SessionOTP.php";

$username = $_SESSION["username"];
$program = $_SESSION["program"];
$usep_ID = $_SESSION["usep_ID"];

$sql = "SELECT FName FROM voters WHERE usep_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usep_ID);
$stmt->execute();
$stmt->bind_result($voter_name);
$stmt->fetch();
$stmt->close();

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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch positions from the positions table for the council_id
    $sqlPositions = "SELECT position_name, position_slot FROM positions WHERE council_id = $council_id";
    $resultPositions = $conn->query($sqlPositions);

    // Initialize an array to hold vote values with default abstain values
    $votes = [];
    $positions = [];

    while ($rowPosition = $resultPositions->fetch_assoc()) {
        $positionName = htmlspecialchars($rowPosition['position_name']);
        $positionName = str_replace(' ', '_', $positionName);
        $positionSlot = (int)$rowPosition['position_slot'];

        $positions[$positionName] = $positionSlot;

        // Initialize votes array with default abstain values
        for ($i = 1; $i <= $positionSlot; $i++) {
            $formattedPositionName = $council_name . '_' . str_replace(' ', '_', $positionName);
            $key = $positionSlot > 1 ? $formattedPositionName . $i : $formattedPositionName;
            $votes[$key] = 100010001; // Default abstain value
        }
    }

    // Process each position from the form submission
    foreach ($positions as $positionName => $positionSlot) {
        $formattedPositionName = $council_name . '_' . str_replace(' ', '_', $positionName);

        if (isset($_POST[$positionName]) && is_array($_POST[$positionName])) {
            // Handle multiple votes for positions with more than one slot
            for ($i = 0; $i < $positionSlot; $i++) {
                $key = $formattedPositionName . ($positionSlot > 1 ? ($i + 1) : '');
                if (isset($_POST[$positionName][$i])) {
                    $votes[$key] = (int)filter_var($_POST[$positionName][$i], FILTER_SANITIZE_NUMBER_INT);
                }
            }
        } elseif (isset($_POST[$positionName])) {
            // Handle single vote for positions with one slot
            $votes[$formattedPositionName] = (int)filter_var($_POST[$positionName], FILTER_SANITIZE_NUMBER_INT);
        }
    }

    // Construct the SQL query dynamically
    $columns = implode(", ", array_keys($votes));
    $placeholders = implode(", ", array_fill(0, count($votes), '?'));
    $updates = implode(", ", array_map(fn ($col) => "$col = VALUES($col)", array_keys($votes)));

    $sqlSaveVote = "
    INSERT INTO $table_name (usep_ID, $columns)
    VALUES (?, $placeholders)
    ON DUPLICATE KEY UPDATE $updates";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sqlSaveVote);

    // Prepare the bind parameters
    $bindTypes = str_repeat('i', count($votes) + 1); // All parameters are integers
    $bindParams = array_merge([$bindTypes, $usep_ID], array_values($votes));

    // Create an array of references
    $bindParamsRefs = [];
    foreach ($bindParams as $key => $value) {
        $bindParamsRefs[$key] = &$bindParams[$key];
    }

    // Use call_user_func_array to bind the parameters dynamically
    call_user_func_array([$stmt, 'bind_param'], $bindParamsRefs);

    if ($stmt->execute()) {
        $queryString = http_build_query($votes);
        echo "<script>window.location.href = 'Voting4.php?$queryString';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            animation: fadeIn 0.3s forwards;
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
            text-align: center;
        }

        .card {
            height: auto;
            width: 100%;
            max-width: 1000px;
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

        .positiontitle p {
            margin: 0;
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
            flex-direction: column;
        }

        input[type="checkbox"] {
            margin-bottom: 20px;
            width: 20px;
            height: 20px;
        }

        .candidateimage {
            display: flex;
            justify-content: center;
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

        .candidateinfocontent input[type="checkbox"] {
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

        .candidateinfocontent input[type="checkbox"] {
            margin-right: 10px;
            /* Hide the default checkbox button */
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            /* Define the size of the custom checkbox button */
            width: 20px;
            height: 20px;
            /* Style the border and background */
            border: none;
            /* Border color */
            border-radius: 50%;
            /* Makes it circular */
            background-color: #fff;
            /* Background color */
            /* Position the checkbox button relative to the label */
            position: relative;
            /* Center the custom checkbox button */
            display: inline-block;
            vertical-align: middle;
            cursor: pointer;
            /* Show cursor on hover */
        }

        /* Style the custom checkbox button when checked */
        .candidateinfocontent input[type="checkbox"]:checked::after {
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
            max-width: 1000px;
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

                <div class="stepper-item completed">
                    <div class="step-counter"></div>
                    <div class="step-name">SC Summary</div>
                </div>

                <div class="stepper-item active">
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
                        <h2><?php echo htmlspecialchars($cFullName); ?>(<?php echo htmlspecialchars($council_name); ?>)</h2>
                    </div>
                </div>
                <form method="post" id="votingForm">
                    <?php while ($rowPosition = $resultPositions->fetch_assoc()) : ?>
                        <?php
                        $positionName = htmlspecialchars($rowPosition['position_name']);
                        $positionSlot = (int)$rowPosition['position_slot'];  // Get the slot for the position
                        $sqlCandidates = "
                        SELECT c.*, p.name_partylist 
                        FROM candidates c 
                        LEFT JOIN list_partylist p ON c.prty_ID = p.prty_ID 
                        WHERE c.position = '$positionName' AND c.program = '$program'";
                        $resultCandidates = $conn->query($sqlCandidates);
                        ?>
                        <div class="card" data-position="<?php echo $positionName; ?>" data-slot="<?php echo $positionSlot; ?>">
                            <div class="positiontitle">
                                <h3><?php echo $positionName; ?></h3>
                                <p><i>(<?php echo $positionSlot; ?> selection required)</i></p>
                            </div>
                            <div class="cardcontent">
                                <?php while ($rowCandidate = $resultCandidates->fetch_assoc()) : ?>
                                    <?php
                                    $candidateId = htmlspecialchars($rowCandidate['usep_ID'] ?? '');
                                    $candidateName = htmlspecialchars(($rowCandidate['FName'] ?? '') . ' ' . ($rowCandidate['LName'] ?? ''));
                                    $candidateImage = htmlspecialchars($rowCandidate['candPic'] ?? 'uploads/default.png');  // Fallback to 'uploads/default.png' if image is not set
                                    $partyListName = htmlspecialchars($rowCandidate['name_partylist'] ?? '');  // Get the party list name
                                    ?>
                                    <div class="candidateinfocontent">
                                        <label for="<?php echo $candidateId; ?>">
                                            <input type="checkbox" class="candidate-checkbox" id="<?php echo $candidateId; ?>" name="<?php echo str_replace(' ', '_', $positionName); ?>[]" value="<?php echo $candidateId; ?>" data-position-name="<?php echo $positionName; ?>">
                                            <?php echo $candidateName . ' (' . $partyListName . ')'; ?>
                                        </label>
                                    </div>
                                    <div class="candidateimage">
                                        <img id="<?php echo $candidateId . 'CandidateImage'; ?>" src="<?php echo $candidateImage; ?>" alt="Candidate Pic">
                                    </div>
                                <?php endwhile; ?>
                                <!-- Repeat Abstain option based on the number of slots -->
                                <?php for ($i = 0; $i < $positionSlot; $i++) : ?>
                                    <div class="candidateinfocontent">
                                        <label for="<?php echo str_replace(' ', '_', $positionName) . 'Abstain' . $i; ?>">
                                            <input type="checkbox" class="candidate-checkbox" id="<?php echo str_replace(' ', '_', $positionName) . 'Abstain' . $i; ?>" name="<?php echo str_replace(' ', '_', $positionName); ?>[]" value="100010001" data-position-name="<?php echo $positionName; ?>">Abstain
                                        </label>
                                    </div>
                                    <div class="candidateimage">
                                        <img id="<?php echo str_replace(' ', '_', $positionName) . 'CandidateImage' . $i; ?>" src="uploads/100010001-Abstain.png" alt="Candidate Pic">
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <div class="button">
                        <div></div>
                        <button type="submit" name="next">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        function showAlertOnce() {
            if (!localStorage.getItem('alertShown')) {
                Swal.fire({
                    title: 'Welcome <?php echo htmlspecialchars($voter_name); ?>!',
                    html: `<div style="text-align: left;">
                            <ol>
                                <li>Please select your preferred candidates for each position.</li>
                                <li>If you wish to abstain, select the "Abstain" option.</li>
                                <li>For each position, a selection is required; if you fail to select, it will automatically count as an abstention.</li>
                                <li>Unselect the current candidate before choosing a new one.</li>
                                <li>Once you have made your selections, click the "Next" button to proceed.</li>
                            </ol>
                        </div>`,
                    imageUrl: "smile.png",
                    imageWidth: 100,
                    imageHeight: 100,
                    imageAlt: "Smile",
                    confirmButtonText: 'Got it!',
                }).then(() => {
                    // Set a flag in localStorage after showing the alert
                    localStorage.setItem('alertShown', 'true');
                });
            }
        }
        showAlertOnce();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.candidate-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const positionName = this.getAttribute('data-position-name');
                    const card = this.closest('.card');
                    const maxSelections = parseInt(card.getAttribute('data-slot'), 10);
                    const selectedCheckboxes = card.querySelectorAll('.candidate-checkbox:checked');

                    if (selectedCheckboxes.length >= maxSelections) {
                        card.querySelectorAll('.candidate-checkbox:not(:checked)').forEach(box => box.disabled = true);
                    } else {
                        card.querySelectorAll('.candidate-checkbox').forEach(box => box.disabled = false);
                    }
                });
            });
        });

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
    </script>

</body>

</html>