<?php
include "DBSessionVoter.php";

$username = $_SESSION["username"];
$usep_ID = $_SESSION["usep_ID"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>U-Vote OTP Verification</title>
    <link rel="icon" type="image/x-icon" href="U-Vote Logo.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
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
            grid-template-columns: 1fr 2fr;
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
            display: flex;
            gap: 5%;
        }

        #otp {
            height: 55px;
            width: 150%;
            font-size: 20px;
            background-color: #D9D9D9;
            color: black;
            font-weight: 100;
            border: none;
            border-radius: 12px;
            text-indent: 3%;
            padding: 0%;
            text-align: center;
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

        button {
            height: 52px;
            width: 100%;
            padding: 3%;
            font-size: larger;
            font-weight: lighter;
            color: #ffffff;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        }

        .OTP {
            background-color: green;
        }

        .Submit {
            background-color: #4361EE;
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
            overflow: auto;
            padding: 5%;
            box-sizing: border-box;
        }

        #logoutpop .popup-content,
        #deletepop .popup-content {
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
                width: 100vw;
            }

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

        .loader {
            border: 2px solid #f3f3f3;
            border-radius: 50%;
            border-top: 2px solid #3498db;
            width: 12px;
            height: 12px;
            animation: spin 2s linear infinite;
            display: inline-block;
            vertical-align: middle;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .disabled-button {
            background-color: gray;
            cursor: not-allowed;
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
        <div class="logincontainer">
            <div class="login">
                <div class="forgap"></div>
                <div>
                    <h1>OTP Verification</h1>
                    <p>Click the <b>Send OTP</b> to send the OTP to your email. Enter the <b>OTP</b> and <b>Submit</b> to verify. </p>
                </div>
                <div class="forgap"></div>
                <form method="post" id="otpForm">
                    <div class="forgap">
                        <input type="text" id="otp" name="otp" placeholder="Enter OTP" maxlength="6" minlength="6" required>
                        <button type="button" class="OTP" id="sendOtpButton">Send OTP</button>
                    </div>
                    <button type="submit" class="Submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function startCountdown() {
            const sendOtpButton = document.getElementById('sendOtpButton');
            let endTime = localStorage.getItem('otpEndTime');

            if (endTime) {
                endTime = parseInt(endTime, 10);
                const now = Date.now();
                const remainingTime = Math.max(0, endTime - now);

                if (remainingTime > 0) {
                    // Countdown is active
                    const countdownInterval = setInterval(function() {
                        const now = Date.now();
                        const timeLeft = Math.max(0, endTime - now);

                        if (timeLeft > 0) {
                            sendOtpButton.innerHTML = `${Math.ceil(timeLeft / 1000)} s`;
                        } else {
                            clearInterval(countdownInterval);
                            sendOtpButton.innerHTML = 'Send OTP';
                            sendOtpButton.disabled = false;
                            sendOtpButton.classList.remove('disabled-button');
                            localStorage.removeItem('otpEndTime');
                        }
                    }, 1000);

                    sendOtpButton.disabled = true;
                    sendOtpButton.classList.add('disabled-button');
                    return;
                }
            }

            sendOtpButton.disabled = false;
            sendOtpButton.innerHTML = 'Send OTP';
            sendOtpButton.classList.remove('disabled-button');
        }

        document.getElementById('sendOtpButton').addEventListener('click', function() {
            const sendOtpButton = document.getElementById('sendOtpButton');

            // Add loading animation, disable the button, and change color
            sendOtpButton.disabled = true;
            sendOtpButton.innerHTML = 'Sending... <span class="loader"></span>';
            sendOtpButton.classList.add('disabled-button');

            fetch('send_otp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        // Add any data you want to send to the server here
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Sent',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });

                        // Set countdown end time in local storage
                        const countdownDuration = 120 * 1000; // 50 seconds in milliseconds
                        const endTime = Date.now() + countdownDuration;
                        localStorage.setItem('otpEndTime', endTime);

                        startCountdown(); // Start countdown

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to send OTP.',
                            confirmButtonText: 'OK'
                        });
                        sendOtpButton.disabled = false;
                        sendOtpButton.innerHTML = 'Send OTP';
                        sendOtpButton.classList.remove('disabled-button');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while sending the OTP.',
                        confirmButtonText: 'OK'
                    });
                    sendOtpButton.disabled = false;
                    sendOtpButton.innerHTML = 'Send OTP';
                    sendOtpButton.classList.remove('disabled-button');
                });
        });

        // Initialize countdown on page load
        startCountdown();

        document.getElementById('otpForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const enteredOtp = document.getElementById('otp').value;

            // Send OTP to the server for verification
            fetch('verifyOtp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        otp: enteredOtp
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Loading',
                            text: 'Please wait.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        setTimeout(() => {
                            window.location.href = 'Voting1.php';
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid OTP',
                            text: 'Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while verifying the OTP.',
                        confirmButtonText: 'OK'
                    });
                });
        });
    </script>

    <script>
        var headerHeight;

        function setHeight() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.querySelector('.bodycontainer').style.height = `calc(100vh - ${headerHeight}px)`;
            document.querySelector('.logincontainer').style.height = `calc(100vh - ${headerHeight}px)`;
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

</body>

</html>