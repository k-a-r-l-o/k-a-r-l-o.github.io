<?php
session_start();

$servername = "localhost"; // Replace with your server name
$username = "u753706103_uvote"; // Replace with your username
$password = "UV+;!!c#~p1"; // Replace with your password
$dbname = "u753706103_Voting_System"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username']) && isset($_SESSION['usertype']) && isset($_SESSION['usep_ID'])) {
    // If session variables are not set, redirect to the login page
    header("Location: Dashboard.php");
}

// If form is submitted
if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["user"])) {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];
    $input_usertype = $_POST["user"];

    // Prepare SQL statement to retrieve user from database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, fetch details
        $row = $result->fetch_assoc();
        if (password_verify($input_password, $row["userpass"]) && $input_usertype === $row["usertype"]) {
            // Password is correct and usertype matches, set session variables
            $_SESSION["username"] = $input_username;
            $_SESSION["usertype"] = $input_usertype;
            $_SESSION["usep_ID"] = $row["usep_ID"];

            // Update user status to 'Active' and set logged_out to 0 using a prepared statement
            $sqlUserEdit = "UPDATE users SET User_status = 'Active', logged_out = 0 WHERE usep_ID = ?";
            $stmtUpdate = $conn->prepare($sqlUserEdit);
            if ($stmtUpdate) {
                $stmtUpdate->bind_param("i", $_SESSION["usep_ID"]);
                $stmtUpdate->execute();
                $stmtUpdate->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
                exit();
            }

            // Log the login activity
            $usepID = $_SESSION["usep_ID"];
            $logAction = 'Logged in';
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

            // Redirect to the dashboard
            header("Location: Dashboard.php");
            exit();
        } else {
            // Password or usertype is incorrect
            echo "<script>alert('Invalid credentials. Please try again.');</script>";
            echo "<script>window.location.href = 'indexAdmin.php';</script>";
            exit(); // Stop further execution
        }
    } else {
        // User does not exist
        echo "<script>alert('User not found. Please try again.');</script>";
        echo "<script>window.location.href = 'indexAdmin.php';</script>";
        exit(); // Stop further execution
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>U-Vote Admin | Login</title>
    <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #222E50;
            background-image: url('background.svg');
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

        .bodycontainer {
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            width: 100vw;
            background-color: transparent;
            overflow: hidden;
            position: fixed;
            z-index: 1;
            animation: fadeIn 0.3s forwards;
        }

        .imagecontainer {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60%;
            height: 100%;
            position: relative;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        .imagecontainer.hidden {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            /* Add transition property */
        }


        #imagebg {
            max-width: 90%;
            max-height: 90%;
            position: absolute;
            /* Position the image absolutely within the container */
            top: 50%;
            /* Move the image 50% from the top */
            left: 50%;
            /* Move the image 50% from the left */
            transform: translate(-50%, -50%);
            /* Center the image */
        }

        .logincontainer {
            display: flex;
            width: 40%;
            height: 100%;
            align-items: center;
            justify-content: center;
            transition: transform 0.5s ease-in-out;
            /* Add transition property */
            transform: translateX(0);
            /* Initial position */
        }

        .logincontainer.shifted {
            transform: translateX(calc(-50vw + 50%));
            /* Shifted position */
        }


        .login {
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            flex-direction: column;
            width: 50%;
            min-width: 300px;
            max-width: 325px;
            height: auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.15);
            padding: 40px;
        }

        @media (max-width: 500px) {
            .login {
                size-adjust: 0.8;
                scale: 0.8;
            }

        }

        h1 {
            font-size: 50px;
            font-weight: 500;
            padding: 0;
            margin-top: 0;
        }

        form {
            width: 100%;
        }

        .forgap {
            width: 100%;
            margin-bottom: 33px;
        }

        #username,
        #password {
            height: 55px;
            width: 100%;
            font-size: 20px;
            background-color: #D9D9D9;
            color: black;
            font-weight: 100;
            border: none;
            border-radius: 12px;
            text-indent: 3%;
            padding: 0%;
        }

        input:focus {
            outline: none;
        }

        .showpasscon {
            display: flex;
            align-items: center;
        }

        .showpass {
            height: 18px;
            width: 18px;
            background-color: #D9D9D9;
            border: none;
            border-radius: 4px;
            text-indent: 3%;
        }

        #usertype {
            height: 55px;
            width: 100%;
            font-size: 20px;
            background-color: #D9D9D9;
            border-radius: 12px;
            color: gray;
            border: none;
            text-indent: 3%;
            cursor: pointer;
            background-image: url('arrow-down.png');
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

        .loginbutton {
            height: 52px;
            width: 100%;
            padding: 3%;
            font-size: larger;
            font-weight: lighter;
            background-color: #4361EE;
            color: #ffffff;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 1000px) {

            .logoName,
            .logoName img {
                scale: 0.9;
            }

            header {
                padding-left: 3%;
            }

            .imagecontainer,
            .login {
                scale: 0.9;
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

            .imagecontainer,
            .login {
                scale: 0.9;
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

            .login {
                scale: 0.8;
            }

        }


        @media (max-height: 500px) {

            .imagecontainer,
            .login {
                scale: 0.8;
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

    <div class="bodycontainer">
        <div class="imagecontainer">
            <img id="imagebg" src="ImageBG.svg" alt="Logo">
        </div>
        <div class="logincontainer">
            <div class="login">
                <div>
                    <h1>Login</h1>
                </div>
                <form method="post">
                    <div class="forgap">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="showpasscon">
                        <input class="showpass" type="checkbox" id="showPassword">
                        <p>Show Password</p>
                    </div>
                    <div class="forgap">
                        <select name="user" id="usertype" required>
                            <option value="" disabled selected hidden>User Type</option>
                            <option value="Watcher">Watcher</option>
                            <option value="Admin-Front">Admin-Front</option>
                            <option value="Admin-Technical">Admin-Technical</option>
                            <option value="Chairperson">Chairperson</option>
                        </select>
                    </div>
                    <button type="submit" class="loginbutton">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('keydown', function(event) {
            // Check if Ctrl (or Cmd on Mac), Y, and U keys are pressed
            if ((event.ctrlKey || event.metaKey) && event.key === 'y') {
                // Prevent default browser behavior
                event.preventDefault();

                // Your custom action here
                window.open('index.php', '_self');
            }
        });

        var headerHeight;

        function setHeight() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.imagecontainer').style.height = `calc(100vh - ${headerHeight}px`;
            document.querySelector('.logincontainer').style.height = `calc(100vh - ${headerHeight}px`;
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

        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPassword');

        showPasswordCheckbox.addEventListener('change', function() {
            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });

        function setContainerVisibility() {
            const imageContainer = document.querySelector('.imagecontainer');
            const loginContainer = document.querySelector('.logincontainer');
            const viewportWidth = window.innerWidth;

            if (viewportWidth < 1100) {
                imageContainer.classList.add('hidden');
                loginContainer.classList.add('shifted'); // Shift login container to the left
            } else {
                imageContainer.style.display = 'flex'; // Show image container if viewport width is 1090px or more
                loginContainer.classList.remove('shifted'); // Reset login container position
                imageContainer.classList.remove('hidden');
            }
        }

        window.addEventListener('load', setContainerVisibility);
        window.addEventListener('resize', setContainerVisibility);
    </script>


</body>

</html>